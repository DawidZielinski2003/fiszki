<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <link rel="stylesheet" href="/fiszki/style2.css">
</head>

<body>
    <?php
    require("baza_danych.php");
    require("session.php");

    $login = $_SESSION["login"];
    $profilowe = $_SESSION["profilowe"];
    $idUzytkownika = $_SESSION["id"];
    ?>

    <div class="header">
        <h1>Fiszkonauka</h1>
        <div class="user-info">
            <img src="/fiszki/profilowe/<?php echo $profilowe; ?>" alt="Profilowe" width="30" height="30" style="border-radius: 50%;">
            <span>Zalogowany jako: <?php echo htmlspecialchars($login); ?></span>
            <a href="logout.php" class="logout-btn">Wyloguj się</a>
        </div>
    </div>

    <div class="menu">
    <a href="menu.php">Strona główna</a>
        <a href="kategorie.php">Kategorie</a>
        <a href="zapamietaj.php">Zapamiętane</a>
        <a href="rencenzje.php">Recenzje</a>
        <a href="test.php">Test</a>
        <a href="wyniki.php">Wyniki</a>
        <a href="zgloszenia.php">Zgłoszenia problemów</a>
    </div>

    <div class="testy">
        <h2>Wybierz kategorię testu</h2>
        <form method="get" action="rozpocznij_test.php">
            <label for="kategoria">Wybierz kategorię:</label>
            <select name="kategoria" id="kategoria" class="form-control">
                <?php
                $sql = "SELECT id, Kategoria FROM kategorie";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['Kategoria']) . '</option>';
                    }
                } else {
                    echo '<option value="">Brak dostępnych kategorii</option>';
                }
                ?>
            </select>
            <button type="submit" class="submit-button">Rozpocznij test</button>
        </form>
    </div>
</body>

</html>
