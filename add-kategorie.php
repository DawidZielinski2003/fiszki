<?php
require("baza_danych.php");
require("session.php");


if ($_SESSION['rola'] !== 'admin') {
    header("Location: kategorie.php");
    exit();
}


$kategoria = $_POST['kategoria'];
$opis = $_POST['opis'];


if (isset($_FILES['obraz']) && $_FILES['obraz']['error'] == UPLOAD_ERR_OK) {
    $obraz = $_FILES['obraz']['name'];
    $temp = $_FILES['obraz']['tmp_name'];
    $uploadDir = 'path/to/your/upload/directory/';
    move_uploaded_file($temp, $uploadDir . $obraz);
} else {
    
    $obraz = 'default_image.png';
}

$sql = "INSERT INTO kategorie (Kategoria, obraz, Opis) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $kategoria, $obraz, $opis);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: kategorie.php");
?>
