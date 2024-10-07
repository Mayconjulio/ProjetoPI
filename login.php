<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars($_POST['nome']);
    $senha = htmlspecialchars($_POST['senha']);
    echo "Olá, " . $nome . "! <br>";
    echo "Sua senha é". $senha;
    


}
?>