<?php
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';

if (!isset($_SESSION)) {
    session_start();
}

$msg = '';

// Verifica se o usuário está logado
if (!isset($_SESSION['povo'])) {
    header("Location: ./");
    exit;
} else {
    $usr = $_SESSION['povo'];
    $query = $DBcon->query("SELECT * FROM povo WHERE id='$usr'");
    if ($userRow = $query->fetch_array()) {
        $meuid = $userRow['id'];
        $nome = $userRow['nome'];
        $email = $userRow['email'];
    } else {
        // Redireciona se o usuário não estiver na tabela 'povo'
        header("Location: ./");
        exit;
    }
}

// Votar
if (isset($_POST['votar'])) {
    $modelid = strip_tags($_POST['votar']);
    $idenquete = strip_tags($_POST['idenquete']);
    $idopcao = strip_tags($_POST['idopcao']);

    // Usar prepared statements para evitar SQL Injection
    $stmt = $DBcon->prepare("INSERT INTO votospovo (idenquete, quemvotou, nome, voto) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $idenquete, $usr, $email, $modelid);

    if ($stmt->execute()) {
        $stmt->close();

        // Atualizar o total de votos na tabela 'modelos'
        $query2 = $DBcon->query("SELECT * FROM modelos WHERE model_id='$idopcao'");
        if ($userRow = $query2->fetch_array()) {
            $votos = $userRow['votospovo'];
            $b = 1;
            $total = $votos + $b;

            $query3 = "UPDATE modelos SET votospovo='$total' WHERE model_id='$idopcao'";
            $DBcon->query($query3);
        }

        $msg = '<div class="container" id="comprovante"><div class="card">
            <center><h5 class="card-header"><strong>Comprovante de voto</strong></h5></center>
            <div class="card-body">
                <p class="card-text">Eleitor: ' . $nome . '<br>Telefone: ' . $email . '<br>Voto registrado: ' . $modelid . '<br>Data: ' . date('d/m/Y') . '<br>Hora: ' . date('H:i:s') . '</p>
            </div>
        </div></div><br><br>';
    } else {
        $msg = "<div class='alert alert-danger' role='alert'>
            <strong>Desculpe!</strong> Tente novamente mais tarde.
        </div>";
    }
}

// Enviar mensagem
if (isset($_POST['sendmsg'])) {
    $idv = strip_tags($_POST['idvereador']);
    $titulomsg = strip_tags($_POST['titulo']);
    $msgvv = strip_tags($_POST['msg']);

    // Usar prepared statements para evitar SQL Injection
    $stmt = $DBcon->prepare("INSERT INTO mensagens (de, para, titulo, msg) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $idv, $titulomsg, $msgvv);

    if ($stmt->execute()) {
        $stmt->close();
        $msg = "<div class='alert alert-success' role='alert'>
            <strong>Obrigado!</strong> O vereador recebeu a sua mensagem.
        </div>";
    } else {
        $msg = "<div class='alert alert-danger' role='alert'>
            <strong>Desculpe!</strong> Tente novamente mais tarde.
        </div>";
    }
}
?>

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />

  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Chart JS -->
  <script src="assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><title>Area do povo - Envie uma mensagem para um vereador</title>

<!-- <script>  
      $(document).on('change', '#enquete', function(){  
           var eid = $(this).find(':selected').data('eid')
           var mid = <?php echo $meuid;?>;
           var cnpj = $(this).find(':selected').data('cnpj')
           $.ajax({  
                url:"load_enquete.php",
                type: "POST",
                data:{eid:eid,mid:mid,cnpj:cnpj},  
                dataType:"text",  
                success:function(data)  
                {  
                     if(data != '')  
                     {  
                         $('#candidatos').replaceWith(data); 
                     }  
                     else  
                     {  
                     }  
                }  
           });  
      });  
</script> -->
    
</head>
<body>    
<div class="bg">
<nav class="navbar navbar-light bg-light justify-content-center" style="background-color: #9E6240;">
<a class="navbar-brand" href="enquete" style="background-color: #9E6240;">
    <img src="assets/logo.png" height="50" class="d-inline-block align-top" alt="">

  </a></nav> 

    <br>
<div class="container">
<center><h2>Área do Povo</h2></center>
<div class="form-group">

<?php 
                                        if (isset($msg)) 
                                        {
                                        echo $msg;
                                        }
                                        ?>
                                        
<form role="form" action="" autocomplete="off" method="post">
<select class="form-control" id="enquete" name="enquete">
<option value="1" selected="selected">Selecione um vereador para entrar em contato</option> 
<?php
$query=$DBcon->query("SELECT * FROM usuarios");
$count=$query->num_rows;
if($count>=1)
{
while($enquete=$query->fetch_array())
{
       $id = $enquete['user_id'];
       $enquete = $enquete['nome'];
    
        echo '<option value="'.$id.'" id="'.$id.'" data-eid="'.$id.'" data-mid="'.$meuid.'" data-cnpj="'.$email.'">'.$enquete.'</option> ';
}
}
else
{}   
?>
</select>
<br>
<input type="text" class="form-control" placeholder="ID vereador" value="" name="idvereador" id="idvereador" hidden>
<input type="text" class="form-control" placeholder="Título da mensagem" value="" name="titulo" required><br>
<textarea type="text" class="form-control" placeholder="Deixe aqui a sua mensagem para o vereador" value="" name="msg" required></textarea>

<button type="submit" class="btn btn-danger btn-lg btn-block" name="sendmsg">Enviar mensagem</button>

    </form>
    </div>
</div>
		
<script>
$("#enquete").change(function(){
  let idaluno = $(this).val();  
  document.getElementById("idvereador").value = idaluno;
})
</script>

      <div class="container-fluid">
          <div class="row">
            <div class="container-fluid" id="candidatos" name="candidatos">
                                                  
              </div>
          </div>
      </div>
    <br>
    
    </div>
    <br><br>
    <div class="container justify-content-center text-center">
    <div class="justify-content-center">


<!--<a href="https://play.google.com/store/apps/details?id=com.homework.workdone&hl=pt_BR&gl=US" target="_blank">Precisa de ajuda com trabalhos escolares?<br>WorkDone é uma ferramenta para realizar trabalhos escolares em apenas 1 toque.<br><img src="assets/gplay.png" width="200" class="d-inline-block align-top" alt="WorkDone - Trabalhos escolares prontos sobre tudo"></a>
-->
</div></div>
    <br><br><br>
    <div class="container justify-content-center text-center">
    <div class="justify-content-center">
<a href="sair" style='color:blue;'><?php if (!isset($_SESSION['povo'])) {
echo '<a href="acessopublico">Registre-se para votar e comentar.</a>';
}else{echo "Votando como: ".$nome.".<br>Clique para sair.";}?><br></a>
</div></div>
</body>  
<footer>
</footer>
</html>