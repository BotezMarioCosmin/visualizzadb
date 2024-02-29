<?php
session_start();
$name = $_POST['username'];
$password = $_POST['password'];

$servername = "localhost";
$db_username = "programma";
$db_password = "12345";
$dbname = "digitalgamestore";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE username='$name' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $_SESSION["UTENTE"] = $name;
    header("location:protetta.php");
    exit();
} else {
    unset($_SESSION["UTENTE"]);
    echo "Non autenticato";
}

$conn->close();
