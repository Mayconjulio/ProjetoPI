<?php
//servidor, usuário, senha e nome do banco de dados
  $DBhost = "localhost";
  $DBuser = "root";
  $DBpass = "";
  $DBname = "starfl19_camocim";
  
  $DBcon = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
    date_default_timezone_set('America/Sao_Paulo');
     if ($DBcon->connect_errno) 
     {
         die("ERRO: ".$DBcon->connect_error);
     }