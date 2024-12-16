<?php
// Menghubungkan ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb-responsi";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengambil nilai yang diinputkan dari form dan mencegah SQL Injection
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$desa = mysqli_real_escape_string($conn, $_POST['desa']);
$kecamatan = mysqli_real_escape_string($conn, $_POST['kecamatan']);
$latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
$longitude = mysqli_real_escape_string($conn, $_POST['longitude']);

// Query untuk memasukkan data ke tabel
$sql = "INSERT INTO pantairembangg (nama, desa, kecamatan, latitude, longitude) 
        VALUES ('$nama', '$desa', '$kecamatan', '$latitude', '$longitude')";

// Eksekusi query
if ($conn->query($sql) === TRUE) {
    echo "Data berhasil ditambahkan";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Menutup koneksi
$conn->close();
?>
