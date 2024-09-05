<?php
require("baza_danych.php");
require("session.php");

$id = $_POST['id'];
$idUzytkownika = $_SESSION["id"];

$sql = "DELETE FROM zapamientaj WHERE id = ? AND idUzytkownika = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $id, $idUzytkownika);

if ($stmt->execute()) {
    header("Location: zapamietaj.php");
} else {
    echo "Błąd: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
