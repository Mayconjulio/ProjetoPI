<?php

// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_login";

// cadastro.php
// Iniciar sessão
session_start();

// Conectar ao banco de dados
$conn = new mysqli("localhost", "root", "", "sistema_login");

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter e sanitizar os dados
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Validar e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: cadastrar.php?error=E-mail inválido.");
        exit();
    }

    // Verificar se o e-mail já está cadastrado usando prepared statements
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // E-mail já cadastrado
        header("Location: cadastrar.php?error=Este e-mail já está cadastrado.");
        $stmt->close();
        $conn->close();
        exit();
    }
    $stmt->close();

    // Criptografar a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir o novo usuário usando prepared statements
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha_hash);

    if ($stmt->execute()) {
        header("Location: cadastrar.php?success=Usuário cadastrado com sucesso! Faça o login.");
    } else {
        header("Location: cadastrar.php?error=Erro ao cadastrar usuário.");
    }

    $stmt->close();
}

$conn->close();
?>

