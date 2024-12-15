<?php   
header("Content-Type:application/json");
 include('Dbconnect.php');
 if (isset($_GET['id']) && $_GET['id'] != '') 
 {
      $id =  strip_tags($_GET['id']);
      $id = $DBcon->real_escape_string($id);
      
 $result2 = mysqli_query($DBcon,"SELECT * FROM usuarios WHERE user_id='".$id."'");
 if(mysqli_num_rows($result2)>0)
 {
 $row2 = mysqli_fetch_array($result2);
 $nome = $row2['nome'];
 $usuario = $row2['usuario'];
 $email = $row2['email'];
 $partido = $row2['partido'];
 $sigla = $row2['sigla'];
response($nome,$usuario,$email,$partido,$sigla);
}
else
{
    $status="0";
     $nome = "0";
 $usuario = "0";
 $email = "0";
 $partido = "0";
 $sigla = "0";
    response($nome,$usuario,$email,$partido,$sigla);
}
mysqli_close($DBcon);
}
 
function response($nome,$usuario,$email,$partido,$sigla)
{
 $response['nome'] = $nome;
 $response['usuario'] = $usuario;
 $response['email'] = $email;
 $response['partido'] = $partido;
 $response['sigla'] = $sigla;
 $json = json_encode(array_map('utf8_encode', $response));
 $json_response = json_encode($response);
 echo $json_response;
}
?>