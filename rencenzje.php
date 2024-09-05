<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recenzje</title>
    <link rel="stylesheet" href="/fiszki/style2.css">
</head>
<body>
    <?php
    require("baza_danych.php");
    require("session.php");

    $login = $_SESSION["login"];
    $profilowe = $_SESSION["profilowe"];

    $kategorieSql = "SELECT id, Kategoria FROM kategorie";
    $kategorieResult = $conn->query($kategorieSql);
    ?>

    <div class="header">
        <h1>Fiszkonauka - Recenzje</h1>
        <div class="user-info">
            <img src="/fiszki/profilowe/<?php echo htmlspecialchars($profilowe); ?>" alt="Profilowe" width="30" height="30" style="border-radius: 50%;">
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

    <div class="recenzje-section">
    <h2>Dodaj swoją recenzję</h2>
    <form method="post" action="dodaj_recenzje.php">
        <div class="form-group">
            <label for="kategoria">Wybierz kategorię:</label>
            <select name="kategoria" id="kategoria" class="form-control">
                <?php
                if ($kategorieResult->num_rows > 0) {
                    while ($row = $kategorieResult->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['Kategoria']) . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="ocena">Wybierz ocenę:</label>
            <select name="ocena" id="ocena" class="form-control">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tresc">Twoja opinia:</label>
            <textarea name="tresc" id="tresc" rows="5" maxlength="50" class="form-control"></textarea>
        </div>

        <button type="submit" class="submit-button">Dodaj recenzję</button>
    </form>
</div>

    <div class="recenzje-list">
        <h2>Opinie użytkowników</h2>
        <?php
        $recenzjeSql = "SELECT r.Ocena, r.tresc, r.data, k.Kategoria, r.login FROM recenzje r 
                        JOIN kategorie k ON r.idKategorii = k.id 
                        ORDER BY r.data DESC";
        $recenzjeResult = $conn->query($recenzjeSql);

        if ($recenzjeResult->num_rows > 0) {
            echo '<ul class="recenzje-list-ul">';
            while ($row = $recenzjeResult->fetch_assoc()) {
                echo '<li>';
                echo '<strong>Kategoria: ' . htmlspecialchars($row['Kategoria']) . '</strong><br>';
                echo '<strong>Ocena: ' . htmlspecialchars($row['Ocena']) . ' / 5</strong><br>';
                echo '<p>' . nl2br(htmlspecialchars($row['tresc'])) . '</p>';
                echo '<span class="recenzja-info">Autor: ' . htmlspecialchars($row['login']) . ' | Data: ' . htmlspecialchars($row['data']) . '</span>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>Brak recenzji do wyświetlenia.</p>';
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
