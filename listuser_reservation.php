<?php
 
 require 'conexion.php';
 session_start();

//Colocar cuando quede lo de sesion 
 if (!isset($_SESSION['user'])) {
   $_SESSION['error_message'] = "Inicia sesion."; 
    header("Location: form.php"); 
    exit(); // Termina la ejecución del script.
 }

 $User = $_SESSION['user'];

 $checkQuery = "SELECT * FROM reserva WHERE user_name='$User'";
 $result = $conexion->query($checkQuery);
 
 if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p> Restaurant: " . $row["name_restaurant"]."</p>";
        echo "<p> Date & Hour: " . $row["date_reserve"]. $row["time_reserve"]."</p>";
        echo "<p> Price: " . $row["cost_restaurant"]."</p>";
        echo "<p> Location: " . $row["city_restaurant"]. $row["state_restaurant"]. $row["country_restaurant"]."</p>";
        echo "<p> Restaurant Phone: " . $row["phone_restaurant"]."</p>";
        echo "<p> Extra Note: " . $row["note_reserve"]."</p>";
        echo"<p></p>";
    }
 } else {
    echo "<p>There are no reservations</p>";
 }

 //}

 $conexion->close();

?>