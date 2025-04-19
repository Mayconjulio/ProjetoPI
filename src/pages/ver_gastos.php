<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['usuario_id'];
$nome = $_SESSION['usuario_nome'];

// Conexão PDO (corrigida - antes de usar $pdo)
try {
    $pdo = new PDO("mysql:host=localhost;dbname=sistema_login", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com PDO: " . $e->getMessage());
}

// Dados para gráficos e cálculo realizado/previsto
$dados = $pdo->query("SELECT data_gasto, preco, categoria FROM gastos WHERE user_id = $user_id")->fetchAll(PDO::FETCH_ASSOC);

$realizadoPorMes = [];
foreach ($dados as $linha) {
    $mes = date('m', strtotime($linha['data_gasto']));
    $realizadoPorMes[$mes] = ($realizadoPorMes[$mes] ?? 0) + $linha['preco'];
}

$valoresPrevistos = array_fill_keys(['01','02','03','04','05','06','07','08','09','10','11','12'], 1000);

$difMeses = [];
for ($i = 1; $i <= 12; $i++) {
    $mes = str_pad($i, 2, '0', STR_PAD_LEFT);
    $real = $realizadoPorMes[$mes] ?? 0;
    $prev = $valoresPrevistos[$mes];
    $difMeses[] = $real - $prev;
}

$labelsMeses = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];

$dadosLucrosMensais = $pdo->query("
    SELECT DATE_FORMAT(data_gasto, '%Y-%m') as mes, SUM(preco) as total 
    FROM gastos 
    WHERE user_id = $user_id AND tipo = 'lucro'
    GROUP BY mes
")->fetchAll(PDO::FETCH_KEY_PAIR);

$dadosDividasMensais = $pdo->query("
    SELECT DATE_FORMAT(data_gasto, '%Y-%m') as mes, SUM(preco) as total 
    FROM gastos 
    WHERE user_id = $user_id AND tipo = 'divida'
    GROUP BY mes
")->fetchAll(PDO::FETCH_KEY_PAIR);

// Preenche meses vazios com zero
foreach ($labelsMeses as $index => $mes) {
    $mesAtual = date('Y') . '-' . str_pad($index + 1, 2, '0', STR_PAD_LEFT);
    $dadosLucrosMensais[$mesAtual] = $dadosLucrosMensais[$mesAtual] ?? 0;
    $dadosDividasMensais[$mesAtual] = $dadosDividasMensais[$mesAtual] ?? 0;
}

// Ordena por mês
ksort($dadosLucrosMensais);
ksort($dadosDividasMensais);

// Conversão para JavaScript
$lucros = array_values($dadosLucrosMensais);
$dividas = array_values($dadosDividasMensais);

// Exportar Excel
if (isset($_POST['exportar_excel'])) {
    $stmt = $pdo->prepare("SELECT * FROM gastos WHERE user_id = ? ORDER BY data_gasto DESC, preco DESC");
    $stmt->execute([$user_id]);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=gastos.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    echo "<table border='1'>";
    echo "<tr><th>ID user</th><th>Nome do Produto</th><th>Data</th><th>Preço (R$)</th><th>Categoria</th><th>Tipo</th><th>Descrição</th></tr>";
    foreach ($produtos as $produto) {
        echo "<tr>";
        echo "<td>{$produto['user_id']}</td>";
        echo "<td>" . htmlspecialchars($produto['Produto']) . "</td>";
        echo "<td>" . date('d/m/Y', strtotime($produto['data_gasto'])) . "</td>";
        echo "<td>{$produto['preco']}</td>";
        echo "<td>{$produto['categoria']}</td>";
        echo "<td>{$produto['tipo']}</td>";
        echo "<td>{$produto['descricao']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    exit();
}

// Conexão mysqli (para outras queries)
$conn = new mysqli("localhost", "root", "", "sistema_login");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

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

$sql = "SELECT * FROM gastos WHERE user_id = ? ORDER BY data_gasto DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$Produto = [];
while ($row = $result->fetch_assoc()) {
    $Produto[] = $row;
}

// Dados para gráficos
$porData = [];
$porMes = [];
$porCategoria = [];

foreach ($dados as $linha) {
    $data = date('d/m', strtotime($linha['data_gasto']));
    $mes = date('Y-m', strtotime($linha['data_gasto']));
    $cat = $linha['categoria'];
    $preco = (float)$linha['preco'];

    $porData[$data] = ($porData[$data] ?? 0) + $preco;
    $porMes[$mes]['gasto'] = ($porMes[$mes]['gasto'] ?? 0) + ($preco < 0 ? $preco : 0);
    $porMes[$mes]['lucro'] = ($porMes[$mes]['lucro'] ?? 0) + ($preco > 0 ? $preco : 0);
    $porCategoria[$cat] = ($porCategoria[$cat] ?? 0) + $preco;
}

$despesa = $pdo->query("SELECT SUM(preco) as total FROM gastos WHERE user_id = $user_id AND tipo = 'divida'")->fetch()['total'] ?? 0;
$lucroTotal = $pdo->query("SELECT SUM(preco) as total FROM gastos WHERE user_id = $user_id AND tipo = 'lucro'")->fetch()['total'] ?? 0;
$lucroLiquido = $lucroTotal - $despesa;
$margem = $lucroTotal > 0 ? number_format(($lucroLiquido / $lucroTotal) * 100, 1) : 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Histórico Financeiro</title>
  <link rel="stylesheet" href="../styles/pasta Dos CSS/ver_gastos.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
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

<form method="post">
  <button type="submit" name="exportar_excel">Exportar para Excel</button>
</form>

<div class="table-container">
  <h3>Seu Histórico Financeiro</h3>
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
          <th>Tipo</th>
          <th>Descrição</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($Produto as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['Produto']) ?></td>
            <td><?= date('d/m/Y', strtotime($row['data_gasto'])) ?></td>
            <td>R$ <?= number_format($row['preco'], 2, ',', '.') ?></td>
            <td><?= htmlspecialchars($row['categoria']) ?></td>
            <td><?= htmlspecialchars($row['tipo']) ?></td>
            <td><?= htmlspecialchars($row['descricao']) ?></td>
            <td>
              <a href="editar_gasto.php?id=<?= $row['id'] ?>">Editar</a>
              <a href="ver_gastos.php?delete_id=<?= $row['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este gasto?');">Excluir</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Você ainda não adicionou nenhum gasto.</p>
  <?php endif; ?>
</div>

<button class="btnn" onclick="mostrarDashboard()">📊 Mostrar Dashboard de Gastos</button>

<div id="dashboard" style="display: none;">
  <div class="cards">
    <div class="card">Total Despesas <h2>R$ <?= number_format($despesa, 2, ',', '.') ?></h2></div>
    <div class="card">Total Lucros <h2>R$ <?= number_format($lucroTotal, 2, ',', '.') ?></h2></div>
    <div class="card">Lucro Líquido <h2>R$ <?= number_format($lucroLiquido, 2, ',', '.') ?></h2></div>
    <div class="card destaque">
      <p>% Margem Lucro Líquido</p>
      <h1><?= $margem ?>%</h1>
      <span>Objetivo: 12,0%</span>
    </div>
  </div>

  <h2 style="text-align: center;">Gráficos Financeiros</h2>
  <div class="linha-e-coluna">
    <div class="grafico">
      <h4>Lucros e Despesas Mensais</h4>
      <canvas id="graficoColuna1" width="600" height="300"></canvas>
    </div>

    <div class="grafico">
      <h4>Gastos por Dia</h4>
      <canvas id="graficoColuna"></canvas>
    </div>
  </div>
 
    <div class="grafico" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
      <h4>Distribuição por Categoria (Pizza)</h4>
      <canvas id="graficoCategoria" width="300" height="300"></canvas>
  </div>

  
  </div>
</div>

<script>
const datas = <?= json_encode(array_map(fn($r) => $r['Produto'] . ' (' . date('d/m/Y', strtotime($r['data_gasto'])) . ')', $Produto)) ?>;
const valores = <?= json_encode(array_map(fn($r) => $r['preco'], $Produto)) ?>;

const labelsLinha = <?= json_encode(array_keys($porMes)) ?>;
const dadosGastos = <?= json_encode(array_map(fn($m) => $m['gasto'], $porMes)) ?>;
const dadosLucros = <?= json_encode(array_map(fn($m) => $m['lucro'], $porMes)) ?>;

const categorias = <?= json_encode(array_keys($porCategoria)) ?>;
const valoresCategoria = <?= json_encode(array_values($porCategoria)) ?>;

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
      

// Gráfico Realizado - Previsto
const ctxMensais = document.getElementById('graficoColuna1').getContext('2d');
new Chart(ctxMensais, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labelsMeses) ?>,
        datasets: [
            {
                label: 'Lucros',
                data: <?= json_encode($lucros) ?>,
                backgroundColor: '#4caf50', // Verde para lucros
                borderWidth: 1
            },
            {
                label: 'Dívidas',
                data: <?= json_encode($dividas) ?>,
                backgroundColor: '#f44336', // Vermelho para dívidas
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'R$ ' + value;
                    }
                }
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'Lucros e Dívidas Mensais'
            }
        }
    }
});


      new Chart(document.getElementById('graficoColuna'), {
        type: 'bar',
        data: {
          labels: datas,
          datasets: [{
            label: 'Gastos por Data',
            backgroundColor: '#33ff33',
            data: valores
          }]
        }
      });

      new Chart(document.getElementById('graficoCategoria'), {
        type: 'pie',
    data: {
        labels: categorias,
        datasets: [{
            label: 'Por Categoria',
            backgroundColor: ['#4e79a7', '#f28e2b', '#e15759', '#76b7b2', '#59a14f', '#edc949',
                '#af7aa1', '#ff9da7', '#9c755f', '#bab0ab'],
            data: valoresCategoria
        }]
    },
    options: {
        responsive: false, // Desabilita ajuste automático do tamanho
        maintainAspectRatio: false // Permite manipular dimensões personalizadas
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
