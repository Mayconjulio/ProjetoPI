<?php
include_once 'Dbconnect.php';
date_default_timezone_set('America/Sao_Paulo');
$output = '';
$disc1id = $_POST['disc1id'];

echo '<div class="container" name="fdiscurso" id="fdiscurso">';

//inicio aceita disc
$now = date("Y-m-d H:i:s");
$tenMinFromNow = date("Y-m-d H:i:s", strtotime('+4 minutes', strtotime($now)));

// Usar Prepared Statements para evitar injeção de SQL
$query = "UPDATE discurso SET status=1, inicio=?, fim=? WHERE id=?";

if ($stmt = $DBcon->prepare($query)) {
    $stmt->bind_param("ssi", $now, $tenMinFromNow, $disc1id);

    if ($stmt->execute()) {
        // Atualização bem-sucedida
        //header("Refresh:0");
    } else {
        // Tratar erros de consulta
        // Por exemplo, você pode exibir uma mensagem de erro ou fazer log do erro
    }

    $stmt->close();
} else {
    // Tratar erros de preparação da consulta
    // Por exemplo, você pode exibir uma mensagem de erro ou fazer log do erro
}

echo "</div>";
?>
