<?php
$host = 'localhost';
$db = 'paie';
$user = 'root';
$pass = '';

$conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_employe = $_POST['id_employe'];
    $date_paiement = $_POST['date_paiement'];
    $montant = $_POST['montant'];

    $stmt = $conn->prepare("INSERT INTO Paiements (ID_Employe, Date_Paiement, Montant) VALUES (?, ?, ?)");
    $stmt->execute([$id_employe, $date_paiement, $montant]);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion de la Paie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eaf0f6;
            padding: 40px;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 0 10px #ccc;
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        form {
            margin-bottom: 30px;
        }
        select, input, button {
            padding: 10px;
            width: calc(100% - 24px);
            margin: 10px auto;
            display: block;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background: #28a745;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }
        table th {
            background: #007BFF;
            color: white;
        }
        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #007BFF;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Gestion de la Paie</h1>

    <form method="POST">
        <select name="id_employe" required>
            <option value="">-- Choisir un employé --</option>
            <?php
            $employes = $conn->query("SELECT * FROM Employes");
            foreach ($employes as $emp) {
                echo "<option value='{$emp['ID']}'>{$emp['Nom']} </option>";
            }
            ?>
        </select>

        <input type="date" name="date_paiement" required>
        <input type="number" step="0.01" name="montant" placeholder="Montant (€)" required>
        <button type="submit">Enregistrer le paiement</button>
    </form>

    <h2>Historique des Paiements</h2>
    <table>
        <tr>
            <th>Employé</th>
            <th>Date de Paiement</th>
            <th>Montant</th>
        </tr>
        <?php
        $paiements = $conn->query("
            SELECT P.Date_Paiement, P.Montant, E.Nom 
            FROM Paiements P 
            JOIN Employes E ON P.ID_Employe = E.ID
            ORDER BY P.Date_Paiement DESC
        ");
        foreach ($paiements as $p) {
            echo "<tr>
                    <td>{$p['Nom']}</td>
                    <td>{$p['Date_Paiement']}</td>
                    <td>{$p['Montant']} €</td>
                  </tr>";
        }
        ?>
    </table>
    <a href="ajout_employe.php">➕ Ajouter un nouvel employé</a>
</div>
</body>
</html>
