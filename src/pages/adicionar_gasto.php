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

// Adicionar gasto ao banco de dados (se o formulário foi enviado)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Produto = $_POST['Produto'];
    $data_gasto = $_POST['data_gasto'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];
    $tipo = $_POST['tipo'];
    $descricao = $_POST['descricao'];

    // Validação de tipo
    if (!in_array($tipo, ['lucro', 'divida'])) {
        header("Location: adicionar_gasto.php?error=Tipo inválido.");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO gastos (user_id, Produto, data_gasto, preco, categoria, tipo, descricao) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issdsss", $user_id, $Produto, $data_gasto, $preco, $categoria, $tipo, $descricao);

    if ($stmt->execute()) {
        header("Location: adicionar_gasto.php?success=Gasto adicionado com sucesso!");
    } else {
        header("Location: adicionar_gasto.php?error=Erro ao adicionar o gasto.");
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Novo Registro Financeiro</title>
  <link rel="stylesheet" href="../styles/pasta Dos CSS/adicionar_gasto.css">
</head>
<body>

<!-- Cabeçalho -->
<header>
    <div class="container">
        <img src="../src/assets/Imagens do Site/Padrão vertical - ByAvanced (1).png" alt="logo do sistema" class="logo">

        <nav class="nav-links">
            <ul>
                <li><a href="ver_gastos.php">Histórico Financeiro</a></li>
                <li><a href="pasta Dos HTML/paginaprincipal.php">Menu Principal</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>

        <div class="login">
            <a href="logout.php"><button class="btn">Sair da conta</button></a>
        </div>
    </div>
</header>

<span class="bem-vindo"><?php echo htmlspecialchars($nome); ?>, Este campo é destinado ao registro de suas informações.</span>

<div class="form-page">
  <div class="form-wrapper">
    <form action="adicionar_gasto.php" method="post">

      <?php
      if (isset($_GET['success'])) {
          echo "<p class='mensagem sucesso'>" . htmlspecialchars($_GET['success']) . "</p>";
      }
      if (isset($_GET['error'])) {
          echo "<p class='mensagem erro'>" . htmlspecialchars($_GET['error']) . "</p>";
      }
      ?>

      <label for="gasto">Nome do Produto:</label>
      <input type="text" step="0.01" name="Produto" id="Produto" required>

      <label for="data_gasto">Data do Gasto:</label>
      <input type="date" name="data_gasto" id="data_gasto" required>

      <label for="preco">Preço do Produto:</label>
      <input type="number" step="0.01" name="preco" id="preco" required>

      <label for="categoria">Categoria:</label>
      <select name="categoria" id="categoria" required>
        <option value=""></option>
        <option value="Alimentação">Alimentação</option>
        <option value="Transporte">Transporte</option>
        <option value="Lazer">Lazer</option>
        <option value="Saúde">Saúde</option>
        <option value="Educação">Educação</option>
        <option value="Outros">Outros</option>
      </select>

      <label for="tipo">Tipo:</label>
      <select name="tipo" id="tipo" required>
        <option value=""></option>
        <option value="lucro">Lucro</option>
        <option value="divida">Dívida</option>
      </select>

      <label for="descricao">Descrição:</label>
      <textarea name="descricao" id="descricao" rows="3" placeholder="Descrição do gasto"></textarea>

      <input type="submit" value="Adicionar">
    </form>
    <p id="p">Preste atenção na hora<br>de organizar seus<br>gastos!</p>
  </div>
</div>

</body>
</html>
