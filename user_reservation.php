<?php
require 'conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos comunes
    $NameR = $conexion->real_escape_string($_POST["NameR"]);  
    $CityR = $conexion->real_escape_string($_POST["CityR"]);
    $StateR = $conexion->real_escape_string($_POST["StateR"]);
    $CountryR = $conexion->real_escape_string($_POST["CountryR"]);  
    $PhoneR = $conexion->real_escape_string($_POST["PhoneR"]);
    $CostR = $conexion->real_escape_string($_POST["CostR"]);

    $Name_reserve = $conexion->real_escape_string($_POST["name"]);  
    $Lastname_reserve = $conexion->real_escape_string($_POST["lastname"]);
    $Phone_reserve = $conexion->real_escape_string($_POST["phone"]);
    $Email_reserve = $conexion->real_escape_string($_POST["email"]);  
    $Note_reserve = $conexion->real_escape_string($_POST["note"]);
    $DateR = $conexion->real_escape_string($_POST["DateR"]);
    $TimeR = $conexion->real_escape_string($_POST["TimeR"]);
    $User = $conexion->real_escape_string($_POST["Username"]);
    $action = $_POST["action"]; // Verificar si es reserva normal o con factura

    // Verificar si ya existe una reserva para esa fecha
    $checkQuery = "SELECT * FROM reserva WHERE date_reserve = '$DateR' AND time_reserve = '$TimeR' AND user_name ='$User'";
    $result = $conexion->query($checkQuery);

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = "Ya tienes una reservación con esa fecha y hora";
        header("Location: user_home.php"); 
        exit();
    } else {
        // Insertar reserva en la base de datos
        $sql = "INSERT INTO reserva (user_name, name_reserve, lastname_reserve, phone_reserve, email_reserve, note_reserve, name_restaurant, date_reserve, time_reserve, cost_restaurant, city_restaurant, state_restaurant, country_restaurant, phone_restaurant)
                VALUES ('$User', '$Name_reserve', '$Lastname_reserve', '$Phone_reserve', '$Email_reserve', '$Note_reserve', '$NameR', '$DateR', '$TimeR', '$CostR', '$CityR', '$StateR', '$CountryR', '$PhoneR')";

        if ($conexion->query($sql) === TRUE) {
            // Recuperar el ID de la reserva recién creada
            $reservationId = $conexion->insert_id;
            if ($action === "invoice") {
                $_SESSION['reservation_id'] = $reservationId; // Guardar el ID de la reserva en la sesión
                include ('correoinvoice.php');
                header("Location: user_home.php"); // Redirigir para mandar correo con factura
                exit();
            }else {
                $_SESSION['reservation_id'] = $reservationId; // Guardar el ID de la reserva en la sesión
                include ('correo.php');
                header("Location: user_home.php"); // Redirigir para mandar correo solamente
                exit();
            }
            exit();
        } else {
            $_SESSION['error_message'] = "Error haciendo la reservación: " . $conexion->error;
            header("Location: user_home.php");
            exit();
        }
    }
}

$conexion->close();
?>

