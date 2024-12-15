<?php   
header("Content-Type:application/json");
if (isset($_GET['id']) && $_GET['id'] != '' && isset($_GET['voto']) && isset($_GET['enqueteid'])) 
{
 include('Dbconnect.php');
 $nome =  strip_tags($_GET['id']);
 $nome = $DBcon->real_escape_string($nome);
 $voto =  strip_tags($_GET['voto']);
 $voto = $DBcon->real_escape_string($voto);
 $enqueteid =  strip_tags($_GET['enqueteid']);
 $enqueteid = $DBcon->real_escape_string($enqueteid);
if($voto=="Remover")
{
   $query = "DELETE FROM votos WHERE nome='".$nome."' AND enqueteid='$enqueteid'";
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
}
else
{
//CHECK VOTO
$result2 = mysqli_query($DBcon,"SELECT * FROM votos WHERE nome='".$nome."' AND enqueteid='$enqueteid'");
 if(mysqli_num_rows($result2)>0)
 {
 $row2 = mysqli_fetch_array($result2);
 $user = $row2['usuario'];
 //INICIO UPDATE
$query = "UPDATE votos SET modelo='$voto',enqueteid='$enqueteid' WHERE nome='".$nome."'";
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
 else
 {
    $query2 = "INSERT INTO votos(nome,enqueteid,modelo) VALUES('$nome','$enqueteid','$voto')";
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
}

}
 
function response($msg)
{
 $response['msg'] = $msg;
 
 $json_response = json_encode($response);
 echo $json_response;
}
?>