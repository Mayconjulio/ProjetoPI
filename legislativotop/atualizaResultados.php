<?php
include_once 'Dbconnect.php';
date_default_timezone_set('America/Sao_Paulo');
$output = '';
$eid = $_POST['eid'];

$output .= '<div name="dresult" id="dresult">';

// Contagem de votos "A Favor"
$querycca = $DBcon->query("SELECT COUNT(*) AS count_favor FROM votos WHERE enqueteid='$eid' AND modelo='A Favor'");
$rowcca = $querycca->fetch_assoc();
$conta = $rowcca['count_favor'];
$output .= '<h1><span class="badge badge-pill badge-success">A Favor: ' . $conta . '</span>&nbsp;';

// Contagem de votos "Contra"
$queryccb = $DBcon->query("SELECT COUNT(*) AS count_contra FROM votos WHERE enqueteid='$eid' AND modelo='Contra'");
$rowccb = $queryccb->fetch_assoc();
$contb = $rowccb['count_contra'];
$output .= '<span class="badge badge-pill badge-danger">Contra: ' . $contb . '</span>&nbsp;';

// Contagem de votos "Abstenção"
$queryccc = $DBcon->query("SELECT COUNT(*) AS count_abstencao FROM votos WHERE enqueteid='$eid' AND modelo='Abster'");
$rowccc = $queryccc->fetch_assoc();
$contc = $rowccc['count_abstencao'];
$output .= '<span class="badge badge-pill badge-secondary">Abstenção: ' . $contc . '</span>&nbsp;';

// Contagem total de votos
$queryccd = $DBcon->query("SELECT COUNT(*) AS count_total FROM votos WHERE enqueteid='$eid'");
$rowccd = $queryccd->fetch_assoc();
$contd = $rowccd['count_total'];
$output .= '<span class="badge badge-pill badge-primary">Total: ' . $contd . '</span></h1>';

$total = $contd;
$favor = $conta;
$contra = $contb;
$abstencao = $contc;

// Verificação do resultado da votação
if ($favor > $contra && $favor > $abstencao) {
    $output .= '<br><center><h1><span class="badge badge-pill badge-success">Aprovado</span></h1></center>';
} elseif ($contra > $favor && $contra > $abstencao) {
    $output .= '<br><center><h1><span class="badge badge-pill badge-danger">Rejeitado</span></h1></center>';
} else {
    $output .= '<br><center><h1><span class="badge badge-pill badge-dark">Em andamento</span></h1></center>';
}

$output .= '</center></div>';
$DBcon->close();

echo $output;
?>
