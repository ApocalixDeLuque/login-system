<?php
session_start();
require_once "config.php";

function username_exists($username, $link) {
    $sql = "SELECT id FROM users WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                return true;
            }
        }
        mysqli_stmt_close($stmt);
    }
    return false;
}

function email_exists($email, $link) {
    $sql = "SELECT id FROM users WHERE email = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = $email;
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                return true;
            }
        }
        mysqli_stmt_close($stmt);
    }
    return false;
}
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Verificar si el usuario es un administrador
if ($_SESSION["role"] !== "admin") {
    header("location: dashboard.php"); // Redirigir a la página de dashboard para usuarios no administradores
    exit;
}

// Obtener todos los usuarios de la base de datos
$sql = "SELECT username, email, password, role FROM users";
$result = mysqli_query($link, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);

// Procesar el formulario de registro de usuarios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (username_exists($username, $link)) {
        $error_msg = "Ese nombre de usuario está en uso. Intenta con uno diferente.";
    } elseif (email_exists($email, $link)) {
        $error_msg = "El correo ya está en uso. Intenta con uno diferente.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = "user";

        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_email, $param_password, $role);

            $param_username = $username;
            $param_email = $email;
            $param_password = $hashed_password;

            if (mysqli_stmt_execute($stmt)) {
                $successMessage = "El usuario se creó correctamente.";
            } else {
                $error_msg = "Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_close($link);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/styles.css">
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

            <a class="register" style="text-decoration:none"
                href="<?php echo isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ? 'logout.php' : 'register.php'; ?>">
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

    <div class="container">
        <h1>Usuarios</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user["username"]; ?></td>
                    <td><?php echo $user["email"]; ?></td>
                    <td><?php echo $user["password"]; ?></td>
                    <td><?php echo $user["role"]; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div>
        <h2>Crear nuevo usuario</h2>
        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
        <?php endif; ?>
        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear usuario</button>
        </form>

    </div>
</body>
</html>
