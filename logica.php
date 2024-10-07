<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero = $_POST['numero'];
    if ($numero == 2) {
        
        header("Location: pasta Dos HTML/pagina2.html");
        exit(); 
    }
    if ($numero == 1) {
        
        header("Location: pagina1.php");
        exit(); 
    }
    if($numero == 3) {
        header( "Location: pasta Dos HTML/login.html" );
        exit();
    }
    else{
        echo("Digite os numeros correspondente sugeridos ao usuário");
    }
     
    
    


}
?>