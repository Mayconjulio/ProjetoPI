<?php

// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_login";


$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografando a senha

    // Verifica se o email já está cadastrado
    $sql = "SELECT * FROM usuarios WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='error'>Este e-mail já está cadastrado.</div>";
    } else {
        // Inserir usuário
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        if ($conn->query($sql) === TRUE) {
            echo "Usuário cadastrado com sucesso!";
            header('Location: pasta Dos HTML/login.html');
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LM R. Finanças</title>
    <link rel="stylesheet" href="../src/styles/pasta Dos CSS/Paginicial.css">
    
</head>
<body>

    <!-- Cabeçalho -->
    <header>
    <div class="container">
        <img src="#" alt="logo do sistema" class="logo">
        
        <nav class="nav-links">
            <ul>
                <li><a href="../src/pages/pasta Dos HTML/sobre.html">Sobre</a></li>
                <li><a href="../src/pages/pasta Dos HTML/servicos.html">Serviços</a></li>
                <li><a href="../src/pages/pasta Dos HTML/sComocadastra.html">Como Se Registrar</a></li>
            </ul>
        </nav>

        <div class="login">
            <a href="../src/pages/loginN.php"><button class="btn">Entra/Login</button></a>
        </div>
    </div>
</header>

    <!-- Comteudo do futuro da sua liberdade.... -->
    <div class="hero-section">
        <h1>
            O Futuro da sua<br>
            Liberdade <span class="highlight">Financeira</span>
        </h1>

        <p>
            Organize suas finanças com
            <strong>inteligência e<br>eficiência</strong>
        </p>

        <div class="cta-buttonn">
            <a href="#">ASSINE JÁ</a>
        </div>
    </div>

    <!-- agora vem a imagem deacordo com o pdf -->
    <!-- Imagem centralizada abaixo do conteúdo -->
  <div class="dashboard-image">
    <img src="../src/assets/Imagens do Site/Captura de tela 2025-04-14 092901.png" alt="Dashboard Financeiro" />
  </div>

    <div class="Paragrafo">
        <p> Ferramentas exclusivas <br>
            que vão te <span>ajudar na sua Jornada</span>
        </p>
    </div>

    <!-- IA. SISTEMA FINANCEIRO E DASHBOARD - AUCTUS -->

    <section class="info-section">

  <div class="info-container">

    <!-- Bloco 1: IA Assistente -->
    <div class="info-box">
      <div class="image-box">
        <img src="img/ia-placeholder.png" alt="IA Assistente">
      </div>
      <div class="text-box">
        <h2>IA. Assistente Financeira</h2>
        <p>
          Sempre ativa e pronta para te atender oferecendo respostas em 
          <strong>tempo real</strong> com 
          <strong>agilidade, precisão</strong> e total compromisso com a sua necessidade.
        </p>
        <p>
          Conte com a gente para <strong>esclarecer dúvidas</strong>, resolver problemas e garantir uma 
          <strong>experiência cada vez mais eficiente</strong>.
        </p>
      </div>
    </div>

    <!-- Bloco 2: Dashboard -->
    <div class="info-box reverse">
        <div class="image-box">
            <img src="img/grafico-placeholder.png" alt="Dashboard Gráfico">
        </div>
        
        <div class="text-box">
            <h2>Dashboard - Auctus</h2>
            <p>
                Uma ferramenta <strong>estratégica</strong> que oferece uma 
                <strong>visão clara e em tempo real</strong> dos principais indicadores.
                Decisões mais rápidas, acompanha o <strong>desempenho</strong> e identifica 
                <strong>oportunidades com agilidade</strong>.
            </p>
            <a href="#" class="cta-button">ASSINE JÁ</a>
        </div>
        
    </div>

  </div>

</section>

    <!-- Conteúdo principal da página -->
    <main>
        <div class="box">
            <h2>Bem-vindo!</h2>
            <p>Faça login para acessar suas Finanças</p>
            <a href="../src/pages/loginN.php"><button class="btn">Login</button></a>
        </div>
    </main>

    <!-- Rodapé -->
    <footer>
        <div class="container">
            <div class="social-icons">
                <a href="https://www.whatsapp.com" target="_blank" class="whatsapp"><i class="fab fa-whatsapp"></i></a>
                <a href="https://www.facebook.com" target="_blank" class="facebook"><i class="fab fa-facebook-f"></i></a>

                <!-- Instagram com animação ao passar o mouse -->
                <div class="instagram-container">
                    <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
                    <div class="dropdown">
                        <a href="https://www.instagram.com/mayconjulio74/" target="_blank">DEV1</a>
                        <a href="https://www.instagram.com/luisfernandofilhodedeus/" target="_blank">DEV2</a>
                    </div>
                </div>
            </div>
            <p>&copy; 2024 Nome do Site. Todos os direitos reservados.</p>
        </div>
    </footer>

</body>
</html>
