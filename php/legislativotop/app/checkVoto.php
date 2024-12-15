<?php   
header("Content-Type:application/json");
 include('Dbconnect.php');
 if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['sess'] != '') 
 {
      $id =  strip_tags($_GET['id']);
      $id = $DBcon->real_escape_string($id);
      $usr =  strip_tags($_GET['sess']);
      $usr = $DBcon->real_escape_string($usr);
      
 $result2 = mysqli_query($DBcon,"SELECT * FROM votos WHERE enqueteid='".$id."' AND nome='".$usr."'");
 if(mysqli_num_rows($result2)>0)
 {
 $row2 = mysqli_fetch_array($result2);
 $status = $row2['modelo'];
 $nome = $row2['id'];
response($status, $nome);
}
else
{
    $status="0";
     $nome = "0";
    response($status, $nome);
}
mysqli_close($DBcon);
}
 
function response($status, $nome)
{
 $response['votacao'] = $status;
 $response['descricao'] = $nome;
 $json = json_encode(array_map('utf8_encode', $response));
 $json_response = json_encode($response);
 echo $json_response;
}
?>