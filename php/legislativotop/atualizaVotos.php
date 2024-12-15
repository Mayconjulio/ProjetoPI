<?php 
include_once 'Dbconnect.php';
date_default_timezone_set('America/Sao_Paulo');
$output = '';
$eid = $_POST['eid'];
$usr = $_POST['mid'];

echo '<div class="container-fluid" id="listav" name="listav"><div class="row">';
//inicio lista de quem votou
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
echo '<div class="col-4"><div class="alert alert-'.$color.'" role="alert" style="background-color:'.$cor.';">
<img src="fotos/'.$foto.'" class="rounded float-left" alt="Vereador(a)" width="90" height="70">
  <strong><p class="card-title" style="color:black;"> &nbsp;<strong>'.$nome.'</strong><br> <a href="#" class="badge badge-light"><img class="rounded float-left" src="partidos/'.$sigla.'.png" alt="'.$sigla.'" width="50" height="20"></a></p></strong>
</div></div>
';
//echo '<img src="fotos/'.$foto.'" alt="Vereador(a)" height="50"> <strong><p33 style="font-size:20px;">'.$nome.' ['.$sigla.']</p33></strong>&nbsp;<span class="badge badge-'.$color.'">'.$txt.'</span><br><br>';
//echo '        <div class="col">

//<div class="image-wrap-2">
 // <div class="image-info">
   // <h2 class="mb-3"></h2>
    //<br><br><br><br><br><br><center><a href="#" class="btn btn-'.$color.'">'.$nome.'<br>'.$sigla.'<br>'.$txt.'</a></center>
  //</div>
  //<img src="fotos/'.$foto.'" alt="Vereador(a)" height="300">
//</div>

//</div>';
}
}
else
{

}

//qm n votou

//pegafoto
$queryfinal=$DBcon->query("SELECT * FROM usuarios");    
$contagemfinal=$queryfinal->num_rows;
//echo $contagemfinal;
if($contagemfinal>=0)
{
//echo "<h1>".$contagemfinal."</h1>";
while($usuariofinal=$queryfinal->fetch_array())
{
       $nomef = $usuariofinal['nome'];
       $usuariof = $usuariofinal['usuario'];
       $fotof = $usuariofinal['foto'];
       $siglaf = $usuariofinal['sigla'];
       //echo "<h1>".$nomef."--</h1>";
       if($fotof=="")
       {
               $fotof = "default-avatar.png";
       }
       //echo "<h1 style='color:white;'>".$usuariof."</h1>";
       $queryy=$DBcon->query("SELECT * FROM votos WHERE nome='".$nomef."' AND enqueteid='".$eid."'");    
$contagemm=$queryy->num_rows;
if($contagemm==0)
{
//echo "<h1 style='color:white;'>ERRO AQ</h1>";
//$nomef = substr($nomef, 0, 18);
$nomef = utf8_decode($nomef);
if($nomef==".")
{
    
}
else
{
 echo '<div class="col-4"><div class="alert alert-light" role="alert" >

<img src="fotos/'.$fotof.'" class="rounded float-left" alt="Vereador(a)" width="90" height="70">
  <strong><p class="card-title" style="color:black;"> &nbsp;<strong>'.$nomef.'</strong><br> <a href="#" class="badge badge-light"><img class="rounded float-left" src="partidos/'.$siglaf.'.png" alt="'.$siglaf.'" width="50" height="20"></a></p></strong>
</div></div>';   
}
//echo '<img src="fotos/'.$fotof.'" alt="Vereador(a)" height="50"> <strong><p33 style="font-size:20px;">'.$nomef.' ['.$siglaf.']</p33></strong>&nbsp;<span class="badge badge-dark">Aguardando</span><br><br>';
}

}
}
//fimfoto
echo '</div>';
//fim qm n votou

echo '</div>';
$DBcon->close();
?>