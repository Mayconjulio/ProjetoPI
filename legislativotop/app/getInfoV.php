<?php   
header("Content-Type:application/json");
 include('Dbconnect.php');
 if (isset($_GET['id']) && $_GET['id'] != '') 
 {
      $id =  strip_tags($_GET['id']);
      $id = $DBcon->real_escape_string($id);
      
 $result2 = mysqli_query($DBcon,"SELECT * FROM enquetes WHERE id='".$id."'");
 if(mysqli_num_rows($result2)>0)
 {
 $row2 = mysqli_fetch_array($result2);
 $status = $row2['titulo'];
 $nome = $row2['descricao'];
 
     //ini
    $queryccb = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$userid."' AND modelo='Contra'");
    $contagemccb=$queryccb->num_rows;
    
    $queryccc = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$userid."' AND modelo='Abster'");
    $contagemccc=$queryccc->num_rows;
    
    $querycca = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$userid."' AND modelo='A Favor'");
    $contagemcca=$querycca->num_rows;
    
    $queryccd = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$userid."'");
    $contagemccd=$queryccd->num_rows;
    
    $total = $contagemccd;
    $favor = $contagemcca;
    $contra = $contagemccb;
    $abstencao = $contagemccc;
  if($favor>$contra && $favor>$abstencao)
  {
  $resultado ="Aprovado";
  }
  elseif($contra>$favor && $contra>$abstencao)
  {
    $resultado ="Rejeitado";
  }
  else
  {
    $resultado ="Em andamento";
  }
    //fim
 
response($status, $nome,$resultado);
}
else
{
    $status="0";
     $nome = "0";
     $resultado="0";
    response($status, $nome,$resultado);
}
mysqli_close($DBcon);
}
 
function response($status, $nome,$resultado)
{
 $response['votacao'] = $status;
 $response['descricao'] = $nome;
 $response['resultado'] = $resultado;
 $json = json_encode(array_map('utf8_encode', $response));
 $json_response = json_encode($response);
 echo $json;
}
?>