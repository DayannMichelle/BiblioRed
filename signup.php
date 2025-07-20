<?php
require 'database.php';

$message = '';

if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['birthdate']) && 
    !empty($_POST['gender']) && !empty($_POST['phone']) && !empty($_POST['email']) && 
    !empty($_POST['password']) && !empty($_POST['confirm_password'])) {

    if ($_POST['password'] === $_POST['confirm_password']) {

        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO usuarios (first_name, last_name, birthdate, gender, phone, email, password) 
                VALUES (:first_name, :last_name, :birthdate, :gender, :phone, :email, :password)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':first_name', $_POST['first_name']);
        $stmt->bindParam(':last_name', $_POST['last_name']);
        $stmt->bindParam(':birthdate', $_POST['birthdate']);
        $stmt->bindParam(':gender', $_POST['gender']);
        $stmt->bindParam(':phone', $_POST['phone']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            $message = 'Su usuario ha sido creado satisfactoriamente';
        } else {
            $message = 'Lo sentimos, ha ocurrido un problema';
        }

    } else {
        $message = 'Las contraseñas no coinciden. Inténtelo de nuevo.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lectorium: Descubre y disfruta de una amplia colección de libros.">
    <title>Crear cuenta-Lectorium</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/img/icon.jpeg">
</head>
<?php require 'partials/header.php' ?>

<?php if (!empty($message)): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>
<section class="signup"
>

    <h2>Crear Cuenta</h2>
    <form action="signup.php" method="POST">
        <label for="first_name">Nombre:</label>
        <input type="text" id="first_name" name="first_name" required><br><br>

        <label for="last_name">Apellido:</label>
        <input type="text" id="last_name" name="last_name" required><br><br>

        <label for="birthdate">Fecha de Nacimiento:</label>
        <input type="date" id="birthdate" name="birthdate" required><br><br>

        <label for="gender">Género:</label>
        <select id="gender" name="gender" required>
            <option value="">Seleccionar</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otro</option>
        </select><br><br>

        <label for="phone">Número de Celular:</label>
        <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" placeholder="3131258745" required><br><br>

        <label for="email">Correo electrónico:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Confirmar Contraseña:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>

        <button type="submit">Crear Cuenta</button>
    </form>
    </section> 
</html>