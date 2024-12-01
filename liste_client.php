<?php
include 'config.php';

// Handle search input
$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "  
    SELECT client.*, region.libelle
    FROM client
    JOIN region ON client.ID_region = region.ID_region
    WHERE client.nom LIKE '%$search%' OR client.prenom LIKE '%$search%'
";
$clients = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des Clients</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 300px;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 8px 12px;
            font-size: 14px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        td a {
            text-decoration: none;
            color: #007bff;
        }
        td a:hover {
            text-decoration: underline;
        }
        .add-client-button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .add-client-button:hover {
            background-color: #218838;
        }
    </style>
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
        <?php if ($clients->num_rows > 0): ?>
            <?php while ($client = $clients->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($client['nom']) ?></td>
                    <td><?= htmlspecialchars($client['prenom']) ?></td>
                    <td><?= htmlspecialchars($client['age']) ?></td>
                    <td><?= htmlspecialchars($client['libelle']) ?></td>
                    <td><a href="modifier.php?id=<?= $client['ID_client'] ?>">Modifier</a></td>
                    <td><a href="supprimer.php?id=<?= $client['ID_client'] ?>">Supprimer</a></td>
                </tr>
            <?php endwhile; ?>
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
</body>
</html>
