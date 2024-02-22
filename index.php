<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //recupera le variabili
    $username = $_POST['username'];
    $password = $_POST['password'];


    // Inizializza la variabile per la connessione
    $conn = null;

    try {
        // Tenta di stabilire la connessione al database
        $conn = new mysqli("127.0.0.1", $username, $password, "digitalgamestore");

        // Verifica se la connessione è riuscita
        if ($conn->connect_error) {
            throw new Exception("Connessione al database non riuscita: " . $conn->connect_error);
        }

        // In questo punto, la connessione al database è stata stabilita con successo

        // Variabile per il nome della tabella predefinita
        $selectedTable = isset($_GET['table']) ? $_GET['table'] : "utenti";

        // Query per ottenere gli utenti
        $queryUtenti = "SELECT * FROM utenti";
        $resultUtenti = mysqli_query($conn, $queryUtenti);

        // Query per ottenere i prodotti
        $queryProdotti = "SELECT * FROM prodotti";
        $resultProdotti = mysqli_query($conn, $queryProdotti);

        // Query per ottenere gli acquisti
        $queryAcquisti = "SELECT * FROM acquisti";
        $resultAcquisti = mysqli_query($conn, $queryAcquisti);

        // Query per ottenere le promozioni
        $queryPromozioni = "SELECT * FROM promozioni";
        $resultPromozioni = mysqli_query($conn, $queryPromozioni);

        // Query per ottenere le recensioni
        $queryRecensioni = "SELECT * FROM recensioni";
        $resultRecensioni = mysqli_query($conn, $queryRecensioni);

    } catch (Exception $e) {
        // Se si verifica un errore durante la connessione o l'esecuzione delle query
        echo "Si è verificato un errore: " . $e->getMessage();

        // Chiudi la connessione se è stata aperta
        if ($conn !== null) {
            $conn->close();
        }
        // Termina l'esecuzione dello script
        exit();
    }

    // Continua l'esecuzione dello script qui...

    // Ricorda di chiudere la connessione quando non è più necessaria
    $conn->close();


    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizzazione Dati</title>
    <link rel="stylesheet" href="style.css">
    <!-- visualizza tabelle -->
    <script>
    function showTable(table) {
        //nascondi button ricerca
        document.getElementById('searchButton').style.display = 'none';

        //nascondi tabelle
        var tables = document.getElementsByClassName('data-table');
        for (var i = 0; i < tables.length; i++) {
            tables[i].style.display = 'none';
        }

        //mostra tabella selezionata
        document.getElementById(table).style.display = 'table';

        //mostra pulsante ricerca
        document.getElementById('searchButton').style.display = 'block';

        var selectBox = document.getElementById('searchColumn');
        selectBox.innerHTML = ''; // Svuota la combobox

        switch (table) {
            case 'utenti':
                addOption(selectBox, "Gamertag");
                addOption(selectBox, "Email");
                break;
            case 'prodotti':
                addOption(selectBox, "Nome prodotto");
                addOption(selectBox, "Prezzo");
                addOption(selectBox, "Categoria");
                break;
            case 'acquisti':
                addOption(selectBox, "Gamertag");
                addOption(selectBox, "Importo");
                break;
            case 'promozioni':
                addOption(selectBox, "Sconto");
                break;
            case 'recensioni':
                addOption(selectBox, "Gamertag");
                addOption(selectBox, "Valutazione");
                addOption(selectBox, "Commento");
                break;
            default:
                break;
        }
    }

    function addOption(selectBox, text) {
        var option = document.createElement("option");
        option.text = text;
        selectBox.add(option);
    }

    function handleKeyPress(event) {
        if (event.key === "Enter") {
            var searchInput = document.getElementById('searchInput');
            var searchColumn = document.getElementById('searchColumn').value;
            var selectedTable = '<?php echo $selectedTable; ?>Table';
            searchByColumn(searchInput, searchColumn, selectedTable);
        }
    }

    // onload carica la tabella selezionata
    window.onload = function() {
        showTable('<?php echo $selectedTable; ?>');
    };
    </script>

    <!-- cerca -->
    <script>
    function searchByColumn(input, columnName, tableId) {
        var inputText = input.value.toLowerCase();
        var table = document.getElementById(tableId);
        var rows = table.getElementsByTagName('tr');

        for (var i = 1; i < rows.length; i++) { // da 1 per evitare l'header della tabella
            var columnIndex;

            switch (tableId) {
                case 'utentiTable':
                    columnIndex = (columnName === 'Email') ? 1 : 0;
                    break;
                case 'prodottiTable':
                    if (columnName === 'Prezzo') {
                        columnIndex = 2; // La colonna 'Prezzo' è la terza colonna
                    } else if (columnName === 'Categoria') {
                        columnIndex = 3; // La colonna 'Categoria' è la quarta colonna
                    } else {
                        columnIndex = 1; // Se non è Prezzo o Categoria, assume 'Nome prodotto' (seconda colonna)
                    }
                    break;
                case 'acquistiTable':
                    if (columnName === 'Importo') {
                        columnIndex = 3; // La colonna 'Importo' è la quarta colonna
                    } else {
                        columnIndex = 1; // Se non è Importo, assume 'Gamertag' (seconda colonna)
                    }
                    break;
                case 'promozioniTable':
                    columnIndex = (columnName === 'Sconto') ? 2 : 1;
                    break;
                case 'recensioniTable':
                    if (columnName === 'Valutazione') {
                        columnIndex = 3; // La colonna 'Valutazione' è la quarta colonna
                    } else if (columnName === 'Commento') {
                        columnIndex = 4; // La colonna 'Commento' è la quinta colonna
                    } else {
                        columnIndex = 1; // Se non è Valutazione o Commento, assume 'Gamertag' (seconda colonna)
                    }
                    break;
                default:
                    columnIndex = 0;
            }

            var columnText = rows[i].getElementsByTagName('td')[columnIndex].innerText.toLowerCase();

            if (columnText.includes(inputText)) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
    </script>
</head>
<body>
<p><?php echo "Messaggio di errore: " ?></p>
    <button onclick="goBack()">Torna indietro</button>

    <nav>
        <button onclick="showTable('utenti')">Utenti</button>
        <button onclick="showTable('prodotti')">Prodotti</button>
        <button onclick="showTable('acquisti')">Acquisti</button>
        <button onclick="showTable('promozioni')">Promozioni</button>
        <button onclick="showTable('recensioni')">Recensioni</button>
    </nav>

    <h4>Ricerca</h4>

    <!-- Combobox per la ricerca -->
    <select id="searchColumn"></select>
    
    <input type="text" id="searchInput" placeholder="Inserisci testo" onkeypress="handleKeyPress(event)">
    <button id="searchButton" onclick="searchByColumn(document.getElementById('searchInput'), document.getElementById('searchColumn').value, '<?php echo $selectedTable; ?>Table')">Cerca</button>

    <!-- tabelle -->
    <div id="utenti" class="data-table" style="display: none;">
        <h2>Dati Utenti</h2>
        <table id="utentiTable">
            <tr><th>Gamertag</th><th>Email</th><th>Password</th></tr>
            <?php
                while ($row = mysqli_fetch_assoc($resultUtenti)) {
                    echo "<tr><td>" . $row['gamertag'] . "</td><td>" . $row['email'] . "</td><td>" . $row['password'] . "</td></tr>";
                }
            ?>
        </table>
    </div>

    <div id="prodotti" class="data-table" style="display: none;">
    <h2>Dati Prodotti</h2>
        <table id="prodottiTable">
        <tr>
            <th>ID Prodotto</th>
            <th>Nome Prodotto</th>
            <th>Prezzo</th>
            <th>Categoria</th>
            <th>Sviluppatore</th>
            <th>Pubblicatore</th>
        </tr>
        <?php
            while ($row = mysqli_fetch_assoc($resultProdotti)) {
                echo "<tr>
                        <td>" . $row['prodottoid'] . "</td>
                        <td>" . $row['nome'] . "</td>
                        <td>" . $row['prezzo'] . "</td>
                        <td>" . $row['categoria'] . "</td>
                        <td>" . $row['sviluppatore'] . "</td>
                        <td>" . $row['pubblicatore'] . "</td>
                      </tr>";
            }
        ?>
        </table>
    </div>

    <div id="acquisti" class="data-table" style="display: none;">
    <h2>Dati Acquisti</h2>
        <table id="acquistiTable">
        <tr>
            <th>ID Acquisto</th>
            <th>Gamertag</th>
            <th>ID Prodotto</th>
            <th>Importo</th>
            <th>Data Acquisto</th>
            <th>Stato Ordine</th>
        </tr>
        <?php
            while ($row = mysqli_fetch_assoc($resultAcquisti)) {
                echo "<tr>
                        <td>" . $row['acquistoid'] . "</td>
                        <td>" . $row['gamertag'] . "</td>
                        <td>" . $row['prodottoid'] . "</td>
                        <td>" . $row['importo'] . "</td>
                        <td>" . $row['dataacquisto'] . "</td>
                        <td>" . $row['statoordine'] . "</td>
                      </tr>";
            }
        ?>
        </table>
    </div>

    <div id="promozioni" class="data-table" style="display: none;">
    <h2>Dati Promozioni</h2>
        <table id="promozioniTable">
        <tr>
            <th>Promozione ID</th>
            <th>Prodotto ID</th>
            <th>Sconto</th>
            <th>Data Inizio</th>
            <th>Data Fine</th>
        </tr>
        <?php
            while ($row = mysqli_fetch_assoc($resultPromozioni)) {
                echo "<tr>
                        <td>" . $row['promozioneid'] . "</td>
                        <td>" . $row['prodottoid'] . "</td>
                        <td>" . $row['sconto'] . "</td>
                        <td>" . $row['datainizio'] . "</td>
                        <td>" . $row['datafine'] . "</td>
                      </tr>";
            }
        ?>
        </table>
    </div>

    <div id="recensioni" class="data-table" style="display: none;">
    <h2>Dati Recensioni</h2>
        <table id="recensioniTable">
        <tr>
            <th>ID</th>
            <th>Gamertag</th>
            <th>Prodotto ID</th>
            <th>Valutazione</th>
            <th>Commento</th>
            <th>Data</th>
        </tr>
        <?php
            while ($row = mysqli_fetch_assoc($resultRecensioni)) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['gamertag'] . "</td>
                        <td>" . $row['prodottoid'] . "</td>
                        <td>" . $row['valutazione'] . "</td>
                        <td>" . $row['commento'] . "</td>
                        <td>" . $row['data'] . "</td>
                      </tr>";
            }
        ?>
        </table>
    </div>


</body>
</html>
