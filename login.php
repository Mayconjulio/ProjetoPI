<?php
session_start();

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
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Buscar o usuário pelo e-mail
    $sql = "SELECT * FROM usuarios WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        
        // Verificar se a senha está correta
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario'] = $usuario['nome'];
            echo "Login bem-sucedido! Bem-vindo, " . $_SESSION['usuario'];
            header('Location:  pasta Dos HTML/paginaprincipal.html');
        } else {
            echo "<div class='error'>Senha incorreta.</div>";
            header('Location:  pasta Dos HTML/login.html');
        }
    } else {
        echo "<div class='error'>E-mail não encontrado.</div>";
        header('Location:  pasta Dos HTML/login.html');
    }
    
}

$conn->close();
?>
