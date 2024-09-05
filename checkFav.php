<?php
require("baza_danych.php");
require("session.php");

$idUzytkownika = $_SESSION["id"];
$idslowa = $_POST['idslowa'];

$sql = "SELECT id FROM zapamientaj WHERE idslowa = ? AND idUzytkownika = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $idslowa, $idUzytkownika);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "saved"; 
} else {
    echo "not_saved"; 
}

$stmt->close();
$conn->close();
?>
