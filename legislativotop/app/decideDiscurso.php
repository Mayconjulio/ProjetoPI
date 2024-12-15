<?php   
header("Content-Type:application/json");
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['sts'] != '' && $_GET['tipo'] != '') 
{
 include('Dbconnect.php');
 $id =  strip_tags($_GET['id']);
 $id = $DBcon->real_escape_string($id);
 $sts = strip_tags($_GET['sts']);
 $sts = $DBcon->real_escape_string($sts);
 $tipo = strip_tags($_GET['tipo']);
 $tipo = $DBcon->real_escape_string($tipo);
 
$res2=$DBcon->query("SELECT * FROM camconfig WHERE id=1");
$userRow2=$res2->fetch_array();
$discurso = $userRow2['discurso'];
$aparte = $userRow2['aparte'];
$qordem = $userRow2['qordem'];
$cfinal = $userRow2['cfinal'];
 
if($tipo=="discurso")
{ 
  $now = date("Y-m-d H:i:s");
  $tenMinFromNow = date('Y-m-d H:i:s', strtotime($now.'+'.$discurso.' minutes'));
}
elseif($tipo=="contra")
{
  $now = date("Y-m-d H:i:s");
  $tenMinFromNow = date('Y-m-d H:i:s', strtotime($now.'+'.$aparte.' minutes'));
}
elseif($tipo=="ordem")
{
  $now = date("Y-m-d H:i:s");
  $tenMinFromNow = date('Y-m-d H:i:s', strtotime($now.'+'.$qordem.' minutes'));
}
else
{
  $now = date("Y-m-d H:i:s");
  $tenMinFromNow = date('Y-m-d H:i:s', strtotime($now.'+'.$cfinal.' minutes'));
}
 
 //INICIO UPDATE
$query = "UPDATE discurso SET status='".$sts."',fim='$tenMinFromNow' WHERE vereador='".$id."' ORDER BY id DESC LIMIT 1";
if ($DBcon->query($query))
{
    $msg = "ok";
    response($msg);
    mysqli_close($DBcon);
 }
 else
 {
     $msg = "erro";
    response($msg);
    mysqli_close($DBcon);
 }
//FIM UPDATE
}
 
function response($msg)
{
 $response['msg'] = $msg;
 
 $json_response = json_encode($response);
 echo $json_response;
}
?>