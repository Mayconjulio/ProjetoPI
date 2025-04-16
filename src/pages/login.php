// login.php
<?php
session_start();

// Conectar ao banco de dados
$conn = new mysqli("localhost", "root", "", "sistema_login");

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter e limpar os dados
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Pesquisar o usuário pelo e-mail usando instruções preparadas
    $stmt = $conn->prepare("SELECT id, nome, senha, admin FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verifica se o e-mail existe
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $nome, $senha_hash, $admin);
        $stmt->fetch();

        // Verifica a senha
        if (password_verify($senha, $senha_hash)) {
            // Senha correta, início da sessão
            $_SESSION['usuario_id'] = $id;
            $_SESSION['usuario_nome'] = $nome;

            // Verifica se é um administrador
            if ($id == 1) {
                header("Location: cadastrar.php"); // Página do administrador
            } else {
                header("Location: pasta Dos HTML/paginaprincipal.php"); // Página para usuários comuns
            }
            exit();
        } else {
            // Senha incorreta
            header("Location: loginN.php?error=Senha incorreta.");
            exit();
        }
    } else {
        // E-mail não encontrado
        header("Location: loginN.php?error=E-mail não encontrado.");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
