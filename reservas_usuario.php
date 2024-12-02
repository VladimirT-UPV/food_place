<?php
 
 require 'conexion.php';
 session_start();

//Colocar cuando quede lo de sesion 
//if (!isset($_SESSION['sesion'])) {
   // header("Location: index.php"); 
    //exit(); // Termina la ejecución del script.
//}

 //Colocar hasta que exista boton de ver reservas en la parte de usuario
 //if ($_SERVER["REQUEST_METHOD"] == "POST") {
 //recuperar el nombre de usuario
 $User = "prueba";


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