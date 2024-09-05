<?php
require("baza_danych.php");
require("session.php");


if ($_SESSION['rola'] !== 'admin') {
    header("Location: kategorie.php");
    exit();
}

$id = $_GET['id'];

$sql = "DELETE FROM slowo_kategoria WHERE idKategorii = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

$sql = "DELETE FROM kategorie WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

$sql = "DELETE FROM słownik WHERE id NOT IN (SELECT idSlowa FROM slowo_kategoria)";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->close();

$conn->close();

header("Location: kategorie.php");
exit();
?>
