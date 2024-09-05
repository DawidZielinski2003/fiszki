<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiszki</title>
    <link rel="stylesheet" href="/fiszki/style2.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/fiszki/script.js" defer></script>
    <script src="/fiszki/script2.js" defer></script>
</head>

<body>
    <?php
    require("baza_danych.php");
    require("session.php");

    $login = $_SESSION["login"];
    $profilowe = $_SESSION["profilowe"];
    $idUzytkownika = $_SESSION["id"];
    $idKategorii = $_GET['idKategorii'] ?? null;
    $idSlowa = $_GET['idSlowa'] ?? null;

    echo $idSlowa;

    if ($idSlowa) {
        $sql = "SELECT id, slowo_eng, slowo_pl FROM słownik WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idSlowa);
    } else if ($idKategorii) {
        $sql = "SELECT s.id, s.slowo_eng, s.slowo_pl 
                FROM słownik s
                JOIN slowo_kategoria sk ON s.id = sk.idSlowa
                WHERE sk.idKategorii = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idKategorii);
    } else {
        $words = [];
    }

    if (isset($stmt)) {
        $stmt->execute();
        $result = $stmt->get_result();
        $words = [];
        while ($row = $result->fetch_assoc()) {
            $words[] = $row;
        }
        $stmt->close();
    }

    // Sprawdzanie progresu nauki dla danego użytkownika i kategorii
    $sql = "SELECT * FROM progres WHERE idUrzytkownika = ? AND idkategori = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $idUzytkownika, $idKategorii);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0 && !empty($words)) {
        // Tworzenie rekordu progresu dla nowej kategorii
        $idSlowa = $words[0]['id'];
        $sqlInsert = "INSERT INTO progres (idUrzytkownika, idkategori, id_ostatniejFiszki) VALUES (?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("iii", $idUzytkownika, $idKategorii, $idSlowa);
        $stmtInsert->execute();
        $stmtInsert->close();
    }
    $stmt->close();
    ?>
    <script>
        var idKategorii = <?php echo json_encode($idKategorii); ?>;
    </script>

    <!-- Wyświetlanie interfejsu fiszek -->
    <div class="header">
        <h1>Fiszkonauka</h1>
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
        <a href="recenzje.php">Recenzje</a>
        <a href="test.php">Test</a>
        <a href="wyniki.php">Wyniki</a>
        <a href="zgloszenia.php">Zgłoszenia problemów</a>
    </div>

    <div class="fiszka">
        <h2>Fiszki do nauki</h2>
        <div class="word-container">
            <button id="prev-btn">&lt;</button>
            <p id="word"></p>
            <button id="next-btn">&gt;</button>
        </div>
        <div id="counter" class="licznik"></div>
        <br>
        <img class="fav" src="gwiazda_pusta.png" data-slowo="<?= htmlspecialchars($idSlowa) ?>" height="200px">
    </div>

    <script id="words-data" type="application/json">
        <?php echo json_encode($words); ?>
    </script>
</body>

</html>