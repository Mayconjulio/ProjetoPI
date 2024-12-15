<?php   
header("Content-Type:application/json");
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['nome'] != '' && $_GET['usuario'] != '' && $_GET['email'] != '' && $_GET['partido'] != '' && $_GET['sigla'] != '') 
{
 include('Dbconnect.php');
 $id =  strip_tags($_GET['id']);
 $id = $DBcon->real_escape_string($id);
 $nome =  strip_tags($_GET['nome']);
 $nome = $DBcon->real_escape_string($nome);
 $usuario =  strip_tags($_GET['usuario']);
 $usuario = $DBcon->real_escape_string($usuario);
 $email =  strip_tags($_GET['email']);
 $email = $DBcon->real_escape_string($email);
 $partido =  strip_tags($_GET['partido']);
 $partido = $DBcon->real_escape_string($partido);
 $sigla =  strip_tags($_GET['sigla']);
 $sigla = $DBcon->real_escape_string($sigla);
 //INICIO UPDATE
$query = "UPDATE usuarios SET nome='$nome',usuario='$usuario',email='$email',partido='$partido',sigla='$sigla' WHERE user_id='".$id."'";
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