<?php
include 'config.php';
$id = $_GET['id'];

// Use a prepared statement to delete the client securely
$stmt = $conn->prepare("DELETE FROM client WHERE ID_client = :id");
$stmt->execute(['id' => $id]);

header('Location: liste_client.php');
exit;
?>
