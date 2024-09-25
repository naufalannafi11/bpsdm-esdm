<?php
// Koneksi ke database
$servername = "localhost"; // atau IP Server
$username = "root"; // username MySQL Anda
$password = ""; // password MySQL Anda
$dbname = "hcsummit"; // nama database yang sudah dibuat

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tangkap data dari form
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$agency = $_POST['agency'];
$participation = isset($_POST['participation']) ? implode(", ", $_POST['participation']) : 'None'; // Menggabungkan nilai checkbox

// Menggunakan prepared statements untuk menghindari SQL Injection
$stmt = $conn->prepare("INSERT INTO participants (full_name, email, phone, agency, participation) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $full_name, $email, $phone, $agency, $participation);

if ($stmt->execute()) {
    // Menampilkan pesan sukses
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <script src='https://cdn.tailwindcss.com'></script>
        <title>Submit Success</title>
    </head>
    <body>
        <div class='bg-green-900 text-center p-6 h-screen flex flex-col justify-center items-center'>
            <h2 class='text-white mt-4 text-2xl'>Data berhasil disimpan!</h2>
            <button onclick='window.location.href=\"index.html\"' class='bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mt-4'>Kembali</button>
        </div>
    </body>
    </html>";
} else {
    // Menampilkan pesan error
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <script src='https://cdn.tailwindcss.com'></script>
        <title>Submit Error</title>
    </head>
    <body>
        <div class='bg-red-900 text-center p-6 h-screen flex flex-col justify-center items-center'>
            <h2 class='text-red-600 text-2xl'>Error: " . $stmt->error . "</h2>
            <button onclick='window.location.href=\"index.html\"' class='bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mt-4'>Kembali</button>
        </div>
    </body>
    </html>";
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();
?>
