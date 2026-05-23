<?php  //HU 03 Prestamos// 
session_start();
require 'database.php';

$message = '';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['prestamo'])) {
    $libro_id = $_POST['libro_id'];
    $user_id_externo = $_POST['user_id'];
    $fecha_prestamo = date('Y-m-d H:i:s');
    $fecha_devolucion = date('Y-m-d H:i:s', strtotime('+7 days')); 


    $sql = "INSERT INTO prestamos (user_id, libro_id, fecha_prestamo, fecha_devolucion, estado) 
            VALUES (:user_id, :libro_id, :fecha_prestamo, :fecha_devolucion, 'prestado')";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id_externo); 
    $stmt->bindParam(':libro_id', $libro_id);
    $stmt->bindParam(':fecha_prestamo', $fecha_prestamo);
    $stmt->bindParam(':fecha_devolucion', $fecha_devolucion);

    if ($stmt->execute()) {
        $message = 'El libro ha sido prestado con éxito al usuario externo.';
    } else {
        $message = 'Hubo un problema al procesar el préstamo.';
    }
}

if (isset($_POST['devolucion'])) {
    $prestamo_id = $_POST['prestamo_id'];
    
    $sql_devolucion = "UPDATE prestamos SET estado = 'devuelto', fecha_devolucion = :fecha_devolucion WHERE id = :prestamo_id";
    $stmt_devolucion = $conn->prepare($sql_devolucion);
    $fecha_devolucion = date('Y-m-d H:i:s');
    $stmt_devolucion->bindParam(':prestamo_id', $prestamo_id);
    $stmt_devolucion->bindParam(':fecha_devolucion', $fecha_devolucion);

    if ($stmt_devolucion->execute()) {
        $message = 'El libro ha sido devuelto con éxito.';
    } else {
        $message = 'Hubo un problema al procesar la devolución, por favor contactese con el administrador.';
    }
}

$sql_libros = "SELECT * FROM libros WHERE id NOT IN (SELECT libro_id FROM prestamos WHERE estado = 'prestado')";
$stmt_libros = $conn->prepare($sql_libros);
$stmt_libros->execute();
$libros = $stmt_libros->fetchAll(PDO::FETCH_ASSOC);

$sql_usuarios = "SELECT id, email, first_name, last_name FROM usuarios";
$stmt_usuarios = $conn->prepare($sql_usuarios);
$stmt_usuarios->execute();
$usuarios = $stmt_usuarios->fetchAll(PDO::FETCH_ASSOC);

$sql_prestamos = "SELECT p.id, l.titulo, u.first_name, u.last_name, p.fecha_prestamo, p.fecha_devolucion 
                  FROM prestamos p 
                  JOIN libros l ON p.libro_id = l.id
                  JOIN usuarios u ON p.user_id = u.id
                  WHERE p.estado = 'prestado'";
$stmt_prestamos = $conn->prepare($sql_prestamos);
$stmt_prestamos->execute();
$prestamos_activos = $stmt_prestamos->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lectorium: Descubre y disfruta de una amplia colección de libros.">
    <title>Prestamos-Lectorium</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/img/icon.jpeg">
</head>
<?php require 'partials/header.php' ?>

<body>

    <div class="prestamos">
        <h2>Realizar Préstamo</h2>
        <form action="prestamos.php" method="POST">
            <label for="user_id">Selecciona el usuario externo:</label>
            <select name="user_id" id="user_id" required>
                <option value="">Selecciona un usuario</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['id'] ?>"><?= $usuario['first_name'] . ' ' . $usuario['last_name'] ?> (<?= $usuario['email'] ?>)</option>
                <?php endforeach; ?>
            </select>

            <label for="libro_id">Selecciona el libro:</label>
            <select name="libro_id" id="libro_id" required>
                <option value="">Selecciona un libro</option>
                <?php foreach ($libros as $libro): ?>
                    <option value="<?= $libro['id'] ?>"><?= $libro['titulo'] ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" name="prestamo">Realizar Préstamo</button>
        </form>

        <h2>Préstamos Activos</h2>
        <?php if ($prestamos_activos): ?>
            <table>
                <tr>
                    <th>Libro</th>
                    <th>Usuario</th>
                    <th>Fecha de Préstamo</th>
                    <th>Fecha de Devolución</th>
                    <th>Acción</th>
                </tr>
                <?php foreach ($prestamos_activos as $prestamo): ?>
                    <tr>
                        <td><?= htmlspecialchars($prestamo['titulo']) ?></td>
                        <td><?= htmlspecialchars($prestamo['first_name']) . ' ' . htmlspecialchars($prestamo['last_name']) ?></td>
                        <td><?= htmlspecialchars($prestamo['fecha_prestamo']) ?></td>
                        <td><?= htmlspecialchars($prestamo['fecha_devolucion']) ?></td>
                        <td>
                            <form action="prestamos.php" method="POST">
                                <input type="hidden" name="prestamo_id" value="<?= $prestamo['id'] ?>">
                                <button type="submit" name="devolucion">Devolver Libro</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No hay préstamos activos.</p>
        <?php endif; ?>

        <?php if ($message): ?>
            <p><?= $message ?></p>
        <?php endif; ?>
    </div>

</body>
</html>
