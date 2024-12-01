<?php
session_start(); // Pokretanje sesije

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'korisnici_db';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Povezivanje s bazom nije uspjelo: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $lozinka = $_POST['lozinka'];

    $stmt = $conn->prepare("SELECT * FROM korisnici WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $korisnik = $result->fetch_assoc();
        if ($lozinka === $korisnik['lozinka']) {
            // Spremanje korisničkog imena u sesiju
            $_SESSION['korisnik_ime'] = $korisnik['ime'];
            header("Location: pocetna.php"); // Redirekcija na početnu stranicu
            exit;
        } else {
            echo "Pogrešna lozinka!";
        }
    } else {
        echo "Korisnik s tim emailom ne postoji!";
    }
}
$conn->close();
?>
