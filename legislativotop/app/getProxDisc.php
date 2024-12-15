<?php   
header("Content-Type:application/json");
 include('Dbconnect.php');
if (isset($_GET['id']) && $_GET['id'] != '') 
{
$id =  strip_tags($_GET['id']);
$id = $DBcon->real_escape_string($id);
$result=$DBcon->query("SELECT * FROM discurso WHERE idvotacao='".$id."' AND status='0' ORDER BY id ASC"); 
$count=$result->num_rows;
if($count>=1)
{
            $arr = [];
            $inc = 0;
            while ($row = $result->fetch_assoc()) 
            {
            //$id = $row['id'];
                $tipo = $row['tipo'];
                $idvereador = $row['vereador'];
                $result2=$DBcon->query("SELECT nome FROM usuarios WHERE user_id='".$idvereador."'"); 
                $count2=$result2->num_rows;
                if($count2>=1)
                {
                            while ($row2 = $result2->fetch_assoc()) 
                            {
                                $nome = $row2['nome'];
                $jsonArrayObject = (array('tipo'=>$tipo,'id'=>$idvereador,'nomedisc'=>$inc." - ".$nome));
                $arr[$inc] = $jsonArrayObject;
                $inc++;
                            }
                        }
            
            
            }
            //$json = json_encode(array_map('utf8_encode', $arr));
            $json_array = json_encode($arr, JSON_UNESCAPED_SLASHES);
            echo $json_array;

    mysqli_close($DBcon);
}
}