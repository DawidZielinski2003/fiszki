<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wyniki</title>
    <link rel="stylesheet" href="/fiszki/style2.css">
</head>
<body>
<?php
require("baza_danych.php");
require("session.php");

$login = $_SESSION["login"];
$profilowe = $_SESSION["profilowe"];
$idUzytkownika = $_SESSION["id"];
$rola = $_SESSION["rola"];  

?>
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

    <div class="wyniki">
        <h2>Twoje wyniki</h2>
        <?php
        $sql = "SELECT w.id, k.Kategoria, w.punkty, w.ocena, w.data 
                FROM wyniki w 
                JOIN kategorie k ON w.idKategorii = k.id 
                WHERE w.idUzytkownika = ? 
                ORDER BY w.data DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idUzytkownika);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<ul>';
            while ($row = $result->fetch_assoc()) {
                echo '<li>';
                echo '<span class="kategoria">Kategoria: ' . htmlspecialchars($row['Kategoria']) . '</span><br>';
                echo '<span class="data">Data: ' . htmlspecialchars($row['data']) . '</span><br>';
                echo '<span class="wynik">Punkty: ' . htmlspecialchars($row['punkty']) . '</span><br>';
                echo '<span class="ocena">Ocena: ' . htmlspecialchars($row['ocena']) . '</span>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>Brak wyników do wyświetlenia.</p>';
        }

        if ($rola === 'admin') {
            echo '<h2>Statystyki Kategorii</h2>';
            $sql = "SELECT k.Kategoria, COUNT(w.id) AS liczba_egzaminow, AVG(w.ocena) AS srednia_ocena
                    FROM wyniki w
                    JOIN kategorie k ON w.idKategorii = k.id
                    GROUP BY k.Kategoria";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<table border="1">';
                echo '<thead><tr><th>Kategoria</th><th>Liczba Egzaminów</th><th>Średnia Ocena</th></tr></thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['Kategoria']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['liczba_egzaminow']) . '</td>';
                    echo '<td>' . number_format($row['srednia_ocena'], 2) . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>Brak statystyk do wyświetlenia.</p>';
            }
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
