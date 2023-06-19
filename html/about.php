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
            <h1 class="container__title"><strong>Sobre Nosotros</strong></h1>
        </div>

        <div class="container__about">
            <div class="container__part">
            <svg viewBox="0 0 24 24" height="5em" width="5em" xmlns="http://www.w3.org/2000/svg"><path d="M19.864 8.465a3.505 3.505 0 0 0-3.03-4.449A3.005 3.005 0 0 0 14 2a2.98 2.98 0 0 0-2 .78A2.98 2.98 0 0 0 10 2c-1.301 0-2.41.831-2.825 2.015a3.505 3.505 0 0 0-3.039 4.45A4.028 4.028 0 0 0 2 12c0 1.075.428 2.086 1.172 2.832A4.067 4.067 0 0 0 3 16c0 1.957 1.412 3.59 3.306 3.934A3.515 3.515 0 0 0 9.5 22c.979 0 1.864-.407 2.5-1.059A3.484 3.484 0 0 0 14.5 22a3.51 3.51 0 0 0 3.19-2.06 4.006 4.006 0 0 0 3.138-5.108A4.003 4.003 0 0 0 22 12a4.028 4.028 0 0 0-2.136-3.535zM9.5 20c-.711 0-1.33-.504-1.47-1.198L7.818 18H7c-1.103 0-2-.897-2-2 0-.352.085-.682.253-.981l.456-.816-.784-.51A2.019 2.019 0 0 1 4 12c0-.977.723-1.824 1.682-1.972l1.693-.26-1.059-1.346a1.502 1.502 0 0 1 1.498-2.39L9 6.207V5a1 1 0 0 1 2 0v13.5c0 .827-.673 1.5-1.5 1.5zm9.575-6.308-.784.51.456.816c.168.3.253.63.253.982 0 1.103-.897 2-2.05 2h-.818l-.162.802A1.502 1.502 0 0 1 14.5 20c-.827 0-1.5-.673-1.5-1.5V5c0-.552.448-1 1-1s1 .448 1 1.05v1.207l1.186-.225a1.502 1.502 0 0 1 1.498 2.39l-1.059 1.347 1.693.26A2.002 2.002 0 0 1 20 12c0 .683-.346 1.315-.925 1.692z"></path></svg>
                <h2><strong>Creación</strong></h2>
                <p>Generamos imágenes a gran escala, si tú lo piensas, nosotros lo convertimos en realidad.</p>
            </div>
            <div class="container__part">
            <svg viewBox="0 0 24 24" height="5em" width="5em" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path><path d="M9.999 13.587 7.7 11.292l-1.412 1.416 3.713 3.705 6.706-6.706-1.414-1.414z"></path></svg>
                <h2><strong>Eficiencia</strong></h2>
                <p>Obten resultados inmediatos, editalos o guarda tu arte para visualizarlo más tarde</p>
            </div>
            <div class="container__part">
            <svg viewBox="0 0 24 24" height="5em" width="5em" xmlns="http://www.w3.org/2000/svg" style="width: 30%; height: 30%;"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 11c-2 0-2-.63-2-1s.7-1 2-1 1.39.64 1.4 1h2A3 3 0 0 0 13 7.12V6h-2v1.09C9 7.42 8 8.71 8 10c0 1.12.52 3 4 3 2 0 2 .68 2 1s-.62 1-2 1c-1.84 0-2-.86-2-1H8c0 .92.66 2.55 3 2.92V18h2v-1.08c2-.34 3-1.63 3-2.92 0-1.12-.52-3-4-3z"></path></svg>
                <h2><strong>Ahorro</strong></h2>
                <p>Crea de manera gratuita y acorde a tu uso te ofrecemos planes que mejor se adapten a tu uso.</p>
            </div>
        </div>

    </div>
</body>
</html>
