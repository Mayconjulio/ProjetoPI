<?php 
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';

// Carregar informações da configuração
$res2 = $DBcon->query("SELECT * FROM camconfig WHERE id=1");
$userRow2 = $res2->fetch_array();
$nomecam = $userRow2['nome'];
$cormenu = $userRow2['cormenu'];
$corexibidor = $userRow2['corexibidor'];
$cortxtexibidor = $userRow2['cortxtexibidor'];
$corgeral = $userRow2['corgeral'];

$output = '';

$eid = $_POST['eid'];
$usr = $_POST['mid'];
$usrname = $_POST['cnpj']; 

// Carregar informações da votação
$query = $DBcon->query("SELECT * FROM enquetes WHERE id='".$eid."'");
if ($userRow = $query->fetch_array()) {
    $titulo = $userRow['titulo'];
    $desc = $userRow['descricao'];
    $ini = $userRow['inicio'];
    $hr = $userRow['fim'];
    $catcat = $userRow['categoria'];
    echo '<center><h2 id="nomevota" name="nomevota" style="color:'.$cortxtexibidor.';">'.$catcat.'<br>'.$titulo.'</h2></center>';
} else {
    echo 'Erro ao carregar exibição da votação.';
}

$DBcon->close();
?>
