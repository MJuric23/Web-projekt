<?php
// Povezivanje s bazom podataka
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'korisnici_db';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Povezivanje s bazom nije uspjelo: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];
    $lozinka = $_POST['lozinka']; // Bez hashiranja

    // Provjera postoji li email već u bazi
    $stmt = $conn->prepare("SELECT * FROM korisnici WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email je već registriran!";
    } else {
        // Unos korisnika u bazu
        $stmt = $conn->prepare("INSERT INTO korisnici (ime, prezime, email, lozinka) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $ime, $prezime, $email, $lozinka);

        if ($stmt->execute()) {
            echo "Registracija uspješna!";
        } else {
            echo "Došlo je do pogreške: " . $stmt->error;
        }
    }
}
$conn->close();
?>
