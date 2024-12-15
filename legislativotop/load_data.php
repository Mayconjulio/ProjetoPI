<?php
include_once 'Dbconnect.php';
date_default_timezone_set('America/Sao_Paulo');
$output = '';

$eid = $_POST['eid'];
$mid = $_POST['mid'];
$cnpj = $_POST['cnpj'];
$data = date('Y-m-d');

$tempresenca = 1;
$qtitulo321 = $DBcon->query("SELECT * FROM camconfig LIMIT 1");
if ($qqtitulo321=$qtitulo321->fetch_array())
{
$temPresenca = $qqtitulo321['tempresenca'] ?? null;
}
$query=$DBcon->query("SELECT * FROM presencas WHERE vereador='".$mid."' AND idvotacao=".$eid."");
$count=$query->num_rows;
if($count>=$temPresenca)
{
$qtitulo = $DBcon->query("SELECT * FROM enquetes WHERE id='".$eid."'");
if ($qqtitulo=$qtitulo->fetch_array())
{
$titulo = $qqtitulo['titulo'];
$desc = $qqtitulo['descricao'];

if($cnpj=="Presidente")
{
  $queryClean = "UPDATE enquetes SET votando=0";
  
  if ($DBcon->query($queryClean))
  {
  $query = "UPDATE enquetes SET votando=1 WHERE id='".$eid."'";
  
  if ($DBcon->query($query))
  {
  echo '<script>alert("Votação enviada para telão.");</script>';
  }

  }
    
}

/* $dataini = $qqtitulo['inicio'];
$datafim = $qqtitulo['fim'];
if($data>$datafim)
{
echo '<div class="container-fluid" id="candidatos" name="candidatos"><center><h4>A enquete já foi realizada.</h4></center><br><p>Participe das outras enquetes.</p><div class="row">';
}
if($data<$dataini)
{
echo '<div class="container-fluid" id="candidatos" name="candidatos"><center><h4>A enquete ainda não foi iniciada.</h4></center><br><p>Participe das outras enquetes.</p><div class="row">'; 
}
if($data<=$datafim && $data>=$dataini)
{*/
 
  //echo '<div class="container" name="results" id="results" hidden><div class="row">';
  //CONTAGEM DE VOTOS
  $querycc = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."' AND modelo='Contra'");
  $contagemcc=$querycc->num_rows;
  if($contagemcc>0)
  {
    $cont = $contagemcc;
    //echo '<div class="col-sm"><button type="button" class="btn btn-danger" data-toggle="comprovante" data-target="#comprovante"> <strong>'.$contagemcc.'</strong> Contra</button></div>';
  }
  else
  {
  
  }
  //CONTAGEM DE VOTOS
    //CONTAGEM DE VOTOS
    $queryaf = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."' AND modelo='A Favor'");
    $contagemaf=$queryaf->num_rows;
    if($contagemaf>0)
    {
      $contaf = $contagemaf;
      //echo '<div class="col-sm"><button type="button" class="btn btn-success" data-toggle="comprovante" data-target="#comprovante"> <strong>'.$contaf.'</strong> A Favor</button></div>';
    }
    else
    {
    
    }
    //CONTAGEM DE VOTOS
        //CONTAGEM DE VOTOS
        $queryabs = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."' AND modelo='Abster'");
        $contagemabs=$queryabs->num_rows;
        if($contagemabs>0)
        {
          $contabs = $contagemabs;
          //echo '<div class="col-sm"><button type="button" class="btn btn-secondary" data-toggle="comprovante" data-target="#comprovante"> <strong>'.$contabs.'</strong> Abstenção</button></div>';
        }
        else
        {
        
        }
        //CONTAGEM DE VOTOS
//echo '</div></div>';
echo '<div class="container-fluid" id="candidatos" name="candidatos"><center><h4><strong>'.$titulo.'</strong></h4></center><br><p>'.$desc.'</p><div class="row">';
$verifica=$DBcon->query("SELECT * FROM votos WHERE usuario='".$cnpj."' AND enqueteid='".$eid."'");    
$contagem=$verifica->num_rows;
if($contagem>=1)
{
$query=$DBcon->query("SELECT * FROM modelos WHERE idenquete='".$eid."'");
$count=$query->num_rows;
if($count>=1)
{
    while($usuario=$query->fetch_array())
{
       $img = $usuario['img'];
       if($img==""){$img="nobg.png";}
       $nome = $usuario['nome'];
       $id = $usuario['model_id'];
    
if($nome=="A Favor")
{
  $numrslt = $contagemaf;
  $color = "success";
  $txt = "A Favor";
}
elseif($nome=="Contra")
{
  $numrslt = $contagemcc;
  $color = "danger";
  $txt = "Contra";
}
else
{
  $numrslt = $contagemabs;
  $color = "secondary";
  $txt = "Abster";
}

        echo '<div class="col">   
  <div class="card" style="width: 16rem;">
  <div class="card-body">
      <form role="form" action="" autocomplete="off" method="post">
      <input type="text" class="form-control" name="idenquete" value='.$eid.' hidden>
      <input type="text" class="form-control" name="idopcao" value='.$id.' hidden>
    <button type="submit" name="votar" class="btn btn-'.$color.' btn-block" value="'.utf8_encode($nome).'" data-toggle="comprovante" data-target="#comprovante">'.$txt.' (mudar voto)</button>
    </form></div>
</div> 
<br>
  </div>';
}
echo '<div class="col">   
<div class="card" style="width: 16rem;">
<div class="card-body">
    <form role="form" action="" autocomplete="off" method="post">
    <input type="text" class="form-control" name="idenquete" value='.$eid.' hidden>
    <input type="text" class="form-control" name="idopcao" value='.$id.' hidden>
  <button type="submit" name="removevoto" class="btn btn-warning btn-block" value="removevoto" data-toggle="comprovante" data-target="#comprovante">Remover voto</button>
  </form></div>
</div> 
<br>
</div>';
}
else
{}  
}
else
{
    //echo $eid;

    $queryeq=$DBcon->query("SELECT * FROM enquetes WHERE id='".$eid."' AND votando='1'");
    $counteq=$queryeq->num_rows;
    if($counteq==0)
    {
      $status = "disabled";
    }
    else
    {
      $status = "";
    }


$query=$DBcon->query("SELECT * FROM modelos WHERE idenquete='".$eid."'");
$count=$query->num_rows;
if($count>=1)
{
while($usuario=$query->fetch_array())
{
       $img = $usuario['img'];
       if($img==""){$img="nobg.png";}
       $nome = $usuario['nome'];
       $id = $usuario['model_id'];
    
if($nome=="A Favor")
{
  $numrslt = $contagemaf;
  $color = "success";
  $txt = "A Favor";
}
elseif($nome=="Contra")
{
  $numrslt = $contagemcc;
  $color = "danger";
  $txt = "Contra";
}
else
{
  $numrslt = $contagemabs;
  $color = "secondary";
  $txt = "Abster";
}

        echo '<div class="col">   
  <div class="card" style="width: 16rem;">
  <div class="card-body">
      <form role="form" action="" autocomplete="off" method="post">
      <input type="text" class="form-control" name="idenquete" value='.$eid.' hidden>
      <input type="text" class="form-control" name="idopcao" value='.$id.' hidden>
    <button '.$status.' type="submit" name="votar" class="btn btn-'.$color.' btn-block" value="'.utf8_encode($nome).'" data-toggle="comprovante" data-target="#comprovante">'.$txt.'</button>
    </form></div>
</div> 
<br>
  </div>';
}

}
else
{}
}
echo "</div><hr><center><strong><p></p></strong></center></div>";
//}
}
} //fim do if presença
else
{
  if($cnpj=="Presidente")
{
  $queryClean = "UPDATE enquetes SET votando=0";
  
  if ($DBcon->query($queryClean))
  {
  $query = "UPDATE enquetes SET votando=1 WHERE id='".$eid."'";
  
  if ($DBcon->query($query))
  {
  echo '<script>alert("Votação enviada para telão.");</script>';
  }

  }
    
}
else
{
  echo '<script>alert("É necessário estar presente para participar.");</script>';
}
  
}
?>