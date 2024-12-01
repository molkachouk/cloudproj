<?php
include 'config.php';
$id = $_GET['id'];

$conn->query("DELETE FROM client WHERE ID_client = $id");
header('Location: liste_client.php');
?>
