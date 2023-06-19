<?php
session_start();
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
            <?php if ($_SESSION["role"] === "admin"): ?>
                <a href="admin.php" class="btn btn-primary">Admin</a>
            <?php endif; ?>
            
            <a class="register" style="text-decoration:none" href="<?php echo isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ? 'logout.php' : 'register.php'; ?>">
            <?php
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                echo "Cerrar sesión";
            } else {
                echo "Registrarse";
            }
            ?>
            </a>
        </div>
    </div>


    <div class="about__body">
        <div class="title">
            <h1><strong>Contáctanos</strong></h1>
        </div>

        <div class="formulariocontainer">
            <div class="formularioinfo">
                <div class="formularioheader">
                    <h2>Contacta con un experto</h2>
                    <p>· Si tienes alguna duda o sugerencia, no dudes en contactarnos.</p>
                </div>

                <div class="helplist">
                    <h2>Podemos ayudarte a:</h2>
                    <div class="helpitem">
                        <img src="/images/idea.png">
                        <p>Resolver dudas de pagos</p>
                    </div>
                    <div class="helpitem">
                        <img src="/images/idea.png">
                        <p>Explicarte el funcionamiento de nuestro servicio</p>
                    </div>
                    <div class="helpitem">
                        <img src="/images/idea.png">
                        <p>Mostrarte ejemplos gráficos</p>
                    </div>
                    <div class="helpitem">
                        <img src="/images/idea.png">
                        <p>Dar soporte si ya eres usuario</p>
                    </div>
                </div>
            </div>
            <div class="formulario">
                <form action="sendmail.php" method="post">
                    <div class="formsection">
                        <label for="nombre">Nombre:</label><br>
                        <input type="text" id="nombre" name="nombre" required><br>
                    </div>
                    <div class="formsection">
                        <label for="email">Email:</label><br>
                        <input type="email" id="email" name="email" required><br>
                    </div>
                    <div class="formsection">
                        <label for="mensaje">Mensaje:</label><br>
                        <textarea id="mensaje" name="mensaje" rows="4" required></textarea><br>
                    </div>
                    <input type="submit" value="Enviar">
                </form>
            </div>
        </div>

    </div>
</body>
</html>
