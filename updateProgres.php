<?php
require("baza_danych.php");
require("session.php");

$idSlowa = $_POST['idSlowa'];
$idKategorii = $_POST['idKategorii'];
$idUzytkownika = $_SESSION['id'];

$sql = "UPDATE progres SET id_ostatniejFiszki = ?, Data_ = CURRENT_TIMESTAMP WHERE idUrzytkownika = ? AND idkategori = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $idSlowa, $idUzytkownika, $idKategorii);
$stmt->execute();
$stmt->close();
?>
