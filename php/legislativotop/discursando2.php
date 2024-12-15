<?php 
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';

$res2 = $DBcon->query("SELECT * FROM camconfig WHERE id=1");
$userRow2 = $res2->fetch_array();
$nomecam = $userRow2['nome'];
$cormenu = $userRow2['cormenu'];
$corexibidor = $userRow2['corexibidor'];
$cortxtexibidor = $userRow2['cortxtexibidor'];
$corgeral = $userRow2['corgeral'];

$output = '';
$eid = $_POST['eid'];
$prestat = $_POST['prestat'];

// Início check botão voto
$queryy = $DBcon->query("SELECT * FROM discurso WHERE idvotacao='$eid' AND status='1' ORDER BY id ASC LIMIT 1");    
$contagemm = $queryy->num_rows;

if ($contagemm > 0) {
    $output .= '<div class="container d-flex justify-content-center" name="discursando" id="discursando"><center><h2 style="'.$cortxtexibidor.';">Discursando agora</h2><hr>';
    while ($usuario = $queryy->fetch_array()) {
        $iddisc = $usuario['id'];
        $idvereador = $usuario['vereador'];
        $inicio = $usuario['inicio'];
        $fim = $usuario['fim'];
        $start = date_create($inicio);
        $end = date_create($fim);
        $now = new DateTime('NOW');
        $differenceFormat = "%i:%s";
        $interval = date_diff($now, $end);

        $output .= '<center><div class="row align-items-center">';
        $queryfinal = $DBcon->query("SELECT * FROM usuarios WHERE user_id=".$idvereador);
        $contagemfinal = $queryfinal->num_rows;
        if ($contagemfinal >= 0) {
            while ($usuariofinal = $queryfinal->fetch_array()) {
                $nomef = $usuariofinal['nome'];
                $idvereador = $usuariofinal['user_id'];
                $fotof = $usuariofinal['foto'];
                $siglaf = $usuariofinal['sigla'];
                if ($fotof == "") {
                    $fotof = "default-avatar.png";
                }

                $output .= '<form role="form" action="" autocomplete="off" method="post">
                <div class="col-sm"><div class="card" style="width: 15rem;">
                <img src="fotos/'.$fotof.'" class="card-img-top" alt="Vereador(a)" width="10" height="200">
                <div class="card-body">
                <strong><p class="card-title" style="color:black;">'.utf8_decode($nomef).' ['.$siglaf.']</p></strong>';
                $output .= '<input id="discnow1" name="discnow1" value="'.$iddisc.'" hidden></input>';

                if ($prestat == 1) {
                    $output .= '<button type="submit" class="btn btn-danger" name="interromper">Cancelar discurso</button>';
                }

                $output .= '</div></div></div></form>';
            }
        }
    }
    $output .= "</center></div>";
} else {
    $output .= '<div class="container d-flex justify-content-center" name="discursando" id="discursando"></div>';
}

echo $output;
// Fim check botão voto
//$DBcon->close();
?>
