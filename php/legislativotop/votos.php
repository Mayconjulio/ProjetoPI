<?php 
include_once 'Dbconnect.php';
date_default_timezone_set('America/Sao_Paulo');

$output = '';
$eid = $_POST['eid'];
$usr = $_POST['usr'];
$usrname = $_POST['usrname']; 

$res2 = $DBcon->query("SELECT * FROM camconfig WHERE id=1");
$userRow2 = $res2->fetch_array();
$nomecam = $userRow2['nome'];
$cormenu = $userRow2['cormenu'];
$corexibidor = $userRow2['corexibidor'];
$cortxtexibidor = $userRow2['cortxtexibidor'];
$corgeral = $userRow2['corgeral'];
$discurso = $userRow2['discurso'];
$aparte = $userRow2['aparte'];
$qordem = $userRow2['qordem'];
$cfinal = $userRow2['cfinal'];

$queryp = $DBcon->query("SELECT * FROM presencas WHERE vereador='".$usr."' AND idvotacao=".$eid."");
$countp = $queryp->num_rows;

$temPresenca = $countp;
$qtitulo321 = $DBcon->query("SELECT * FROM camconfig LIMIT 1");
if ($qqtitulo321 = $qtitulo321->fetch_array()) {
    $temPresenca = $qqtitulo321['tempresenca'] ?? null;
    $countp = $temPresenca;
}

echo '<div class="container" id="resvotos" name="resvotos">';
// Pega título e descrição
$query = $DBcon->query("SELECT titulo,descricao FROM enquetes WHERE id='".$eid."'");
if ($userRow = $query->fetch_array()) {
    $titulo = $userRow['titulo'];
    $desc = $userRow['descricao'];

    echo '<div class="container" name="fdiscurso" id="fdiscurso"></div><br></center>';

    if ($usrname == "Presidente") {
        // Gerar lista de pedidos - nenhum pedido = mostrar que não há interessados em discurso
        echo '<script>
            setInterval(function() { 
                // APARECER OS PEDIDOS DE DISCURSO - APROVAR OU NEGAR - MOSTRAR EM ORDEM
                $( document ).ready(function() {
                    var eid ='.$eid.';
                    //alert(eid);
                    $.ajax({  
                        url:"querdiscurso.php",
                        type: "POST",
                        data: {eid:eid},  
                        dataType: "text",  
                        success: function(data) {  
                            if(data != "") {  
                                $("#fdiscurso").replaceWith(data); 
                            } else {  
                     
                            }  
                        }  
                    });  
                }); 
            }, 4000);
        </script>';
        // Gerar botão
    } else {
        // Gerar botão
    }
 
    if ($temPresenca >= 0) {
        echo '<div class="container">
        <div class="row justify-content-md-center">
        <form role="form" action="" autocomplete="off" method="POST">
        <button type="submit" class="btn btn-primary" name="novodiscurso">Pedir Discurso('.$discurso.'min)</button>
        <button type="submit" class="btn btn-secondary" name="novaordem">Pedir Questão de Ordem('.$qordem.'min)</button>
        <button type="submit" class="btn btn-warning" name="novocontra">Pedir aparte('.$aparte.'min)</button>
        <button type="submit" class="btn btn-info" name="novaconsideracao">Pedir Considerações Finais('.$cfinal.'min)</button>
        <input value="'.$eid.'" name="eidval" id="eidval" hidden>
        </form>
        </div></div><br>';     
    } 

    echo '<div class="container" id="resvotos" name="resvotos">';
    if ($usrname == "Telao") {
        echo '<center><a class="btn btn-info btn-lg" href="exibidor" role="button"><strong>EXIBIDOR</strong></a></center>';
    }
} else {
    echo '<div class="container" name="fdiscurso" id="fdiscurso"></div>';
    
    if ($usrname == "Presidente") {
        // Gerar lista de pedidos - nenhum pedido = mostrar que não há interessados em discurso
        echo '<script>
        setInterval(function() { 
            // APARECER OS PEDIDOS DE DISCURSO - APROVAR OU NEGAR - MOSTRAR EM ORDEM
            $( document ).ready(function(){
                var eid ='.$eid.';
                //alert(eid);
                $.ajax({  
                    url:"querdiscurso.php",
                    type: "POST",
                    data:{eid:eid},  
                    dataType:"text",  
                    success:function(data) {  
                        if(data != "") {  
                            $("#fdiscurso").replaceWith(data); 
                        } else {  
                   
                        }  
                    }  
                });  
            }); 
        }, 4000);
        </script>';
    }

    echo '<div class="container">
        <div class="row justify-content-md-center">
        <form role="form" action="" autocomplete="off" method="POST">
        <button type="submit" class="btn btn-primary" name="novodiscurso">Pedir Discurso('.$discurso.'min)</button>
        <button type="submit" class="btn btn-secondary" name="novaordem">Pedir Questão de Ordem('.$qordem.'min)</button>
        <button type="submit" class="btn btn-warning" name="novocontra">Pedir aparte('.$aparte.'min)</button>
        <button type="submit" class="btn btn-info" name="novaconsideracao">Pedir Considerações Finais('.$cfinal.'min)</button>
        <input value="'.$eid.'" name="eidval" id="eidval" hidden>
        </form>
    </div></div><br>'; 

}

// Fim pega título e desc

// Início check botão voto
$queryy = $DBcon->query("SELECT * FROM votos WHERE usuario='".$usrname."'");    
$contagemm = $queryy->num_rows;
if ($contagemm > 0) {
    while ($usuario = $queryy->fetch_array()) {
        $nome = $usuario['nome'];
        $usuario = $usuario['usuario'];
    }
} else {
    echo "<strong><center>Você ainda não votou nesse projeto<br>Veja abaixo os vereadores que já votaram.</center></strong>";
}

// Fim check botão voto

// Início lista de quem votou
$query = $DBcon->query("SELECT * FROM votos WHERE enqueteid='".$eid."'");    
$contagem = $query->num_rows;
if ($contagem > 0) {
    while ($usuariooo = $query->fetch_array()) {
        $nome = $usuariooo['nome'];
        $usuario = $usuariooo['usuario'];
        $voto = $usuariooo['modelo'];

        if ($voto == "A Favor") {
            $color = "success";
            $txt = "A Favor";
        } elseif ($voto == "Contra") {
            $color = "danger";
            $txt = "Contra";
        } else {
            $color = "secondary";
            $txt = "Abster";
        }

        // Pega foto
        $query2 = $DBcon->query("SELECT * FROM usuarios WHERE nome='".$nome."'");    
        $contagem2 = $query2->num_rows;
        if ($contagem2 >= 0) {
            while ($usuario2 = $query2->fetch_array()) {
                $foto = $usuario2['foto'];
                if ($foto == "") {
                    $foto = "default-avatar.png";
                }
            }
        }
        // Fim foto

        echo '<div class="alert alert-'.$color.'">
            <center>
                <span><img src="fotos/'.$foto.'" width="50"/> 
                <br>
                <strong>'.utf8_decode($nome).'</strong><br>('.$txt.')</span>
            </center>
        </div>';
    }
} else { 
    echo '<div class="alert alert-danger">
            <span><center>Nenhum vereador participou na votação desse projeto.</center></span>
        </div>';
}
echo "</div>";
?>
