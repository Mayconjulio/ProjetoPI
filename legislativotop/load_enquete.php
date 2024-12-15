<?php
include_once 'Dbconnect.php';
date_default_timezone_set('America/Sao_Paulo');
$output = '';

$eid = $_POST['eid']; 
$mid = $_POST['mid'];
$data = date('Y-m-d');

$query=$DBcon->query("SELECT * FROM presencas WHERE vereador='".$mid."' AND idvotacao=".$eid."");
$count=$query->num_rows;
//$qtitulo = $DBcon->query("SELECT * FROM permissoes WHERE qualenquete='".$eid."' AND quemvota='".$grupo."'");
//if ($qqtitulo=$qtitulo->fetch_array())
//{//inicio - if para ativar permissoes por grupo
  if($count>=1)
{
$qtitulo = $DBcon->query("SELECT * FROM enquetes WHERE id='".$eid."'");
if ($qqtitulo=$qtitulo->fetch_array())
{
$titulo = $qqtitulo['titulo'];
$desc = $qqtitulo['descricao'];
//$dataini = $qqtitulo['inicio'];
//$datafim = $qqtitulo['fim'];
// if($data>$datafim)
// {
// echo '<div class="container-fluid" id="candidatos" name="candidatos"><center><h4>A enquete já foi realizada.</h4></center><br><p>Participe das outras enquetes.</p><div class="row">';
// }
// if($data<$dataini)
// {
// echo '<div class="container-fluid" id="candidatos" name="candidatos"><center><h4>A enquete ainda não foi iniciada.</h4></center><br><p>Participe das outras enquetes.</p><div class="row">'; 
// }
// if($data<=$datafim && $data>=$dataini)
// {
echo '<div class="container" id="candidatos" name="candidatos"><center><h4>'.$titulo.'</h4></center><br><center><p>'.$desc.'</p></center><div class="row">';
$verifica=$DBcon->query("SELECT * FROM votospovo WHERE quemvotou=".$mid." AND idenquete=".$eid."");    
$contagem=$verifica->num_rows;
if($contagem>=1)
{//RESULTADOS
  $chcksim=$DBcon->query("SELECT * FROM votospovo WHERE voto='A Favor' AND idenquete=".$eid."");    
  $contagemsim=$chcksim->num_rows;
  $chckn=$DBcon->query("SELECT * FROM votospovo WHERE voto='Contra' AND idenquete=".$eid."");    
  $contagemnnn=$chckn->num_rows;
  echo "<div class='col'><center><strong>A Favor</strong>: ".$contagemsim."<br><strong>Contra</strong>: ".$contagemnnn."<br><h4><strong>Você já respondeu essa pesquisa.</strong></h4></center></div></div></div>";
  //RESULTADOS
}
else
{
$query=$DBcon->query("SELECT * FROM enquetes WHERE id='".$eid."'");
$count=$query->num_rows;
if($count>=0)
{
while($usuario=$query->fetch_array())
{
       $id = $usuario['id'];

       echo "<div class='container'>";
       echo '<div class="row">

       <div class="col">
       <div class="card-body">
       <h5 class="card-title">A Favor</h5><br>
         <form role="form" action="" autocomplete="off" method="post">
         <input type="text" class="form-control" name="idenquete" value='.$eid.' hidden>
         <input type="text" class="form-control" name="idopcao" value='.$id.' hidden>
       <button type="submit" name="votar" class="btn btn-primary" value="A Favor" data-toggle="comprovante" data-target="#comprovante">A Favor</button>
       </form></div>
       </div>

       <div class="col">
      <div class="card-body">
      <h5 class="card-title">Contra</h5><br>
        <form role="form" action="" autocomplete="off" method="post">
        <input type="text" class="form-control" name="idenquete" value='.$eid.' hidden>
        <input type="text" class="form-control" name="idopcao" value='.$id.' hidden>
      <button type="submit" name="votar" class="btn btn-danger" value="Contra" data-toggle="comprovante" data-target="#comprovante">Contra</button>
      </form></div>
  </div> 

     </div>
   </div>';

  echo "<div>";
}
}
}
echo "</div></div>";
}
}

//}//fim
else
{
  echo '<script>alert("É necessário estar presente para participar.");</script>';
}
?>