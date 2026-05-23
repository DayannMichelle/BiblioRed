<?php  //HU-02 Búsqueda implementada//
require 'database.php';

$buscar = $_POST['buscar'] ?? '';
$genero = $_POST['genero'] ?? '';
$autor = $_POST['autor'] ?? '';
$topografico = $_POST['numero_topografico'] ?? '';

$sql = "SELECT titulo, autor, genero, numero_topografico FROM libros WHERE 1=1";

if (!empty($buscar)) {
    $sql .= " AND (titulo LIKE :buscar OR autor LIKE :buscar OR genero LIKE :buscar)";
}
if (!empty($genero)) {
    $sql .= " AND genero = :genero";
}
if (!empty($autor)) {
    $sql .= " AND autor LIKE :autor";
}
if (!empty($topografico)) {
    $sql .= " AND numero_topografico = :numero_topografico";
}

$query = $conn->prepare($sql);

if (!empty($buscar)) {
    $query->bindValue(':buscar', "%$buscar%");
}
if (!empty($genero)) {
    $query->bindValue(':genero', $genero);
}
if (!empty($autor)) {
    $query->bindValue(':autor', "%$autor%");
}
if (!empty($topografico)) {
    $query->bindValue(':numero_topografico', $topografico);
}

$query->execute();
$resultados = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lectorium: Descubre y disfruta de una amplia colección de libros.">
    <title>Resultados-Lectorium</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/img/icon.jpeg">
</head>
<?php require 'partials/header.php' ?>

<body>
<section class="tabla">

    <h2>Resultados de la Búsqueda</h2>

    <?php if (count($resultados) > 0): ?>
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
                <?php foreach ($resultados as $libro): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($libro['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($libro['autor']); ?></td>
                        <td><?php echo htmlspecialchars($libro['genero']); ?></td>
                        <td><?php echo htmlspecialchars($libro['numero_topografico']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron resultados para los criterios de búsqueda ingresados.</p>
    <?php endif; ?>
</body>
</section>

</html>
