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

if (!isset($_SESSION['userSession']) && !isset($_COOKIE['ccuserSession'])) {
    header("Location: acessovereador");
} else {
    $_SESSION['userSession'] = $_COOKIE['ccuserSession'];
}

$res = $DBcon->query("SELECT * FROM usuarios WHERE user_id='".$_SESSION['userSession']."'");
$userRow = $res->fetch_array();
$usuario = $userRow['usuario'];
$nome = $userRow['nome'];
$usrid = $userRow['user_id'];
$presidente = $userRow['presidente'];

$res2 = $DBcon->query("SELECT id FROM enquetes ORDER BY id DESC LIMIT 1");
$userRow2 = $res2->fetch_array();
$countuuu = $res2->num_rows;

if ($countuuu >= 1) { 
    $lastid = $userRow2['id'] + 1;
} else {
    $lastid = 1;
}

if (isset($_POST['votar'])) {
    $modelid = strip_tags($_POST['votar']);
    $idenquete =  strip_tags($_POST['idenquete']);
    $idopcao =  strip_tags($_POST['idopcao']);

    $verifica = $DBcon->query("SELECT * FROM votos WHERE usuario='".$usuario."' AND enqueteid='".$idenquete."'");    
    $contagem = $verifica->num_rows;

    if ($contagem >= 1) {
        $query22 = $DBcon->query("SELECT * FROM modelos WHERE model_id='".$idopcao."'");
        if ($userRow2 = $query22->fetch_array()) {
            $votos = $userRow2['votos'];
            $b = 1;
            $total = $votos + $b;
            $query4 = "UPDATE modelos SET votos='$total' WHERE model_id='".$idopcao."'";
            
            if ($DBcon->query($query4)) {
                $query444 = "UPDATE votos SET modelo='$modelid' WHERE usuario='$usuario' AND enqueteid='$idenquete'";
                if ($DBcon->query($query444)) {
                    header("Refresh:0");
                }
            }
        }
    } else {
        $query = "INSERT INTO votos (nome, usuario, enqueteid, modelo) VALUES('$nome','$usuario', '$idenquete','$modelid')";
        $query2 = $DBcon->query("SELECT * FROM modelos WHERE model_id='".$idopcao."'");

        if ($userRow = $query2->fetch_array()) {
            $votos = $userRow['votos'];
            $b = 1;
            $total = $votos + $b;
            $query3 = "UPDATE modelos SET votos='$total' WHERE model_id='".$idopcao."'";

            if ($DBcon->query($query3)) {
                if ($DBcon->query($query)) {
                    header("Refresh:0");
                } 
            }
        }
    }
} else {}

if (isset($_POST['removevoto'])) {
    $idenquete =  strip_tags($_POST['idenquete']);
    $idopcao =  strip_tags($_POST['idopcao']);

    $verifica = $DBcon->query("SELECT * FROM votos WHERE usuario='".$usuario."' AND enqueteid='".$idenquete."'");    
    $contagem = $verifica->num_rows;

    if ($contagem >= 1) {
        $query = "DELETE FROM votos WHERE usuario='".$usuario."' AND enqueteid='".$idenquete."'";
        if ($DBcon->query($query)) {
            header("Refresh:0");
        } 
    } else {}
} else {}

if (isset($_POST['novaenquete'])) {
    $titulo = strip_tags($_POST['tituloen']);
    $sobre = strip_tags($_POST['sobreen']);
    $lastidd = strip_tags($_POST['lastide']);
    $catcat = strip_tags($_POST['categoria']);
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
    $query = "INSERT INTO sessoes(sessao) VALUES('$titulo')";

    if ($DBcon->query($query)) {
        header("Refresh:0");
    } else {
        $msg2 = "<br><div class='alert alert-danger' role='alert'>
        <strong>Desculpe!</strong> Tente novamente mais tarde.
        </div>";
    }
}

if (isset($_POST['novaenquetee'])) {
    $titulo = strip_tags($_POST['tituloenn']);
    $queryo = "INSERT INTO ordemdodia(ordem) VALUES('$titulo')";

    if ($DBcon->query($queryo)) {
        header("Refresh:0");
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
      $(document).on('change', '#selcategoria', function(){  
           var eid = $(this).find(':selected').data('sssid');
           var mid = <?php echo $usrid;?>;
           var cnpj = "<?php echo $usuario;?>";
           $.ajax({  
                url:"load_sessao.php",
                type: "POST",
                data:{eid:eid,mid:mid,cnpj:cnpj},  
                dataType:"text",  
                success:function(data)  
                {  
                     if(data != '')  
                     {  
                         $('#lstenquetes').replaceWith(data); 
                     }  
                     else  
                     {  
                     }  
                }
                
           });  
      });  
 </script>

  <script>  
      $(document).on('change', '#enquete2', function(){  
           var eid = $(this).find(':selected').data('eid');
           Cookies.set('votacao', eid);
           var mid = <?php echo $usrid;?>;
           var cnpj = "<?php echo $usuario;?>";
           $.ajax({  
                url:"load_data.php",
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
 </script>
   <script>  
      $(document).on('change', '#enquete2', function(){  
           var eid = $(this).find(':selected').data('eid');
           Cookies.set('votacao', eid);
           var mid = <?php echo $usrid;?>;
           var cnpj = "<?php echo $usuario;?>";
           $.ajax({  
                url:"load_data2.php",
                type: "POST",
                data:{eid:eid,mid:mid,cnpj:cnpj},  
                dataType:"text",  
                success:function(data)  
                {  
                     if(data != '')  
                     {  
                         $('#results').replaceWith(data); 
                     }  
                     else  
                     {  
                     }  
                }  
           });  
      });  
 </script>
  <script>   
      $(document).on('change', '#enquete2', function(){  
           var eid = $(this).find(':selected').data('eid');
           Cookies.set('votacao', eid);
           var usr = "<?php echo $usrid;?>";
           var usrname = "<?php echo $usuario;?>";
           $.ajax({  
                url:"votos.php",
                type: "POST",
                data:{eid:eid,usr:usr,usrname:usrname},  
                dataType:"text",  
                success:function(data)  
                {  
                     if(data != '')  
                     {  
                         $('#resvotos').replaceWith(data); 
                     }  
                     else  
                     {  
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
        <a class="simple-text logo-normal"  style="color: black;">
PODER LEGISLATIVO
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="./" style="color: black;">
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
          <li class="active">
            <a href="./votacoes" style="color: black;">
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
        <div class="row">
          <div class="col-md-12">
            <div class="card">
<?php

?>
<?php
    $queryu=$DBcon->query("SELECT * FROM usuarios ORDER BY presidente DESC LIMIT 1");
    $countu=$queryu->num_rows;
    if($countu>=1)
    { 
    while($enqueteeeu=$queryu->fetch_array())
    {  
    $prescam = $enqueteeeu['user_id'];
    if($usrid == $prescam)
    {
      echo '

      <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Ordem do Dia</a>
     </li>

     <li class="nav-item" role="presentation">
     <a class="nav-link" id="sess-tab" data-toggle="tab" href="#sess" role="tab" aria-controls="sess" aria-selected="true">Iniciar Sessão</a>
   </li>

  <li class="nav-item" role="presentation">
    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Adicionar votação</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Adicionar Ordem do dia</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">

<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

';

$queryordem=$DBcon->query("SELECT * FROM ordemdodia ORDER BY id ASC");
$countordem=$queryordem->num_rows;
if($countordem>=1)
{ 
while($enqueteordem=$queryordem->fetch_array())
{  
$ordem = $enqueteordem['ordem'];
echo '<div class="alert alert-info" role="alert">'.$ordem.'</div>';
}
}

echo '</div>

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
</form>

</div></div></div>

  <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
  
  <form role="form" action="" autocomplete="off" method="post">
            <div class="row">
        <div class="col-md-12">

        <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <strong><label>SESSÃO Nº</label></strong>
            <select class="form-control" id="categoria" name="categoria" required>
<option id="1" data-sssid="1" value="1" selected="selected">Selecione uma sessão</option> ';
            
            $query=$DBcon->query("SELECT * FROM sessoes ORDER BY id DESC");
$count=$query->num_rows;
if($count>=1)
{
while($enquete=$query->fetch_array())
{
       $id = $enquete['id'];
       $enquete = $enquete['sessao'];
          echo '<option id="'.$id.'" data-sssid="'.$id.'" style="background-color: grey; color: white;"  value="'.$enquete.'">SESSÃO: '.$enquete.'</option> ';
}
}

            
            
            echo '</select>
          </div>
        </div>
      </div>

        <div class="form-group" hidden>
    <input type="text" class="form-control" name="lastide" value="'.$lastid.'" >
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

</div>';
    }
    else
    {
      echo '

      <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
      <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Ordem do Dia</a>
     </li>
</ul>
<div class="tab-content" id="myTabContent">

<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">';

$queryordem=$DBcon->query("SELECT * FROM ordemdodia ORDER BY id ASC");
$countordem=$queryordem->num_rows;
if($countordem>=1)
{ 
while($enqueteordem=$queryordem->fetch_array())
{
$ordem = $enqueteordem['ordem'];
echo '<div class="alert alert-info" role="alert">'.$ordem.'</div>';
}
}

echo '</div>
</div>';
    }
}
}
?>
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
    
    <div class="container" id="candidatos" name="candidatos"> </div>
            <div class="container" id="results" name="results"> </div>
            
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