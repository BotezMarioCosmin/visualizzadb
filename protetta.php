<?php
session_start();

//verifica utente accesso
if(isset($_SESSION["UTENTE"])) {
    echo "Benvenuto: ";
    $username = $_SESSION["UTENTE"];

    $servername = "localhost";
    $username_db = "programma";
    $password = "12345";
    $dbname = "digitalgamestore";

    $conn = new mysqli($servername, $username_db, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    //privilegi utente
    $sql = "SELECT admin FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row['admin'] == 1) {
            echo $username . '  (  ' . ' <input type="text" id="textboxadmin" value="admin" readonly>' . '  )  ';

        } else {
            echo $username . '  (  ' . ' <input type="text" id="textboxadmin" value="visualizzatore" readonly>' . '  )  ';
        }
    }

    echo '<form action="index.html" method="post"><input type="submit" value="Logout"></form>';


    echo '<form action="#" method="post">';
    echo '<select name="scelta">';
    $selectedOption = isset($_POST['scelta']) ? $_POST['scelta'] : 'utenti'; // Imposta predefinito utenti
    $options = array("utenti", "prodotti", "acquisti", "promozioni", "recensioni", "prodotti_promozioni");
    foreach ($options as $option) {
        echo '<option value="' . $option . '"';
        if ($option == $selectedOption) {
            echo ' selected';
        }
        echo '>' . ucfirst($option) . '</option>'; //converte prima lettera in maiuscolo
    }
    echo '</select>';
    echo '<input type="submit" value="Visualizza">';
    echo '</form>';

    //casella ricerca
    echo '<form id="searchForm" action="#" method="post">';
    echo '<input type="text" id="searchInput" placeholder="Cerca nella tabella" onkeyup="searchTable()">';
    echo '</form>';

    //gestione selezione tabella
    $tabella = isset($_POST['scelta']) ? $_POST['scelta'] : 'utenti'; //predefinito
    //query
    $sql = "SELECT * FROM $tabella";
    $result = $conn->query($sql);

    
    if ($result->num_rows > 0) {
        echo '<table border="1" id="dataTable">';
        echo '<tr>';
        switch($tabella) {
            case "utenti":
                echo '<th>Gamertag</th><th>Email</th><th>Password</th>';
                break;
            case "prodotti":
                echo '<th>Prodotto ID</th><th>Nome</th><th>Prezzo</th><th>Categoria</th><th>Sviluppatore</th><th>Pubblicatore</th>';
                break;
            case "acquisti":
                echo '<th>Acquisto ID</th><th>Gamertag</th><th>Prodotto ID</th><th>Importo</th><th>Data Acquisto</th><th>Stato Ordine</th>';
                break;
            case "promozioni":
                echo '<th>ID</th><th>Sconto</th><th>Data Inizio</th><th>Data Fine</th>';
                break;
            case "recensioni":
                echo '<th>ID</th><th>Gamertag</th><th>Prodotto ID</th><th>Valutazione</th><th>Commento</th><th>Data</th>';
                break;
            case "prodotti_promozioni":
                echo '<th>ID Prodotto</th><th>ID Promozione</th>';
                break;
            default:
                echo "Tabella non riconosciuta";
        }
        echo '</tr>';

        //output
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach($row as $key => $value) {
                echo "<td>".$value."</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        echo "<br>";

        echo '<h2>Elimina elemento</h2>';

        //combobox con prima colonna
        echo '<select id="recordSelect">';
        $result = $conn->query($sql); //riprende dati
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $firstColumnValue = reset($row); //prima colonna
                echo '<option value="'.$firstColumnValue.'">'.$firstColumnValue.'</option>';
            }
        } else {
            echo '<option value="">Nessun record disponibile</option>';
        }
        echo '</select>';
        echo '<button onclick="eliminaRecord(\''.$tabella.'\')">Elimina</button>';

    } else {
        echo "Nessun risultato trovato.";
    }

    echo '<h2>Aggiungi nuovo elemento</h2>';
    echo '<form action="#" method="post">';
    echo '<input type="hidden" name="tabella" value="' . $tabella . '">'; //campo nascosto per tabella selez
    switch($tabella) {
        case "utenti":
            echo 'Gamertag: <input type="text" name="gamertag"><br>';
            echo 'Email: <input type="email" name="email"><br>';
            echo 'Password: <input type="password" name="password"><br>';
            break;
        case "prodotti":
            echo 'Nome: <input type="text" name="nome"><br>';
            echo 'Prezzo: <input type="number" step="0.01" name="prezzo"><br>';
            echo 'Categoria: <input type="text" name="categoria"><br>';
            echo 'Sviluppatore: <input type="text" name="sviluppatore"><br>';
            echo 'Pubblicatore: <input type="text" name="pubblicatore"><br>';
            break;
        case "acquisti":
            echo 'Gamertag: <input type="text" name="gamertag"><br>';
            echo 'Prodotto ID: <input type="text" name="prodotto_id"><br>';
            echo 'Importo: <input type="number" step="0.01" name="importo"><br>';
            echo 'Data Acquisto: <input type="date" name="data_acquisto"><br>';
            echo 'Stato Ordine: <input type="text" name="stato_ordine"><br>';
            break;
        case "promozioni":
            echo 'Sconto: <input type="number" step="0.01" name="sconto"><br>';
            echo 'Data Inizio: <input type="date" name="data_inizio"><br>';
            echo 'Data Fine: <input type="date" name="data_fine"><br>';
            break;
        case "recensioni":
            echo 'Gamertag: <input type="text" name="gamertag"><br>';
            echo 'Prodotto ID: <input type="text" name="prodotto_id"><br>';
            echo 'Valutazione: <input type="number" name="valutazione" min="1" max="5"><br>';
            echo 'Commento: <textarea name="commento"></textarea><br>';
            echo 'Data: <input type="date" name="data"><br>';
            break;
        case "prodotti_promozioni":
            echo 'ID Prodotto: <input type="text" name="id_prodotto"><br>';
            echo 'ID Promozione: <input type="text" name="id_promozione"><br>';
            break;
        default:
            echo "Tabella non riconosciuta";
    }
    echo '<input type="submit" value="Aggiungi elemento">';
    echo '</form>';

    //nuovi element
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tabella = $_POST['tabella']; //tabella campo nascosto
        switch($tabella) {
            case "utenti":
                $gamertag = $_POST['gamertag'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                $sql = "INSERT INTO utenti (gamertag, email, password) VALUES ('$gamertag', '$email', '$password')";
                break;
            case "prodotti":
                $nome = $_POST['nome'];
                $prezzo = $_POST['prezzo'];
                $categoria = $_POST['categoria'];
                $sviluppatore = $_POST['sviluppatore'];
                $pubblicatore = $_POST['pubblicatore'];

                $sql = "INSERT INTO prodotti (nome, prezzo, categoria, sviluppatore, pubblicatore) VALUES ('$nome', '$prezzo', '$categoria', '$sviluppatore', '$pubblicatore')";
                break;
            case "acquisti":
                $gamertag = $_POST['gamertag'];
                $prodotto_id = $_POST['prodottoid'];
                $importo = $_POST['importo'];
                $data_acquisto = $_POST['dataacquisto'];
                $stato_ordine = $_POST['statoordine'];

                $sql = "INSERT INTO acquisti (gamertag, prodottoid, importo, dataacquisto, statoordine) VALUES ('$gamertag', '$prodotto_id', '$importo', '$data_acquisto', '$stato_ordine')";
                break;
            case "promozioni":
                $sconto = $_POST['sconto'];
                $data_inizio = $_POST['datainizio'];
                $data_fine = $_POST['datafine'];

                $sql = "INSERT INTO promozioni (sconto, datainizio, datafine) VALUES ('$sconto', '$data_inizio', '$data_fine')";
                break;
            case "recensioni":
                $gamertag = $_POST['gamertag'];
                $prodotto_id = $_POST['prodottoid'];
                $valutazione = $_POST['valutazione'];
                $commento = $_POST['commento'];
                $data = $_POST['data'];

                $sql = "INSERT INTO recensioni (gamertag, prodottoid, valutazione, commento, data) VALUES ('$gamertag', '$prodotto_id', '$valutazione', '$commento', '$data')";
                break;
            case "prodotti_promozioni":
                $id_prodotto = $_POST['idprodotto'];
                $id_promozione = $_POST['idpromozione'];

                $sql = "INSERT INTO prodotti_promozioni (idprodotto, idpromozione) VALUES ('$id_prodotto', '$id_promozione')";
                break;
            default:
                echo "Tabella non riconosciuta";
        }
        
        //inserisci dati db
        if ($conn->query($sql) === TRUE) {
            echo "Nuovo record inserito con successo";
        } else {
            echo "Errore durante l'inserimento del record: " . $conn->error;
        }
    }

    $conn->close();
} else {
    echo "Accesso non consentito";
}
?>

<script>
function eliminaRecord(tabella) {
    var recordSelect = document.getElementById('recordSelect');
    var recordId = recordSelect.value;
    if (recordId !== '') {
        if (confirm('Sei sicuro di voler eliminare questo record?')) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'elimina_record.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert('Record eliminato con successo');
                    location.reload(); //ricarica la pagina dopo elimina record
                } else {
                    alert('Errore durante l\'eliminazione del record');
                }
            };
            xhr.send('tabella=' + tabella + '&recordId=' + recordId);
        }
    } else {
        alert('Seleziona un record da eliminare');
    }
}
</script>
