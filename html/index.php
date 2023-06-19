<?php
ob_start();

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location:dashboard.php");
    exit;
}

require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT id, username, password FROM users WHERE username = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_username);

        $param_username = $username;

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {
                        session_start();
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;

                        header("location: dashboard.php");
                    } else {
                        $error_msg = "Invalid username or password.";
                    }
                }
            } else {
                $error_msg = "Invalid username or password.";
            }
        } else {
            $error_msg = "Something went wrong. Please try again later.";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
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
    <link rel="stylesheet" href="/css/styles.css">
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
    <div class="bigcontainer">
        <div class="midcontainer">
            <div class="container">
                <div class="infobox">
                    <div class="container col-sm-4">
                        <h2>¿Quiénes somos?</h2>
                        <p>Somos una empresa que se dedica a la venta de productos de tecnología, con el fin de satisfacer las necesidades de nuestros clientes.</p>

                        <h2>¿Qué hacemos?</h2>
                        <p>Ofrecemos productos de calidad, con garantía y a un precio accesible.</p>

                        <h2>¿Por qué elegirnos?</h2>
                        <p>Porque somos una empresa que se preocupa por sus clientes, ofreciendo productos de calidad y a un precio accesible.</p>
                    </div>
                </div>
            </div>
            <div class='examples'>
                <div class='examples__container'>
                    <div class='examples__container-title'>
                    <h2>Mira nuestros <span class='text-color'>ejemplos</span></h2>
                    </div>
                    <div class='examples__container-images'>
                        <div class='examples__container-images__section'>
                            <img src="/images/example1.webp" alt='example' />
                            <img src="/images/example2.jpeg" alt='example' />
                        </div>
                        <div class='examples__container-images__section'>
                            <img src="/images/example5.png" alt='example' />
                            <img src="/images/example6.png" alt='example' />
                            <img src="/images/example7.png" alt='example' />
                            <img src="/images/example3.jpeg" alt='example' />
                        </div>
                        <div class='examples__container-images__section'>
                            <img src="/images/example8.png" alt='example' />
                            <img src="/images/example9.png" alt='example' />
                            <img src="/images/example10.png" alt='example' />
                            <img src="/images/example4.png" alt='example' />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="midcontainer">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h3>Inicia sesión</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error_msg)): ?>
                            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                        <?php endif; ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label for="username">Usuario:</label>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Inicia sesión</button>
                            <label></label>
                            <a href="register.php" class="btn btn-secondary"> ¿No tienes cuenta? Registrate</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="textbox">
                <h3>¿Tienes alguna duda?</h3>
                <p>Contáctanos</p>
                <a href="contact.php" class="btn btn-primary">Contáctanos</a>
            </div>
        </div>
    </div>
</body>
</html>
