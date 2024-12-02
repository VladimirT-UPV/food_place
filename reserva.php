<?php
require 'conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Datos del restaurante
    $NameR = $conexion->real_escape_string($_POST["NameR"]);
    $CityR = $conexion->real_escape_string($_POST["CityR"]);
    $StateR = $conexion->real_escape_string($_POST["StateR"]);
    $CountryR = $conexion->real_escape_string($_POST["CountryR"]);
    $PhoneR = $conexion->real_escape_string($_POST["PhoneR"]);
    $CostR = $conexion->real_escape_string($_POST["CostR"]);

    // Datos de la reserva
    $Name_reserve = $conexion->real_escape_string($_POST["name"]);
    $Lastname_reserve = $conexion->real_escape_string($_POST["lastname"]);
    $Phone_reserve = $conexion->real_escape_string($_POST["phone"]);
    $Email_reserve = $conexion->real_escape_string($_POST["email"]);
    $Note_reserve = $conexion->real_escape_string($_POST["note"]);
    $DateR = $conexion->real_escape_string($_POST["DateR"]);
    $TimeR = $conexion->real_escape_string($_POST["TimeR"]);
    $User = $conexion->real_escape_string($_POST["Username"]);

    // Verificar si ya existe una reserva para esa fecha, hora y usuario
    $checkQuery = "SELECT * FROM reserva WHERE date_reserve = '$DateR' AND time_reserve = '$TimeR' AND user_name = '$User'";
    $result = $conexion->query($checkQuery);

    if ($result->num_rows > 0) {
        // Si ya existe una reserva, definir alerta de error
        $_SESSION['alertType'] = "error";
        $_SESSION['alertMessage'] = "You already have a reservation for this date and time.";
    } else {
        // Insertar nueva reserva
        $sql = "INSERT INTO reserva (
                    user_name, name_reserve, lastname_reserve, phone_reserve, email_reserve, 
                    note_reserve, name_restaurant, date_reserve, time_reserve, cost_restaurant, 
                    city_restaurant, state_restaurant, country_restaurant, phone_restaurant
                ) VALUES (
                    '$User', '$Name_reserve', '$Lastname_reserve', '$Phone_reserve', '$Email_reserve',
                    '$Note_reserve', '$NameR', '$DateR', '$TimeR', '$CostR',
                    '$CityR', '$StateR', '$CountryR', '$PhoneR'
                )";

        if ($conexion->query($sql) === TRUE) {
            // Si la reserva se realiza correctamente, definir alerta de éxito
            $_SESSION['alertType'] = "success";
            $_SESSION['alertMessage'] = "Reservation successfully made!";
        } else {
            // Si ocurre un error en la inserción, definir alerta de error
            $_SESSION['alertType'] = "error";
            $_SESSION['alertMessage'] = "Error making the reservation: " . $conexion->error;
        }
    }

    // Redirigir al usuario de vuelta a la página principal o de formulario
    header("Location: home.php");
    exit();
}

$conexion->close();
?>
