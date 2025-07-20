<?php
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $numero_topografico = $_POST['numero_topografico'];

    $sql = "INSERT INTO libros (titulo, autor, genero, numero_topografico) 
            VALUES (:titulo, :autor, :genero, :numero_topografico)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':genero', $genero);
    $stmt->bindParam(':numero_topografico', $numero_topografico);

    if ($stmt->execute()) {
        echo "¡Libro ingresado con éxito!";
    } else {
        echo "Hubo un error al ingresar el libro.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lectorium: Descubre y disfruta de una amplia colección de libros.">
    <title>Ingresos-Lectorium</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/img/icon.jpeg">
</head>
<?php require 'partials/header.php' ?>
<body>
<section class="cata">

    <h2>Registro de material bibliográfico</h2>
    <form action="ingresar_libro.php" method="POST">
        <div class="campo">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
        </div>

        <div class="campo">
            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" required>
        </div>

        <div class="campo">
            <label for="genero">Género:</label>
            <select id="genero" name="genero" required>
                <option value="ficcion">Ficción</option>
                <option value="novela">Novela</option>
                <option value="ciencia_ficcion">Ciencia Ficción</option>
                <option value="historia">Historia</option>
                <option value="autoayuda">Autoayuda</option>
                <option value="misterio">Misterio</option>
                <option value="fantasia">Fantasía</option>
                <option value="biografia">Biografía</option>
                <option value="otros">Otros</option>
            </select>
        </div>

        <div class="campo">
            <label for="numero_topografico">Número Topográfico:</label>
            <input type="text" id="numero_topografico" name="numero_topografico" required>
        </div>

        <button type="submit" class="cta">Ingresar Libro</button>
    </form>
</body>
</html>
