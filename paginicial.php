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
    <title>LM R. Finacias</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-image: linear-gradient(to right, #00c6ff, #0072ff);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            color: #333;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        /* Cabeçalho */
        header {
            background-color: #00509e;
            color: #fff;
            padding: 20px 0;
        }

        header h1 {
            margin: 0;
            font-size: 28px;
            letter-spacing: 1px;
        }

        header nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 20px;
        }

        header nav ul li {
            display: inline;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        header nav ul li a:hover {
            color: #e0e0e0;
        }

        /* Estilo da caixa central */
        .box {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            width: 30%;
            text-align: center;
            margin: 20px auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #00509e;
        }

        .btn {
            background-color: #0072ff;
            color: white;
            padding: 15px 30px;
            margin: 10px;
            font-size: 18px;
            border: none;
            cursor: pointer;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #00509e;
        }

        /* Estilo principal */
        main {
            flex: 1;
            padding: 20px 0;
        }

        /* Rodapé */
        footer {
            background-color: #00509e;
            color: #fff;
            padding: 20px 0;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        footer p {
            margin: 5px 0;
        }

        footer .social-icons {
            display: flex;
            align-items: center;
        }

        footer .social-icons a {
            margin: 0 10px;
            color: #fff;
            text-decoration: none;
            font-size: 24px;
            transition: color 0.3s ease;
        }

        footer .social-icons a:hover {
            color: #e0e0e0;
        }

        footer .whatsapp:hover {
            color: #25D366; /* Cor do WhatsApp */
        }

        footer .facebook:hover {
            color: #3b5998; /* Cor do Facebook */
        }

        /* Instagram com dropdown */
        .instagram-container {
            position: relative;
            display: inline-block;
        }

        .instagram-container .dropdown {
            display: none;
            position: absolute;
            left: 40px;
            top: -40px;
            background-color: #fff;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .instagram-container .dropdown a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 10px;
            font-weight: bolder;
            
        }

        .instagram-container .dropdown a:hover {
            color: #C13584; /* Cor do Instagram */
        }

        .instagram-container:hover .dropdown {
            display: block;
        }

        .instagram-container:hover a.instagram {
            color: #C13584; /* Cor do Instagram */
        }
    </style>
</head>
<body>

    <!-- Cabeçalho -->
    <header>
        <div class="container">
            <h1>LM R. Finacias</h1>
            <nav>
                <ul>
                    <li><a href="paginicial.php">Início</a></li>
                    <li><a href="pasta Dos HTML/sobre.html">Sobre</a></li>
                    <li><a href="pasta Dos HTML/servicos.html">Serviços</a></li>
                    <li><a href="pasta Dos HTML/sComocadastra.html">Como Se Registrar</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Conteúdo principal da página -->
    <main>
        <div class="box">
            <h2>Bem-vindo!</h2>
            <p>Faça login para acessar suas finacias</p>
            <a href="loginN.php"><button class="btn">Login</button></a>
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
