<?php   
header("Content-Type:application/json");
 include('Dbconnect.php');
if (isset($_GET['id']) && $_GET['id'] != '') 
{
$userid =  strip_tags($_GET['id']);
$userid = $DBcon->real_escape_string($userid);
$result=$DBcon->query("SELECT * FROM anotacoes WHERE idvereador=".$userid." ORDER BY id DESC"); 
$count=$result->num_rows;
if($count>=1)
{
            $arr = [];
            $inc = 0;
            while ($row = $result->fetch_assoc()) 
            {
            //$id = $row['id'];
            $nome = $row['anota'];
            $desc = strval($row['datan']);
            $phpdate = strtotime( $desc );
            $mysqldate = date( 'd/m/Y H:i', $phpdate );
                $jsonArrayObject = (array('anota'=>$nome,'datan'=>$mysqldate));
                $arr[$inc] = $jsonArrayObject;
                $inc++;
            }
            //$json = json_encode(array_map('utf8_encode', $arr));
            $json_array = json_encode($arr, JSON_UNESCAPED_SLASHES);
            echo $json_array;

    mysqli_close($DBcon);
}
}