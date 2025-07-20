<?php
require 'database.php';

$sql = "SELECT * FROM libros";
$stmt = $conn->prepare($sql);
$stmt->execute();
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lectorium: Descubre y disfruta de una amplia colección de libros.">
    <title>Modificar-Lectorium</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/img/icon.jpeg">
</head>
<?php require 'partials/header.php' ?>

<body>
<section class="tabla">
     
    <h2>Actualizar Información de Libros</h2>

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Género</th>
                <th>Número Topográfico</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($libros as $libro): ?>
            <tr>
                <td><?php echo htmlspecialchars($libro['titulo']); ?></td>
                <td><?php echo htmlspecialchars($libro['autor']); ?></td>
                <td><?php echo htmlspecialchars($libro['genero']); ?></td>
                <td><?php echo htmlspecialchars($libro['numero_topografico']); ?></td>
                <td>
                    <a href="editar_libro.php?id=<?php echo $libro['id']; ?>" class="cta">Editar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
 </section>

</body>
</html>