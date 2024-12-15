<?php
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';

if (!isset($_SESSION)) {
    session_start();
}

$res22 = $DBcon->query("SELECT * FROM camconfig WHERE id=1");
$userRow22 = $res22->fetch_array();
$nomecam = $userRow22['nome'];
$cormenu = $userRow22['cormenu'];
$corexibidor = $userRow22['corexibidor'];
$corgeral = $userRow22['corgeral'];

if (!isset($_SESSION['userSession'])) {
    header("Location: acesso");
    exit(); // Encerra o script para evitar execução adicional
}

$res = $DBcon->query("SELECT * FROM usuarios WHERE user_id=".$_SESSION['userSession']);
$userRow = $res->fetch_array();
$usuario = $userRow['usuario'];
$nome = $userRow['nome'];
$usrid = $userRow['user_id'];
$presidente = $userRow['presidente'];

$res2 = $DBcon->query("SELECT id FROM enquetes ORDER BY id DESC LIMIT 1");
$userRow2 = $res2->fetch_array();
$lastid = $userRow2['id'] + 1;

if (isset($_POST['novaenquete'])) {
    $titulo = $_POST['tituloen'];
    $sobre = $_POST['sobreen'];

    // Validar os dados antes de inserir no banco de dados

    $titulo = $DBcon->real_escape_string($titulo);
    $sobre = $DBcon->real_escape_string($sobre);

    $query4 = "INSERT INTO duvidasfrequentes (duvida, resposta) VALUES ('$titulo', '$sobre')";
    if ($DBcon->query($query4)) {
        header("Refresh:0");
        exit(); // Encerra o script para evitar execução adicional
    } else {
        $msg2 = "<br><div class='alert alert-danger' role='alert'>
        <strong>Desculpe!</strong> Tente novamente mais tarde.
        </div>";
    }
}
?>

<!-- O resto do HTML da página continua abaixo -->

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Administração do Presidente
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
  <script>
$(document).on('change', '#enquete2', function(){
    var eid = $(this).find(':selected').data('eid');
    var mid = <?php echo $usrid; ?>;
    var cnpj = "<?php echo $usuario; ?>";
    var usr = mid;
    var usrname = cnpj;

    // Carregar candidatos
    $.ajax({
        url: "load_data.php",
        type: "POST",
        data: { eid: eid, mid: mid, cnpj: cnpj },
        dataType: "text",
        success: function (data) {
            if (data !== '') {
                $('#candidatos').replaceWith(data);
            } else {
                // Tratar quando não há dados
            }
        }
    });

    // Carregar resultados de votos
    $.ajax({
        url: "votos.php",
        type: "POST",
        data: { eid: eid, usr: usr, usrname: usrname },
        dataType: "text",
        success: function (data) {
            if (data !== '') {
                $('#resvotos').replaceWith(data);
            } else {
                // Tratar quando não há dados
            }
        }
    });
});
</script>


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
            <a class="navbar-brand" href="./">Câmara Municipal de <?php echo $nomecam;?></a>
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
                <center><h4 class="card-title">Dúvidas Frequentes</h4></center>
              </div>

              <?php
$queryu = $DBcon->query("SELECT * FROM usuarios ORDER BY presidente DESC LIMIT 1");
$countu = $queryu->num_rows;

if ($countu >= 1) {
    while ($enqueteeeu = $queryu->fetch_array()) {
        $prescam = $enqueteeeu['user_id'];
        if ($usrid == $prescam) {
            echo '
            <form role="form" action="" autocomplete="off" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" hidden>
                            <input type="text" class="form-control" name="lastide" value="' . $lastid . '" hidden>
                        </div>
                        <div class="form-group">
                            <label>Título da dúvida</label>
                            <input type="text" class="form-control" placeholder="Título da dúvida" name="tituloen">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Resposta</label>
                            <textarea rows="4" cols="80" class="form-control" placeholder="Resposta" name="sobreen"></textarea>
                        </div>
                    </div>
                </div>
                <center>
                    <button type="submit" class="btn btn-info" name="novaenquete">Enviar</button>
                </center>
                <br><br>
                <center>
                    <a class="btn btn-danger" href="administracaopr" role="button">Voltar</a>
                </center>
            </form>';
        }
    }
}
?>

              <div class="card-header">
                <h4 class="card-title"> </h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">


</select>   
    </form><center>


</form>

</center>
    </div><br>
            <div class="container" id="candidatos" name="candidatos"> </div>
            <div class="container" id="resvotos" name="resvotos"> </div>

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