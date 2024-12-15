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
    $output .= '<div class="container-fluid d-flex" name="discursando" id="discursando"><center><h2 style="'.$cortxtexibidor.';"></h2>';
    while ($usuario = $queryy->fetch_array()) {
        $iddisc = $usuario['id'];
        $idvereador = $usuario['vereador'];

        $inicio = $usuario['inicio'];
        $fim = $usuario['fim'];

        $start = date_create($inicio);
        $end = date_create($fim);
        $now = new DateTime('NOW');
        $interval = date_diff($now, $end);

        $minutes = $interval->i;
        $seconds = $interval->s;

        // Adiciona "0" na frente se o minuto ou segundo tiver somente 1 caractere
        $minutes = sprintf("%02d", $minutes);
        $seconds = sprintf("%02d", $seconds);

        $interval = "{$minutes}:{$seconds}";

        // Pegafoto
        $queryfinal = $DBcon->query("SELECT * FROM usuarios WHERE user_id=".$idvereador);
        $contagemfinal = $queryfinal->num_rows;

        if ($contagemfinal > 0) {
            $output .= '<center><div class="row">';
            while ($usuariofinal = $queryfinal->fetch_array()) {
                $nomef = $usuariofinal['nome'];
                $idvereador = $usuariofinal['user_id'];
                $fotof = $usuariofinal['foto'];
                $siglaf = $usuariofinal['sigla'];
                if ($fotof == "") {
                    $fotof = "default-avatar.png";
                }

                $output .= '<form role="form" action="" autocomplete="off" method="post">
                            <div class="col">
                            <div class="card mb-8" style="max-height: 2240px;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="fotos/'.$fotof.'" class="img-fluid rounded-start" height="1600" alt="'.utf8_decode($nomef).'"><br>
                                    <h5 class="card-title" style="font-size:40px;"><strong>'.utf8_decode($nomef).'</strong></h5>
                                    <center><br><img src="partidos/'.$siglaf.'.png" alt="Vereador(a)" width="100"></center><br>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title" style="font-size:350px;"><strong>'.$interval.'</strong></h5>
                                        <input id="trest1" name="trest1" value="'.$interval.'" hidden></input>
                                        <input id="discnow1" name="discnow1" value="'.$iddisc.'" hidden></input>';

                if ($prestat == 1) {
                    $output .= '<button type="submit" class="btn btn-danger" name="interromper">Cancelar discurso</button>';
                }

                $output .= '</div></div></div></div></div></form>';
            }
            $output .= '</div>';

            // Contra parte
            $queryy2 = $DBcon->query("SELECT * FROM discurso WHERE idvotacao='$eid' AND status='1' AND id<>".$iddisc." ORDER BY id ASC LIMIT 1");    
            $contagemm2 = $queryy2->num_rows;

            if ($contagemm2 > 0) {
                $output .= '<center><hr><div class="row">';
                while ($usuario2 = $queryy2->fetch_array()) {
                    $iddisc2 = $usuario2['id'];
                    $idvereador2 = $usuario2['vereador'];
                    $inicio2 = $usuario2['inicio'];
                    $fim2 = $usuario2['fim'];
                    $start2 = date_create($inicio2);
                    $end2 = date_create($fim2);
                    $now2 = new DateTime('NOW');
                    $interval2 = date_diff($now2, $end2);

                    $minutes2 = $interval2->i;
                    $seconds2 = $interval2->s;

                    // Adiciona "0" na frente se o minuto ou segundo tiver somente 1 caractere
                    $minutes2 = sprintf("%02d", $minutes2);
                    $seconds2 = sprintf("%02d", $seconds2);

                    $interval2 = "{$minutes2}:{$seconds2}";

                    // Pegafoto
                    $queryfinal2 = $DBcon->query("SELECT * FROM usuarios WHERE user_id=".$idvereador2);    
                    $contagemfinal2 = $queryfinal2->num_rows;

                    if ($contagemfinal2 > 0) {
                        $output .= '<center><div class="row">';
                        while ($usuariofinal2 = $queryfinal2->fetch_array()) {
                            $nomef2 = $usuariofinal2['nome'];
                            $idvereador2 = $usuariofinal2['user_id'];
                            $fotof2 = $usuariofinal2['foto'];
                            $siglaf2 = $usuariofinal2['sigla'];

                            if ($fotof2 == "") {
                                $fotof2 = "default-avatar.png";
                            }

                            $output .= '<form role="form" action="" autocomplete="off" method="post">
                                        <div class="col">
                                        <div class="card mb-8" style="max-height: 2240px;">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <img src="fotos/'.$fotof2.'" class="img-fluid rounded-start" height="1600" alt="'.utf8_decode($nomef2).'"><br>
                                                <h5 class="card-title" style="font-size:40px;"><strong>'.utf8_decode($nomef2).'</strong></h5>
                                                <center><br><img src="partidos/'.$siglaf2.'.png" alt="Vereador(a)" width="100"></center><br>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title" style="font-size:350px;"><strong>'.$interval2.'</strong></h5>
                                                    <input id="trest2" name="trest2" value="'.$interval2.'" hidden></input>
                                                    <input id="discnow2" name="discnow2" value="'.$iddisc2.'" hidden></input>';
                            $output .= '</div></div></div></div></div></form>';
                        }
                        $output .= '</div>';
                    }
                    // Fim contra parte
                }
                $output .= '</div>';
            }
        }
    }
    $output .= '</center></div>';
} else {
    $output .= '<div class="container-fluid d-flex" name="discursando" id="discursando"></div>';
}

echo $output;
// Fim check botão voto
//$DBcon->close();
?>
