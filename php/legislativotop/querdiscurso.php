<?php 
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';
$res2=$DBcon->query("SELECT * FROM camconfig WHERE id=1");
$userRow2=$res2->fetch_array();
$nomecam = $userRow2['nome'];
$cormenu = $userRow2['cormenu'];
$corexibidor = $userRow2['corexibidor'];
$cortxtexibidor = $userRow2['cortxtexibidor'];
$corgeral = $userRow2['corgeral'];

$output = '';
$eid = $_POST['eid'];
//inicio check botão voto
$queryy=$DBcon->query("SELECT * FROM discurso WHERE idvotacao='".$eid."' AND status='0' ORDER BY tipo='contra' DESC, id ASC LIMIT 1");    
$contagemm=$queryy->num_rows;
if($contagemm>0)
{ //<h2 style="color:'.$cortxtexibidor.';">
       echo '<div class="container" name="fdiscurso" id="fdiscurso"><center><h2 style="color:black;">Pedidos de discurso</h2><hr>';
while($usuario=$queryy->fetch_array())
{
       $iddisc = $usuario['id'];
       $usuarioo = $usuario['vereador'];
       $tipo = $usuario['tipo'];

//pegafoto
$queryfinal=$DBcon->query("SELECT * FROM usuarios WHERE user_id=".$usuarioo);    
$contagemfinal=$queryfinal->num_rows;
//echo $contagemfinal;
if($contagemfinal>=0)
{
while($usuariofinal=$queryfinal->fetch_array())
{
       $nomef = $usuariofinal['nome'];
       $idvereador = $usuariofinal['user_id'];
       $fotof = $usuariofinal['foto'];
       $siglaf = $usuariofinal['sigla'];
       if($fotof=="")
       {
               $fotof = "default-avatar.png";
       }

       //$nomef = substr($nomef, 0, 18);
echo '<center><div class="row"><div class="col-sm"><div class="card" style="width: 15rem;">
<img src="fotos/'.$fotof.'" class="card-img-top" alt="Vereador(a)" width="10" height="200">
<div class="card-body">
  <strong><p class="card-title" style="color:black;">'.utf8_decode($nomef).' ['.$siglaf.']</p></strong>
  <form role="form" action="" autocomplete="off" method="post">
  <input id="tipo" name="tipo" value="'.$tipo.'" hidden></input>
  <input id="iddisc1" name="iddisc1" value="'.$iddisc.'" hidden></input>';
 
       if($tipo=="discurso")
{
       echo '<center><button type="submit" class="btn btn-primary" name="aceitar">Aceitar discurso</button></center><br>

       <center><button type="submit" class="btn btn-danger" name="negar">Rejeitar discurso</button></center>';
}
elseif($tipo=="contra")
{
       echo '<center><button type="submit" class="btn btn-primary" name="aceitar">Aceitar aparte</button></center><br>

       <center><button type="submit" class="btn btn-danger" name="negar">Rejeitar aparte</button></center>';
}
elseif($tipo=="ordem")
{
       echo '<center><button type="submit" class="btn btn-primary" name="aceitar">Aceitar questão de ordem</button></center><br>

       <center><button type="submit" class="btn btn-danger" name="negar">Rejeitar questão de ordem</button></center>';
}
else
{ 
       echo '<center><button type="submit" class="btn btn-primary" name="aceitar">Aceitar considerações finais</button></center><br>

       <center><button type="submit" class="btn btn-danger" name="negar">Rejeitar considerações finais</button></center>';
}
       echo '</form>
       </div>
       </div>
</div></div></div></center>';

}
}
//fimfoto

}
echo "</center></div>";
}
else
{
echo '<div class="container" name="fdiscurso" id="fdiscurso"></div>';
}
//fim check botão voto
$DBcon->close();
?>