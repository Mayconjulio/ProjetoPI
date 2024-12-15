<?php 
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';
session_start();

$res2 = $DBcon->query("SELECT * FROM camconfig WHERE id=1");
$userRow2 = $res2->fetch_array();
$nomecam = $userRow2['nome'];
$cormenu = $userRow2['cormenu'];
$corexibidor = $userRow2['corexibidor'];
$corgeral = $userRow2['corgeral'];

if (!isset($_SESSION['userSession'])) { 
    header("Location: acessovereador");
    exit;
}

$id = $_SESSION['userSession'];
$userData = getUserData($DBcon, $id);
if ($userData) 
{
  $usuario = $userData['usuario'];
$nome = $userData['nome'];
$id = $userData['user_id'];
$email = $userData['email'];
$foto = !empty($userData['foto']) ? "fotos/" . $userData['foto'] : "fotos/default-avatar.png";
$partido = $userData['partido'];
$sigla = $userData['sigla'];
$endereco = $userData['endereco'];
$sobre = $userData['sobre'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['salvar'])) 
    {
        updateUserProfile($DBcon, $id);
    }  
    elseif (isset($_POST['novogasto'])) 
    {
        createNewExpense($DBcon, $id);
    } 
    elseif (isset($_POST['salvar2'])) 
    {
        updatePassword($DBcon, $id);
    }
}

function getUserData($connection, $userId) {
    $query = "SELECT * FROM usuarios WHERE user_id=".$userId;
    $result = $connection->query($query);
    return $result ? $result->fetch_array() : null;
}

function updateUserProfile($connection, $userId) {
    $usuario = isset($_POST['usuario']) ? strip_tags($_POST['usuario']) : '';
    $nome = isset($_POST['nome']) ? strip_tags($_POST['nome']) : '';
    $email = isset($_POST['email']) ? strip_tags($_POST['email']) : '';
    $partido = isset($_POST['partido']) ? strip_tags($_POST['partido']) : '';
    $sigla = isset($_POST['sigla']) ? strip_tags($_POST['sigla']) : '';
    $endereco = isset($_POST['endereco']) ? strip_tags($_POST['endereco']) : '';
    $sobre = isset($_POST['sobre']) ? strip_tags($_POST['sobre']) : '';

    $usuario = $connection->real_escape_string($usuario);
    $nome = $connection->real_escape_string($nome);
    $email = $connection->real_escape_string($email);
    $partido = $connection->real_escape_string($partido);
    $sigla = $connection->real_escape_string($sigla);
    $endereco = $connection->real_escape_string($endereco);
    $sobre = $connection->real_escape_string($sobre);
    $nome = utf8_encode($nome);

    $query = "UPDATE usuarios SET usuario='$usuario', nome='$nome', email='$email', partido='$partido', sigla='$sigla', endereco='$endereco', sobre='$sobre' WHERE user_id=$userId";
  
    if ($connection->query($query)) {
        header("Refresh:0");
        exit;
    } else {
        echo "ERRO";
    } 
}

if(isset($_FILES['imge'])){
  $errors= array();
  $file_name = $_FILES['imge']['name'];
  $file_size =$_FILES['imge']['size'];
  $file_tmp =$_FILES['imge']['tmp_name'];
  $file_type=$_FILES['imge']['type'];
  $file_ext=strtolower(@end(explode('.',$_FILES['imge']['name'])));
$temp = explode(".", $file_name);
$hash2 = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 30)), 30, 30);
$hashbg = round(microtime(true)).$hash2.'.'.end($temp);
  
  $expensions= array("jpeg","jpg","png");

   if(in_array($file_ext,$expensions)=== false){
     $errors[]="";
  }
  
  if($file_size > 3097152){
     $errors[]='Arquivo precisa ser menor que 3MB';
  }
  
  if(empty($errors)==true){
      
      $fileArray = array("./modelos/j.png");

foreach ($fileArray as $value) {
if (file_exists($value) and $value!="./modelos/default-avatar.png") {
    unlink($value);
} else {

}
} 

$query = "UPDATE usuarios SET foto='$hashbg' WHERE user_id=".$_SESSION['userSession'];

if ($DBcon->query($query))
{
header("Refresh:0");
}
else 
{
echo "ERRO";
}      

     move_uploaded_file($file_tmp,"fotos/".$hashbg);
  }else{
     print_r($errors);
  }
}

function createNewExpense($connection, $userId) {
    $valgasto = isset($_POST['valgasto']) ? strip_tags($_POST['valgasto']) : '';
    $valgasto = $connection->real_escape_string($valgasto);

    $query = "INSERT INTO gastos (valgasto, quemgastou) VALUES ('$valgasto', $userId)";
    if ($connection->query($query)) {
        header("Refresh:0");
        exit;
    } else {
        echo "ERRO";
    }
}

function updatePassword($connection, $userId) {
    $pw = isset($_POST['pw']) ? strip_tags($_POST['pw']) : '';
    $pw = $connection->real_escape_string($pw);
    $hashed_password = password_hash($pw, PASSWORD_DEFAULT);
    
    $query = "UPDATE usuarios SET senha='$hashed_password' WHERE user_id=$userId";
  
    if ($connection->query($query)) {
        header("Refresh:0");
        exit;
    } else {
        echo "ERRO";
    } 
}
?>
<!DOCTYPE html>
<html lang="pt">

<head><meta charset="utf-8">
  
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Conta
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
</head>

<body class="user-profile">
  <div class="wrapper ">
  <?php 
  echo '<div class="sidebar" data-color="'.$cormenu.'">';
  ?>  
      <!--
        Alterar a cor usando: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a class="simple-text logo-mini">
          CM
        </a>
        <a class="simple-text logo-normal" style="color: black;">
PODER LEGISLATIVO
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
      </div>
    </div>
    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <!-- End Navbar -->
      <div style="background-color: #0e2949;">
      <center>
            <a href="#" style="color: white;margin-top:80px;"><img src="assets/logo2.png" height="80"> Câmara Municipal de <?php echo $nomecam;?></a></center>
      </div>
      <br><br><br>
      <div class="content">
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h5 class="title">Editar perfil</h5>
              </div>
              <div class="card-body">
                <form role="form" action="" autocomplete="off" method="post">
                  <div class="row">
                    <div class="col-md-5 pr-1">
                      <div class="form-group">
                        <label>Cargo</label>
                        <input type="text" class="form-control" disabled="" placeholder="Cargo" value="Vereador(a)">
                      </div>
                    </div>
                    <div class="col-md-3 px-1">
                      <div class="form-group">
                        <label>Usuário</label>
                        <input type="text" class="form-control" placeholder="Usuário" value="<?php echo $usuario;?>" name="usuario">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control" placeholder="Email" value="<?php echo $email;?>" name="email">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Nome completo</label>
                        <input type="text" class="form-control" placeholder="Nome completo" value="<?php echo utf8_decode($nome);?>" name="nome">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                        <label>Partido</label>
                        <input type="text" class="form-control" placeholder="Partido" value="<?php echo $partido;?>" name="partido">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Sigla</label>
                        <input type="text" class="form-control" placeholder="Sigla" value="<?php echo $sigla;?>" name="sigla">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Endereço</label>
                        <input type="text" class="form-control" placeholder="Endereço do vereador" value="<?php echo $endereco;?>" name="endereco">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Sobre</label>
                        <textarea rows="4" cols="80" class="form-control" placeholder="Sobre o vereador" value="<?php echo $sobre;?>" name="sobre"><?php echo $sobre;?></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-primary btn-block" name="salvar">Salvar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                   </form>
                  
<hr>
<form role="form" action="" autocomplete="off" method="post">
<div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Nova senha</label>
                        <input type="password" class="form-control" placeholder="Nova senha" value="" name="pw">
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-primary btn-block" name="salvar2">Trocar senha</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  </form>
<hr>
<div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <a href="./" class="btn btn-primary btn-block" style="background-color: blue;">Voltar</a>
                        </div>
                      </div>
                    </div>
                  </div>
<hr>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <a href="sair" class="btn btn-danger btn-block" style="color:white;">Sair</a>
                        </div>
                      </div>
                    </div>
                  </div>

               
              </div>
            </div>
          </div>

          <div class="col-md-4"><br><br><br>
            <div class="card card-user">
              <div class="card-body">
                <div class="author">
                  <a>
                    <img class="avatar border-gray" src="<?php 
                      echo $foto;
                    ?>">
                    <h5 class="title"><?php echo utf8_decode($nome);?></h5>
                  </a>
                  <p class="description">
                  <?php echo $sigla;?>
                  </p>

                  <form role="form" action="" method="post" enctype="multipart/form-data">
                  <div class="form-group">
         <label class="btn btn-warning btn-file"><img src="newavicon.png" width="32">
          <input type="file" onchange="this.form.submit()" style="display: none;" name="imge" /></label>
      </form>

                </div>
                <p class="description text-center">
                <?php echo $sobre;?>
                </p>
              </div>
              <form role="form" action="" autocomplete="off" method="post">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Gastos atuais: R$ 
                        
                        <?php
$result = $DBcon->query("SELECT COUNT(*) as num_gastos, SUM(valgasto) as total_gastos FROM gastos WHERE quemgastou='$id'");
$row = $result->fetch_array();
$numGastos = $row['num_gastos'];
$totalGastos = $row['total_gastos'];

if ($numGastos > 0) {
    $mediaGastos = $totalGastos / $numGastos;
    echo number_format($mediaGastos, 2, ',', '.');
} else {
    echo '0,00'; // Caso não haja gastos, exibe 0,00 como média.
}
?>

                        </label><br>
                        <label>Adicionar novo gasto</label>
                        <input type="number" class="form-control" placeholder="Qual o valor gasto? ex: 1000" name="valgasto">
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-primary btn-block" name="novogasto">Informar gasto</button>
                        </div>
                      </div>
                    </div>
</form>
            </div>
          </div>

        </div>
      </div>

      <footer class="footer">
        <div class=" container-fluid ">
          <nav>
            <ul>
              <li>
                <a href="https://starsolutions.net.br/contato">
                  SUPORTE TÉCNICO
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright" id="copyright">
            &copy; <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>, Feito por <a href="https://starsolutions.net.br" target="_blank">Star Solutions</a>.
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Chart JS -->
  <script src="assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
</body>

</html>