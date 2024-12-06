<?php
// config.php
$servername = "tcp:min-proj-server.database.windows.net,1433";
$username = "min-proj-user";
$password = "Molka$2002";
$dbname = "db1";
//$conn = new PDO("sqlsrv:server =$servername; Database =$dbname;Encrypt=true;TrustServerCertificate=false",$username, $password);
try {
    $conn = new PDO("sqlsrv:server=$servername;Database=$dbname;Encrypt=true;TrustServerCertificate=false", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>


