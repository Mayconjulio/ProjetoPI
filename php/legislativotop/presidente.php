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
$usrid = $userRow['user_id'];
$presidente = $userRow['presidente'];

//$res2=$DBcon->query("SELECT id FROM enquetes ORDER BY id DESC LIMIT 1");
//$userRow2=$res2->fetch_array();
//$lastid = $userRow2['id']+1;
?>
<?php
if(isset($_POST['reset'])) 
{
  header("Refresh:0");
}
?>
<?php
if(isset($_POST['votar'])) 
{
$modelid = strip_tags($_POST['votar']);
$modelid = $DBcon->real_escape_string($modelid);
$idopcao =  strip_tags($_POST['idopcao']);
$idopcao = $DBcon->real_escape_string($idopcao);
    
$query2 = $DBcon->query("SELECT * FROM usuarios WHERE user_id='".$idopcao."'");
if ($userRow=$query2->fetch_array())
{
$votos = $userRow['presidente'];
$b = 1;
$total = $votos+$b;
$query3 = "UPDATE usuarios SET presidente='$total' WHERE user_id='".$idopcao."'";
if ($DBcon->query($query3)) 
{
         $msg = "<div class='alert alert-success' role='alert'>
  <strong>Registrando voto...</strong></div>";
  $query4 = "INSERT INTO votospr(quemvotou,votado) VALUES('$usrid','$idopcao')";
if ($DBcon->query($query4)) 
{
  header("Refresh:1");
}
}
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
    Votação Presidente da Câmara
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
          <li class="active">
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
        <div class="row">
          <div class="col-md-12">
            <div class="card">

              <div class="card-header">
                <center><h4 class="card-title"> Presidente da Câmara</h4>
                <?php
$querycheck=$DBcon->query("SELECT * FROM votospr WHERE quemvotou='".$usrid."'");
$countcheck=$querycheck->num_rows;
if($countcheck>=1)
{
  //aa
  $query=$DBcon->query("SELECT * FROM usuarios ORDER BY presidente DESC LIMIT 1");
  $count=$query->num_rows;
  if($count>=1)
  { 
  while($enqueteee=$query->fetch_array())
  {         
         $nome = $enqueteee['nome'];
         $img = $enqueteee['foto'];
         $partido = $enqueteee['partido'];
         $presidente = $enqueteee['presidente'];
if($img=="")
       {
               $img = "fotos/default-avatar.png";
       }
else
{
  $img = "fotos/".$enqueteee['foto'];
}

if($nome==".")
{
    
}
else
{
          echo '<div class="alert alert-info d-flex align-items-start"><span><img src="'.$img.'" width="50">'.utf8_decode($nome).'('.$partido.') - <strong>'.$presidente.' votos</strong></span>
      </div>';
}  
  }
  }
  
  //aa
    //aa
    $queryu=$DBcon->query("SELECT * FROM usuarios ORDER BY presidente DESC");
    $countu=$queryu->num_rows;
    if($countu>=1)
    { 
      if($countcheck>=1)
      {echo "<strong>Você já votou no seu candidato, aguarde o resultado.</strong><br>";}
    echo "<strong>Há um total de ".$countu." vereadores</strong>";
    while($enqueteeeu=$queryu->fetch_array())
    {  
           $nomeu = $enqueteeeu['nome'];
           $imgu = $enqueteeeu['foto'];
           $partidou = $enqueteeeu['partido'];
           $presidenteu = $enqueteeeu['presidente'];

           if($imgu=="")
       {
               $imgu = "fotos/default-avatar.png";
       }
else
{
  $imgu = "fotos/".$enqueteeeu['foto'];
}

if($nomeu==".")
{
    
}
else
{
            echo '<div class="alert alert-warning d-flex align-items-start">
            <span><img src="'.$imgu.'" width="50"> '.utf8_decode($nomeu).'('.$partidou.') - '.$presidenteu.' votos</span>
        </div>';
}
    }
    }
    
    //aa
}
else
{
  echo "<p>Vote no candidato de sua escolha para ser o presidente da câmara</p>";
}
?>
                </center>
              </div>
              <div class="card-body">
                <div class="table-responsive">

<div class="row">
                <form role="form" action="" autocomplete="off" method="post">
<?php
$querycheck=$DBcon->query("SELECT * FROM votospr WHERE quemvotou='".$usrid."'");
$countcheck=$querycheck->num_rows;
if($countcheck>=1)
{
  
}
else
{
$query=$DBcon->query("SELECT * FROM usuarios");
$count=$query->num_rows;
if($count>=1)
{
while($enquete=$query->fetch_array())
{
       $id = $enquete['user_id'];
       $nome = $enquete['nome'];
       $img = $enquete['foto'];

       if($img=="")
       {
      $img = "fotos/default-avatar.png";
       }
       else
       {
         $img = "fotos/".$enquete['foto'];
       }
       
       if($nome==".")
{
    
}
else
{
       echo '<div class="col">   
       <div class="card" style="width: 16rem;">
       <img class="card-img-top" src="'.$img.'">
       <div class="card-body">
         <h5 class="card-title">'.utf8_decode($nome).'</h5><br>
           <form role="form" action="" autocomplete="off" method="post">
           <input type="text" class="form-control" name="idopcao" value='.$id.' hidden>
         <button type="submit" name="votar" class="btn btn-primary btn-block" value="'.$id.'" data-toggle="comprovante" data-target="#comprovante">Votar</button>
         </form></div>
     </div> 
     <br>
       </div>';

}
}
}
else
{}
}   
?>
</form></div>
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