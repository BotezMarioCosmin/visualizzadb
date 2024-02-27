<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VisualizzaDB - Registrazione</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Registrati</h2>
    <form action="gestioneregistrazione.php" method="post">
        <label for="new_username">Username:</label><br>
        <input type="text" id="new_username" name="new_username" required><br><br>
        <label for="new_password">Password:</label><br>
        <input type="password" id="new_password" name="new_password" required><br><br>
        <input type="submit" name="register" value="Registrati">
    </form>
</body>
</html>
