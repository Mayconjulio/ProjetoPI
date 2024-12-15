<?php 
include_once 'Dbconnect.php';
date_default_timezone_set('America/Sao_Paulo');
$output = '';
$disc1id = $_POST['disc1id'];
//$usr = $_POST['mid'];
//$usrname = $_POST['cnpj']; 

echo '<div class="container" name="fdiscurso" id="fdiscurso">';

//inicio aceita disc
$query = "UPDATE discurso SET status=2 WHERE id='".$disc1id."'";
  
if ($DBcon->query($query))
{
  //header("Refresh:0");
}
else
{

}
//fim check botão voto
echo "</div>";
?>