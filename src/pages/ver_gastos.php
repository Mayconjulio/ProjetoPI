<?php

/**
 * a que abaixo esta o código que faz com que baixe todos os dados salvos na tabela gastos
 * para o formato excel.
 */
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['exportar_excel'])) {
  $pdo = new PDO("mysql:host=localhost;dbname=sistema_login", "root", "");
  
  $user_id = $_SESSION['usuario_id'];
  $stmt = $pdo->prepare("SELECT * FROM gastos WHERE user_id = ? ORDER BY data_gasto DESC, preco DESC");
  $stmt->execute([$user_id]);
  $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);


    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=gastos.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    echo "<table border='1'>";
    echo "<tr><th>ID user</th><th>Nome do Produto</th><th>Data</th><th>Preço (R$)</th><th>Categoria</th><th>descricao</th></tr>";

    foreach ($produtos as $produto) {
        echo "<tr>";
        echo "<td>{$produto['user_id']}</td>";
        echo "<td>" . htmlspecialchars($produto['Produto']) . "</td>";
        echo "<td>{$produto['data_gasto']}</td>";
        echo "<td>{$produto['preco']}</td>";
        echo "<td>{$produto['categoria']}</td>";
        echo "<td>{$produto['descricao']}</td>";
        echo "</tr>";
    }

    echo "</table>";
    exit(); // IMPORTANTE: impede que o restante da página seja processado
}
?>

<?php


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

$Produto = []; // <- Novo array
while ($row = $result->fetch_assoc()) {
    $Produto[] = $row;
}

    
// Buscar dados para o dashboard (gastos por data)
$dados_sql = "SELECT data_gasto, SUM(preco) AS total_gasto FROM gastos WHERE user_id = ? GROUP BY data_gasto ORDER BY data_gasto ASC";
$dados_stmt = $conn->prepare($dados_sql);
$dados_stmt->bind_param("i", $user_id);
$dados_stmt->execute();
$dados_result = $dados_stmt->get_result();
$gastos;
$datas = [];
$valores = [];

foreach ($Produto as $row) {
    $label = $row['Produto'] . ' (' . date('d/m/Y', strtotime($row['data_gasto'])) . ')';
    $datas[] = $label;
    $valores[] = $row['preco'];
}



// Dados para o gráfico de pizza (categoria e soma dos preços)
$sqlPizza = "SELECT categoria, SUM(preco) AS total FROM gastos WHERE user_id = ? GROUP BY categoria";
$stmtPizza = $conn->prepare($sqlPizza);
$stmtPizza->bind_param("i", $user_id);
$stmtPizza->execute();
$resultPizza = $stmtPizza->get_result();

$categorias = [];
$valoresCategoria = [];

while ($row = $resultPizza->fetch_assoc()) {
    $categorias[] = $row['categoria'];
    $valoresCategoria[] = $row['total'];
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Histórico Financeiro</title>
  <link rel="stylesheet" href="../styles/pasta Dos CSS/ver_gastos.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


</head>
<body>

<!-- Cabeçalho -->
    <header>
        <div class="container">
            <img src="../src/assets/Imagens do Site/Padrão vertical - ByAvanced (1).png" alt="logo do sistema" class="logo">
        
            <nav class="nav-links">
                <ul>
                    <li><a href="adicionar_gasto.php">Novo Registro Financeiro</a></li>
                    <li><a href="pasta Dos HTML/paginaprincipal.php">Menu Principal</a></li>
                    <li><a href="logout.php">Sair</a></li>
                </ul>
            </nav>

            <div class="login">
            <a href="logout.php">Sair da conta</a>
            </div>
        </div>
    </header>

    <span class="bem-vindo">Bem-vindo, <?php echo htmlspecialchars($nome); ?>!</span>

  
<div class="table-container">
  
  <?php if (isset($_GET['success'])) echo "<p style='color: green;'>".htmlspecialchars($_GET['success'])."</p>"; ?>
  <?php if (isset($_GET['error'])) echo "<p style='color: red;'>".htmlspecialchars($_GET['error'])."</p>"; ?>
  <?php if ($result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>Nome do Produto</th>
          <th>Data</th>
          <th>Preço</th>
          <th>Categoria</th>
          <th>Descrição</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($Produto as $row): ?>
<tr>
  <td><?php echo htmlspecialchars($row['Produto']); ?></td>
  <td><?php echo htmlspecialchars($row['data_gasto']); ?></td>
  <td>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
  <td><?php echo htmlspecialchars($row['categoria']); ?></td>
  <td><?php echo htmlspecialchars($row['descricao']); ?></td>
  <td>
  <a class="botao-editar" href="editar_gasto.php?id=<?php echo $row['id']; ?>">
    <i class="bi bi-pencil-fill"></i> Editar
  </a>
  <a class="botao-excluir" href="ver_gastos.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este gasto?');">
    <i class="bi bi-trash-fill"></i> Excluir
  </a>
</td>

</tr>
<?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Você ainda não adicionou nenhum gasto.</p>
  <?php endif; ?>
</div>

<!-- Área de botões -->
<div class="botoes-dashboard">
  <!-- Botão Exportar Excel -->
  <form method="post">
    <button type="submit" name="exportar_excel" class="btn-dashboard">
      <i class="bi bi-file-earmark-excel-fill"></i> Exportar para Excel
    </button>
  </form>

  <!-- Botão Mostrar Dashboard -->
  <button class="btn-dashboard" onclick="mostrarDashboard()">
    <i class="bi bi-graph-up-arrow"></i> Mostrar Dashboard de Gastos
  </button>
</div>

<div id="dashboard">
  <h3 style="text-align: center;">Gastos por Data e por Categoria</h3>
  <div class="graficos-container">
    <div class="grafico grafico-barras">
      <canvas id="graficoGastos" width="300" height="300"></canvas>
      <p class="grafico-legenda">📅 Gastos por Data</p>
    </div>
    <div class="grafico grafico-pizza">
      <canvas id="graficoPizza" width="300" height="300"></canvas>
      <p class="grafico-legenda">📊 Gastos por Categoria</p>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const datas = <?php echo json_encode($datas); ?>;
  const valores = <?php echo json_encode($valores); ?>;

  const categorias = <?php echo json_encode($categorias); ?>;
  const valoresCategoria = <?php echo json_encode($valoresCategoria); ?>;

  let chartCriado = false;
  let dashboardVisivel = false;

  function mostrarDashboard() {
    const dash = document.getElementById('dashboard');

    if (dashboardVisivel) {
      dash.style.display = 'none';
      dashboardVisivel = false;
    } else {
      dash.style.display = 'block';
      if (!chartCriado) {
        // Gráfico de barras
        const ctx = document.getElementById('graficoGastos').getContext('2d');
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: datas,
            datasets: [{
              label: 'Gastos (R$)',
              data: valores,
              backgroundColor: 'rgba(0, 25, 216, 0.8)',
              borderColor: 'rgba(192, 57, 43, 1)',
              borderWidth: 1,
              borderRadius: 8,
              hoverBackgroundColor: 'rgba(231, 76, 60, 1)'
            }]
          },
          options: {
            responsive: true,
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  callback: function(value) {
                    return 'R$ ' + value.toFixed(2).replace('.', ',');
                  }
                }
              }
            }
          }
        });

        // Gráfico de pizza
        const ctxPizza = document.getElementById('graficoPizza').getContext('2d');
        new Chart(ctxPizza, {
          type: 'pie',
          data: {
            labels: categorias,
            datasets: [{
              label: 'Gasto por Categoria',
              data: valoresCategoria,
              backgroundColor: [
                '#2ecc71', '#3498db', '#f1c40f', '#e67e22', '#9b59b6', '#e74c3c'
              ],
              borderColor: '#fff',
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'bottom',
                labels: {
                  color: '#2c3e50',
                  font: { weight: 'bold' }
                }
              }
            }
          }
        });

        chartCriado = true;
      }
      dashboardVisivel = true;
    }
  }
</script>


</body>
</html>
