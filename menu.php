<?php
require("baza_danych.php");
require("session.php");


if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$login = $_SESSION["login"];
$profilowe = $_SESSION["profilowe"];
$idUzytkownika = $_SESSION["id"];


$sql = "SELECT k.Kategoria, s.slowo_eng, s.slowo_pl, p.Data_ AS last_studied_date
        FROM progres p
        JOIN słownik s ON p.id_ostatniejFiszki = s.id
        JOIN kategorie k ON p.idkategori = k.id
        WHERE p.idUrzytkownika = ?
        ORDER BY p.Data_ DESC
        LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUzytkownika);
$stmt->execute();
$result = $stmt->get_result();
$last_studied_flashcards = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="/fiszki/style2.css">
</head>
<body>
    <div class="header">
        <h1>Fiszkonauka</h1>
        <div class="user-info">
            <img src="/fiszki/profilowe/<?php echo htmlspecialchars($profilowe); ?>" alt="Profilowe">
            <span>Zalogowany jako: <?php echo htmlspecialchars($login); ?></span>
            <a href="logout.php" class="logout-btn">Wyloguj się</a>
        </div>
    </div>

    <div class="menu">
        <a href="menu.php">Strona główna</a>
        <a href="kategorie.php">Kategorie</a>
        <a href="zapamietaj.php">Zapamiętane</a>
        <a href="recenzje.php">Recenzje</a>
        <a href="test.php">Test</a>
        <a href="wyniki.php">Wyniki</a>
        <a href="zgloszenia.php">Zgłoszenia problemów</a>
    </div>

    <div class="content">
        <h2>Ostatnio nauczane fiszki</h2>
        <?php if (!empty($last_studied_flashcards)): ?>
            <ul>
                <?php foreach ($last_studied_flashcards as $flashcard): ?>
                    <li>
                        <span class="kategoria">Kategoria: <?php echo htmlspecialchars($flashcard['Kategoria']); ?></span>
                        <span>Słówko: <?php echo htmlspecialchars($flashcard['slowo_eng']); ?> (<?php echo htmlspecialchars($flashcard['slowo_pl']); ?>)</span>
                        <span class="data">Data: <?php echo htmlspecialchars($flashcard['last_studied_date']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Nie masz jeszcze żadnych nauczanych fiszek.</p>
        <?php endif; ?>
    </div>
</body>
</html>
