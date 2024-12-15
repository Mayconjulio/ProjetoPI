<?php   
header("Content-Type:application/json");
if (isset($_GET['id']) && $_GET['id'] != '') 
{
 include('Dbconnect.php');
 $id =  strip_tags($_GET['id']);
 $id = $DBcon->real_escape_string($id);
 //INICIO UPDATE
$query = "UPDATE discurso SET status='2' WHERE vereador='".$id."'";
if ($DBcon->query($query))
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
//FIM UPDATE
}
 
function response($msg)
{
 $response['msg'] = $msg;
 
 $json_response = json_encode($response);
 echo $json_response;
}
?>