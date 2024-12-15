<?php
$servername = "localhost";
$username = " root@localhost";
$password = "";
$dbname = "meu_banco_de_dados";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
echo "Conexão bem-sucedida";
?>
