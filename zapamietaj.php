<?php
require("baza_danych.php");
require("session.php");

$login = $_SESSION["login"];
$profilowe = $_SESSION["profilowe"];
$idUzytkownika = $_SESSION["id"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zapamiętane słowa</title>
    <link rel="stylesheet" href="/fiszki/style2.css">
</head>

<body>
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
        <a href="rencenzje.php">Recenzje</a>
        <a href="test.php">Test</a>
        <a href="wyniki.php">Wyniki</a>
        <a href="zgloszenia.php">Zgłoszenia problemów</a>
    </div>

    <div class="zapamietaj">
        <h2>Słowa zapamiętania</h2>

        <?php
        $sql = "SELECT z.id AS zapamietaj_id, s.id AS idSlowa, s.slowo_eng, s.slowo_pl, k.id AS idKategorii, k.Kategoria 
        FROM zapamientaj z 
        JOIN słownik s ON z.idslowa = s.id 
        JOIN slowo_kategoria sk ON s.id = sk.idSlowa 
        JOIN kategorie k ON sk.idKategorii = k.id 
        WHERE z.idUzytkownika = ?";


        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idUzytkownika);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<ul class="zapamietane-list">';
            while ($row = $result->fetch_assoc()) {
                echo '<li>';
                echo '<span class="word">' . htmlspecialchars($row['slowo_eng']) . ' - ' . htmlspecialchars($row['slowo_pl']) . '</span><br>';
                echo '<span class="category-info">Kategoria: ' . htmlspecialchars($row['Kategoria']) . '</span><br>';
                echo '<form method="post" action="usun_slowo.php" class="delete-form">';
                echo '<input type="hidden" name="id" value="' . htmlspecialchars($row['zapamietaj_id']) . '">';
                echo '<button type="submit" class="delete-button">Usuń</button>';
                echo '</form>';
                echo '<br>';
                echo '<a href="fiszki.php?idKategorii=' . htmlspecialchars($row['idKategorii']) . '&idSlowa=' . htmlspecialchars($row['idSlowa']) . '" class="fiszka-button">Zobacz fiszkę</a>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>Nie masz jeszcze zapamiętanych słów.</p>';
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>

</html>
