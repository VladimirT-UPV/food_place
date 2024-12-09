<?php

require("conexion.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name= $conexion->real_escape_string($_POST["username"]);
    $pass=$conexion->real_escape_string($_POST["password"]);

    $sql = "SELECT * FROM registro WHERE user= '$name' and pass = '$pass'";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        if($name == "Admin" && $pass=="Admin"){
            header("Location: admin_home.php"); //Redireccionar al inicio del sistema
        }else{
            $_SESSION['user'] = $name; 
            header("Location: user_home.php"); //Redireccionar al inicio del sistema
        } 
        exit();
    } else {
        $_SESSION['error_message'] = "User or password incorrect.";   
        header("Location: form.php"); 
        exit();
    }
}

$conexion->close();
?>