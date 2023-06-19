<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    $to = "lololertrololer@gmail.com";

    $subject = "Nuevo mensaje de contacto de $nombre";

    $body = "Has recibido un nuevo mensaje de contacto.\n\n".
            "Nombre: $nombre\n".
            "Email: $email\n".
            "Mensaje:\n$mensaje";

    $headers = "From: $email";

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/styles.css">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="navbar"> 
        <div class="navbar__logo">
            <img src="/images/logo.png">
            <p>ArteNeural</p>
        </div>
        <div class="navbar__menu">
            <a style="text-decoration:none" href="index.php">Inicio</a>
            <a style="text-decoration:none" href="about.php">Sobre nosotros</a>
            <a style="text-decoration:none" href="contact.php">Contacto</a>
            <a class="register" style="text-decoration:none" href="register.php">Registrarse</a>
        </div>
    </div>
    <div class="mailcontainer">
        <div class="mailitem">
            <h1>Gracias por contactar con nosotros</h1>
            <p>Mensaje enviado con éxito</p>
        </div>
        <div class="">
            <a class="register" style="text-decoration:none" href="index.php">Volver a la página principal</a>
        </div>

    </div>
</body>
</html>
