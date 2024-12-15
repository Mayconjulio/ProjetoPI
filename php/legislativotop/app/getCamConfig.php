<?php   
header("Content-Type:application/json");
ini_set('display_errors', 1); 
error_reporting(-1);
 include('Dbconnect.php');
 $result2 = mysqli_query($DBcon,"SELECT * FROM camconfig WHERE id=1");
 if(mysqli_num_rows($result2)>0)
 {
 $row2 = mysqli_fetch_array($result2);
 $nome = utf8_decode($row2['nome']);
 $nomee = utf8_decode($row2['nomee']);
 $logo = $row2['logo'];
 $corexibidor = $row2['corexibidor'];
 $cortxtexibidor = $row2['cortxtexibidor'];
 $corgeral = $row2['corgeral'];
 $cormenu = $row2['cormenu'];
 response($nome, $nomee, $logo, $corexibidor, $cortxtexibidor, $corgeral, $cormenu);
}
else
{
 $nome = "0";
 $nomee = "0";
 $logo = "0";
 $corexibidor = "0";
 $cortxtexibidor = "0";
 $corgeral = "0";
 $cormenu = "0";
    response($nome,$nomee,$logo, $corexibidor, $cortxtexibidor, $corgeral, $cormenu);
}
//mysqli_close($DBcon);
 
function response($nome, $nomee, $logo, $corexibidor, $cortxtexibidor, $corgeral, $cormenu)
{
 $response['nome'] = $nome;
 $response['nomee'] = $nomee;
 $response['logo'] = $logo;
 $response['corexibidor'] = $corexibidor;
 $response['cortxtexibidor'] = $cortxtexibidor;
 $response['corgeral'] = $corgeral;
 $response['cormenu'] = $cormenu;
 $json = json_encode(array_map('utf8_encode', $response));
 //$json_response = json_encode($response, JSON_UNESCAPED_SLASHES);
 echo $json;
}
?>