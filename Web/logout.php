<?php
session_start();
session_unset(); // Uklanja sve varijable sesije
session_destroy(); // Uništava sesiju
header("Location: pocetna.php"); // Redirekcija na početnu stranicu
exit;
?>
