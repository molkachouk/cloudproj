<?php
// Database connection
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $ID_region = $_POST['ID_region'];

    // Check if the client already exists
    $checkQuery = "SELECT * FROM client WHERE nom = '$nom' AND prenom = '$prenom'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // Display an error message if the client already exists
        echo "<script>alert('Le client avec le même nom et prénom existe déjà.');</script>";
    } else {
        // Insert the new client
        $sql = "INSERT INTO client (nom, prenom, age, ID_region) VALUES ('$nom', '$prenom', $age, $ID_region)";
        $conn->query($sql);
        header('Location: liste_client.php');
    }
}

// Fetch regions for the dropdown
$regions = $conn->query("SELECT * FROM region");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un client</title>
    <link rel="stylesheet" href="styles/ajoutClient.css">
</head>
<body>
    <form method="POST">
        <h1>Ajouter un client</h1>
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="age">Âge:</label>
        <input type="number" id="age" name="age" required>

        <label for="ID_region">Région:</label>
        <select id="ID_region" name="ID_region" required>
            <?php while ($region = $regions->fetch_assoc()): ?>
                <option value="<?= $region['ID_region'] ?>"><?= $region['libelle'] ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Ajouter</button>

        <!-- New Button for "Liste des Clients" -->
        <button type="button" onclick="window.location.href='liste_client.php'">Liste des Clients</button>
        </a>
    <!-- Return Button -->
    <a class="return-btn" href="index.php">Return to Home</a>
    </form>
</body>
</html>
