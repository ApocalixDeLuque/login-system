<?php
define('DB_SERVER', 'db');
define('DB_USERNAME', 'user');
define('DB_PASSWORD', 'root1234');
define('DB_NAME', 'logindb');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>