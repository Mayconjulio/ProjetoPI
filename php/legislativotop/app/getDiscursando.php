<?php   
header("Content-Type:application/json");
 include('Dbconnect.php');
 if (isset($_GET['id'])) 
 {
      $id =  strip_tags($_GET['id']);
      $id = $DBcon->real_escape_string($id);

      $queryy=$DBcon->query("SELECT * FROM discurso WHERE idvotacao='".$id."' AND status='1' ORDER BY id ASC LIMIT 1");    
      $contagemm=$queryy->num_rows;
      if($contagemm>0)
      {
          while($usuario=$queryy->fetch_array())
{
        $iddisc = $usuario['id'];
        $idvereador = $usuario['vereador'];
        $inicio = $usuario['inicio'];
        $fim = $usuario['fim'];
 
        $start = date_create($inicio);
        $end = date_create($fim);
        $now = new DateTime('NOW');
        $differenceFormat = "%i:%s";
        $interval = date_diff($now, $end);
        $tempo = $interval->format($differenceFormat);

 $result2 = mysqli_query($DBcon,"SELECT * FROM usuarios WHERE user_id='".$idvereador."'");
 if(mysqli_num_rows($result2)>0)
 {
 $row2 = mysqli_fetch_array($result2);
 $nome = $row2['nome'];
 $foto = $row2['foto'];
 $sigla = $row2['sigla'];
response($nome,$foto,$sigla,$tempo,$idvereador);
}
else
{
     $nome = "0";
 $foto = "0";
 $sigla = "0";
 $tempo="0";
 $idvereador="0";
    response($nome,$foto,$sigla,$tempo,$idvereador);
}
mysqli_close($DBcon);
    }
 }
}
else
{
  $nome = "0";
 $foto = "0";
 $sigla = "0";
 $tempo="0";
 $idvereador="0";  
 response($nome,$foto,$sigla,$tempo,$idvereador);
}
 
function response($nome,$foto,$sigla,$tempo,$idvereador)
{
    $response['id'] = $idvereador;
    $response['nome'] = $nome;
    $response['foto'] = $foto;
 $response['sigla'] = $sigla;
 $response['tempo'] = $tempo;
 $json = json_encode(array_map('utf8_encode', $response));
 $json_response = json_encode($response);
 echo $json_response;
}
?>