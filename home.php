<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
    <title>Food Place</title>
</head>

<body>
    <header>
        <div class="header-container">
            <button class="menu-btn" onclick="toggleMenu()">
                <img src="assets/Logo.png" alt="Food Place Logo">
            </button>
            <nav class="side-menu" id="sideMenu">
                <button class="close-btn" onclick="toggleMenu()"><i class="fa-regular fa-rectangle-xmark"></i></button>
                <ul>
                    <li><a href="#"><i class="fa-solid fa-chair">&nbsp; &nbsp;</i>Reservations</a></li>
                    <li><a href="#"><i class="fa-solid fa-arrow-right-from-bracket">&nbsp; &nbsp;</i>Sign out</a></li>
                </ul>
            </nav>

            <form class="search-form" id="search-form" onsubmit="event.preventDefault(); performSearch();">
                <input type="text" id="search-input" name="query"
                    placeholder="Search by name, city, state, country or score"
                    value="<?php echo isset($_GET['query']) ? htmlspecialchars($_GET['query']) : ''; ?>">
                <button type="button" id="searchButton" onclick="performSearch()"><i
                        class="fa-solid fa-magnifying-glass"></i></button>
                <button type="button" id="start-voice"><i class="fa-solid fa-microphone"></i></button>
            </form>
        </div>
    </header>

    <main>
        <div id="results">
            <?php include 'restaurants_login.php'; ?>
        </div>

        <button id="scrollTopBtn" title="Go to top" onclick="scrollToTop()">
            <i class="fa-solid fa-arrow-up-long"></i>
        </button>
    </main>

    <!-- Overlay de alerta para sin resultados -->
    <div class="alert-overlay" id="alertOverlay">
        <div class="alert-box">
            <h2>No results!</h2>
            <p>No restaurants found with your search.</p>
            <button onclick="closeAlert()">Close</button>
        </div>
    </div>

    <footer class="pie-pagina">
        <div class="grupo-2">
            <small>&copy; 2024 <b>- Centro de Investigación ITI 4-1</b> - All Rights Reserved.</small>
        </div>
    </footer>

    <script>
        let lastScrollTop = 0; // Variable para almacenar la última posición del scroll

        // Función que detecta la dirección del scroll
        window.addEventListener('scroll', function () {
            const sideMenu = document.getElementById('sideMenu');
            let currentScroll = window.pageYOffset || document.documentElement.scrollTop;

            // Si estamos bajando (scroll hacia abajo), ocultar el menú
            if (currentScroll > lastScrollTop) {
                sideMenu.classList.remove('open'); // Ocultar menú cuando bajamos
            }

            // Actualiza la última posición del scroll
            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // Evita que se convierta en un valor negativo
        });

        // Función para controlar el toggle del menú (se activa al hacer click en el logo)
        function toggleMenu() {
            const sideMenu = document.getElementById('sideMenu');
            sideMenu.classList.toggle('open');
        }

        // Inicializa el menú en estado cerrado (al cargar la página)
        document.addEventListener('DOMContentLoaded', function () {
            const sideMenu = document.getElementById('sideMenu');
            sideMenu.classList.remove('open'); // Asegura que el menú esté cerrado al inicio
        });
    </script>

    <script>
        const alertOverlay = document.getElementById('alertOverlay');
        const searchInput = document.getElementById('search-input');

        // Función para mostrar la alerta
        function showAlert() {
            alertOverlay.style.display = 'flex';
        }

        // Función para cerrar la alerta y redirigir a home.php
        function closeAlert() {
            alertOverlay.style.display = 'none';
            searchInput.value = ''; // Reiniciar el campo de búsqueda
            window.location.href = 'home.php'; // Redirigir al inicio


        }

        // Búsqueda por voz
        const startVoiceButton = document.getElementById('start-voice');

        function startVoiceSearch() {
            startVoiceButton.innerHTML = '<i class="fa-solid fa-ear-listen"></i>';
            const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.lang = 'en-US';
            recognition.start();

            recognition.onresult = function (event) {
                const transcript = event.results[0][0].transcript;
                searchInput.value = transcript;
                performSearch();
            };

            recognition.onerror = function () {
                startVoiceButton.innerHTML = '<i class="fa-solid fa-microphone"></i>';
            };

            recognition.onend = function () {
                startVoiceButton.innerHTML = '<i class="fa-solid fa-microphone"></i>';
            };
        }

        function performSearch() {
            const query = searchInput.value.trim();

            if (query.length > 0) {
                window.location.href = '?query=' + encodeURIComponent(query) + '&page=1';
            } else {
                window.location.href = 'home.php';
            }
        }

        // Asociar la búsqueda por voz
        startVoiceButton.onclick = startVoiceSearch;

        // Detectar "sin resultados" desde PHP
        const noResults = <?php echo $result->num_rows === 0 ? 'true' : 'false'; ?>;
        if (noResults) {
            searchInput.value = ''; // Limpiar el input si no hay resultados
            showAlert();
        }
    </script>

    <script>
        // Botón hacia arriba
        const scrollTopBtn = document.getElementById('scrollTopBtn');

        // Mostrar/ocultar el botón según el scroll
        window.onscroll = function () {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                scrollTopBtn.style.display = 'block';
            } else {
                scrollTopBtn.style.display = 'none';
            }
        };

        // Función para ir al inicio de la página
        function scrollToTop() {
            document.body.scrollTop = 0; // Para navegadores Safari
            document.documentElement.scrollTop = 0; // Para Chrome, Firefox, IE y Opera
        }
    </script>

</body>

</html>