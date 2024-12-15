<?php
include_once 'Dbconnect.php';
date_default_timezone_set('America/Sao_Paulo');
$opinionid = $_POST['id'];
$me = $_POST['me'];
$iddebate = $_POST['they'];

$verhaha = $DBcon->query("SELECT * FROM likesdebate WHERE userid='".$me."' AND reaction='Gostei' AND opid='".$iddebate."'");
$hahacount=$verhaha->num_rows;
if($hahacount==1)
{

$removehaha = $DBcon->query("DELETE FROM likesdebate WHERE reaction='Gostei' AND opid='$iddebate' AND userid='$me'");

$verhaha2 = $DBcon->query("SELECT * FROM likesdebate WHERE userid='".$me."' AND reaction='Gostei' AND opid='".$iddebate."'");
$hahacount2=$verhaha2->num_rows;
$nhaha = $hahacount2;
if ($nhaha < 1000000) 
{
    $format = number_format($nhaha);
} 
else if ($nhaha < 1000000000) 
{
    $format = number_format($nhaha / 1000000, 2) . 'M';
} 
else 
{ 
    $format = number_format($nhaha / 1000000000, 2) . 'B';
}
$nhaha = $format;
echo "".$nhaha." Gostaram";
}

else
{
$hahaop = $DBcon->query("INSERT INTO likesdebate(reaction,opid,userid) VALUES('Gostei','$iddebate','$me')");

$queryhaha = $DBcon->query("SELECT * FROM likesdebate WHERE userid='".$me."' AND reaction='Gostei' AND opid='".$iddebate."'");
$hahacount=$queryhaha->num_rows;

$nhaha = $hahacount;
if ($nhaha < 1000000) 
{
    $format = number_format($nhaha);
} 
else if ($nhaha < 1000000000) 
{
    $format = number_format($nhaha / 1000000, 2) . 'M';
} 
else 
{
    $format = number_format($nhaha / 1000000000, 2) . 'B';
}
$nhaha = $format;
    
		  $hahaop = $DBcon->query("SELECT * FROM likesdebate WHERE userid='".$me."' AND reaction='Gostei' AND opid='".$iddebate."'");
		  $hahaaa=$hahaop->fetch_array();
		  if($me==$hahaaa['userid'] and $hahaaa['reaction']=='Gostei' and $hahaaa['opid']==$iddebate)
		  {
			$btnhaha = $nhaha." Gostaram";
		  }
		  else
		  {
          }
    echo $btnhaha;
}
?>