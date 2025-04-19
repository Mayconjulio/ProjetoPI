<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_login";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$tipo = $_POST['tipo'];
$gastos = $_POST['gastos'];
$categoria = $_POST['categoria'];
$descricao = $_POST['descricao'];
$datas = $_POST['data'];


$sql = "INSERT INTO gastos (valor, tipo, categoria, descricao, data_gasto) VALUES ('$gastos', '$tipo', '$categoria', '$descricao', '$datas')";

if ($conn->query($sql) === TRUE) {
    header('Location: pasta Dos HTML/paginaprincipal.html');
    exit();
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
