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
    <title>Inicio-Lectorium</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/img/icon.jpeg">
</head>

<?php require 'partials/header.php' ?>


  <div class="usuario-info">

    <?php if ($user): ?>
      <h2>Bienvenido, <?php echo htmlspecialchars($user['first_name']); ?>!</h2>
      <p>Nombre: <?php echo htmlspecialchars($user['first_name']); ?> <?php echo htmlspecialchars($user['last_name']); ?></p>
      <p>Correo: <?php echo htmlspecialchars($user['email']); ?></p>
      <p>Teléfono: <?php echo htmlspecialchars($user['phone']); ?></p>
      <p>Género: <?php echo htmlspecialchars($user['gender']); ?></p>
      <a href="demo.php" class="por">Prueba</a>
      <a href="logout.php" class="por">Cerrar sesión</a>

    <?php else: ?>
      <p>No has iniciado sesión.</p>
      <?php endif; ?>

    </div>
    
</body>

</html>
