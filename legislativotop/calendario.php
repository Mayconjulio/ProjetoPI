<?php
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_COOKIE['ccuserSession'])) {
    header("Location: acessovereador");
} else {
    $_SESSION['userSession'] = $_COOKIE['ccuserSession'];
}

$res2 = $DBcon->query("SELECT * FROM camconfig WHERE id=1");
$userRow2 = $res2->fetch_assoc();
$nomecam = $userRow2['nome'];
$cormenu = $userRow2['cormenu'];
$corexibidor = $userRow2['corexibidor'];
$corgeral = $userRow2['corgeral'];

$res = $DBcon->query("SELECT * FROM usuarios WHERE user_id=" . $_SESSION['userSession']);
$userRow = $res->fetch_assoc();
$usuario = $userRow['usuario'];
$nome = $userRow['nome'];
$id = $userRow['user_id'];
$fotovereador = $userRow['foto'];

if (isset($_POST['confirmaev'])) {
    $evento = strip_tags($_POST['evento']);
    $data = strip_tags($_POST['dataev']);
    $hora = strip_tags($_POST['horaev']);
    $obs = strip_tags($_POST['obs']);

    $evento = $DBcon->real_escape_string($evento);
    $data = $DBcon->real_escape_string($data);
    $hora = $DBcon->real_escape_string($hora);
    $obs = $DBcon->real_escape_string($obs);

    $query = "INSERT INTO calendario (evento, dataev, hora, obs) VALUES ('$evento','$data','$hora','$obs')";
    if ($DBcon->query($query)) {
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
    Calendário - Câmara Municipal de <?php echo $nomecam;?>
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet" />
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
<a href="conta" style="color:white;"><center> <img src="fotos/<?php echo $fotovereador;?>" height="32"></center>
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

          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Calendário</h4>

                <form role="form" action="" autocomplete="off" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Evento</label>
    <input type="text" class="form-control" id="evento" name="evento" placeholder="Dê um nome para o próximo evento">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Data</label>
    <input type="date" class="form-control" id="dataev" name="dataev" placeholder="Data do evento">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Hora</label>
    <input type="time" class="form-control" id="horaev" name="horaev" placeholder="Hora do evento">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Observações</label>
    <input type="text" class="form-control" id="obs" name="obs" placeholder="Observações para o evento">
  </div>
  <button type="submit" class="btn btn-primary" id="confirmaev" name="confirmaev">Confirmar evento</button>
                  </form>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="col-md-12">
                          <a href="./" class="btn btn-primary btn-block" style="background-color: blue;">Voltar</a>
                        </div>
                      </div>
                    </div>
                  </div>

              </div>
              <HR>  
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        Evento
                      </th>
                      <th>
                        Data
                      </th>
                      <th>
                        Observações
                      </th>
                    </thead>
                    <tbody>

                    <?php
$query=$DBcon->query("SELECT * FROM calendario ORDER BY dataev ASC");
$count=$query->num_rows;
if($count>=1)
{
  $pos = 0;
  while($usuario=$query->fetch_array())
  {
    $ev = $usuario['evento'];
    $data = $usuario['dataev'];
    $data = str_replace('/', '-', $data);
    $hora = $usuario['hora'];
    $obs = $usuario['obs'];
    $date = new DateTime($data);
    $datee = $date-> format( 'd/m/Y' );
    $horaa = new DateTime($hora);
    $horaaa = $horaa-> format( 'h:i' );
    echo '                      <tr>
    <td>
      '.$ev.'
    </td>
    <td>
    '.$datee.' às '.$horaaa.'
    </td>
    <td>
    '.$obs.'
    </td>
  </tr>';
  }
}
                    ?>

                    </tbody>
                  </table>
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
                <a href="https:/starsolutions.net.br//contato">
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