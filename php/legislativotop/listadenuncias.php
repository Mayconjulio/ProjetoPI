<?php 
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    $res2=$DBcon->query("SELECT * FROM camconfig WHERE id=1");
$userRow2=$res2->fetch_array();
$nomecam = $userRow2['nome'];
$cormenu = $userRow2['cormenu'];
$corexibidor = $userRow2['corexibidor'];
$corgeral = $userRow2['corgeral'];
?>
<?php 
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if (!isset($_SESSION['userSession'])) 
{
 header("Location: acesso");
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
  
  $query = "INSERT INTO debates(mensagem,nome,foto) VALUES('$valgasto','$nome','$foto')";
  if ($DBcon->query($query))
  {
    header("Refresh:0");
  }

}
?>
<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
   Denúncias
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
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
        <ul class="nav">
          <li>
            <a href="estatisticas" style="color: black;">
              <i class="now-ui-icons design_app"></i>
              <p>Estatísticas</p>
            </a>
          </li>
          <li>
            <a href="./presidente" style="color: black;">
              <i class="now-ui-icons business_badge"></i>
              <p>Presidente da Câmara</p>
            </a>
          </li>
          <li>
            <a href="./" style="color: black;">
              <i class="now-ui-icons location_map-big"></i>
              <p>Votações</p>
            </a>
          </li>
          <li>
            <a href="./debate" style="color: black;">
              <i class="now-ui-icons ui-2_chat-round"></i>
              <p>Debate</p>
            </a>
          </li>
          <li>
            <a href="./calendario" style="color: black;">
              <i class="now-ui-icons ui-1_calendar-60"></i>
              <p>Calendário da Câmara</p>
            </a>
          </li>
          <li>
            <a href="./lista" style="color: black;">
              <i class="now-ui-icons design_bullet-list-67"></i>
              <p>Lista de vereadores</p>
            </a>
          </li>
          <li>
            <a href="./gasto" style="color: black;">
              <i class="now-ui-icons business_money-coins"></i>
              <p>Gasto dos vereadores</p>
            </a>
          </li>
          <li>
            <a href="./conta" style="color: black;">
              <i class="now-ui-icons users_single-02"></i>
              <p>Minha Conta</p>
            </a>
          </li>
        </ul>
      </div>
    </div>

    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#">Câmara Municipal de <?php echo $nomecam;?></a>

          </div>

        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        
      <form role="form" action="" autocomplete="off" method="post">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <center><label><p style="color:white;">Denúncias</p></label></center>
                      </div>
                    </div>
                  </div>


      <?php
$query=$DBcon->query("SELECT * FROM reqcidadao WHERE tipo='DN' ORDER BY id DESC");
$count=$query->num_rows;
if($count>=1)
{
  $pos = 0;
  while($usuario=$query->fetch_array())
  {
    $nome = $usuario['nome'];
    $email = $usuario['email'];
    $mensagem = $usuario['mensagem'];
    $telefone = $usuario['telefone'];


    echo '<div class="card">
    <div class="card-header">
      <center>Sugerido por: '.$nome.'</center>
    </div>
    <div class="card-body">
      <blockquote class="blockquote mb-0">
        <p>'.$mensagem.'</p>
        <hr><footer>Email: '.$email.'<br>Telefone: '.$telefone.'</footer>
      </blockquote>
    </div>
  </div>';
  }
}
                    ?>


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