<?php
// logout.php
session_start();
session_unset();
session_destroy();
header("Location: loginN.php?success=Você saiu com sucesso.");
exit();
?>
