<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VisualizzaDB - Area Riservata</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        input[type="text"],
        input[type="password"],
        input[type="submit"],
        select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #358dc0; /* Colore base */
            color: white;
            border: none;
            cursor: pointer;
            width: calc(50% - 11px); /* Metà della larghezza del container meno il padding */
            transition: background-color 0.3s ease; /* Animazione del cambio di colore */
        }

        input[type="submit"]:hover {
            background-color: #60abd6; /* Colore hover */
        }

        input[type="submit"]:focus {
            outline: none;
        }

        #searchInput {
            margin-bottom: 20px;
        }

        .form-group {
            display: inline-block;
            width: calc(50% - 10px); /* Metà della larghezza del container meno il padding */
            margin-right: 10px;
            vertical-align: top;
        }

        .form-group select {
            width: calc(100% - 10px);
        }
    </style>
</head>
<body>
<div class="container">
<?php
session_start();

// Verifica accesso dell'utente
if(isset($_SESSION["UTENTE"])) {
    $username = $_SESSION["UTENTE"];
    echo '<h2>Benvenuto: ' . $username . '</h2>';

    $servername = "localhost";
    $username_db = "programma";
    $password = "12345";
    $dbname = "digitalgamestore";

    $conn = new mysqli($servername, $username_db, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    echo '<form action="login.html" method="post"><input type="submit" value="Logout"></form>';

    echo '<form action="#" method="post">';
    echo '<select name="scelta">';
    $selectedOption = isset($_POST['scelta']) ? $_POST['scelta'] : 'utenti'; // Imposta predefinito utenti
    $options = array("utenti", "prodotti", "acquisti", "promozioni", "recensioni", "prodotti_promozioni");
    foreach ($options as $option) {
        echo '<option value="' . $option . '"';
        if ($option == $selectedOption) {
            echo ' selected';
        }
        echo '>' . ucfirst($option) . '</option>'; // Converte prima lettera in maiuscolo
    }
    echo '</select>';
    echo '<input type="submit" value="Visualizza">';
    echo '</form>';

    // Casella di ricerca
    echo '<form id="searchForm" action="#" method="post">';
    echo '<input type="text" id="searchInput" placeholder="Cerca nella tabella" onkeyup="searchTable()">';
    echo '</form>';

    // Gestione selezione tabella
    $tabella = isset($_POST['scelta']) ? $_POST['scelta'] : 'utenti'; // Predefinito
    // Query
    $sql = "SELECT * FROM $tabella";
    $result = $conn->query($sql);

    
    if ($result->num_rows > 0) {
        echo '<table border="1" id="dataTable">';
        echo '<tr>';
        switch($tabella) {
            case "utenti":
                echo '<th>Gamertag</th><th>Email</th><th>Password</th><th>Modifica</th>';
                break;
            case "prodotti":
                echo '<th>Prodotto ID</th><th>Nome</th><th>Prezzo</th><th>Categoria</th><th>Sviluppatore</th><th>Pubblicatore</th><th>Modifica</th>';
                break;
            case "acquisti":
                echo '<th>Acquisto ID</th><th>Gamertag</th><th>Prodotto ID</th><th>Importo</th><th>Data Acquisto</th><th>Stato Ordine</th><th>Modifica</th>';
                break;
            case "promozioni":
                echo '<th>ID</th><th>Sconto</th><th>Data Inizio</th><th>Data Fine</th><th>Modifica</th>';
                break;
            case "recensioni":
                echo '<th>ID</th><th>Gamertag</th><th>Prodotto ID</th><th>Valutazione</th><th>Commento</th><th>Data</th><th>Modifica</th>';
                break;
            case "prodotti_promozioni":
                echo '<th>ID Prodotto</th><th>ID Promozione</th><th>Modifica</th>';
                break;
            default:
                echo "Tabella non riconosciuta";
        }
        echo '</tr>';

        // Output
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach($row as $key => $value) {
                echo "<td>".$value."</td>";
            }
            echo '<td><button onclick="popolaModifica('.htmlspecialchars(json_encode($row)).')">Modifica</button></td>';
            echo "</tr>";
        }
        echo "</table>";

        echo "<br>";

        echo '<div id="modifyDiv"></div>';

        echo '<h2>Eliminazione record</h2>';
        // Combobox con prima colonna e pulsante Elimina
        echo '<form id="deleteForm" action="#" method="post">';
        echo '<select id="recordSelect" name="recordToDelete">';
        $result = $conn->query($sql); // Riprende dati
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $firstColumnValue = reset($row); // Prima colonna
                echo '<option value="'.$firstColumnValue.'">'.$firstColumnValue.'</option>';
            }
        } else {
            echo '<option value="">Nessun record disponibile</option>';
        }
        echo '</select>';
        echo '<input type="submit" value="Elimina">';
        echo '</form>';

    } else {
        echo "Nessun risultato trovato.";
    }

    echo '<h2>Aggiungi nuovo elemento</h2>';
    echo '<form id="addForm" action="#" method="post">';
    echo '<input type="hidden" name="tabella" value="' . $tabella . '">'; // Campo nascosto per tabella selezionata
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
            echo 'Prodotto ID: <input type="text" name="prodottoid"><br>';
            echo 'Importo: <input type="number" step="0.01" name="importo"><br>';
            echo 'Data Acquisto: <input type="date" name="dataacquisto"><br>';
            echo 'Stato Ordine: <input type="text" name="statoordine"><br>';
            break;
        case "promozioni":
            echo 'Sconto: <input type="number" step="0.01" name="sconto"><br>';
            echo 'Data Inizio: <input type="date" name="datainizio"><br>';
            echo 'Data Fine: <input type="date" name="datafine"><br>';
            break;
        case "recensioni":
            echo 'Gamertag: <input type="text" name="gamertag"><br>';
            echo 'Prodotto ID: <input type="text" name="prodottoid"><br>';
            echo 'Valutazione: <input type="number" name="valutazione" min="1" max="5"><br>';
            echo 'Commento: <textarea name="commento"></textarea><br>';
            echo 'Data: <input type="date" name="data"><br>';
            break;
        case "prodotti_promozioni":
            echo 'ID Prodotto: <input type="text" name="idprodotto"><br>';
            echo 'ID Promozione: <input type="text" name="idpromozione"><br>';
            break;
        default:
            echo "Tabella non riconosciuta";
    }
    echo '<input type="submit" value="Aggiungi elemento">';
    echo '</form>';

    // Nuovi elementi
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tabella = isset($_POST['tabella']) ? $_POST['tabella'] : ''; // Tabella campo nascosto
        if($tabella !== '') {
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
                    $prodottoid = $_POST['prodottoid'];
                    $importo = $_POST['importo'];
                    $dataacquisto = $_POST['dataacquisto'];
                    $statoordine = $_POST['statoordine'];
    
                    $sql = "INSERT INTO acquisti (gamertag, prodottoid, importo, dataacquisto, statoordine) VALUES ('$gamertag', '$prodottoid', '$importo', '$dataacquisto', '$statoordine')";
                    break;
                case "promozioni":
                    $sconto = $_POST['sconto'];
                    $datainizio = $_POST['datainizio'];
                    $datafine = $_POST['datafine'];
    
                    $sql = "INSERT INTO promozioni (sconto, datainizio, datafine) VALUES ('$sconto', '$datainizio', '$datafine')";
                    break;
                case "recensioni":
                    $gamertag = $_POST['gamertag'];
                    $prodottoid = $_POST['prodottoid'];
                    $valutazione = $_POST['valutazione'];
                    $commento = $_POST['commento'];
                    $data = $_POST['data'];
    
                    $sql = "INSERT INTO recensioni (gamertag, prodottoid, valutazione, commento, data) VALUES ('$gamertag', '$prodottoid', '$valutazione', '$commento', '$data')";
                    break;
                case "prodotti_promozioni":
                    $idprodotto = $_POST['idprodotto'];
                    $idpromozione = $_POST['idpromozione'];
    
                    $sql = "INSERT INTO prodotti_promozioni (idprodotto, idpromozione) VALUES ('$idprodotto', '$idpromozione')";
                    break;
                default:
                    echo "Tabella non riconosciuta";
            }
        } else {
            echo "Tabella non riconosciuta";
        }

        // Inserisci dati nel database
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Nuovo record inserito con successo");</script>';
        } else {
            echo '<script>alert("Errore durante l\'inserimento del record: ' . $conn->error . '");</script>';
        }

    }

    $conn->close();
} else {
    echo "Accesso non consentito";
}
?>

<script>
function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("dataTable");
    tr = table.getElementsByTagName("tr");

    // Ciclo tra le righe di tutte le tabelle, nasconde le non necessarie
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        for (var j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
}

function popolaModifica(rowData) {
    var form = '<h2>Modifica elemento</h2>';
    form += '<form id="modifyForm" action="modifica_record.php" method="post">';
    for (var key in rowData) {
        form += key + ': <input type="text" name="' + key + '" value="' + rowData[key] + '"><br>';
    }
    form += '<input type="hidden" name="id" value="' + rowData['ID'] + '">';
    form += '<input type="hidden" name="tabella" value="' + rowData['tabella'] + '">';
    form += '<input type="hidden" name="modifica" value="true">';
    form += '<input type="submit" value="Modifica elemento">';
    form += '</form>';

    document.getElementById('modifyDiv').innerHTML = form;
}


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
                    location.reload(); // Ricarica la pagina dopo elimina record
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

</div>

</body>
