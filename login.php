<?php // HU-04 Inicio de sesión //

  session_start();

  if (isset($_SESSION['user_id'])) {
    header('Location: /proyecto.php/login.php');
  }
  require 'database.php';

  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $records = $conn->prepare('SELECT id, email, password FROM usuarios WHERE email = :email');
    $records->bindParam(':email', $_POST['email']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $message = '';

    if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
      $_SESSION['user_id'] = $results['id'];
      header("Location: /proyecto.php/inicio.php");
    } else {
      $message = 'La contraseña o el correo son incorrectos';
    }
    
  }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lectorium: Descubre y disfruta de una amplia colección de libros.">
    <title>Inicio de sesión-Lectorium</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/img/icon.jpeg">
</head>
    <?php require 'partials/header.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

   <section class="login"> 
    <h1>Inicia sesión</h1>
    <form action="login.php" method="POST">
      <input name="email" type="text" placeholder="Ingresa tu correo institucional">
      <input name="password" type="password" placeholder="Contraseña">
          <div><label><input type="checkbox"> Recordar cuenta</label></div>
          <div><a href="#">Olvidé mi contraseña</a></div>
        
      <input type="submit" value="Enviar">
    </section>
    </form>
  </body>
</html>