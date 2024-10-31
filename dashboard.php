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
  <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 20px;
}
nav {
    background: #007bff;
    text-align: center;
    color: white;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px; /* Espaço entre a nav e o conteúdo abaixo */
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

nav span {
    margin-bottom: 10px; /* Espaço entre o nome do usuário e os links */
    display: block; /* Faz com que o nome do usuário fique em linha separada */
    font-weight: bold;
    font-size: 1.2em;
}

nav a {
    color: white;
    text-decoration: none;
    display: inline-block;
    margin: 0 15px; /* Espaço horizontal entre os links */
    padding: 5px 10px; /* Padding para deixar o link mais "clicável" */
    border-radius: 5px;
    background-color: #0056b3; /* Fundo dos links */
    transition: background-color 0.3s;
    font-weight: bolder;
}

nav a:hover {
    background-color: #003f8a; /* Cor do fundo ao passar o mouse */
    color: #4caf50;
}
h3 {
  text-align: center;
    color: #333;
}

.table-container {
    margin-top: 20px;
    background: white;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #4caf50;
    color: white;
}

tr:hover {
    background-color: #f1f1f1;
}

p {
    color: #888;
}

  </style>
</head>
<body>

<nav>
  <span>Bem-vindo, <?php echo htmlspecialchars($nome); ?>!</span>
  <div>
  <a href="ver_gastos.php">Registrar Novos Gastos</a>
  <a href="pasta%20Dos%20HTML/paginaprincipal.html">Voltar ao Menu Principal</a>
  <a href="logout.php">Sair</a>
  </div>
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
                  <th>🛒 Gasto</th>
                  <th>📅 Data</th>
                  <th>💰 Preço</th>
                  <th>📊 Categoria</th>
                  <th>📝 Descrição</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['gasto']) . "</td>
                    <td>" . htmlspecialchars($row['data_gasto']) . "</td>
                    <td>R$ " . number_format($row['preco'], 2, ',', '.') . "</td>
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

</body>
</html>
