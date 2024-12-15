<?php   
header("Content-Type:application/json");
if (isset($_GET['id']) && $_GET['id'] != '' && isset($_GET['vereador']) && isset($_GET['tipo'])) 
{
 include('Dbconnect.php');
 $id =  strip_tags($_GET['id']);
 $id = $DBcon->real_escape_string($id);
 $vereador =  strip_tags($_GET['vereador']);
 $vereador = $DBcon->real_escape_string($vereador);
 $tipo =  strip_tags($_GET['tipo']);
 $tipo = $DBcon->real_escape_string($tipo);

$query2 = "INSERT INTO discurso(idvotacao,vereador,tipo) VALUES('$id','$vereador','$tipo')";
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