<?php
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

// Excluir gasto
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM gastos WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $delete_id, $user_id);
    if ($stmt->execute()) {
        header("Location: ver_gastos.php?success=Gasto excluído com sucesso.");
    } else {
        header("Location: ver_gastos.php?error=Erro ao excluir gasto.");
    }
    exit();
}

// Buscar gastos do usuário
$sql = "SELECT * FROM gastos WHERE user_id = ? ORDER BY data_gasto DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ver Gastos</title>
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
          margin-bottom: 20px;
          box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
      }

      nav span {
          margin-bottom: 10px;
          display: block;
          font-weight: bold;
          font-size: 1.2em;
      }

      nav a {
          color: white;
          text-decoration: none;
          display: inline-block;
          margin: 0 15px;
          padding: 5px 10px;
          border-radius: 5px;
          background-color: #0056b3;
          transition: background-color 0.3s;
          font-weight: bolder;
      }

      nav a:hover {
          background-color: #003f8a;
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
    <a href="adicionar_gasto.php">Adicionar Gastos</a>
    <a href="pasta Dos HTML/paginaprincipal.html">Menu Principal</a>
    <a href="logout.php">Sair</a>
  </div>
</nav>

<div class="table-container">
  <h3>Seus Gastos</h3>
  <?php if (isset($_GET['success'])) echo "<p style='color: green;'>".htmlspecialchars($_GET['success'])."</p>"; ?>
  <?php if (isset($_GET['error'])) echo "<p style='color: red;'>".htmlspecialchars($_GET['error'])."</p>"; ?>
  <?php if ($result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>Gasto</th>
          <th>Data</th>
          <th>Preço</th>
          <th>Categoria</th>
          <th>Descrição</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['gasto']); ?></td>
            <td><?php echo htmlspecialchars($row['data_gasto']); ?></td>
            <td>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
            <td><?php echo htmlspecialchars($row['categoria']); ?></td>
            <td><?php echo htmlspecialchars($row['descricao']); ?></td>
            <td>
              <a class="btn btn-edit" href="editar_gasto.php?id=<?php echo $row['id']; ?>">Editar</a>
              <a class="btn btn-delete" href="ver_gastos.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este gasto?');">Excluir</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Você ainda não adicionou nenhum gasto.</p>
  <?php endif; ?>
</div>

</body>
</html>
