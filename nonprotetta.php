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
            background-color: #358dc0;
            color: white;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #60abd6;
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

        // Verifica accesso utente
        if(isset($_SESSION["UTENTE"])) {
            $username = $_SESSION["UTENTE"];
            echo '<h2>Benvenuto, ' . $username . '</h2>';

            // Connessione al database
            $servername = "localhost";
            $username_db = "programma";
            $password = "12345";
            $dbname = "digitalgamestore";
            $conn = new mysqli($servername, $username_db, $password, $dbname);

            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            // Form per selezionare la tabella
            echo '<form action="#" method="post">';
            echo '<div class="form-group">';
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
            echo '</div>';
            echo '<div class="form-group">';
            echo '<input type="submit" value="Visualizza">';
            echo '</div>';
            echo '</form>';

            // Casella di ricerca
            echo '<input type="text" id="searchInput" placeholder="Cerca nella tabella" onkeyup="searchTable()">';

            // Gestione selezione tabella e query
            $tabella = isset($_POST['scelta']) ? $_POST['scelta'] : 'utenti'; // Predefinito
            $sql = "SELECT * FROM $tabella";
            $result = $conn->query($sql);

            // Output tabella
            if ($result->num_rows > 0) {
                echo '<table>';
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

                // Output righe della tabella
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach($row as $value) {
                        echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "Nessun risultato trovato.";
            }

            $conn->close();

            // Logout
            echo '<form action="login.html" method="post"><input type="submit" value="Logout"></form>';
        } else {
            echo "<p>Accesso non consentito</p>";
        }
        ?>
    </div>

    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementsByTagName("table")[0];
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
    </script>
</body>
</html>
