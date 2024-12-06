<?php
// Database connection
include 'config.php';
// Fetch regions
$stmt = $conn->query("SELECT * FROM region");
$regions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des Régions</title>
    <link rel="stylesheet" href="styles/listeRegion.css">

</head>
<body>
    <h1>Liste des Régions</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Libelle</th>
        </tr>
        <?php foreach ($regions as $region): ?>
            <tr>
                <td><?= htmlspecialchars($region['ID_region']) ?></td>
                <td><?= htmlspecialchars($region['libelle']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    
    <!-- Return Button -->
    <a class="return-btn" href="index.php">Return to Home</a>
</body>
</html>
