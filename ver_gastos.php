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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  
  <!-- Estilos inline com emojis -->
  <style>
      body {
          font-family: "Arial", sans-serif;
          background-color: #f4f4f9;
          color: #333;
          margin: 0;
          padding: 20px;
          display: flex;
          flex-direction: column;
          align-items: center;
      }
      nav{
        text-align: center;
      }

      h1 {
          color: #2c3e50;
          margin-bottom: 20px;
          font-size: 24px;
      }
      h2,
      h3{
        text-align: center;
      }

      #categoria{
        width: 525px;
        
      }

      form {
          background-color: #ffffff;
          border-radius: 12px;
          box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
          padding: 30px;
          max-width: 500px;
          width: 100%;
      }

      label {
          display: block;
          margin-bottom: 10px;
          font-weight: bold;
      }

      input[type="text"],
      input[type="number"],
      input[type="date"],
      select,
      textarea {
          width: 100%;
          padding: 10px;
          margin: 8px 0 20px;
          border: 2px solid #ddd;
          border-radius: 6px;
          font-size: 1em;
          background-color: #f9f9f9;
      }

      input[type="text"]:focus,
      input[type="date"]:focus,
      input[type="number"]:focus,
      select:focus,
      textarea:focus {
          border-color: #2980b9;
          outline: none;
          background-color: #eef4fb;
      }

      input[type="submit"] {
          width: 100%;
          background-color: #4caf50;
          color: white;
          border: none;
          padding: 12px;
          font-size: 1.1em;
          cursor: pointer;
          border-radius: 6px;
          transition: background-color 0.3s ease;
      }

      input[type="submit"]:hover {
          background-color: #45a049;
      }

      /* Adicionando emojis aos labels */
      label[for="gasto"]::before {
          content: "💵 ";
      }
      label[for="data_gasto"]::before {
          content: "📅 ";
      }
      label[for="preco"]::before {
          content: "💲 ";
      }
      label[for="categoria"]::before {
          content: "📂 ";
      }
      label[for="descricao"]::before {
          content: "📝 ";
      }

      input[type="submit"]::before {
          content: "🚀 ";
      }

      a {
          text-decoration: none;
          color: #003366;
          font-weight: bold;
          transition: color 0.3s ease, background-color 0.3s ease;
      }

      a:hover {
          color: #0056b3;
          background-color: #f0f8ff;
          padding: 2px 4px;
          border-radius: 4px;
      }
  </style>
</head>
<body>

<nav>
  <span>Bem-vindo, <?php echo htmlspecialchars($nome); ?>!</span>
  <br>
  <a href="pasta Dos HTML/paginaprincipal.html">voltar ao Menu Principal</a>
  <br>
  <a href="logout.php">Sair da conta</a>
</nav>

<div class="container">
  <h2>Dashboard</h2>
  <?php
  if (isset($_GET['success'])) {
      echo "<div class='success'>" . htmlspecialchars($_GET['success']) . "</div>";
  }
  if (isset($_GET['error'])) {
      echo "<div class='error'>" . htmlspecialchars($_GET['error']) . "</div>";
  }
  ?>

  <h3>💼 Bem-vindo ao Gerenciador de Gastos</h3>
  <form action="adicionar_gasto.php" method="post">
    <label for="gasto">Gasto:</label>
    <input type="number" step="0.01" name="gasto" id="gasto" required>

    <label for="data_gasto">Data do Gasto:</label>
    <input type="date" name="data_gasto" id="data_gasto" required>

    <label for="preco">Preço:</label>
    <input type="number" step="0.01" name="preco" id="preco" required>

    <label for="categoria">Categoria:</label>
    <select name="categoria" id="categoria" required>
      <option value="">Selecione</option>
      <option value="Alimentação">Alimentação</option>
      <option value="Transporte">Transporte</option>
      <option value="Lazer">Lazer</option>
      <option value="Saúde">Saúde</option>
      <option value="Educação">Educação</option>
      <option value="Outros">Outros</option>
    </select>

    <label for="descricao">Descrição:</label>
    <textarea name="descricao" id="descricao" rows="3" placeholder="Descrição do gasto"></textarea>

    <input type="submit" value="Adicionar Gasto e ver-los">
  </form>
</div>

</body>
</html>
