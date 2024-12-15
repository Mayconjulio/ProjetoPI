<?php   
header("Content-Type:application/json");
 include('Dbconnect.php');
 
 $result=$DBcon->query("SELECT * FROM sessoes ORDER BY id DESC"); 
$count=$result->num_rows;
if($count>=1)
{
            $arr = [];
            $inc = 0;
            while ($row = $result->fetch_assoc()) 
            {
            $idusuario = $row['id'];
            $nomeusrmaca = $row['sessao'];
                $jsonArrayObject = (array('sessao'=>$nomeusrmaca));
                $arr[$inc] = $jsonArrayObject;
                $inc++;
            }
            //$json = json_encode(array_map('utf8_encode', $arr));
            $json_array = json_encode($arr, JSON_UNESCAPED_SLASHES);
            echo $json_array;

    mysqli_close($DBcon);
}