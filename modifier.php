<?php
include 'config.php';
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $ID_region = $_POST['ID_region'];

    $conn->query("
        UPDATE client
        SET nom = '$nom', prenom = '$prenom', age = $age, ID_region = $ID_region
        WHERE ID_client = $id
    ");
    header('Location: liste_client.php');
}

$client = $conn->query("SELECT * FROM client WHERE ID_client = $id")->fetch_assoc();
$regions = $conn->query("SELECT * FROM region");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un client</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            border: 2px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 14px;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        button {
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .return-button {
            background-color: #6c757d;
            color: white;
        }
        .return-button:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h1>Modifier un client</h1>
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($client['nom']) ?>" required>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($client['prenom']) ?>" required>

        <label for="age">Âge:</label>
        <input type="number" id="age" name="age" value="<?= htmlspecialchars($client['age']) ?>" required>

        <label for="ID_region">Région:</label>
        <select id="ID_region" name="ID_region" required>
            <?php while ($region = $regions->fetch_assoc()): ?>
                <option value="<?= $region['ID_region'] ?>" <?= $client['ID_region'] == $region['ID_region'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($region['libelle']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Modifier</button>
        <a href="liste_client.php" style="text-decoration: none;">
            <button type="button" class="return-button">Retour</button>
        </a>
    </form>
</body>
</html>
