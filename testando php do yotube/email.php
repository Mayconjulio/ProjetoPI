<?php 

if(isset($_POST["email"]) && !empty($_POST["email"]))
{
$nome = addslashes($_POST["name"]);
$email = addslashes($_POST["email"]);
$mensagem = addslashes($_POST["message"]);

$to = "luis35624141@gmail.com";
$subject = "Contato - Programador-br";
$body = "Nome: ".$nome."/n"."Email: ".$email."/n"."Mensagem".$mensagem;
$header = "From:igor36547892145@gmail.com"."/r/n/"."Reply=To:".$email."/r/n"."X=Mailer:PHP/".phpversion();

if(mail($to,$subject,$body,$header)){
    echo"Email enviago com sucesso!";
}else{
    echo"O Email não pode ser enviado";
}



}
?>