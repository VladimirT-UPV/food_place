<?php
require 'conexion.php';
session_start();

// Parámetros de paginación
$records_per_page = 10; // Número de registros por página
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual

// Calcular el inicio de los registros para la página actual
$start = ($page - 1) * $records_per_page;

// Consultar el total de registros
$total_records_query = "SELECT COUNT(*) AS total FROM reserva";
$total_records_result = $conexion->query($total_records_query);
$total_records = $total_records_result->fetch_assoc()['total'];

// Calcular el número total de páginas
$total_pages = ceil($total_records / $records_per_page);

// Consultar los registros para la página actual
$checkQuery = "SELECT * FROM reserva LIMIT $start, $records_per_page";
$result = $conexion->query($checkQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reservations List</title>
   <link rel="stylesheet" href="css/styles.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
   <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
</head>

<body>
   <header>
      <div class="header-container">
         <button class="menu-btn" onclick="toggleMenu()">
            <img src="assets/Logo.png" alt="Food Place Logo">
         </button>

         <button class="btn-restaurants" type="button">
            <a href="home_admin.php">
               <i class="fa-solid fa-shop"></i>&nbsp; &nbsp;RESTAURANTS
            </a>
         </button>
      </div>
   </header>
   <main>
      <div class="container2">
         <?php
         if ($result->num_rows > 0) {
            echo '<table>';
            echo '<thead>
                        <tr>
                            <th>ID</th>
                            <th>Reservation Details</th>
                        </tr>
                    </thead>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
               echo "<tr>";
               echo "<td>" . $row["id"] . "</td>";
               echo "<td>";
               echo "<p><strong>User:</strong> " . $row["user_name"] . "</p>";
               echo "<p><strong>Full Name:</strong> " . $row["name_reserve"] . " " . $row["lastname_reserve"] . "</p>";
               echo "<p><strong>Phone:</strong> " . $row["phone_reserve"] . "</p>";
               echo "<p><strong>Email:</strong> " . $row["email_reserve"] . "</p>";
               echo "<p><strong>Note:</strong> " . $row["note_reserve"] . "</p>";
               echo "<p><strong>Restaurant:</strong> " . $row["name_restaurant"] . "</p>";
               echo "<p><strong>Date & Hour:</strong> " . $row["date_reserve"] . " / " . $row["time_reserve"] . "</p>";
               echo "<p><strong>Price:</strong> $" . $row["cost_restaurant"] . "</p>";
               echo "<p><strong>Location:</strong> " . $row["city_restaurant"] . " " . $row["state_restaurant"] . " " . $row["country_restaurant"] . "</p>";
               echo "<p><strong>Restaurant Phone:</strong> " . $row["phone_restaurant"] . "</p>";
               echo "</td>";
               echo "</tr>";
            }
            echo '</tbody>';
            echo '</table>';
         } else {
            echo "<p>There are no reservations</p>";
         }
         ?>

         <!-- Paginación -->
         <div class='pagination'>
            <?php
            // Botón de "Anterior"
            if ($page > 1) {
               echo "<a href='?page=" . ($page - 1) . "' class='prev'>« Previous</a>";
            } else {
               echo "<span class='prev disabled'>« Previous</span>";
            }

            // Mostrar la página actual
            echo "<span class='current-page'>Page $page of $total_pages</span>";

            // Botón de "Siguiente"
            if ($page < $total_pages) {
               echo "<a href='?page=" . ($page + 1) . "' class='next'>Next »</a>";
            } else {
               echo "<span class='next disabled'>Next »</span>";
            }
            ?>
         </div>
      </div>

      <button id="scrollTopBtn" title="Go to top" onclick="scrollToTop()">
         <i class="fa-solid fa-arrow-up-long"></i>
      </button>
   </main>

   <footer class="pie-pagina">
      <div class="grupo-2">
         <small>&copy; 2024 <b>- Centro de Investigación ITI 4-1</b> - All Rights Reserved.</small>
      </div>
   </footer>
   <script>
        const scrollTopBtn = document.getElementById('scrollTopBtn');

        window.onscroll = function () {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                scrollTopBtn.style.display = 'block';
            } else {
                scrollTopBtn.style.display = 'none';
            }
        };

        function scrollToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</body>

</html>
