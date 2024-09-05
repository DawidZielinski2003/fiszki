
<?php
require("baza_danych.php");
require("session.php");

$idKategorii = $_POST['idKategorii'];
$idUzytkownika = $_SESSION['id'];

$sql = "DELETE FROM progres WHERE idUrzytkownika = ? AND idkategori = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $idUzytkownika, $idKategorii);
$stmt->execute();
$stmt->close();
?>
