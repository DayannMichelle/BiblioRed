<?php
session_start();

require 'database.php';

$user = null;

if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, first_name, last_name, email, phone, birthdate, gender FROM usuarios WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    if ($results) {
        $user = $results;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lectorium: Descubre y disfruta de una amplia colección de libros.">
    <title>Prueba-Lectorium</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/img/icon.jpeg">
</head>

<?php require 'partials/header.php' ?>

<div class="demo">

<body>
    
    <a href="libros.php" class="dem">Registrar Material Bibliográfico</a>
    <a href="prestamos.php" class="dem">Gestionar Préstamos de Libros</a>
    <a href="estadisticas.php" class="dem">Ver Estadísticas de Préstamos</a>
    <a href="inventarios.php" class="dem">Ver Inventarios de Libros</a>
    
</body>

</html>
