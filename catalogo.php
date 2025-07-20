<?php
session_start();
require 'database.php';

$user = null; 

if (isset($_SESSION['user_id'])) {
 
    $records = $conn->prepare('SELECT id, email, password FROM usuarios WHERE id = :id');
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
    <title>Catalogo-Lectorium</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/img/icon.jpeg">
</head>

<?php require 'partials/header.php' ?>

    <section class="cata">
      <h2>Encuentra tu Libro</h2>
      <form action="resultados_busqueda.php" method="POST">
        <div class="campo">
          <label for="buscar">Título:</label>
          <input type="text" id="buscar" name="buscar" placeholder="Título">
        </div>
        <div class="campo">
          <label for="genero">Género:</label>
          <select id="genero" name="genero">
            <option value="">Cualquiera</option>
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
          <label for="autor">Autor:</label>
          <input type="text" id="autor" name="autor" placeholder="Ingrese el nombre del autor">
        </div>


        <div class="campo">
          <label for="topografico">Número Topográfico:</label>
          <input type="text" id="topografico" name="topografico" placeholder="Ejemplo: 613.7042 D33u">
        </div>

        <button type="submit" class="cta">Buscar Libro</button>
      </form>
    </section>
    <footer>
        <p>&copy; 2024 Lectorium. Todos los derechos reservados.</p>
        <nav>
            <ul>
                <li><a href="#">Política de Privacidad</a></li>
                <li><a href="#">Términos de Servicio</a></li>
                <li><a href="#">Síguenos en Redes Sociales</a></li>
            </ul>
        </nav>
    </footer>
  </body>
</html>
