<?php
include('conexion.php');

// Consultar usuarios
$sqlUsuarios = "SELECT * FROM registro WHERE rol = 'usuario'";
$resultUsuarios = $conexion->query($sqlUsuarios);

// Consultar administradores
$sqlAdmins = "SELECT * FROM registro WHERE rol = 'admin'";
$resultAdmins = $conexion->query($sqlAdmins);
?>

<html lang="es">

<head>
    <title>Gestión de Usuarios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .container {
            display: flex;
            justify-content: space-between;
        }
        .table-container {
            width: 48%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .convert-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .convert-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <h2 style="text-align: center;">Gestión de Usuarios y Administradores</h2>
    <div class="container">
        <!-- Tabla de Usuarios -->
        <div class="table-container">
            <h3>Información de Usuarios</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultUsuarios && $resultUsuarios->num_rows > 0) {
                        while ($row = $resultUsuarios->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['Id_usuario']; ?></td>
                                <td><?php echo $row['user']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td>
                                    <form action="convertir.php" method="POST">
                                        <input type="hidden" name="Id_usuario" value="<?php echo $row['Id_usuario']; ?>">
                                        <button type="submit" class="convert-button">Convertir a Admin</button>
                                    </form>
                                </td>
                            </tr>
                    <?php }
                    } else {
                        echo "<tr><td colspan='4'>No hay usuarios disponibles.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Tabla de Administradores -->
        <div class="table-container">
            <h3>Información de Administradores</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultAdmins && $resultAdmins->num_rows > 0) {
                        while ($row = $resultAdmins->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['Id_usuario']; ?></td>
                                <td><?php echo $row['user']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                            </tr>
                    <?php }
                    } else {
                        echo "<tr><td colspan='3'>No hay administradores disponibles.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
