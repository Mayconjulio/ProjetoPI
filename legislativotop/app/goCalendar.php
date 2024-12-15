<?php   
header("Content-Type:application/json");
if (isset($_GET['id']) && $_GET['id'] != '' && isset($_GET['voto']) && isset($_GET['datan'])) 
{
 include('Dbconnect.php');
 $nome =  strip_tags($_GET['id']);
 $nome = $DBcon->real_escape_string($nome);
 $voto =  strip_tags($_GET['voto']);
 $voto = $DBcon->real_escape_string($voto);
 $datan =  strip_tags($_GET['datan']);
 $datan = $DBcon->real_escape_string($datan);
    $query2 = "INSERT INTO calendario(idvereador,evento,dataev) VALUES('$nome','$voto','$datan')";
if ($DBcon->query($query2))
{
    $msg = "ok";
    response($msg);
    mysqli_close($DBcon);
 }
 else
 {
     $msg = "erro";
    response($msg);
    mysqli_close($DBcon);
 } 
}
 
function response($msg)
{
 $response['msg'] = $msg;
 
 $json_response = json_encode($response);
 echo $json_response;
}
?>