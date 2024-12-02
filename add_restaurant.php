<?php
include('conexion.php');

if ($_POST) {
    $name_rest = $_POST['name_rest'];
    $score = $_POST['score'];
    $price = $_POST['price'];
    $city = $_POST['city'];
    $state_country = $_POST['state_country'];
    $country = $_POST['country'];
    $postcode = $_POST['postcode'];
    $phone = $_POST['phone'];

    $sql_insert = "INSERT INTO restaurants (name_rest, score, price, city, state_country, country, postcode, phone) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sissssss", $name_rest, $score, $price, $city, $state_country, $country, $postcode, $phone);

    if ($stmt_insert->execute()) {
        echo "<script>alert('Nuevo restaurante agregado exitosamente'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Error al agregar el restaurante');</script>";
    }
}
?>

<html lang="es">

<head>
    <title>Add Restaurant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <div class="container">
        <h2>Add Restaurant</h2>
        <form method="POST">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name_rest" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Score:</label>
                <input type="number" name="score" class="form-control" min="1" max="10" required>
            </div>
            <div class="form-group">
                <label>Price:</label>
                <input type="text" name="price" class="form-control" required>
            </div>
            <div class="form-group">
                <label>City:</label>
                <input type="text" name="city" class="form-control" required>
            </div>
            <div class="form-group">
                <label>State Country:</label>
                <input type="text" name="state_country" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Country:</label>
                <input type="text" name="country" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Postcode:</label>
                <input type="text" name="postcode" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Phone:</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Add</button>
            <a href="index.php" class="btn btn-danger">Back</a>
        </form>
    </div>
</body>

</html>