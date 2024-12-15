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
  Câmara Municipal de     <?php 
  echo $nomecam;
?>  
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
            <a class="navbar-brand" href="./">  Câmara Municipal de     <?php 
  echo $nomecam;
?>  </a>
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
                <center><h4 class="card-title"> TV Câmara</h4>
                <center><a class="btn btn-danger" href="./acesso" role="button">Voltar</a></center>
                <?php
  //aa
  $query=$DBcon->query("SELECT * FROM tvcamara ORDER BY id DESC");
  $count=$query->num_rows;
  if($count>=1)
  { 
  while($enqueteee=$query->fetch_array())
  {         
         $nome = $enqueteee['titulo'];
         $sobre = $enqueteee['link'];

         echo '<div class="card" style="width: 18rem;">
         <div class="card-body">
           <h5 class="card-title">'.$nome.'</h5>
           <p class="card-text"><a class="btn btn-primary" href="'.$sobre.'" role="button">Veja o vídeo</a></p>
         </div>
       </div>';
         
  }
  }

  //aa
?>
                </center>
              </div>
              <div class="card-body">
                <div class="table-responsive">

<div class="row">
</div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <footer class="footer">
        <div class=" container-fluid ">
        <center><a class="btn btn-danger" href="./acesso" role="button">Voltar</a></center>
        </div>
      </footer>
    </div>
  </div>
</body>

</html>