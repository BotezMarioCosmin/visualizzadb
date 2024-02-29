<?php
session_start();

$servername = "localhost";
$username_db = "programma";
$password_db = "12345";
$dbname = "digitalgamestore";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

//registraz
if(isset($_POST['register'])) {
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];

    //query per controllo utente esistente
    $check_sql = "SELECT * FROM users WHERE username='$new_username'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "Utente già esistente.";
        echo '<br><a href="login.html">Torna alla pagina di login</a>';
    } else {
        //inserisce nuovo utente
        $sql = "INSERT INTO users (username, password) VALUES ('$new_username', '$new_password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registrazione effettuata con successo. Ora puoi effettuare il login.";
            echo '<br><a href="login.html">Torna alla pagina di login</a>';
        } else {
            echo "Errore durante la registrazione: " . $conn->error;
        }
    }
}

$conn->close();
?>
