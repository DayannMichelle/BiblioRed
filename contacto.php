<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lectorium: Descubre y disfruta de una amplia colección de libros.">
    <title>Contacto</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/img/icon.jpeg">
</head>

<?php require 'partials/header.php' ?>

<body>
        <div class="container">
            <h1>Software para Bibliotecas Escolares</h1>
        
        </div>

    <section id="contacto" class="contact">
        <div class="container">
            <h2>Contacto</h2>
            <p>Estamos aquí para ayudarte. Si tienes alguna pregunta o deseas obtener más información sobre nuestros servicios, por favor, completa el formulario a continuación o contáctanos directamente.</p>
            
            <div class="contact-info">
                <h3>Información de Contacto</h3>
                <ul>
                    <li><strong>Correo electrónico:</strong> <a href="michelle031@live.com">michelle031@live.com</a></li>
                    <li><strong>Teléfono:</strong>3115479995</li>
                    <li><strong>Dirección:</strong> Carrera 95 #65 - 49 Sur</li>
                </ul>
            </div>

            <div class="contact-form">
                <h3>Envíanos un Mensaje</h3>
                <form action="mailto:info@tusitio.com" method="post" enctype="text/plain">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>

                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" required></textarea>

                    <button type="submit">Enviar Mensaje</button>
                </form>
            </div>
</body>
</html>
