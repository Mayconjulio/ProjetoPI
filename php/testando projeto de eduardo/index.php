<?php
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';
error_reporting(0);

if (!isset($_SESSION)) {
    session_start();
}

$res22 = $DBcon->query("SELECT * FROM camconfig WHERE id=1");
$userRow22 = $res22->fetch_array();
$nomecam = $userRow22['nome'];
$cormenu = $userRow22['cormenu'];
$corexibidor = $userRow22['corexibidor'];
$corgeral = $userRow22['corgeral'];
$discurso = $userRow22['discurso'];
$aparte = $userRow22['aparte'];
$qordem = $userRow22['qordem'];
$cfinal = $userRow22['cfinal'];
$tempresenca = $userRow22['tempresenca'];

include_once 'Dbconnect.php';

if (!isset($_SESSION['userSession']) && !isset($_COOKIE['ccuserSession'])) {
    header("Location: acessovereador");
    exit;
} elseif (!isset($_SESSION['userSession'])) {
    $_SESSION['userSession'] = $_COOKIE['ccuserSession'];
}

$res = $DBcon->query("SELECT * FROM usuarios WHERE user_id='" . $_SESSION['userSession'] . "'");
$userRow = $res->fetch_array();
$usuario = $userRow['usuario'];
$nome = $userRow['nome'];
$usrid = $userRow['user_id'];
$presidente = $userRow['presidente'];
$fotovereador = $userRow['foto'];

$res2 = $DBcon->query("SELECT id FROM enquetes ORDER BY id DESC LIMIT 1");
$userRow2 = $res2->fetch_array();
$countuuu = $res2->num_rows;
$lastid = $countuuu >= 1 ? $userRow2['id'] + 1 : 1;

if (isset($_POST['votar'])) {
    $modelid = strip_tags($_POST['votar']);
    $modelid = $DBcon->real_escape_string($modelid);
    $idenquete = strip_tags($_POST['idenquete']);
    $idenquete = $DBcon->real_escape_string($idenquete);
    $idopcao = strip_tags($_POST['idopcao']);
    $idopcao = $DBcon->real_escape_string($idopcao);

    $verifica = $DBcon->query("SELECT * FROM votos WHERE usuario='" . $usuario . "' AND enqueteid='" . $idenquete . "'");
    $contagem = $verifica->num_rows;

    if ($contagem >= 1) {
        $query22 = $DBcon->query("SELECT * FROM modelos WHERE model_id='" . $idopcao . "'");
        if ($userRow2 = $query22->fetch_array()) {
            $votos = $userRow2['votos'];
            $b = 1;
            $total = $votos + $b;
            $query4 = "UPDATE modelos SET votos='$total' WHERE model_id='" . $idopcao . "'";
            if ($DBcon->query($query4)) {
                $query444 = "UPDATE votos SET modelo='$modelid' WHERE usuario='$usuario' AND enqueteid='$idenquete'";
                if ($DBcon->query($query444)) {
                    header("Refresh:0");
                    exit;
                }
            }
        }
    } else {
        $query = "INSERT INTO votos (nome, usuario, enqueteid, modelo) VALUES('$nome','$usuario', '$idenquete','$modelid')";
        $query2 = $DBcon->query("SELECT * FROM modelos WHERE model_id='" . $idopcao . "'");
        if ($userRow = $query2->fetch_array()) {
            $votos = $userRow['votos'];
            $b = 1;
            $total = $votos + $b;
            $query3 = "UPDATE modelos SET votos='$total' WHERE model_id='" . $idopcao . "'";
            if ($DBcon->query($query3)) {
                //echo "Registrando voto..."
            }
        }
        if ($DBcon->query($query)) {
            header("Refresh:0");
            exit;
        }
    }
}

if (isset($_POST['removevoto'])) {
    $idenquete = strip_tags($_POST['idenquete']);
    $idenquete = $DBcon->real_escape_string($idenquete);
    $idopcao = strip_tags($_POST['idopcao']);
    $idopcao = $DBcon->real_escape_string($idopcao);

    $verifica = $DBcon->query("SELECT * FROM votos WHERE usuario='" . $usuario . "' AND enqueteid='" . $idenquete . "'");
    $contagem = $verifica->num_rows;

    if ($contagem >= 1) {
        $query = "DELETE FROM votos WHERE usuario='" . $usuario . "' AND enqueteid='" . $idenquete . "'";
        if ($DBcon->query($query)) {
            header("Refresh:0");
            exit;
        }
    }
}

if (isset($_POST['novaenquete'])) {
    $titulo = strip_tags($_POST['tituloen']);
    $sobre = strip_tags($_POST['sobreen']);
    $lastidd = strip_tags($_POST['lastide']);
    $lastidd = $DBcon->real_escape_string($lastidd);
    $titulo = $DBcon->real_escape_string($titulo);
    $sobre = $DBcon->real_escape_string($sobre);
    $catcat = strip_tags($_POST['categoria']);
    $catcat = $DBcon->real_escape_string($catcat);
    $datahj = date("d/m/Y");
    $horahj = date("h:i:sa");

    $query = "INSERT INTO enquetes(id,titulo,descricao,categoria,inicio,fim) VALUES('$lastidd','$titulo','$sobre','$catcat','$datahj','$horahj')";
    if ($DBcon->query($query)) {
        $query2 = "INSERT INTO modelos(idenquete,nome,img) VALUES('$lastidd','A Favor','afavor.png')";
        if ($DBcon->query($query2)) {
            $query3 = "INSERT INTO modelos(idenquete,nome,img) VALUES('$lastidd','Contra','contra.png')";
            if ($DBcon->query($query3)) {
                $query4 = "INSERT INTO modelos(idenquete,nome,img) VALUES('$lastidd','Abster','abster.png')";
                if ($DBcon->query($query4)) {
                    header("Refresh:0");
                    exit;
                }
            }
        }
    } else {
        $msg2 = "<br><div class='alert alert-danger' role='alert'>
                  <strong>Desculpe!</strong> Tente novamente mais tarde.
              </div>";
    }
}

if (isset($_POST['novasess'])) {
    $titulo = strip_tags($_POST['nomesessao']);
    $titulo = $DBcon->real_escape_string($titulo);

    $query = "INSERT INTO sessoes(sessao) VALUES('$titulo')";
    if ($DBcon->query($query)) {
        header("Refresh:0");
        exit;
    } else {
        $msg2 = "<br><div class='alert alert-danger' role='alert'>
                  <strong>Desculpe!</strong> Tente novamente mais tarde.
              </div>";
    }
}

if (isset($_POST['novaenquetee'])) {
    $titulo = strip_tags($_POST['tituloenn']);
    $titulo = $DBcon->real_escape_string($titulo);
    $queryo = "INSERT INTO ordemdodia(ordem) VALUES('$titulo')";
    if ($DBcon->query($queryo)) {
        header("Refresh:0");
        exit;
    } else {
        $msg2 = "<br><div class='alert alert-danger' role='alert'>
                  <strong>Desculpe!</strong> Tente novamente mais tarde.
              </div>";
    }
}

if (isset($_POST['novodiscurso'])) {
    $eidval = strip_tags($_POST['eidval']);
    $eidval = $DBcon->real_escape_string($eidval);
    $query4 = "INSERT INTO discurso(idvotacao,vereador,tipo) VALUES('$eidval','$usrid','discurso')";
    if ($DBcon->query($query4)) {
        header("Refresh:0");
        exit;
    } else {
        $msg2 = "<br><div class='alert alert-danger' role='alert'>
                  <strong>Desculpe!</strong> Tente novamente mais tarde.
              </div>";
    }
}

if (isset($_POST['novocontra'])) {
    $eidval = strip_tags($_POST['eidval']);
    $eidval = $DBcon->real_escape_string($eidval);
    $query4 = "INSERT INTO discurso(idvotacao,vereador,tipo) VALUES('$eidval','$usrid','contra')";
    if ($DBcon->query($query4)) {
        header("Refresh:0");
        exit;
    } else {
        $msg2 = "<br><div class='alert alert-danger' role='alert'>
                  <strong>Desculpe!</strong> Tente novamente mais tarde.
              </div>";
    }
}
?>

<?php
if (isset($_POST['novaordem'])) {
  $eidval = isset($_POST['eidval']) ? $_POST['eidval'] : '';
  $eidval = strip_tags($eidval);
  $eidval = $DBcon->real_escape_string($eidval);

  $query = "INSERT INTO discurso (idvotacao, vereador, tipo) VALUES ('$eidval', '$usrid', 'ordem')";

  if ($DBcon->query($query)) {
      header("Refresh: 0");
      exit; // Encerrar o script após a redireção para evitar execução desnecessária
  } else {
      $msg2 = "<br><div class='alert alert-danger' role='alert'>
              <strong>Desculpe!</strong> Tente novamente mais tarde.
          </div>";
  }
}
?>
<?php
if (isset($_POST['novaconsideracao'])) {
  $eidval = isset($_POST['eidval']) ? $_POST['eidval'] : '';
  $eidval = strip_tags($eidval);
  $eidval = $DBcon->real_escape_string($eidval);

  $query = "INSERT INTO discurso (idvotacao, vereador, tipo) VALUES ('$eidval', '$usrid', 'consideracao')";

  if ($DBcon->query($query)) {
      header("Refresh: 0");
      exit; // Encerrar o script após a redireção para evitar execução desnecessária
  } else {
      $msg2 = "<br><div class='alert alert-danger' role='alert'>
              <strong>Desculpe!</strong> Tente novamente mais tarde.
          </div>";
  }
}
?>
<?php
if (isset($_POST['aceitar'])) {
  $iddisc1 = isset($_POST['iddisc1']) ? $_POST['iddisc1'] : '';
  $iddisc1 = strip_tags($iddisc1);
  $iddisc1 = $DBcon->real_escape_string($iddisc1);

  $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
  $tipo = strip_tags($tipo);
  $tipo = $DBcon->real_escape_string($tipo);

  // Defina o intervalo de tempo associado a cada tipo
  $intervalos = array(
      "discurso" => $discurso,
      "contra" => $aparte,
      "ordem" => $qordem,
  );

  if (array_key_exists($tipo, $intervalos)) {
      $timeCheck = $intervalos[$tipo];
      $now = date("Y-m-d H:i:s");
      $tenMinFromNow = date('Y-m-d H:i:s', strtotime($now . '+' . $timeCheck . ' minutes'));

      // Verificar se já existe um discurso em andamento
      $queryu = $DBcon->query("SELECT * FROM discurso WHERE status=1 LIMIT 1");
      $countu = $queryu->num_rows;

      if ($countu >= 1) {
          $enqueteeeup = $queryu->fetch_array();
          $oldFim = $enqueteeeup['fim'];
          $tenMinFromNow2 = date('Y-m-d H:i:s', strtotime($oldFim . '+' . $timeCheck . ' minutes'));

          $queryup = "UPDATE discurso SET fim='" . $tenMinFromNow2 . "' WHERE status=1 LIMIT 1";

          if ($DBcon->query($queryup)) {
              $query = "UPDATE discurso SET status=1, inicio='" . $now . "',fim='" . $tenMinFromNow . "' WHERE id='" . $iddisc1 . "'";

              if ($DBcon->query($query)) {
                  header("Refresh: 0");
                  exit;
              } else {
                  $msg2 = "<br><div class='alert alert-danger' role='alert'>
                          <strong>Desculpe!</strong> Tente novamente mais tarde.
                          </div>";
              }
          } else {
              echo "<script>alert('erro3');</script>";
          }
      } else {
          $query = "UPDATE discurso SET status=1, inicio='" . $now . "',fim='" . $tenMinFromNow . "' WHERE id='" . $iddisc1 . "'";

          if ($DBcon->query($query)) {
              header("Refresh: 0");
              exit;
          } else {
              $msg2 = "<br><div class='alert alert-danger' role='alert'>
                      <strong>Desculpe!</strong> Tente novamente mais tarde.
                      </div>";
          }
      }
  } else {
      // Tipo inválido, tratar o erro conforme necessário
  }
}

?>
<?php
if (isset($_POST['negar'])) {
  $iddisc1 = isset($_POST['iddisc1']) ? $_POST['iddisc1'] : '';
  $iddisc1 = strip_tags($iddisc1);
  $iddisc1 = $DBcon->real_escape_string($iddisc1);

  $query = "UPDATE discurso SET status=2 WHERE id='" . $iddisc1 . "'";

  if ($DBcon->query($query)) {
      header("Refresh: 0");
      exit; // Encerrar o script após a redireção para evitar execução desnecessária
  } else {
      $msg2 = "<br><div class='alert alert-danger' role='alert'>
              <strong>Desculpe!</strong> Tente novamente mais tarde.
          </div>";
  }
}
?>
<?php
if (isset($_POST['interromper'])) {
  $iddisc1 = isset($_POST['discnow1']) ? $_POST['discnow1'] : '';
  $iddisc1 = strip_tags($iddisc1);
  $iddisc1 = $DBcon->real_escape_string($iddisc1);

  $query = "DELETE FROM discurso WHERE id='" . $iddisc1 . "'";

  if ($DBcon->query($query)) {
      header("Refresh: 0");
      exit; // Encerrar o script após a redireção para evitar execução desnecessária
  } else {
      $msg2 = "<br><div class='alert alert-danger' role='alert'>
              <strong>Desculpe!</strong> Tente novamente mais tarde.
          </div>";
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
    Votações
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
  <script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
  <!-- Chart JS -->
  <script src="assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>

  <script>  
$(document).on('change', '#selcategoria', function() {
    var eid = $(this).find(':selected').data('sssid');
    var mid = <?php echo $usrid; ?>;
    var cnpj = "<?php echo $usuario; ?>";
    $.ajax({
        url: "load_sessao.php",
        type: "POST",
        data: { eid: eid, mid: mid, cnpj: cnpj },
        dataType: "text",
        success: function(data) {
            if (data !== '') {
                $('#lstvereadorespresentes').remove();
                $('#lstenquetes').replaceWith(data);
            } else {
                // Tratar o caso em que o retorno é vazio (opcional)
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Erro na requisição AJAX:", textStatus, errorThrown);
            // Tratar erros de requisição (opcional)
        }
    });
});
 </script>

<script>  
$(document).on('change', '#vpresentes', function() {
    var eid = $(this).find(':selected').data('eid');

    $.ajax({
        url: "marcaPresenca.php",
        type: "POST",
        data: { eid: eid },
        dataType: "text",
        success: function(data) {
            $('#lstvereadorespresentes').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Erro na requisição AJAX:", textStatus, errorThrown);
            // Tratar erros de requisição, se necessário
        }
    });
});  
 </script>

  <script>  
$(document).on('change', '#enquete2', function() {
    var eid = $(this).find(':selected').data('eid');
    Cookies.set('votacao', eid);

    var mid = <?php echo $usrid; ?>;
    var cnpj = "<?php echo addslashes($usuario); ?>";

    $.ajax({
        url: "load_data.php",
        type: "POST",
        data: { eid: eid, mid: mid, cnpj: cnpj },
        dataType: "text",
        success: function(data) {
            $('#candidatos').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Erro na requisição AJAX:", textStatus, errorThrown);
            // Tratar erros de requisição, se necessário
        }
    });
}); 
 </script>
   <script>  
$(document).on('change', '#enquete2', function() {
    var eid = $(this).find(':selected').data('eid');
    Cookies.set('votacao', eid);

    var mid = <?php echo json_encode($usrid); ?>;
    var cnpj = "<?php echo addslashes($usuario); ?>";

    $.ajax({
        url: "load_data2.php",
        type: "POST",
        data: { eid: eid, mid: mid, cnpj: cnpj },
        dataType: "text",
        success: function(data) {
            $('#results').html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Erro na requisição AJAX:", textStatus, errorThrown);
            // Tratar erros de requisição, se necessário
        }
    });
});
 </script>
  <script>   
$(document).on('change', '#enquete2', function() {
    var eid = $(this).find(':selected').data('eid');
    Cookies.set('votacao', eid);
    var usr = "<?php echo $usrid; ?>";
    var usrname = "<?php echo $usuario; ?>";

    $.ajax({
        url: "votos.php",
        type: "POST",
        data: { eid: eid, usr: usr, usrname: usrname },
        dataType: "text",
        success: function(data) {
            if (data !== '') {
                $('#resvotos').html(data); // Usar .html() em vez de .replaceWith() para substituir o conteúdo
            } else {
                // Tratar o caso em que o retorno é vazio (opcional)
            }
        },
        error: function() {
            // Tratar erros de requisição (opcional)
        }
    });
});
 </script>
<style>
.overrideRed {background-color: red !important;}
.overrideGreen {background-color: green !important;}
.overrideGray {background-color: grey !important;}
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

  /* Estilo para o select */
  select.form-control {
    width: 100%;
    font-size: 30px; /* Defina o tamanho de fonte desejado */
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
        <a class="simple-text logo-normal"  style="color: black;">
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
          <div class="col-md-12"><br>
            <div class="card">
<?php

?> 
<?php
$queryu = $DBcon->query("SELECT user_id FROM usuarios ORDER BY presidente DESC LIMIT 1");
$isPresident = $queryu->num_rows >= 1;

?>

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Ordem do Dia</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">

<?php if ($isPresident): ?>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
    <?php
    $queryordem = $DBcon->query("SELECT ordem FROM ordemdodia ORDER BY id ASC");
    while ($enqueteordem = $queryordem->fetch_assoc()) {
      $ordem = $enqueteordem['ordem'];
      echo '<div class="alert alert-info" role="alert">' . htmlspecialchars($ordem) . '</div>';
    }
    ?>
  </div>
  <div class="tab-pane fade" id="sess" role="tabpanel" aria-labelledby="sess-tab">
    <form role="form" action="" autocomplete="off" method="post">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <strong><label>INFORME A SESSÃO Nº</label></strong>
                <input type="text" class="form-control" placeholder="Definir a sessão para organizar votações. Ex: 123/2022" name="nomesessao">
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary" name="novasess">REGISTRAR SESSÃO</button>
        </div>
      </div>
    </form>
  </div>
  <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
    <form role="form" action="" autocomplete="off" method="post">
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <strong><label>SESSÃO Nº</label></strong>
                <select class="form-control" id="categoria" name="categoria" required>
                  <option id="1" data-sssid="1" value="1" selected="selected">Selecione uma sessão</option>
                  <?php
                  $query = $DBcon->query("SELECT id, sessao FROM sessoes ORDER BY id DESC");
                  while ($row = $query->fetch_assoc()) {
                    $id = $row['id'];
                    $sessao = $row['sessao'];
                    echo '<option id="sessao_' . $id . '" data-sssid="' . $id . '" style="background-color: grey; color: white;" value="' . $sessao . '">SESSÃO: ' . htmlspecialchars($sessao) . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group" hidden>
            <input type="text" class="form-control" name="lastide" value="<?php echo htmlspecialchars($lastid); ?>" >
          </div>
          <div class="form-group">
            <label>Nome da votação</label>
            <input type="text" class="form-control" placeholder="Ex: Projeto de Lei nº1111/2021" name="tituloen">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Descrição</label>
            <textarea rows="4" cols="80" class="form-control" placeholder="Descrição da votação" name="sobreen"></textarea>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary" name="novaenquete">Enviar projeto para votação</button>
    </form>
  </div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <form role="form" action="" autocomplete="off" method="post">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label><strong>Ordem do Dia</strong></label>
            <input type="text" class="form-control" placeholder="Ex: Projeto de Lei nº1111/2021" name="tituloenn">
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-primary" name="novaenquetee">Enviar Ordem do Dia</button>
    </form>
  </div>
<?php else: ?>
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
    <?php
    $queryordem = $DBcon->query("SELECT ordem FROM ordemdodia ORDER BY id ASC");
    while ($enqueteordem = $queryordem->fetch_assoc()) {
      $ordem = $enqueteordem['ordem'];
      echo '<div class="alert alert-info" role="alert">' . htmlspecialchars($ordem) . '</div>';
    }
    ?>
  </div>
<?php endif; ?>

</div>


              <div class="card-header">
                <h4 class="card-title"> Votações</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">

                <?php
echo '<select class="form-control" id="selcategoria" name="selcategoria" required>
<option id="1" data-sssid="1" value="1" selected="selected">Selecione uma sessão</option> ';
            
            $query=$DBcon->query("SELECT * FROM sessoes ORDER BY id DESC");
$count=$query->num_rows;
if($count>=1)
{
while($enquete=$query->fetch_array())
{
       $id = $enquete['id'];
       $enquete = $enquete['sessao'];
          echo '<option id="'.$enquete.'" data-sssid="'.$enquete.'" style="background-color: grey; color: white;"  value="'.$enquete.'">SESSÃO: '.$enquete.'</option> ';
}
}

            
            
            echo '</select><br>';
?>
<div id="lstenquetes" name="lstenquetes">

</div>

</select>   
    </form><center>


</form>

</center>
    </div>

    <div class="container" id="results" name="results"> </div>
    <div class="container" id="candidatos" name="candidatos"> </div>
            
    <div class="container" name="discursando" id="discursando"></div><br>        

            <div class="container" id="resvotos" name="resvotos"> </div>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <?php
$queryu = $DBcon->query("SELECT user_id FROM usuarios ORDER BY presidente DESC LIMIT 1");
$enqueteeeu = $queryu->fetch_array();
$prescam = $enqueteeeu['user_id'];

// Definir $presidastat com base na comparação entre $usrid e $prescam
$presidastat = ($usrid == $prescam) ? 1 : 0;
?>
<?php
// Definir uma variável PHP que contém o código JavaScript
$javascriptCode = '
<script>
$(document).ready(function() {
  var discursandoIntervalId, discursoTimerIntervalId;
  
  // Função para buscar os pedidos de discurso
  function getDiscursoData() {
    var eid = $("#enquete2").find(":selected").data("eid");
    var prestat = '.$presidastat.';

    $.ajax({
      url: "discursando2.php",
      type: "POST",
      data: {eid: eid, prestat: prestat},
      dataType: "text",
      success: function(data) {
        if (data != "") {
          if ("'.$usuario.'" === "Telao") {
            window.location.replace("discursotelao");
          } else {
            $("#discursando").replaceWith(data);
          }
        } else {
          // Fazer algo quando não há dados
        }
      }
    });
  }

  // Intervalo para buscar os pedidos de discurso a cada 1 segundo
  $("#enquete2").on("change", function() {
    clearInterval(discursandoIntervalId);
    discursandoIntervalId = setInterval(getDiscursoData, 1000);
  });

  // Timer de discurso
  function checkDiscursoTimer() {
    var tempo = $("#trest1").val();

    if (tempo === "0:2") {
      var disc1id = $("#discnow1").val();

      $.ajax({
        url: "fimdiscurso1.php",
        type: "POST",
        data: {disc1id: disc1id},
        dataType: "text",
        success: function(data) {
          if (data !== "") {
            $("#discursando").replaceWith(data);
            var audio = new Audio("alert.wav");
            audio.play();
          } else {
            // Fazer algo quando não há dados
          }
        }
      });
    } else {
      // Fazer algo quando o tempo não é válido
    }
  }

  // Intervalo para verificar o timer de discurso a cada 1 segundo
  discursoTimerIntervalId = setInterval(checkDiscursoTimer, 1000);
});
</script>';

// Imprimir o código JavaScript no local desejado (após o carregamento das bibliotecas jQuery, se necessário)
echo $javascriptCode;
?>


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