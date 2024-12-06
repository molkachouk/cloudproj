<?php
// Database connection
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $ID_region = $_POST['ID_region'];

   // Check if the client already exists (Prepared Statement)
   $stmt = $conn->prepare("SELECT COUNT(*) FROM client WHERE nom = :nom AND prenom = :prenom");
   $stmt->execute(['nom' => $nom, 'prenom' => $prenom]);
   $clientExists = $stmt->fetchColumn() > 0;

   if ($clientExists) {
       // Display an error message if the client already exists
       echo "<script>alert('Le client avec le même nom et prénom existe déjà.');</script>";
   } else {
       // Insert the new client (Prepared Statement)
       $insertStmt = $conn->prepare("INSERT INTO client (nom, prenom, age, ID_region) VALUES (:nom, :prenom, :age, :ID_region)");
       $insertStmt->execute([
           'nom' => $nom,
           'prenom' => $prenom,
           'age' => $age,
           'ID_region' => $ID_region,
       ]);

       // Redirect to the list of clients
       header('Location: liste_client.php');
       exit;
   }
}

// Fetch regions for the dropdown (Prepared Statement)
$regionsStmt = $conn->query("SELECT * FROM region");
$regions = $regionsStmt->fetchAll(PDO::FETCH_ASSOC);
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
            <?php foreach ($regions as $region): ?>
                <option value="<?= $region['ID_region'] ?>"><?= $region['libelle'] ?></option>
            <?php endforeach; ?>
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
