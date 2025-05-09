<?php
$servername = "database-2.cvvheevijzzd.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "admin123";
$dbname = "rds32";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nomor = $_GET['nomor'] ?? null;

if ($nomor && is_numeric($nomor)) {
    $sql = "DELETE FROM students WHERE nomor = " . intval($nomor);
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record deleted successfully'); window.location.href='index.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "ID tidak valid.";
}

$conn->close();
?>
