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
        if(!isset($_COOKIE['ccuserSession']))
        {
            header("Location: acessovereador");
        } 
    else
    {
      $_SESSION['userSession'] = $_COOKIE['ccuserSession'];
    }
$res=$DBcon->query("SELECT * FROM usuarios WHERE user_id='".$_SESSION['userSession']."'");
$userRow=$res->fetch_array();
$usuario = $userRow['usuario'];
$nome = $userRow['nome'];
$id = $userRow['user_id'];
?>
<!DOCTYPE html>
<html lang="pt">

<head><meta charset="utf-8">
  
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Legislativo <?php echo $nomecam;?>
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
</head>

<body class="" style="background-color:#9E6240;">
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
        <li class="active ">
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

      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12">
              <div class="card card-stats">
                  <div class="card-body">

                  <div class="container">
  <div class="row">
<?php
  //aa
  echo '<div class="col-sm"><a class="btn btn-info" href="orcamentopa" role="button">ORÇAMENTO PARTICIPATIVO</a></div>';
  echo '<div class="col-sm"><a class="btn btn-info" href="sugestaolei" role="button">SUGESTÕES DE LEIS MUNICIPAIS</a></div>';
  echo '<div class="col-sm"><a class="btn btn-info" href="mensagensdopovo" role="button">MENSAGENS DO POVO</a></div>';
  echo '<div class="col-sm"><a class="btn btn-danger" href="listadenuncias" role="button">DENÚNCIAS</a></div>';

  $query=$DBcon->query("SELECT * FROM usuarios ORDER BY presidente DESC LIMIT 1");
  $count=$query->num_rows;
  if($count>=1)
  { 
  while($enqueteee=$query->fetch_array())
  {         
         $idpr = $enqueteee['user_id'];
         if($id==$idpr)
         {
          echo '<div class="col-sm"><a class="btn btn-primary" href="administracaopr" role="button">ÁREA DO PRESIDENTE</a></div>';
         }

          
         
  }
  }
  
  //aa
?>
 </div></div>             
                  
                      <div class="row">
                          <div class="col-md-4">
                              <div class="statistics">
                                  <div class="info">
                                      <div class="icon icon-primary">
                                          <i class="now-ui-icons ui-2_chat-round"></i>
                                      </div>
                                      <h3 class="info-title">
                                      <?php
$result = $DBcon->query("SELECT count(*)as media FROM enquetes");
$row = $result->fetch_array();
$reputationvalll = $row['media'];
echo $reputationvalll;
                                      ?>
                                      </h3>
                                      <h6 class="stats-title">VOTAÇÕES</h6>
                                  </div>
                              </div>
                          </div>
                          <!--
                          <div class="col-md-4">
                              <div class="statistics">
                                  <div class="info">
                                      <div class="icon icon-success">
                                          <i class="now-ui-icons business_money-coins"></i>
                                      </div>
                                      <h3 class="info-title"><small>R$</small>
                                                              //$result = $DBcon->query("SELECT sum(valgasto)as media FROM gastos");
                                                              //$row = $result->fetch_array();
                                                              //$valgasto = $row['media'];
                                                              //echo number_format($valgasto, 2, ',', '.');
                                                             
                                                              </h3>
                                      <h6 class="stats-title">GASTOS DA CÂMARA</h6>
                                  </div>
                              </div>

                          </div>-->
                          <div class="col-md-4">
                              <div class="statistics">
                                  <div class="info">
                                      <div class="icon icon-info">
                                          <i class="now-ui-icons users_single-02"></i>
                                      </div>
                                      <h3 class="info-title">
                                      <?php
$result = $DBcon->query("SELECT count(*)as media FROM usuarios");
$row = $result->fetch_array();
$reputationval = $row['media'];
echo $reputationval-1;
                                      ?>
                                      </h3>
                                      <h6 class="stats-title">VEREADORES ELEITOS</h6>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
      
              </div>
          </div>
      </div>

        <div class="row">
          <div class="col-md-6">
            <div class="card  card-tasks">
              <div class="card-header ">
                <h5 class="card-category">Votações recentes</h5>
                <h4 class="card-title">Votações</h4>
              </div>
              <div class="card-body ">
                <div class="table-full-width table-responsive">
                  <table class="table">
                    <tbody>
                    <?php
$query=$DBcon->query("SELECT * FROM enquetes ORDER BY id DESC LIMIT 3");
$count=$query->num_rows;
if($count>=1)
{
  while($usuario=$query->fetch_array())
  {
    $titulo = $usuario['titulo'];
    $descr = $usuario['descricao'];

    echo '                      <tr>
    <td>
    </td>
    <td class="text-left">'.$titulo.' - '.$descr.'</td>
    <td class="td-actions text-right">
       <button type="button" rel="tooltip" title="" class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Edit Task">
        <i hidden class="now-ui-icons ui-2_settings-90"></i>
      </button>
      <button type="button" rel="tooltip" title="" class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral" data-original-title="Remove">
        <i hidden class="now-ui-icons ui-1_simple-remove"></i>
      </button> 
    </td>
  </tr>';
  }
}
                    ?>

                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                Últimas três(3) votações mais recentes, para mais informações, acesse a página de votação.
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h5 class="card-category">Lista de vereadores em exercício</h5>
                <h4 class="card-title"> Vereadores</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        Nome
                      </th>
                      <th>
                        Partido
                      </th>
                      <th>
                        Sigla
                      </th>
                    </thead>
                    <tbody>
                    <?php
$query=$DBcon->query("SELECT * FROM usuarios ORDER BY user_id DESC LIMIT 3");
$count=$query->num_rows;
if($count>=1)
{
  $pos = 0;
  while($usuario=$query->fetch_array())
  {
    $nome = $usuario['nome'];
    $partido = $usuario['partido'];
    $sigla = $usuario['sigla'];

if($nome==".")
{
    
}
else
{
        echo '                      <tr>
    <td>
      '.utf8_decode($nome).'
    </td>
    <td>
    '.$partido.'
    </td>
    <td>
    '.$sigla.'
    </td>
  </tr>';
}

  }
}
                    ?>


                    </tbody>
                  </table>
                </div>

                  <hr>
                  <div class="stats">
                  <a href="lista">Veja a lista completa de vereadores eleitos em exercício clicando aqui</a>
                  </div>

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
                <a href="https://agenciafantastika.com/contato">
                  SUPORTE TÉCNICO
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright" id="copyright">
            &copy; <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>, Feito por <a href="https://agenciafantastika.com" target="_blank">Agência Fantastika</a>.
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