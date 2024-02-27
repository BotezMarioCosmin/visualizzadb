<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tabella"]) && isset($_POST["recordId"])) {

    $servername = "localhost";
    $username_db = "programma";
    $password = "12345";
    $dbname = "digitalgamestore";

    $conn = new mysqli($servername, $username_db, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    //dati richiesta
    $tabella = $_POST["tabella"];
    $recordId = $_POST["recordId"];

    //query per elimin
    switch ($tabella) {
        case "promozioni":
        case "recensioni":
            $sql = "DELETE FROM $tabella WHERE ID = '$recordId'";
            break;
        case "utenti":
            $sql = "DELETE FROM $tabella WHERE Gamertag = '$recordId'";
            break;
        case "prodotti":
            $sql = "DELETE FROM $tabella WHERE ProdottoID = '$recordId'";
            break;
        case "acquisti":
            $sql = "DELETE FROM $tabella WHERE AcquistoID = '$recordId'";
            break;
        case "prodotti_promozioni":
            $sql = "DELETE FROM $tabella WHERE IDProdotto = '$recordId'";
            break;
        default:
            //per errore
            http_response_code(400);
            echo "Errore: Tabella non supportata.";
            exit();
    }

    //query elim
    if ($conn->query($sql) === TRUE) {
        //success
        http_response_code(200);
        echo "Record eliminato con successo.";
    } else {
        //errore
        http_response_code(500);
        echo "Errore durante l'eliminazione del record: " . $conn->error;
    }

    $conn->close();
} else {
    http_response_code(400);
    echo "Errore: Parametri mancanti.";
}
?>
