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

// Buscar dados do usuário
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if (!$usuario) {
    die("Usuário não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ouvidoria</title>
  <link rel="stylesheet" href="../styles/pasta Dos CSS/servicosphp.css">
</head>
<body>

  <header>
    <div class="container">
      <img src="../../assets/Imagens do Site/Conteudo do site/Logo Branca.png" alt="logo do sistema" class="logo" />
      <nav class="nav-links">
        <ul>
          <li><a href="pasta Dos HTML/paginaprincipal.php" class="option">Início</a></li>
          <li><a href="ver_gastos.php" class="option">Histórico Financeiro</a></li>
          <li><a href="adicionar_gasto.php" class="option">Novo Registro Financeiro</a></li>
        </ul>
      </nav>
      <div class="login">
        <a href="logout.php" class="option">Sair da conta</a>
      </div>
    </div>
  </header>

  <div class="Titulo">
    <h1>Fale conosco!</h1>
  </div>

  <form action="enviar_mensagem.php" method="post">
    <div class="DadosPrincipais">
      <label for="nome">Nome completo</label><br>
      <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>"><br>

      <label for="email">Email</label><br>
      <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>"><br>

      <label for="tel">Telefone</label><br>
      <input type="text" id="tel" name="tel" value="<?php echo htmlspecialchars($usuario['telefone']); ?>"><br><br>
    </div>

    <div class="Mensagem">
      <label for="message">Envie sua mensagem</label><br>
      <textarea name="message" id="message" rows="5" cols="40"></textarea>
    </div>

    <button type="submit">Enviar</button>
  </form>

</body>
</html>
