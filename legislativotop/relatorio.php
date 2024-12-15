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
if (!isset($_SESSION['adminSession'])) 
{
 header("Location: acessoadmin");
}
?>
<!DOCTYPE html>
<html lang="pt">

<head><meta charset="utf-8">
  
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
  <script src='js/print.js'></script>
</head>
<style type="text/css" media="print">
      @media print
      {
         @page {
           margin-top: 0;
           margin-bottom: 0;
         }
         body  {
           padding-top: 72px;
           padding-bottom: 72px ;
         }
      } 
</style>
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
                <?php
                  $idrel = $_SESSION['relSess'];
                  $query2 = $DBcon->query("SELECT id,titulo,descricao,inicio,fim FROM enquetes WHERE id='".$idrel."'");
                  if ($userRow2=$query2->fetch_array())
                  {
                           $id = $userRow2['id'];
                          $titulo = $userRow2['titulo'];
                          $desc = $userRow2['descricao'];
                          $data = $userRow2['inicio'];
                          $hora = $userRow2['fim'];
                  }
  //aa
  echo '<div class="container-fluid" id="listav" name="listav">';
  echo '<center><strong><h4 class="card-title">['.$id.'] Relatório '.$titulo.'</h4></strong></center>';
  echo '<center><p>'.$desc.'</p></center>';
  echo '<center><p>'.$data.' - '.$hora.'</p></center>';

  $eid = $idrel;
$querycca = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."' AND modelo='A Favor'");
$contagemcca=$querycca->num_rows;
if($contagemcca>=0)
{
$conta = $contagemcca;
echo '<center><span class="badge badge-pill badge-success">A Favor: '.$conta.'</span>&nbsp;';
}


$eid = $idrel;
$queryccb = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."' AND modelo='Contra'");
$contagemccb=$queryccb->num_rows;
if($contagemccb>=0)
{
$contb = $contagemccb;
echo '<span class="badge badge-pill badge-danger">Contra: '.$contb.'</span>&nbsp;';
}

$eid = $idrel;
$queryccc = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."' AND modelo='Abster'");
$contagemccc=$queryccc->num_rows;
if($contagemccc>=0)
{
$contc = $contagemccc;
echo '<span class="badge badge-pill badge-secondary">Abstenção: '.$contc.'</span>&nbsp;';
}

$eid = $idrel;
$queryccd = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."'");
$contagemccd=$queryccd->num_rows;
if($contagemccd>=0)
{
$contd = $contagemccd;
echo '<span class="badge badge-pill badge-primary">Total: '.$contd.'</span></center>';
}

$total = $contd;
$favor = $conta;
$contra = $contb;
$abstencao = $contc;
if($favor>$contra && $favor>$abstencao)
{
echo '<br><center><h2><span class="badge badge-pill badge-success">Aprovado</span></h2></center>';
}
elseif($contra>$favor && $contra>$abstencao)
{
echo '<br><center><h2><span class="badge badge-pill badge-danger">Rejeitado</span></h2></center>';
}
else
{
echo '<br><center><h2><span class="badge badge-pill badge-dark">Em andamento</span></h2></center>';
}


echo '</center>';


  echo '<div class="row">';

  //inicio lista de quem votou
  $eid = $idrel;
  $query=$DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."'");    
  $contagem=$query->num_rows;
  if($contagem>0)
  {
  while($usuariooo=$query->fetch_array())
  {
         $nome = $usuariooo['nome'];
         $usuario = $usuariooo['usuario'];
         $voto = $usuariooo['modelo'];
  
  if($voto=="A Favor")
  {
    $cor = "green";
    $color = "success";
    $txt = "A Favor";
  }
  elseif($voto=="Contra")
  {
    $cor = "red";
    $color = "danger";
    $txt = "Contra";
  }
  else
  {
    $cor = "gray";
    $color = "secondary";
    $txt = "Abster";
  }
      
  //pegafoto
  $query2=$DBcon->query("SELECT * FROM usuarios WHERE nome='".$nome."'");    
  $contagem2=$query2->num_rows;
  if($contagem2>=0)
  {
  while($usuario2=$query2->fetch_array())
  {
         $foto = $usuario2['foto'];
         $sigla = $usuario2['sigla'];
         if($foto=="")
         {
                 $foto = "default-avatar.png";
         }
  }
  }
  //fimfoto
  //$nome = substr($nome, 0, 18);
  //background-color:'.$cor.'
  $nome = utf8_decode($nome);
  if($nome==".")
{
    
}
else
{
  echo '<div class="col-4"><div class="alert alert-secondary" role="alert">
  
    <strong><p class="card-title" style="color:black;"> &nbsp;<strong>'.$nome.' ['.$sigla.']</strong><br>-'.$txt.'</p></strong>
  </div></div>
  ';
  }
  }
  }
  else
  {
  
  }
  
  //qm n votou
  
  //fimfoto
  echo '</div>';
  //fim qm n votou
  
  echo '</div>';
  //aa
?>
                </center>
              </div>
              <div class="card-body">

              <br><br><center><button name="salvar" id="salvar" type="submit" class="btn btn-success">IMPRIMIR RELATÓRIO</button></center>
              <br><br>
              <center><a class="btn btn-danger" href="administracao" role="button">Voltar</a></center>

                <div class="table-responsive">

<div class="row">
</div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <script>
$( "#salvar" ).click(function() {
	$("#listav").print({
    addGlobalStyles : true,
    stylesheet : null,
    rejectWindow : true,
    noPrintSelector : ".no-print",
    iframe : true,
    append : null,
    prepend : null
});
});
</script>
      <footer class="footer">
        <div class=" container-fluid ">
        <center><a class="btn btn-danger" href="./acesso" role="button">Voltar</a></center>
        </div>
      </footer>
    </div>
  </div>
</body>

</html>