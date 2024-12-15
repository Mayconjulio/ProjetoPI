<?php 
include_once 'Dbconnect.php';
date_default_timezone_set('America/Sao_Paulo');

$output = '';

$eid = $_POST['eid'];
$usr = $_POST['mid'];
$usrname = $_POST['cnpj']; 

echo '<div class="container-fluid" id="listav" name="listav"><div class="row">';

// Check botão voto
$queryy = $DBcon->query("SELECT * FROM votos WHERE usuario='".$usrname."'");    
$contagemm = $queryy->num_rows;
if ($contagemm > 0) {
    while ($usuario = $queryy->fetch_array()) {
        $nome = $usuario['nome'];
        $usuario = $usuario['usuario'];
    }
    // Aqui funciona

    // Fim aqui funciona
}

// Lista de quem votou
$query = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."'");    
$contagem = $query->num_rows;
if ($contagem > 0) {
    while ($usuariooo = $query->fetch_array()) {
        $nome = $usuariooo['nome'];
        $usuario = $usuariooo['usuario'];
        $voto = $usuariooo['modelo'];

        if ($voto == "A Favor") {
            $cor = "green";
            $color = "success";
            $txt = "A Favor";
        } elseif ($voto == "Contra") {
            $cor = "red";
            $color = "danger";
            $txt = "Contra";
        } else {
            $cor = "gray";
            $color = "secondary";
            $txt = "Abster";
        }

        // Pega foto
        $query2 = $DBcon->query("SELECT * FROM usuarios WHERE nome='".$nome."'");    
        $contagem2 = $query2->num_rows;
        if ($contagem2 >= 0) {
            while ($usuario2 = $query2->fetch_array()) {
                $foto = $usuario2['foto'];
                $sigla = $usuario2['sigla'];
                if ($foto == "") {
                    $foto = "default-avatar.png";
                }
            }
        }
        // Fim foto

        $nome = utf8_decode($nome);
        echo '<div class="col-4"><div class="alert alert-'.$color.'" role="alert" style="background-color:'.$cor.';">
        <img src="fotos/'.$foto.'" class="rounded float-left" alt="Vereador(a)" width="90" height="70">
          <strong><p class="card-title" style="color:black;"> &nbsp;<strong>'.$nome.'</strong> <br><a href="#" class="badge badge-light"><img class="rounded float-left" src="partidos/'.$sigla.'.png" alt="'.$sigla.'" width="50" height="20"></a></p></strong>
        </div></div>';
    }
}

// Quem não votou
$queryfinal = $DBcon->query("SELECT * FROM usuarios");    
$contagemfinal = $queryfinal->num_rows;
if ($contagemfinal >= 0) {
    while ($usuariofinal = $queryfinal->fetch_array()) {
        $nomef = $usuariofinal['nome'];
        $usuariof = $usuariofinal['usuario'];
        $fotof = $usuariofinal['foto'];
        $siglaf = $usuariofinal['sigla'];
        if ($fotof == "") {
            $fotof = "default-avatar.png";
        }

        $queryy = $DBcon->query("SELECT * FROM votos WHERE nome='".$nomef."' AND enqueteid='".$eid."'");    
        $contagemm = $queryy->num_rows;
        if ($contagemm == 0) {
            $nomef = utf8_decode($nomef);
            if ($nomef != ".") {
                echo '<div class="col-4"><div class="alert alert-light" role="alert" >
                <img src="fotos/'.$fotof.'" class="rounded float-left" alt="Vereador(a)" width="90" height="70">
                  <strong><p class="card-title" style="color:black;"> &nbsp;<strong>'.$nomef.'</strong><br> <a href="#" class="badge badge-light"><img class="rounded float-left" src="partidos/'.$siglaf.'.png" alt="'.$siglaf.'" width="50" height="20"></a></p></strong>
                </div></div>';
            }
        }
    }
}

echo '</div>';
$DBcon->close();
?>
