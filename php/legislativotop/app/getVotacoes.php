<?php   
header("Content-Type:application/json");
 include('Dbconnect.php');
if (isset($_GET['id']) && $_GET['id'] != '') 
{
$userid =  strip_tags($_GET['id']);
$userid = $DBcon->real_escape_string($userid);
$result=$DBcon->query("SELECT * FROM enquetes WHERE categoria='".$userid."'"); 
$count=$result->num_rows;
if($count>=1)
{
            $arr = [];
            $inc = 0;
            while ($row = $result->fetch_assoc()) 
            {
            $id = $row['id'];
            $nome = $row['titulo'];
            $desc = $row['descricao'];
                $jsonArrayObject = (array('votacao'=>"[".$id."] ".$nome,'descricao'=>$desc));
                $arr[$inc] = $jsonArrayObject;
                $inc++;
            }
            //$json = json_encode(array_map('utf8_encode', $arr));
            $json_array = json_encode($arr, JSON_UNESCAPED_SLASHES);
            echo $json_array;

    mysqli_close($DBcon);
}
}