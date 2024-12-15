<?php   
header("Content-Type:application/json");
 include('Dbconnect.php');
 
 if (isset($_GET['id']) && $_GET['id'] != '') 
 {
      $id =  strip_tags($_GET['id']);
      $id = $DBcon->real_escape_string($id);
//echo $id;
      $queryy=$DBcon->query("SELECT * FROM discurso WHERE idvotacao=".$id." AND status=0 ORDER BY id ASC LIMIT 1");    
      $contagemm=$queryy->num_rows;
      if($contagemm>0)
      {
        while ($usuario = $queryy->fetch_assoc()) 
            {
        $iddisc = $usuario['id'];
        $idvereador = $usuario['vereador'];
        $inicio = $usuario['inicio'];
        $fim = $usuario['fim'];
        $tipo = $usuario['tipo'];
 
        $start = date_create($inicio);
        $end = date_create($fim);
        $now = new DateTime('NOW');
        $differenceFormat = "%i:%s";
        $interval = date_diff($now, $end);
        $tempo = $interval->format($differenceFormat);
            }

 $result2 = mysqli_query($DBcon,"SELECT * FROM usuarios WHERE user_id=".$idvereador."");
 if(mysqli_num_rows($result2)>0)
 {
 $row2 = mysqli_fetch_array($result2);
 $nome = $row2['nome'];
 $foto = $row2['foto'];
 $sigla = $row2['sigla'];
response($nome,$foto,$sigla,$tempo,$idvereador,$tipo);
}
else
{
     $nome = "0";
 $foto = "0";
 $sigla = "0";
 $tempo="0";
 $idvereador="0";
 $tipo="0";
    response($nome,$foto,$sigla,$tempo,$idvereador,$tipo);
}
mysqli_close($DBcon);
    }
    else
    {
        $nome = "0";
 $foto = "0";
 $sigla = "0";
 $tempo="0";
 $idvereador="0";
 $tipo="0"; 
 response($nome,$foto,$sigla,$tempo,$idvereador,$tipo);
    }
}
else
{
  $nome = "0";
 $foto = "0";
 $sigla = "0";
 $tempo="0";
 $idvereador="0";
 $tipo="0"; 
 response($nome,$foto,$sigla,$tempo,$idvereador,$tipo);
}
 
function response($nome,$foto,$sigla,$tempo,$idvereador,$tipo)
{
    $response['id'] = $idvereador;
    $response['nome'] = $nome;
    $response['foto'] = $foto;
 $response['sigla'] = $sigla;
 $response['tempo'] = $tempo;
 $response['tipo'] = $tipo;
 $json = json_encode(array_map('utf8_encode', $response));
 $json_response = json_encode($response);
 echo $json_response;
}
?>