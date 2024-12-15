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
<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
  Câmara Municipal de <?php echo $nomecam;?> - Administração do Presidente
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
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
  <script src="assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>

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
          <li class="">
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
            <a class="navbar-brand" href="./"> Câmara Municipal de <?php echo $nomecam;?></a>
          </div>

        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
            <div class="card-header">
                <center><h4 class="card-title">Painel do Presidente</h4></center>
              </div>

              <center><a class="btn btn-info btn-block" href="addfaq" role="button">Adicionar Dúvidas Frequentes</a></center>
              <center><a class="btn btn-info btn-block" href="addmesa" role="button">Adicionar Mesa Diretora</a></center>
              <center><a class="btn btn-info btn-block" href="addcomperm" role="button">Adicionar Comissões Permanentes</a></center>
              <center><a class="btn btn-info btn-block" href="addtv" role="button">Adicionar TV Câmara</a></center>
              <center><a class="btn btn-info btn-block" href="addindica" role="button">Adicionar Indicações</a></center>
              <center><a class="btn btn-info btn-block" href="addmocoes" role="button">Adicionar Moções</a></center>
              <center><a class="btn btn-info btn-block" href="addreq" role="button">Adicionar Requerimentos</a></center>
              <!-- <center><a class="btn btn-info btn-block" href="addfaq" role="button">Adicionar Leis Municipais</a></center>
              <center><a class="btn btn-info btn-block" href="addfaq" role="button">Adicionar Leis Complementares</a></center>
              <center><a class="btn btn-info btn-block" href="addfaq" role="button">Adicionar Contas Públicas</a></center> -->
<br><br><br>
              <center><a class="btn btn-danger btn-block" href="./" role="button">Voltar</a></center>

</select>   
    </form><center>


</form>

</center>

              </div>
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
</body>

</html>