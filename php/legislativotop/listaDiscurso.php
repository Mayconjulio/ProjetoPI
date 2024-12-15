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
?>
<?php 
include_once 'Dbconnect.php';
date_default_timezone_set('America/Sao_Paulo');
$output = '';
$eid = $_POST['eid'];
//$usr = $_POST['mid'];
//$usrname = $_POST['cnpj']; 

//select id,name 
//from friends 
//order by id=5 desc, id asc
//inicio check bot찾o voto
$queryy=$DBcon->query("SELECT * FROM discurso WHERE idvotacao='".$eid."' AND status='0' ORDER BY tipo='contra' DESC, id ASC");    
$contagemm=$queryy->num_rows;
$countlst = 0;
if($contagemm>0)
{
       echo '<div class="container-fluid" name="proxdisc" id="proxdisc" style="display: flex; justify-content: flex-end;margin-top: -300px;"><center><h2 style="color:'.$cortxtexibidor.';">Próximos a discursar</h2><hr>';
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
       if($tipo=="contra")
{
       $tipoq = "Aparte";
}
else
{
       $tipoq = ucfirst($tipo);
}

       $countlst++;
echo '<strong><p class="card-title" style="color:'.$cortxtexibidor.';">'.$countlst.' - '.utf8_decode($nomef).' ['.$siglaf.'] ('.$tipoq.')</p></strong>';
}
}
//fimfoto

}
echo "</center></div>";
}
else
{
echo '<div class="container-fluid" name="proxdisc" id="proxdisc" style="display: flex; justify-content: flex-end;margin-top: -300px;"><center><h2 style="color:'.$cortxtexibidor.';">Próximos a discursar</h2><hr></center></div>';
}
//fim check botao voto
$DBcon->close();
?>