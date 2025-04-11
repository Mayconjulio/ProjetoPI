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
 
    /**
    Abaixo esta o estilo de dashboard - a estilização do botão e o tamanho do dashboard também esta sendo afetado por essa estilização!
    */
  
  #dashboard {
    display: none;
    width: fit-content;
    margin: 30px auto;
    padding: 20px;
    background-color: #f5f5f5;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);
  }

  .graficos-container {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    gap: 50px;
    flex-wrap: wrap;
  }

  .grafico {
    text-align: center;
  }

  .grafico canvas {
    max-width: 100%;
    height: auto;
  }

  .grafico-legenda {
    font-weight: bold;
    color: #333;
    margin-top: 10px;
  }
  .btnn {
    display: block;
    margin: 20px auto;
    padding: 10px 20px;
    background-color: #001dd8;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s ease;
  }

  .btnn:hover {
    background-color: #3b44f5;
  }

  @media (max-width: 768px) {
    .graficos-container {
      flex-direction: column;
      gap: 20px;
    }
  }
</style>


</head>
<body>

<nav>
  <span>Bem-vindo, <?php echo htmlspecialchars($nome); ?>!</span>
  <div>
    <a href="adicionar_gasto.php">Novo Registro Financeiro</a>
    <a href="pasta Dos HTML/paginaprincipal.html">Menu Principal</a>
    <a href="logout.php">Sair</a>
  </div>
</nav>

<div class="table-container">
  <h3>Seus Histórico Financeiro</h3>
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
    <a class="btn btn-edit" href="editar_gasto.php?id=<?php echo $row['id']; ?>">Editar</a>
    <a class="btn btn-delete" href="ver_gastos.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este gasto?');">Excluir</a>
  </td>
</tr>
<?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Você ainda não adicionou nenhum gasto.</p>
  <?php endif; ?>
</div>

  <!-- DA QUE PARA BAIXO ESTÃO OS CÓDIGOS DO DASHBOARD-->
  <button class="btnn" onclick="mostrarDashboard()">📊 Mostrar Dashboard de Gastos</button>

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
