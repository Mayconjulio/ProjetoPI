<?php
// Definir constantes para as informações de conexão
define('DB_HOST', 'localhost');
define('DB_USER', 'starfl19_ferr');
define('DB_PASS', 'EqxdkFBZhb4');
define('DB_NAME', 'starfl19_ferr');

// Constante para a timezone
define('TIMEZONE', 'America/Sao_Paulo');

// Conexão com o banco de dados usando a função mysqli
$DBcon = new MySQLi(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Definir a timezone padrão
date_default_timezone_set(TIMEZONE);

// Verificar se a conexão foi estabelecida com sucesso
if ($DBcon->connect_errno) {
    die("ERRO: " . $DBcon->connect_error);
}
?>
