<?php
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$_SESSION = [];
header("Location: ./");

if (!isset($_SESSION['userSession'])) {
	header("Location: ./");
} else if (isset($_SESSION['userSession'])!="") {
	header("Location: index");
}

if(isset($_COOKIE['ccuserSession']))
{
    unset($_COOKIE['ccuserSession']);
    setcookie("ccuserSession", "",time()-3600);
} 

if(isset($_COOKIE['admuserSession']))
{
    unset($_COOKIE['admuserSession']);
    setcookie("admuserSession", "",time()-3600);
} 

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_COOKIE['admuserSession']);
	unset($_COOKIE['ccuserSession']);
	unset($_SESSION['userSession']);
	unset($_SESSION['admin']);
    unset($_SESSION['auditoria']);
	unset($_SESSION['povo']);
	header("Location: acesso");
}

?>