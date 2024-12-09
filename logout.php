<?php

if (!isset($_SESSION['user'])) {
    $_SESSION['error_message'] = "Inicia sesion."; 
    header("Location: index.php"); 
    exit(); // Termina la ejecución del script.
}else{
    session_start();
    session_destroy();
    //$_SESSION['user'] = "sesion cerrada";
    header('Location: index.php');
}


?>