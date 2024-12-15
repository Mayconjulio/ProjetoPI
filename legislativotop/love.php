<?php
include_once 'Dbconnect.php';
date_default_timezone_set('America/Sao_Paulo');
$opinionid = $_POST['id'];
$me = $_POST['me'];
$iddebate = $_POST['they'];

$verlove = $DBcon->query("SELECT * FROM likesdebate WHERE userid='".$me."' AND reaction='Nao' AND opid='".$iddebate."'");
$lovecount=$verlove->num_rows;
if($lovecount==1)
{

$removelove = $DBcon->query("DELETE FROM likesdebate WHERE reaction='Nao' AND opid='$iddebate' AND userid='$me'");

$verlove2 = $DBcon->query("SELECT * FROM likesdebate WHERE userid='".$me."' AND reaction='Nao' AND opid='".$iddebate."'");
$lovecount2=$verlove2->num_rows;
$nlove = $lovecount2;
if ($nlove < 1000000) 
{
    $format = number_format($nlove);
} 
else if ($nlove < 1000000000) 
{
    $format = number_format($nlove / 1000000, 2) . 'M';
}  
else 
{
    $format = number_format($nlove / 1000000000, 2) . 'B';
}
$nlove = $format;
echo "".$nlove." não gostaram";
}

else
{
$loveop = $DBcon->query("INSERT INTO likesdebate(reaction,opid,userid) VALUES('Nao','$iddebate','$me')");

$querylove = $DBcon->query("SELECT * FROM likesdebate WHERE userid='".$me."' AND reaction='Nao' AND opid='".$iddebate."'");
$lovecount=$querylove->num_rows;

$nlove = $lovecount;
if ($nlove < 1000000) 
{
    $format = number_format($nlove);
} 
else if ($nlove < 1000000000) 
{
    $format = number_format($nlove / 1000000, 2) . 'M';
} 
else 
{
    $format = number_format($nlove / 1000000000, 2) . 'B';
}
$nlove = $format;
    
		  $loveop = $DBcon->query("SELECT * FROM likesdebate WHERE userid='".$me."' AND reaction='Nao' AND opid='".$iddebate."'");
		  $loveee=$loveop->fetch_array();
		  if($me==$loveee['userid'] and $loveee['reaction']=='Nao' and $loveee['opid']==$iddebate)
		  {
			$btnlove = "".$nlove." não gostaram";
		  }
		  else
		  {
          }
    echo $btnlove;
}
?>