<?php   
header("Content-Type:application/json");
 include('Dbconnect.php');
if (isset($_GET['id']) && $_GET['id'] != '') 
{
$userid =  strip_tags($_GET['id']);
$userid = $DBcon->real_escape_string($userid);
$result=$DBcon->query("SELECT * FROM votos WHERE enqueteid='".$userid."'"); 
$count=$result->num_rows;
if($count>=1)
{
    
            $arr = [];
            $inc = 0;
            while ($row = $result->fetch_assoc()) 
            {
            $nome = $row['nome'];
            $voto = $row['modelo'];
            if($voto=="A Favor")
            {
                $color="Green";
            }
            elseif($voto=="Contra")
            {
                $color="Red";
            }
            elseif($voto=="Abster")
            {
                $color="Gray";
            }
            else
            {
                $color="White";
            }
            
            $result2=$DBcon->query("SELECT * FROM usuarios WHERE nome='".$nome."'"); 
$count2=$result2->num_rows;
if($count2>=1)
{
    while ($row2 = $result2->fetch_assoc()) 
            {
            $foto = "https://legislativocamocim.top/fotos/". $row2['foto'];
            $sigla = "https://legislativocamocim.top/partidos/". $row2['sigla'].".png";
            }
            $nome = utf8_decode($nome);
            $jsonArrayObject = (array('nome'=>$nome,'votacao'=>$voto,'color'=>$color,'foto'=>$foto,'sigla'=>$sigla));
                $arr[$inc] = $jsonArrayObject;
                $inc++;
            
}
else
{
    $jsonArrayObject = (array('nome'=>$nome,'votacao'=>$voto,'color'=>$color,'foto'=>"https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png"));
                $arr[$inc] = $jsonArrayObject;
                $inc++;
}
            
            }
            //$json = json_encode(array_map('utf8_encode', $arr));
            $json_array = json_encode($arr, JSON_UNESCAPED_SLASHES);
            //$json_array = json_encode($json_array, JSON_UNESCAPED_UNICODE);
            echo utf8_encode($json_array);

    mysqli_close($DBcon);
}
}