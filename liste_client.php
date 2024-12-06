<?php
include 'config.php';

// Handle search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare the query with placeholders
$query = "  
    SELECT client.*, region.libelle
    FROM client
    JOIN region ON client.ID_region = region.ID_region
    WHERE client.nom LIKE ? OR client.prenom LIKE ?
";

// Prepare the query
$stmt = $conn->prepare($query);

// Use wildcards for LIKE search
$searchTerm = "%$search%";
$stmt->bindValue(1, $searchTerm, PDO::PARAM_STR);
$stmt->bindValue(2, $searchTerm, PDO::PARAM_STR);

// Execute the query and handle potential errors
try {
    $stmt->execute();
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
    $clients = []; // Set clients to an empty array on failure
}

// Debugging - check the SQL query
//echo "<pre>";
//print_r($clients);
//echo "</pre>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des Clients</title>
    <link rel="stylesheet" href="styles/listeClient.css">
</head>
<body>
    <h1>Liste des Clients</h1>
    
    <!-- Search Form -->
    <form method="GET">
        <input type="text" name="search" placeholder="Rechercher un client..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Rechercher</button>
    </form>
    
    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Âge</th>
            <th>Région</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        <?php if (!empty($clients)): ?>
            <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= htmlspecialchars($client['nom']) ?></td>
                    <td><?= htmlspecialchars($client['prenom']) ?></td>
                    <td><?= htmlspecialchars($client['age']) ?></td>
                    <td><?= htmlspecialchars($client['libelle']) ?></td>
                    <td><a href="modifier.php?id=<?= $client['ID_client'] ?>">Modifier</a></td>
                    <td><a href="supprimer.php?id=<?= $client['ID_client'] ?>">Supprimer</a></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align: center;">Aucun client trouvé.</td>
            </tr>
        <?php endif; ?>
    </table>

    <!-- Add Client Button -->
    <a href="ajout_client.php">
        <button class="add-client-button">Ajouter un client</button>
    </a>
    <!-- Return Button -->
    <a class="return-btn" href="index.php">Return to Home</a>
</body>
</html>
