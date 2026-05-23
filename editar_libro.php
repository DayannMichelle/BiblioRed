<?php  //  HU-05 Actualización de libros //
require 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM libros WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $libro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$libro) {
        header('Location: modificar_libro.php');
        exit;
    }
} else {
    header('Location: modificar_libro.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $numero_topografico = $_POST['numero_topografico'];

    $sql = "UPDATE libros SET titulo = :titulo, autor = :autor, genero = :genero, numero_topografico = :numero_topografico WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':genero', $genero);
    $stmt->bindParam(':numero_topografico', $numero_topografico);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "¡Libro actualizado con éxito!";
    } else {
        echo "Hubo un error al actualizar el libro.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lectorium: Descubre y disfruta de una amplia colección de libros.">
    <title>Editar-Lectorium</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/img/icon.jpeg">
</head>
<?php require 'partials/header.php' ?>
<body>
<section class="cata">

    <h2>Editar Libro: <?php echo htmlspecialchars($libro['titulo']); ?></h2>

    <form action="editar_libro.php?id=<?php echo $libro['id']; ?>" method="POST">
        <div class="campo">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($libro['titulo']); ?>" required>
        </div>

        <div class="campo">
            <label for="autor">Autor:</label>
            <input type="text" id="autor" name="autor" value="<?php echo htmlspecialchars($libro['autor']); ?>" required>
        </div>

        <div class="campo">
            <label for="genero">Género:</label>
            <select id="genero" name="genero" required>
                <option value="ficcion" <?php if ($libro['genero'] == 'ficcion') echo 'selected'; ?>>Ficción</option>
                <option value="novela" <?php if ($libro['genero'] == 'novela') echo 'selected'; ?>>Novela</option>
                <option value="ciencia_ficcion" <?php if ($libro['genero'] == 'ciencia_ficcion') echo 'selected'; ?>>Ciencia Ficción</option>
                <option value="historia" <?php if ($libro['genero'] == 'historia') echo 'selected'; ?>>Historia</option>
                <option value="autoayuda" <?php if ($libro['genero'] == 'autoayuda') echo 'selected'; ?>>Autoayuda</option>
                <option value="misterio" <?php if ($libro['genero'] == 'misterio') echo 'selected'; ?>>Misterio</option>
                <option value="fantasia" <?php if ($libro['genero'] == 'fantasia') echo 'selected'; ?>>Fantasía</option>
                <option value="biografia" <?php if ($libro['genero'] == 'biografia') echo 'selected'; ?>>Biografía</option>
                <option value="otros" <?php if ($libro['genero'] == 'otros') echo 'selected'; ?>>Otros</option>
            </select>
        </div>

        <div class="campo">
            <label for="numero_topografico">Número Topográfico:</label>
            <input type="text" id="numero_topografico" name="numero_topografico" value="<?php echo htmlspecialchars($libro['numero_topografico']); ?>" required>
        </div>

        <button type="submit" class="cta">Actualizar Libro</button>
    </form>
    </section>

</body>
</html>