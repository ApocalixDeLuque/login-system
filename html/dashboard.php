<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Obtener información del usuario
$id = $_SESSION["id"];
$username = $_SESSION["username"];

$sql = "SELECT role FROM users WHERE id = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
  mysqli_stmt_bind_param($stmt, "i", $id); // Suponiendo que el id del usuario está almacenado en la variable $id
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $role);
  mysqli_stmt_fetch($stmt);
  $_SESSION["role"] = $role;
  mysqli_stmt_close($stmt);
}

$sql = "SELECT email FROM users WHERE id = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
  mysqli_stmt_bind_param($stmt, "i", $id); // Suponiendo que el id del usuario está almacenado en la variable $id
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $email);
  mysqli_stmt_fetch($stmt);
  $_SESSION["email"] = $email;
  mysqli_stmt_close($stmt);
}

$sql = "SELECT password FROM users WHERE id = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
  mysqli_stmt_bind_param($stmt, "i", $id); // Suponiendo que el id del usuario está almacenado en la variable $id
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $password);
  mysqli_stmt_fetch($stmt);
  $_SESSION["password"] = $password;
  mysqli_stmt_close($stmt);
}



// Variables para almacenar los nuevos datos
$newUsername = $newEmail = $newPassword = "";

// Mensajes de error
$usernameError = $emailError = $passwordError = "";

// Mensajes de confirmación
$successMessage = "";


if (isset($_POST["toggleRole"])) {
    // Verificar el rol actual del usuario
    $currentRole = $_SESSION["role"];

    // Alternar el rol
    if ($currentRole === "admin") {
        $newRole = "user";
    } else {
        $newRole = "admin";
    }

    // Actualizar el rol en la base de datos
    $sql = "UPDATE users SET role = ? WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "si", $newRole, $id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION["role"] = $newRole;
            $successMessage .= "El cambio de rol se realizó correctamente. ";
        } else {
            $errorMessage = "Hubo un problema al actualizar el rol.";
        }
        mysqli_stmt_close($stmt);
    }
}


// Manejo del formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación del campo de nombre de usuario
    if (isset($_POST["newUsername"]) && !empty(trim($_POST["newUsername"]))) {
        $newUsername = trim($_POST["newUsername"]);
        if ($newUsername == $username) {
            $usernameError = "El nuevo nombre de usuario debe ser diferente al actual.";
        }
    }

    // Validación del campo de correo
    if (isset($_POST["newEmail"]) && !empty(trim($_POST["newEmail"]))) {
        $newEmail = trim($_POST["newEmail"]);
        if ($newEmail == $_SESSION["email"]) {
            $emailError = "El nuevo correo electrónico debe ser diferente al actual.";
        }
    }

    // Validación del campo de contraseña
    if (isset($_POST["newPassword"]) && !empty(trim($_POST["newPassword"]))) {
        $newPassword = trim($_POST["newPassword"]);
    }

    // Actualizar los datos del usuario si no hay errores
    if (empty($usernameError) && empty($emailError) && empty($passwordError)) {
        // Actualizar el nombre de usuario en la base de datos
        if (!empty($newUsername)) {
            $sql = "UPDATE users SET username = ? WHERE id = ?";
            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "si", $newUsername, $id);
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION["username"] = $newUsername;
                    $successMessage .= "El cambio de nombre de usuario se realizó correctamente. ";
                } else {
                    $usernameError = "Hubo un problema al actualizar el nombre de usuario.";
                }
                mysqli_stmt_close($stmt);
            }
            $_SESSION["username"] = $newUsername;
            $_SESSION["email"] = $newEmail;
            $_SESSION["password"] = $newPassword;

            // Redirigir a la misma página para reflejar los cambios
            header("location: dashboard.php");
            exit;
        }
        

        // Actualizar el correo electrónico en la base de datos
        if (!empty($newEmail)) {
            $sql = "UPDATE users SET email = ? WHERE id = ?";
            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "si", $newEmail, $id);
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION["email"] = $newEmail;
                    $successMessage .= "El cambio de correo electrónico se realizó correctamente. ";
                } else {
                    $emailError = "Hubo un problema al actualizar el correo electrónico.";
                }
                mysqli_stmt_close($stmt);
            }
        }

        // Actualizar la contraseña en la base de datos
        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "si", $hashedPassword, $id);
                if (mysqli_stmt_execute($stmt)) {
                    $successMessage .= "El cambio de contraseña se realizó correctamente.";
                } else {
                    $passwordError = "Hubo un problema al actualizar la contraseña.";
                }
                mysqli_stmt_close($stmt);
            }
        }
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
        <div class="navbar__menu" >
            
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
            <div class="card">
                <div class="card-header">
                    <h3>Panel de acceso</h3>
                </div>
                <div class="card-body">
                    <p>Bienvenido, <?php echo htmlspecialchars($username); ?>!</p>
                    <p>Correo actual: <?php echo htmlspecialchars($_SESSION["email"]); ?></p>
                    <p>Contraseña actual: <?php echo isset($_SESSION["password"]) ? "*********" : "error"; ?></p>
                    <p>Rol: <?php echo htmlspecialchars($_SESSION["role"]); ?></p>

                    <?php if (!empty($successMessage)): ?>
                    <div class="alert alert-success"><?php echo $successMessage; ?></div>
                    <?php endif; ?>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label for="newUsername">Nuevo nombre de usuario:</label>
                            <input type="text" name="newUsername" id="newUsername" class="form-control"
                                value="<?php echo htmlspecialchars($newUsername); ?>">
                            <span class="text-danger"><?php echo $usernameError; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="newEmail">Nuevo correo electrónico:</label>
                            <input type="text" name="newEmail" id="newEmail" class="form-control"
                                value="<?php echo htmlspecialchars($newEmail); ?>">
                            <span class="text-danger"><?php echo $emailError; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="newPassword">Nueva contraseña:</label>
                            <input type="text" name="newPassword" id="newPassword" class="form-control"
                                value="<?php echo htmlspecialchars($newPassword); ?>">
                            <span class="text-danger"><?php echo $passwordError; ?></span>
                        </div>
                        <button type="submit" name="toggleRole" class="btn btn-secondary">Alternar rol</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
        </div>
    </div>
</body>

</html>
