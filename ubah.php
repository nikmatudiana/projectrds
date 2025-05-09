<?php
$servername = "database-2.cvvheevijzzd.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "admin123";
$dbname = "rds32";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Tangkap parameter nomor dari URL
$nomor = isset($_GET['nomor']) ? intval($_GET['nomor']) : 0;

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $class = $_POST['class'];
    $absent_number = $_POST['absent_number'];
    $photo = $_POST['photo'];

    // Update data siswa
    $stmt = $conn->prepare("UPDATE students SET name=?, class=?, absent_number=?, photo=? WHERE nomor=?");
    $stmt->bind_param("ssisi", $name, $class, $absent_number, $photo, $nomor);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui'); window.location.href='index.php';</script>";
    } else {
        echo "Gagal memperbarui data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit();
}

// Ambil data siswa dari database
$stmt = $conn->prepare("SELECT * FROM students WHERE nomor = ?");
$stmt->bind_param("i", $nomor);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Data tidak ditemukan.";
    exit();
}

$row = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ubah Data Siswa</title>
</head>
<body>
    <h1>Ubah Data Siswa</h1>
    <form method="POST">
        <label>Nama:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required><br><br>

        <label>Kelas:</label><br>
        <input type="text" name="class" value="<?php echo htmlspecialchars($row['class']); ?>" required><br><br>

        <label>Nomor Absen:</label><br>
        <input type="number" name="absent_number" value="<?php echo htmlspecialchars($row['absent_number']); ?>" required><br><br>

        <label>URL Foto:</label><br>
        <input type="text" name="photo" value="<?php echo htmlspecialchars($row['photo']); ?>"><br><br>

        <input type="submit" value="Simpan Perubahan">
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
