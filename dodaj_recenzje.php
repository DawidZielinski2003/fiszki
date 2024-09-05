<?php
require("baza_danych.php");
require("session.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idKategorii = $_POST['kategoria'];
    $login = $_SESSION['login'];
    $ocena = $_POST['ocena'];
    $tresc = $_POST['tresc'];

    $sql = "INSERT INTO recenzje (idKategorii, login, tresc, Ocena) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $idKategorii, $login, $tresc, $ocena);
    
    if ($stmt->execute()) {
        header("Location: rencenzje.php?status=success");
    } else {
        header("Location: rencenzje.php?status=error");
    }
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: rencenzje.php");
    exit();
}
