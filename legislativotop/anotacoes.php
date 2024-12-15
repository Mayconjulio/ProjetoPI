<?php 
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    $res22=$DBcon->query("SELECT * FROM camconfig WHERE id=1");
$userRow22=$res22->fetch_array();
$nomecam = $userRow22['nome'];
$cormenu = $userRow22['cormenu'];
$corexibidor = $userRow22['corexibidor'];
$corgeral = $userRow22['corgeral'];
?>
<?php 
error_reporting(0);
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
        if(!isset($_COOKIE['ccuserSession']))
        {
            header("Location: acessovereador");
        } 
    else
    {
      $_SESSION['userSession'] = $_COOKIE['ccuserSession'];
    }
$res=$DBcon->query("SELECT * FROM usuarios WHERE user_id=".$_SESSION['userSession']);
$userRow=$res->fetch_array();
$usuario = $userRow['usuario'];
$nome = $userRow['nome'];
$id = $userRow['user_id'];
$foto = $userRow['foto'];
?>
<?php
require_once 'Dbconnect.php';

if(isset($_POST['enviar'])) {
 
 $valgasto = strip_tags($_POST['txtdebate']);
 $valgasto = $DBcon->real_escape_string($valgasto);
  
  $query = "INSERT INTO anotacoes(anota,idvereador) VALUES('$valgasto','$id')";
  if ($DBcon->query($query))
  {
    header("Refresh:0");
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
    Anotações
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
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
  <script src="assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>
  <style>
.element {
  align-items: center;
  background-color: #1a385b;
  box-shadow: 
    12px 12px 16px 0 rgba(0, 0, 0, 0.25),
    -8px -8px 12px 0 rgba(255, 255, 255, 0.3);
  border-radius: 15px;
  display: flex;
  height: 50px;
  justify-content: center;
  margin-right: 0rem;
  padding: 10px;
}
</style> 
</head>

<body class="">
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
        &nbsp;&nbsp;&nbsp;
<div class="col element">
<a href="conta" style="color:white;"><center> <img src="fotos/<?php echo $foto;?>" height="32"></center>
</a>
</div>

<div class="col">
&nbsp;
</div>

<div class="col element">
<a href="calendario" style="color:white;"><center> <img src="calendar.png" height="32"></center>
</a>
</div>
<div class="col">
&nbsp;
</div>

<div class="col element">
<a href="anotacoes" style="color:white;"><center> <img src="debate.png" height="32"></center>
</a>
</div>
<div class="col">
&nbsp;
</div>

<div class="col element" style="background-color: red;">
<a href="sair" style="color:white;"><center> <img src="shutdown.png" height="32"></center>
</a>
</div>
&nbsp;&nbsp;&nbsp;
</div>

<div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <a href="./" class="btn btn-primary btn-block" style="background-color: blue;">Voltar</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  
      <form role="form" action="" autocomplete="off" method="post">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <center><label><p style="color:black;">Anotações</p></label></center>
                        <textarea rows="4" cols="80" class="form-control" placeholder="Escreva uma anotação..." value="" name="txtdebate"></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <button type="submit" class="btn btn-primary btn-block" name="enviar">Enviar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  </form>

      <?php
$query=$DBcon->query("SELECT * FROM anotacoes ORDER BY id DESC LIMIT 100");
$count=$query->num_rows;
if($count>=1)
{
  $pos = 0;
  while($usuario=$query->fetch_array())
  {
    $iddebate = $usuario['id'];
    $anota = $usuario['anota'];
    $datan = $usuario['datan'];
    $phpdate = strtotime( $datan );
    $mysqldate = date( 'd/m/Y H:i', $phpdate );

echo '      <div class="card mb-12">
<div class="row g-0">
  <div class="col-md-12">
    <div class="card-body">
      <center><h5 class="card-title">'.utf8_decode($anota).'</h5></center><br><br>
    <center><p>'.$mysqldate.'</p></center>
    </div>

    <center>';

        //FINALIZA BOTÕES

echo '</div>
</div>
</div>';
  }
}
                    ?>

<script>
    function love() {
        var elements = document.getElementsByName ("btn-love");
        for (var i=0; i < elements.length; i++) 
        {
            elements[i].onclick = function() 
            {
           var botao = "#"+this.id;
           var id = $(this).data("id");
           var they = $(this).attr("data-id");
           var me = <?php echo $id ?>; 
           $.ajax({  
                url:"love.php",
                type: "POST",
                data:{id:id, they:they, me:me},  
                dataType:"text",  
                success:function(data)  
                {  
                     if(data != '')  
                     { 
                          $(botao).html(data);
                     }  
                     else  
                     {
                         
                     }  
                }  
           }); 
            }
        }
    }
 </script>
<script>
    function haha() {
        var elements = document.getElementsByName ("btn-haha");
        for (var i=0; i < elements.length; i++) 
        {
            elements[i].onclick = function() 
            {
           var botao = "#"+this.id;
           var id = $(this).data("id");
           var they = $(this).attr("data-id");
           var me = <?php echo $id ?>; 
           $.ajax({  
                url:"haha.php",
                type: "POST",
                data:{id:id, they:they, me:me},  
                dataType:"text",  
                success:function(data)  
                {  
                     if(data != '')  
                     { 
                          $(botao).html(data);
                     }  
                     else  
                     {
                         
                     }  
                }  
           }); 
            }
        }
    }
 </script>
 <script>
window.onload=function()
{
    love();
    haha();
}
</script>
<script>
window.onload=function()
{
    love();
    haha();
}
</script>
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

</body>
</html>