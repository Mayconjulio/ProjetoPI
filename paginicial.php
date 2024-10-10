<?php

// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_login";


$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografando a senha

    // Verifica se o email já está cadastrado
    $sql = "SELECT * FROM usuarios WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='error'>Este e-mail já está cadastrado.</div>";
    } else {
        // Inserir usuário
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        if ($conn->query($sql) === TRUE) {
            echo "Usuário cadastrado com sucesso!";
            header('Location:  pasta Dos HTML/login.html');
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolha: Login ou Cadastro</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(to right, #00c6ff, #0072ff);
        }
        .box {
            color: black;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            width: 30%;
            text-align: center;
        }
        h2 {
            color: #0072ff;
        }
        .btn {
            background-color: #0072ff;
            color: white;
            padding: 15px 30px;
            margin: 10px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            border-radius: 10px;
        }
        .btn:hover {
            background-color: rgb(0, 63, 122);
        }
    </style>
</head>
<body>
    <div class="box">
        <h2>Bem-vindo!</h2>
        <p>Escolha uma das opções abaixo:</p>
        <a href="pasta Dos HTML/login.html"><button class="btn">Login</button></a>
        <a href="pasta Dos HTML/cadastro.html"><button class="btn">Cadastro</button></a>
    </div>
</body>
</html>
