<?php
session_start();
require 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM libros";
$stmt = $conn->prepare($sql);
$stmt->execute();
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agregar'])) {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $numero_topografico = $_POST['numero_topografico'];

    $sql_agregar = "INSERT INTO libros (titulo, autor, genero, numero_topografico) 
                    VALUES (:titulo, :autor, :genero, :numero_topografico)";
    $stmt_agregar = $conn->prepare($sql_agregar);
    $stmt_agregar->bindParam(':titulo', $titulo);
    $stmt_agregar->bindParam(':autor', $autor);
    $stmt_agregar->bindParam(':genero', $genero);
    $stmt_agregar->bindParam(':numero_topografico', $numero_topografico);
    $stmt_agregar->execute();

    header("Location: inventario.php?mensaje=Libro agregado correctamente");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar'])) {
    $id_libro = $_POST['id_libro'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $numero_topografico = $_POST['numero_topografico'];

    $sql_editar = "UPDATE libros SET titulo = :titulo, autor = :autor, genero = :genero, numero_topografico = :numero_topografico 
                   WHERE id = :id_libro";
    $stmt_editar = $conn->prepare($sql_editar);
    $stmt_editar->bindParam(':id_libro', $id_libro);
    $stmt_editar->bindParam(':titulo', $titulo);
    $stmt_editar->bindParam(':autor', $autor);
    $stmt_editar->bindParam(':genero', $genero);
    $stmt_editar->bindParam(':numero_topografico', $numero_topografico);
    $stmt_editar->execute();

    header("Location: inventario.php?mensaje=Libro actualizado correctamente");
    exit;
}

if (isset($_GET['eliminar'])) {
    $id_libro = $_GET['eliminar'];

    $sql_eliminar = "DELETE FROM libros WHERE id = :id_libro";
    $stmt_eliminar = $conn->prepare($sql_eliminar);
    $stmt_eliminar->bindParam(':id_libro', $id_libro);
    $stmt_eliminar->execute();

    header("Location: inventario.php?mensaje=Libro eliminado correctamente");
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lectorium: Descubre y disfruta de una amplia colección de libros.">
    <title>Inventario-Lectorium</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/img/icon.jpeg">
</head>
<?php require 'partials/header.php' ?>
<body>
<section class="tabla">
    <div class="inventario">
        <h3>Libros en Inventario</h3>

        <?php
        if (isset($_GET['mensaje'])) {
            echo "<p class='mensaje-success'>" . htmlspecialchars($_GET['mensaje']) . "</p>";
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Género</th>
                    <th>Número Topográfico</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($libros as $libro): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($libro['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($libro['autor']); ?></td>
                        <td><?php echo htmlspecialchars($libro['genero']); ?></td>
                        <td><?php echo htmlspecialchars($libro['numero_topografico']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </section>

</body>
</html>
