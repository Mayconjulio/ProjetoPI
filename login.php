<?php
// login.php
session_start();

// Conectar ao banco de dados
$conn = new mysqli("localhost", "root", "", "sistema_login");

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter e sanitizar os dados
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Buscar o usuário pelo e-mail usando prepared statements
    $stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verificar se o e-mail existe
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $nome, $senha_hash);
        $stmt->fetch();

        // Verificar a senha
        if (password_verify($senha, $senha_hash)) {
            // Senha correta, iniciar sessão
            $_SESSION['usuario_id'] = $id;
            $_SESSION['usuario_nome'] = $nome;
            header("Location: pasta Dos HTML/paginaprincipal.html");
            exit();
        } else {
            // Senha incorreta
            header("Location: login.php?error=Senha incorreta.");
            exit();
        }
    } else {
        // E-mail não encontrado
        header("Location: login.php?error=E-mail não encontrado.");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
