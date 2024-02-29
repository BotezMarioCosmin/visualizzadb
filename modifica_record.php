<?php
session_start();

if(isset($_SESSION["UTENTE"])) {
    $servername = "localhost";
    $username_db = "programma";
    $password = "12345";
    $dbname = "digitalgamestore";

    $conn = new mysqli($servername, $username_db, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifica'])) {
        $tabella = $_POST['tabella'];
        $id = $_POST['id']; //id
        unset($_POST['modifica']);
        unset($_POST['tabella']); //rimuove il campo

        //pk
        $primaryKey = '';

        switch ($tabella) {
            case 'utenti':
                $primaryKey = 'gamertag';
                break;
            case 'prodotti':
                $primaryKey = 'prodottoid';
                break;
            case 'acquisti':
                $primaryKey = 'acquistoid';
                break;
            case 'promozioni':
            case 'recensioni':
                $primaryKey = 'id';
                break;
            case 'prodotti_promozioni':
                $primaryKey = 'idprodotto';
                break;
            default:
                echo "<script>alert('Errore: Tabella non riconosciuta');</script>";
                //header("Location: protetta.php");   
            
                exit;
        }

        //
        $sql = "UPDATE $tabella SET ";
        foreach ($_POST as $key => $value) {
            //aggiorna pk
            if ($key !== $primaryKey) {
                $sql .= "$key = '$value', ";
            }
        }
        $sql = rtrim($sql, ", "); //rimuove virgola e spaz
        $sql .= " WHERE $primaryKey = '$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Record aggiornato con successo";
        } else {
            echo "Errore durante l'aggiornamento del record: " . $conn->error;

        }
    } else {
        echo "Richiesta non valida";
    }

    $conn->close();
} else {
    echo "Accesso non consentito";
}
?>
