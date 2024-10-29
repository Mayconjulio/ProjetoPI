<?php
// dashboard.php
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

// Obter informações do usuário
$user_id = $_SESSION['usuario_id'];
$nome = $_SESSION['usuario_nome'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
    <link rel="stylesheet" href="pasta Dos CSS/pagina1.css">
</head>
<body>

<nav>
  <span>Bem-vindo, <?php echo htmlspecialchars($nome); ?>!</span>
  <a href="ver_gastos.php">registre novos gastos</a>
  <a href="logout.php">Sair</a>
</nav>
  <h3>Seus Gastos</h3>
  <div class="table-container">
    <?php
    // Buscar os gastos do usuário
    $stmt = $conn->prepare("SELECT id, gasto, data_gasto, preco, categoria, descricao FROM gastos WHERE user_id = ? ORDER BY data_gasto DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                  <th>Gasto</th>
                  <th>Data</th>
                  <th>Preço</th>
                  <th>Categoria</th>
                  <th>Descrição</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['gasto']) . "</td>
                    <td>" . htmlspecialchars($row['data_gasto']) . "</td>
                    <td>" . htmlspecialchars($row['preco']) . "</td>
                    <td>" . htmlspecialchars($row['categoria']) . "</td>
                    <td>" . htmlspecialchars($row['descricao']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhum gasto registrado.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
  </div>
</div>

</body>
</html>
