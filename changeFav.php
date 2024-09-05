<?php
require("baza_danych.php");
require("session.php");

$idslowa = $_REQUEST["idslowa"];
$idUzytkownika = $_SESSION["id"];

$sql = "SELECT id FROM zapamientaj WHERE idslowa = ? AND idUzytkownika = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $idslowa, $idUzytkownika);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $id = $result->fetch_object()->id;
    $sql = "DELETE FROM zapamientaj WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
} else {
    $sql = "INSERT INTO zapamientaj (idslowa, idUzytkownika) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idslowa, $idUzytkownika);
}

if ($stmt->execute()) {
    echo "sukces";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>
