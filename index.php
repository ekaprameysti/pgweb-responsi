<?php
// Sesuaikan dengan setting MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pgweb-responsi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Proses hapus data jika parameter id ada di URL
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM pantairembangg WHERE id = $delete_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "Data berhasil dihapus.";
    } else {
        echo "Error menghapus data: " . $conn->error;
    }
}

// Proses edit data jika parameter edit_id ada di POST
if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $nama = $_POST['nama'];
    $desa = $_POST['desa'];
    $kecamatan = $_POST['kecamatan'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $edit_sql = "UPDATE pantairembangg SET nama='$nama', desa='$desa', kecamatan='$kecamatan', latitude='$latitude', longitude='$longitude' WHERE id=$edit_id";
    if ($conn->query($edit_sql) === TRUE) {
        echo "Data berhasil diupdate.";
    } else {
        echo "Error mengupdate data: " . $conn->error;
    }
}

// Menampilkan data dari tabel
$sql = "SELECT * FROM pantairembangg";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table style='width: 50%; border-collapse: collapse; margin: 20px auto; font-size: 15px; text-align: left; border: 1px solid black;'>
            <thead>
                <tr style='background-color: blue; color: white;'>
                    <th style='border: 1px solid black; padding: 12px; text-align: center;'>NO</th>
                    <th style='border: 1px solid black; padding: 12px; text-align: center;'>NAMA PANTAI</th>
                    <th style='border: 1px solid black; padding: 12px; text-align: center;'>DESA</th>
                    <th style='border: 1px solid black; padding: 12px; text-align: center;'>KECAMATAN</th>
                    <th style='border: 1px solid black; padding: 12px; text-align: center;'>LATITUDE</th>
                    <th style='border: 1px solid black; padding: 12px; text-align: center;'>LONGITUDE</th>
                    <th style='border: 1px solid black; padding: 12px; text-align: center;'>AKSI</th>
                </tr>
            </thead>
            <tbody>";
    // Output data dari setiap baris
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td style='border: 1px solid black; padding: 12px; text-align: center;'>" . $row["id"]. "</td>
                <td style='border: 1px solid black; padding: 12px; text-align: center;'>" . $row["nama"]. "</td>
                <td style='border: 1px solid black; padding: 12px; text-align: center;'>" . $row["desa"]. "</td>
                <td style='border: 1px solid black; padding: 12px; text-align: center;'>" . $row["kecamatan"]. "</td>
                <td style='border: 1px solid black; padding: 12px; text-align: center;'>" . $row["latitude"]. "</td>
                <td style='border: 1px solid black; padding: 12px; text-align: center;'>" . $row["longitude"]. "</td>
                <td style='border: 1px solid black; padding: 12px; text-align: center;'>
                    <a href='index.php?delete_id=" . $row["id"] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                    <a href='index.php?edit_id=" . $row["id"] . "'>Edit</a>
                </td>
              </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "0 results";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pantai</title>
    <style>
        .edit-form-container {
           
            background-color: #ffffff; 
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <!-- Form Edit Data -->
<div class="edit-form-container" id="editFormContainer">
    <h3>Edit Data</h3>
    <?php
    if (isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        $conn = new mysqli($servername, $username, $password, $dbname);
        $edit_sql = "SELECT * FROM pantairembangg WHERE id = $edit_id";
        $edit_result = $conn->query($edit_sql);
        $edit_data = $edit_result->fetch_assoc();
    ?>
    <form method="post" action="index.php">
        <div class="form-group">
            <label for="nama">Nama Pantai:</label>
            <input type="text" id="nama" name="nama" value="<?php echo $edit_data['nama']; ?>" required>
        </div>
        <div class="form-group">
            <label for="desa">Desa:</label>
            <input type="text" id="desa" name="desa" value="<?php echo $edit_data['desa']; ?>" required>
        </div>
        <div class="form-group">
            <label for="kecamatan">Kecamatan:</label>
            <input type="text" id="kecamatan" name="kecamatan" value="<?php echo $edit_data['kecamatan']; ?>" required>
        </div>
        <div class="form-group">
            <label for="latitude">Latitude:</label>
            <input type="number" step="any" id="latitude" name="latitude" value="<?php echo $edit_data['latitude']; ?>" required>
        </div>
        <div class="form-group">
            <label for="longitude">Longitude:</label>
            <input type="number" step="any" id="longitude" name="longitude" value="<?php echo $edit_data['longitude']; ?>" required>
        </div>
        <input type="submit" value="Update" class="submit-btn">
    </form> 
    <p id="successMessage">Data successfully updated</p> 
    <button class="back-button" id="backButton" onclick="location.href='index.html#website'">Back</button> </div>
    <?php
        $conn->close();
    }
    ?>
</div>

<!-- CSS Styling -->
<style>
    .edit-form-container {
        background: linear-gradient(to right, #6dd5fa, #2980b9);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin: 20px auto;
        color: white;
    }

    .edit-form-container h3 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 1.8rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 15px;
    }

    .form-group label {
        margin-bottom: 5px;
        font-size: 1.1rem;
    }

    .form-group input {
        padding: 10px;
        border: none;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .submit-btn {
        background: #0056b3;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
        transition: background 0.3s ease;
        font-size: 1.1rem;
    }

    .submit-btn:hover {
        background: #004494;
    }
    .back-button {
            /* Button hidden by default */
            background: #0056b3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            text-align: center;
            margin-top: 10px;
            transition: background 0.3s ease;
            font-size: 1.1rem;
        }
        .back-button:hover {
            background: #09afff;
        }

        #successMessage {
            display: none;
            color: green;
            text-align: center;
            margin-top: 20px;
        }


</style>

</body>
</html>
