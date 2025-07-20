
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
    <title>Libros-Lectorium</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/img/icon.jpeg">
</head>
<?php require 'partials/header.php' ?>
<body>
<div class="demo">
    <a href="catalogo.php" class="dem">Consulta</a>
    <a href="ingresar_libro.php" class="dem">Agregar registro</a>
    <a href="editar_libro.php" class="dem">Editar registro</a>
    <a href="eliminar_libro.php" class="dem">Eliminar registro</a>
</body>
</html>
