<html>
<style>
table, th, td {
  border: 1px solid black;
}
</style>
<body>
  <h1>DATA PROFIL SISWA</h1>
  <a href="add.php">Tambah Data</a>
  <table style="width:100%">
    <tr>
      <th>Nomor</th>
      <th>Nama</th>
      <th>Kelas</th>
      <th>Nomor Absen</th>
      <th>Foto</th>
      <th>Aksi</th>
    </tr>
    <?php
    $servername = "database-2.cvvheevijzzd.us-east-1.rds.amazonaws.com";
    $username = "admin";
    $password = "admin123";
    $dbname = "rds32";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT nomor, name, class, absent_number, photo FROM students";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["nomor"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["class"] . "</td>";
            echo "<td>" . $row["absent_number"] . "</td>";
            echo "<td><img src='" . $row["photo"] . "' height='50' width='50'></td>";
            echo "<td>
                    <a href='ubah.php?nomor=" . $row["nomor"] . "'>Ubah</a> | 
                    <a href='hapus.php?nomor=" . $row["nomor"] . "' onclick=\"return confirm('Yakin ingin menghapus data ini?')\">Hapus</a>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Tidak ada data.</td></tr>";
    }

    $conn->close();
    ?>
  </table>
</body>
</html>
