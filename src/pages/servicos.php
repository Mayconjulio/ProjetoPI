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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ouvidoria</title>
  <link rel="stylesheet" href="../styles/pasta Dos CSS/servicos.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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
  <main>

    <form id="formEmail" action="enviar_mensagem.php" method="post">
      <div class="DadosPrincipais">
        <label for="nome">Nome completo</label><br>
        <input type="text" id="nome" name="nome" required value="<?php echo htmlspecialchars($usuario['nome']); ?>"><br>
    
        <label for="email">Email</label><br>
        <input type="text" id="email" name="email" required value="<?php echo htmlspecialchars($usuario['email']); ?>"><br>
    
        <label for="tel">Telefone</label><br>
        <input type="text" id="tel" name="telefone" required value="<?php echo htmlspecialchars($usuario['telefone']); ?>"><br>
      </div>
    
      <div class="Mensagem">
        <label for="message">Envie sua mensagem</label><br>
        <textarea name="mensagem" required></textarea>
    
        <div class="Social-links">
          <a href="#"><i class="bi bi-youtube"></i></a>
          <a href="#"><i class="bi bi-instagram"></i></a>
          <a href="#"><i class="bi bi-tiktok"></i></a>
        </div>
      </div>
    </form>
    
  
    <div class="botao">
      <button id="enviar" type="submit">Enviar</button>
    </div>

  </main>

  <script src="https://cdn.emailjs.com/dist/email.min.js"></script>
  <script src="../JS/From.js"></script>  
</body>
</html>
