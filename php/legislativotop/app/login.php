<?php   
header("Content-Type:application/json");
if (isset($_GET['username']) && $_GET['username'] != '' && isset($_GET['password']) && $_GET['password'] != '') 
{
 include('Dbconnect.php');
 $username =  strip_tags($_GET['username']);
 $password =  strip_tags($_GET['password']);

$username = $DBcon->real_escape_string($username);
$password = $DBcon->real_escape_string($password);

 $result = mysqli_query($DBcon,"SELECT * FROM usuarios WHERE usuario='$username'");

 if(mysqli_num_rows($result)>0)
 {
 $row = mysqli_fetch_array($result);
 $user_id = $row['user_id'];
 $nome = $row['nome'];
 $usuario = $row['usuario'];
 $foto = $row['foto'];
 $partido = $row['partido'];
 $sigla = $row['sigla'];
 $senha = $row['senha'];

    if (password_verify($password, $senha)) 
    {
    $msg = "loggedin";
    response($user_id,$usuario,$nome,$foto,$partido,$sigla,$msg);
    }
    else
    {
        $user_id = "";
 $nome = "";
  $usuario = "";
 $foto = "";
 $partido = "";
 $sigla = "";
 $msg = "erro";
    response($user_id,$usuario,$nome,$foto,$partido,$sigla,$msg);
    }
 }
 else
 {
    $user_id = "";
 $nome = "";
 $usuario = "";
 $foto = "";
 $partido = "";
 $sigla = "";
 $msg = "erro2";
    response($user_id,$usuario,$nome,$foto,$partido,$sigla,$msg);
 }
mysqli_close($DBcon);
 }
else
{
    $user_id = "";
 $nome = "";
 $usuario = "";
 $foto = "";
 $partido = "";
 $sigla = "";
 $msg = "erro3";
    response($user_id,$usuario,$nome,$foto,$partido,$sigla,$msg);
}
 
function response($user_id,$usuario,$nome,$foto,$partido,$sigla,$msg)
{
 $response['id'] = $user_id;
 $response['nome'] = $nome;
 $response['usuario'] = $usuario;
 $response['foto'] = $foto;
 $response['partido'] = $partido;
 $response['sigla'] = $sigla;
 $response['msg'] = $msg;
 
 $json_response = json_encode($response);
 echo $json_response;
}
?>