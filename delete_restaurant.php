<?php
include('conexion.php');

$id = $_GET['id'];

$sql = "DELETE FROM restaurants WHERE id = ?";

mysqli_query($conn, "DELETE FROM restaurants where id=$id");
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
	echo "<script>alert('Registro eliminado exitosamente'); window.location='index.php';</script>";
} else {
	echo "<script>alert('Error al eliminar'); window.location='index.php';</script>";
}