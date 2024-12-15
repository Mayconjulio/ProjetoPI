<?php   
header("Content-Type:application/json");
if (isset($_GET['id']) && $_GET['id'] != '' && isset($_GET['voto'])) 
{
 include('Dbconnect.php');
 $nome =  strip_tags($_GET['id']);
 $nome = $DBcon->real_escape_string($nome);
 $voto =  strip_tags($_GET['voto']);
 $voto = $DBcon->real_escape_string($voto);

    $query2 = "INSERT INTO anotacoes(idvereador,anota) VALUES('$nome','$voto')";
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