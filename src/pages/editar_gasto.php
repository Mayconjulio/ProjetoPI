


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

$user_id = $_SESSION['usuario_id'];
$gasto_id = $_GET['id'] ?? null; // Pegando o ID passado pela URL

// Validar se o ID foi fornecido
if (!$gasto_id) {
    header("Location: ver_gastos.php?error=ID do gasto não fornecido.");
    exit();
}

// Buscar dados do gasto
$stmt = $conn->prepare("SELECT * FROM gastos WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $gasto_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$gasto = $result->fetch_assoc();  // Aqui é onde a variável $gasto é definida

// Verificar se o gasto foi encontrado
if (!$gasto) {
    header("Location: ver_gastos.php?error=Gasto não encontrado.");
    exit();
}

// Agora a variável $gasto está definida, e podemos usá-la para preencher o formulário

// Atualizar gasto (processar formulário)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_gasto = $_POST['gasto'];
    $nova_data = $_POST['data_gasto'];
    $novo_preco = $_POST['preco'];
    $nova_categoria = $_POST['categoria'];
    $nova_descricao = $_POST['descricao'];

    // Atualizando os dados no banco
    $stmt = $conn->prepare("UPDATE gastos SET gasto = ?, data_gasto = ?, preco = ?, categoria = ?, descricao = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssdssii", $novo_gasto, $nova_data, $novo_preco, $nova_categoria, $nova_descricao, $gasto_id, $user_id);
    if ($stmt->execute()) {
        header("Location: ver_gastos.php?success=Gasto atualizado com sucesso.");
    } else {
        header("Location: editar_gasto.php?id=$gasto_id&error=Erro ao atualizar gasto.");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Gasto</title>
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
        color: #4caf50; }

      form { 
        background-color: white; 
        border-radius: 10px; 
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); 
        padding: 20px; 
        max-width: 500px; 
        margin: auto;
     }
      label { 
        display: block; 
        font-weight: bold;
        margin-bottom: 10px; 
    }
      input[type="text"], 
      input[type="number"], 
      input[type="date"], 
      select, 
      textarea {
         width: 100%; 
         padding: 10px; 
         margin-bottom: 20px; 
         border: 1px solid #ddd; 
         border-radius: 5px;
         }
         
      input[type="submit"] { 
        background-color: #4caf50; 
        color: white; 
        border: none;
        padding: 10px 15px;
         cursor: pointer; 
         border-radius: 5px; 
         transition: background-color 0.3s; 
         width: 100%; }

      input[type="submit"]:hover { 
        background-color: #45a049;
     }
  </style>
</head>
<body>

<nav>
  <span>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</span>
  <div>
    <a href="ver_gastos.php">Ver Gastos</a>
    <a href="pasta Dos HTML/paginaprincipal.html">Menu Principal</a>
    <a href="logout.php">Sair</a>
  </div>
</nav>

<h3 style="text-align: center;">Editar Gasto</h3>

<form action="editar_gasto.php?id=<?php echo $gasto_id; ?>" method="post">
    <label for="gasto">Gasto:</label>
    <input type="number" step="0.01" name="gasto" id="gasto" value="<?php echo htmlspecialchars($gasto['gasto']); ?>" required>

    <label for="data_gasto">Data do Gasto:</label>
    <input type="date" name="data_gasto" id="data_gasto" value="<?php echo htmlspecialchars($gasto['data_gasto']); ?>" required>

    <label for="preco">Preço:</label>
    <input type="number" step="0.01" name="preco" id="preco" value="<?php echo htmlspecialchars($gasto['preco']); ?>" required>

    <label for="categoria">Categoria:</label>
    <select name="categoria" id="categoria" required>
        <option value="Alimentação" <?php echo $gasto['categoria'] === 'Alimentação' ? 'selected' : ''; ?>>Alimentação</option>
        <option value="Transporte" <?php echo $gasto['categoria'] === 'Transporte' ? 'selected' : ''; ?>>Transporte</option>
        <option value="Lazer" <?php echo $gasto['categoria'] === 'Lazer' ? 'selected' : ''; ?>>Lazer</option>
        <option value="Saúde" <?php echo $gasto['categoria'] === 'Saúde' ? 'selected' : ''; ?>>Saúde</option>
        <option value="Educação" <?php echo $gasto['categoria'] === 'Educação' ? 'selected' : ''; ?>>Educação</option>
        <option value="Outros" <?php echo $gasto['categoria'] === 'Outros' ? 'selected' : ''; ?>>Outros</option>
    </select>

    <label for="descricao">Descrição:</label>
    <textarea name="descricao" id="descricao" rows="3"><?php echo htmlspecialchars($gasto['descricao']); ?></textarea>

    <input type="submit" value="Atualizar Gasto">
</form>

</body>



