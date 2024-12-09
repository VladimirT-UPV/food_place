<?php

require("conexion.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conexion->real_escape_string($_POST["username"]);
    $email = $conexion->real_escape_string($_POST["email"]);
    $pass = $conexion->real_escape_string($_POST["password"]); 
    $conf = $conexion->real_escape_string($_POST["confirm_password"]); 
    $rol = $conexion->real_escape_string($_POST["rol"]);

    $verificarUsuario = $conexion->query("SELECT * FROM registro WHERE email='$email' OR user='$name'");

    if ($verificarUsuario->num_rows > 0) {
        $_SESSION['error_message'] = "The user is already registered."; 

    } else {
        if($pass == $conf){

            $sql = "INSERT INTO registro (user, email, pass, confpassword, rol) 
            VALUES ('$name', '$email', '$pass', '$conf', '$rol')";

            if ($conexion->query($sql) === TRUE){
                $_SESSION['success_message'] = '<script> alert ("Register success")</script>'; 
                $_SESSION['user'] = $name;

            } else {
                $_SESSION['error_message'] = '<script> alert ("Failed in the register")</script>';
            }
            header("Location: form.php"); 
            exit();
        } else{
            $_SESSION['error_message'] = '<script> alert ("The passwords are not the same")</script>';
        }
    }
}

$conexion->close();
?>