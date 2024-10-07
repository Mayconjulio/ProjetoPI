<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bancodedados";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}


$gastos = $_POST['gastos'];
$categoria = $_POST['categoria'];
$descricao = $_POST['descricao'];
$datas = $_POST['data'];


$sql = "INSERT INTO gastos (valor, categoria, descricao, data_gasto) VALUES ('$gastos', '$categoria', '$descricao', '$datas')";

if ($conn->query($sql) === TRUE) {
    header('Location: pasta Dos HTML/paginaprincipal.html');
    exit();
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
