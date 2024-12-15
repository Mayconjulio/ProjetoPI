<?php 
include_once 'Dbconnect.php';
date_default_timezone_set('America/Sao_Paulo');
$output = '';
$eid = $_POST['eid'];
$votacao = htmlspecialchars($_COOKIE["votacao"]);

$verifica=$DBcon->query("SELECT * FROM presencas WHERE idvotacao=".$votacao." AND vereador=".$eid."");    
$contagem=$verifica->num_rows;
if($contagem>=1)
{
  echo '<script>alert("Vereador já teve presença registrada.");</script>';

  echo '<div name="lstvereadorespresentes" id="lstvereadorespresentes"><br>
<form role="form" action="" autocomplete="off" method="post">
<select class="form-control" id="vpresentes" name="vpresentes">';
echo '<option id="1" data-eid="1" value="1" selected="selected">Registre a presença dos vereadores</option>';
$queryv=$DBcon->query("SELECT * FROM usuarios ORDER BY user_id DESC");
$countv=$queryv->num_rows;
if($countv>=1)
{
while($enquetev=$queryv->fetch_array())
{
        $vereador = $enquetev['nome'];
        $party = $enquetev['partido'];
        $user_id = $enquetev['user_id'];
        if($vereador==".")
        {}
        else
        {
          $queryvv=$DBcon->query("SELECT * FROM presencas WHERE vereador=$user_id AND idvotacao=$votacao");
          $countvv=$queryvv->num_rows;
        if($countvv>=1)
      {
        echo '<option id="'.$user_id.'" data-eid="'.$user_id.'" style="background-color: green; color: white;" class="overrideGreen">['.$party.'] '.utf8_decode($vereador).'</option> ';
      }
      else
      {
        echo '<option id="'.$user_id.'" data-eid="'.$user_id.'">['.$party.'] '.utf8_decode($vereador).'</option> ';
      }
        }
}
}
echo '</select>   
</form>
</div>';

}
else
{
$query = "INSERT INTO presencas(idvotacao,vereador) VALUES('$votacao','$eid')";
if ($DBcon->query($query))
{
  echo '<div name="lstvereadorespresentes" id="lstvereadorespresentes"><br>
<form role="form" action="" autocomplete="off" method="post">
<select class="form-control" id="vpresentes" name="vpresentes">';
echo '<option id="1" data-eid="1" value="1" selected="selected">Registre a presença dos vereadores</option>';
$queryv=$DBcon->query("SELECT * FROM usuarios ORDER BY user_id DESC");
$countv=$queryv->num_rows;
if($countv>=1)
{
while($enquetev=$queryv->fetch_array())
{
        $vereador = $enquetev['nome'];
        $party = $enquetev['partido'];
        $user_id = $enquetev['user_id'];
        if($vereador==".")
        {}
        else
        {
          $queryvv=$DBcon->query("SELECT * FROM presencas WHERE vereador=$user_id AND idvotacao=$votacao");
          $countvv=$queryvv->num_rows;
        if($countvv>=1)
      {
        echo '<option id="'.$user_id.'" data-eid="'.$user_id.'" style="background-color: green; color: white;" class="overrideGreen">✅['.$party.'] '.utf8_decode($vereador).'</option> ';
      }
      else
      {
        echo '<option id="'.$user_id.'" data-eid="'.$user_id.'">['.$party.'] '.utf8_decode($vereador).'</option> ';
      }
        }
}
}
echo '</select>   
</form>
</div>';
echo '<script>alert("Presença do vereador foi registrada.");</script>';
}
else
{
echo '<script>alert("Erro ao registrar presença");</script>';
}
}
?>