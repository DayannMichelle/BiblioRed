<?php
session_start();
require 'database.php';

$message = '';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; 



$sql_total_prestamos = "SELECT COUNT(*) FROM prestamos WHERE estado = 'prestado' AND user_id != :user_id";
$stmt_total_prestamos = $conn->prepare($sql_total_prestamos);
$stmt_total_prestamos->bindParam(':user_id', $user_id);
$stmt_total_prestamos->execute();
$total_prestamos = $stmt_total_prestamos->fetchColumn();

$sql_total_devoluciones = "SELECT COUNT(*) FROM prestamos WHERE estado = 'devuelto' AND user_id != :user_id";
$stmt_total_devoluciones = $conn->prepare($sql_total_devoluciones);
$stmt_total_devoluciones->bindParam(':user_id', $user_id);
$stmt_total_devoluciones->execute();
$total_devoluciones = $stmt_total_devoluciones->fetchColumn();

$sql_prestamos_activos = "SELECT COUNT(*) FROM prestamos WHERE estado = 'prestado' AND user_id != :user_id";
$stmt_prestamos_activos = $conn->prepare($sql_prestamos_activos);
$stmt_prestamos_activos->bindParam(':user_id', $user_id);
$stmt_prestamos_activos->execute();
$total_prestamos_activos = $stmt_prestamos_activos->fetchColumn();

$sql_prestamos_por_libro = "SELECT l.titulo, COUNT(p.libro_id) AS prestamos_count 
                            FROM prestamos p 
                            JOIN libros l ON p.libro_id = l.id
                            WHERE p.user_id != :user_id
                            GROUP BY l.titulo ORDER BY prestamos_count DESC";
$stmt_prestamos_por_libro = $conn->prepare($sql_prestamos_por_libro);
$stmt_prestamos_por_libro->bindParam(':user_id', $user_id);
$stmt_prestamos_por_libro->execute();
$prestamos_por_libro = $stmt_prestamos_por_libro->fetchAll(PDO::FETCH_ASSOC);

$sql_prestamos_por_usuario = "SELECT u.first_name, u.last_name, COUNT(p.user_id) AS prestamos_count 
                              FROM prestamos p 
                              JOIN usuarios u ON p.user_id = u.id
                              WHERE p.user_id != :user_id
                              GROUP BY u.id ORDER BY prestamos_count DESC";
$stmt_prestamos_por_usuario = $conn->prepare($sql_prestamos_por_usuario);
$stmt_prestamos_por_usuario->bindParam(':user_id', $user_id);
$stmt_prestamos_por_usuario->execute();
$prestamos_por_usuario = $stmt_prestamos_por_usuario->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lectorium: Descubre y disfruta de una amplia colección de libros.">
    <title>Estadisticas-Lectorium</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/img/icon.jpeg">
</head>
<?php require 'partials/header.php' ?>
<body>

    <div class="estadisticas">
        <h2>Estadísticas de Préstamos (Usuarios Externos)</h2>
        
        <div class="estadisticas-box">
            <h3>Total de Préstamos Realizados</h3>
            <p><?= $total_prestamos ?> préstamos realizados por usuarios externos</p>
        </div>

        <div class="estadisticas-box">
            <h3>Total de Devoluciones Realizadas</h3>
            <p><?= $total_devoluciones ?> devoluciones realizadas por usuarios externos</p>
        </div>

        <div class="estadisticas-box">
            <h3>Total de Préstamos Activos</h3>
            <p><?= $total_prestamos_activos ?> préstamos activos por usuarios externos</p>
        </div>

        <div class="estadisticas-box">
            <h3>Préstamos por Libro</h3>
            <table>
                <tr>
                    <th>Libro</th>
                    <th>Préstamos Realizados</th>
                </tr>
                <?php foreach ($prestamos_por_libro as $prestamo_libro): ?>
                    <tr>
                        <td><?= htmlspecialchars($prestamo_libro['titulo']) ?></td>
                        <td><?= $prestamo_libro['prestamos_count'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="estadisticas-box">
            <h3>Préstamos por Usuario</h3>
            <table>
                <tr>
                    <th>Usuario</th>
                    <th>Préstamos Realizados</th>
                </tr>
                <?php foreach ($prestamos_por_usuario as $prestamo_usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($prestamo_usuario['first_name']) . ' ' . htmlspecialchars($prestamo_usuario['last_name']) ?></td>
                        <td><?= $prestamo_usuario['prestamos_count'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <?php if ($message): ?>
            <p><?= $message ?></p>
        <?php endif; ?>

    </div>

</body>
</html>
