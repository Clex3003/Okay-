<?php
$host = 'localhost';
$db = 'paie';
$user = 'root';
$pass = '';

// Connexion à la base de données
$conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];

    $stmt = $conn->prepare("INSERT INTO Employes (Nom) VALUES (?)");
    $stmt->execute([$nom]);

    $message = "✅ Employé ajouté avec succès !";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Employé</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 40px;
        }
        .container {
            background: #fff;
            border-radius: 8px;
            padding: 30px;
            width: 400px;
            margin: auto;
            box-shadow: 0 0 10px #ccc;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #007BFF;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .message {
            color: green;
            text-align: center;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Ajouter un Employé</h1>
    <?php if ($message): ?>
        <p class="message"><?= $message ?></p>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="nom" placeholder="Nom de l'employé" required>
        <button type="submit">Ajouter</button>
    </form>
    <a href="index.php">← Retour à la gestion de la paie</a>
</div>
</body>
</html>
