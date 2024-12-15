<?php 
date_default_timezone_set('America/Sao_Paulo');
include_once 'Dbconnect.php';
$output = '';
$eid = $_POST['eid'];

$queryy = $DBcon->query("SELECT * FROM enquetes WHERE id='".$eid."' AND votando='1'");    
$contagemm = $queryy->num_rows;
if ($contagemm == 0) // Atual não está sendo votada
{
    $qtitulo = $DBcon->query("SELECT * FROM enquetes WHERE votando=1");
    if ($qqtitulo = $qtitulo->fetch_array())
    {
        $tituloVotacao = $qqtitulo['id'];
        echo "
            <script>  
                Cookies.set('votacao', ".$tituloVotacao.");
            </script>";
    }
}

$DBcon->close();
?>
