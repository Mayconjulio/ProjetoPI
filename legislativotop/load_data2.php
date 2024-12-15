<?php
include_once 'Dbconnect.php';
date_default_timezone_set('America/Sao_Paulo');
$output = '';

$eid = $_POST['eid'];
$mid = $_POST['mid'];
$cnpj = $_POST['cnpj'];
$data = date('Y-m-d');

//$eid = htmlspecialchars($_COOKIE["votacao"]);
$querycca = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."' AND modelo='A Favor'");
$contagemcca=$querycca->num_rows;
if($contagemcca>=0)
{
  $conta = $contagemcca;
  echo '<center><h2><span class="badge badge-pill badge-success">A Favor: '.$conta.'</span>&nbsp;';
}


//$eid = htmlspecialchars($_COOKIE["votacao"]);
$queryccb = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."' AND modelo='Contra'");
$contagemccb=$queryccb->num_rows;
if($contagemccb>=0)
{
  $contb = $contagemccb;
 echo '<span class="badge badge-pill badge-danger">Contra: '.$contb.'</span>&nbsp;';
}

//$eid = htmlspecialchars($_COOKIE["votacao"]);
$queryccc = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."' AND modelo='Abster'");
$contagemccc=$queryccc->num_rows;
if($contagemccc>=0)
{
  $contc = $contagemccc;
  echo '<span class="badge badge-pill badge-secondary">Abstenção: '.$contc.'</span>&nbsp;';
}

//$eid = htmlspecialchars($_COOKIE["votacao"]);
$queryccd = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."'");
$contagemccd=$queryccd->num_rows;
if($contagemccd>=0)
{
  $contd = $contagemccd;
  echo '<span class="badge badge-pill badge-primary">Total: '.$contd.'</span></h2></center>';
}

$total = $contd;
$favor = $conta;
$contra = $contb;
$abstencao = $contc;
if($favor>$contra && $favor>$abstencao)
{
echo '<br><center><h1><span class="badge badge-pill badge-success">Aprovado</span></h1></center>';
}
elseif($contra>$favor && $contra>$abstencao)
{
echo '<br><center><h1><span class="badge badge-pill badge-danger">Rejeitado</span></h1></center>';
}
else
{
echo '<br><center><h1><span class="badge badge-pill badge-dark">Em andamento</span></h1></center>';
}


echo '</center>';
echo "</div></div>";
//}
?>