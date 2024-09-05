<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zgłoszenia problemów</title>
    <link rel="stylesheet" href="/fiszki/style2.css">
</head>
<body>
<?php
require("baza_danych.php");
require("session.php");

$login = $_SESSION["login"];
$profilowe = $_SESSION["profilowe"];
$idUzytkownika = $_SESSION["id"];
$rola = $_SESSION["rola"];  // Fetch the user's role
$message = "";

// Handle new problem report submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['delete'])) {
    $idKategorii = $_POST['kategoria'];
    $opis = $_POST['opis'];

    $sql = "INSERT INTO zgłoszenia (idUzytkownika, idKategorii, Opis) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $idUzytkownika, $idKategorii, $opis);

    if ($stmt->execute()) {
        $message = "Zgłoszenie zostało pomyślnie przesłane.";
    } else {
        $message = "Błąd: " . $stmt->error;
    }

    $stmt->close();
}

// Handle deletion of problem reports (only for admin)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete']) && $rola === 'admin') {
    $idZgloszenia = $_POST['delete'];

    $sql = "DELETE FROM zgłoszenia WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idZgloszenia);

    if ($stmt->execute()) {
        $message = "Zgłoszenie zostało pomyślnie usunięte.";
    } else {
        $message = "Błąd: " . $stmt->error;
    }

    $stmt->close();
}
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

    <div class="zgloszenia">
        <h2>Zgłoś problem</h2>
        <?php if ($message != "") { echo "<p>$message</p>"; } ?>
        <form action="zgloszenia.php" method="POST">
            <label for="kategoria">Wybierz kategorię problemu:</label>
            <select name="kategoria" id="kategoria" required>
                <?php
                // Fetch categories for the dropdown
                $sql = "SELECT id, Kategoria FROM kategorie";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>" . htmlspecialchars($row['Kategoria']) . "</option>";
                }
                ?>
            </select><br>

            <label for="opis">Opis problemu:</label>
            <textarea name="opis" id="opis" rows="5" cols="50" maxlength="100" required></textarea><br>

            <input type="submit" value="Zgłoś problem">
        </form>

        <?php if ($rola === 'admin'): ?>
            <h2>Wszystkie zgłoszenia</h2>
            <?php
            $sql = "SELECT z.id, k.Kategoria, z.Opis, z.idUzytkownika
            FROM zgłoszenia z 
            JOIN kategorie k ON z.idKategorii = k.id 
            ORDER BY z.id DESC";

            if ($result->num_rows > 0) {
                echo '<table border="1">';
                echo '<thead><tr><th>Kategoria</th><th>Opis</th><th>Data</th><th>Użytkownik ID</th><th>Akcje</th></tr></thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['Kategoria']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['Opis']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['data']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['idUzytkownika']) . '</td>';
                    echo '<td>';
                    echo '<form method="POST" action="zgloszenia.php" style="display:inline;">
                            <input type="hidden" name="delete" value="' . htmlspecialchars($row['id']) . '">
                            <input type="submit" value="Usuń" onclick="return confirm(\'Na pewno chcesz usunąć to zgłoszenie?\');">
                          </form>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>Brak zgłoszeń do wyświetlenia.</p>';
            }
            ?>
        <?php endif; ?>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
