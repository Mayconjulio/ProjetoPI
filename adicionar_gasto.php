<?php
// adicionar_gasto.php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php?error=Por favor, faça o login primeiro.");
    exit();
}

// Conectar ao banco de dados
$conn = new mysqli("localhost", "root", "", "sistema_login");

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter e sanitizar os dados
    $user_id = $_SESSION['usuario_id'];
    $gasto = trim($_POST['gasto']);
    $data_gasto = trim($_POST['data_gasto']);
    $preco = trim($_POST['preco']);
    $categoria = trim($_POST['categoria']);
    $descricao = trim($_POST['descricao']);

    // Validações básicas
    if (empty($gasto) || empty($data_gasto) || empty($preco) || empty($categoria)) {
        header("Location: dashboard.php?error=Por favor, preencha todos os campos obrigatórios.");
        exit();
    }

    // Inserir o gasto usando prepared statements
    $stmt = $conn->prepare("INSERT INTO gastos (user_id, gasto, data_gasto, preco, categoria, descricao) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isdiss", $user_id, $gasto, $data_gasto, $preco, $categoria, $descricao);

    if ($stmt->execute()) {
        header("Location: dashboard.php?success=Gasto adicionado com sucesso.");
    } else {
        header("Location: dashboard.php?error=Erro ao adicionar gasto.");
    }

    $stmt->close();
}

$conn->close();
?>
