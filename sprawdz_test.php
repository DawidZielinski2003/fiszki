<?php
require("baza_danych.php");
require("session.php");

if (!isset($_SESSION['id'])) {
    die('Brak zalogowanego użytkownika.');
}

if (!isset($_POST['kategoria'])) {
    die('Brak kategorii.');
}

if (!isset($_SESSION['slowa'])) {
    die('Brak danych słów w sesji.');
}

$idUzytkownika = $_SESSION['id'];
$idKategorii = $_POST['kategoria'];
$slowa = $_SESSION['slowa'];
$punkty = 0;
$bledy = [];


for ($i = 0; $i < 4; $i++) {
    if (isset($_POST['pytanie' . $i])) {
        $odpowiedz = $_POST['pytanie' . $i];
        $slowo_pl = $slowa[$i]['slowo_pl'];
        $poprawna_odpowiedz = $slowa[$i]['slowo_eng'];

        if ($odpowiedz === $poprawna_odpowiedz) {
            $punkty += 2;
        } else {
            $bledy[] = [
                'pytanie' => "Co oznacza '{$slowo_pl}'?",
                'twoja_odpowiedz' => $odpowiedz,
                'poprawna_odpowiedz' => $poprawna_odpowiedz
            ];
        }
    } else {
        die('Brak odpowiedzi dla pytania ' . ($i + 1));
    }
}


for ($i = 4; $i < 10; $i++) {
    if (isset($_POST['pytanie_otwarte' . $i])) {
        $odpowiedz = strtolower(trim($_POST['pytanie_otwarte' . $i]));
        $poprawna_odpowiedz = strtolower(trim($slowa[$i]['slowo_pl']));

        if ($odpowiedz === $poprawna_odpowiedz) {
            $punkty += 2;
        } else {
            $bledy[] = [
                'pytanie' => "Przetłumacz '{$slowa[$i]['slowo_eng']}'",
                'twoja_odpowiedz' => $odpowiedz,
                'poprawna_odpowiedz' => $poprawna_odpowiedz
            ];
        }
    } else {
        die('Brak odpowiedzi dla pytania ' . ($i + 1));
    }
}


if ($punkty >= 19) {
    $ocena = "5";
} elseif ($punkty >= 17) {
    $ocena = "4+";
} elseif ($punkty >= 15) {
    $ocena = "4";
} elseif ($punkty >= 13) {
    $ocena = "3+";
} elseif ($punkty >= 11) {
    $ocena = "3";
} elseif ($punkty >= 9) {
    $ocena = "2+";
} elseif ($punkty >= 7) {
    $ocena = "2";
} elseif ($punkty >= 5) {
    $ocena = "1+";
} else {
    $ocena = "1";
}

// Wstawianie wyników do bazy danych
$sql = "INSERT INTO wyniki (idKategorii, idUzytkownika, punkty, ocena) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Błąd przygotowania zapytania: ' . $conn->error);
}
$stmt->bind_param("iiis", $idKategorii, $idUzytkownika, $punkty, $ocena);
if (!$stmt->execute()) {
    die('Błąd wykonania zapytania: ' . $stmt->error);
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wyniki Testu</title>
    <link rel="stylesheet" href="/fiszki/style2.css">
</head>
<body>
    <header class="header">
        <h1>Wyniki Testu</h1>
    </header>

    <div class="test-summary">
        <h2>Twój wynik: <span class="score"><?php echo htmlspecialchars($punkty); ?>/20</span></h2>
        <h2>Ocena: <span class="grade"><?php echo htmlspecialchars($ocena); ?></span></h2>

        <?php if (count($bledy) > 0): ?>
            <h3>Błędy:</h3>
            <div class="test-summary">
                <?php foreach ($bledy as $blad): ?>
                    <p>
                        <strong><?php echo htmlspecialchars($blad['pytanie']); ?></strong><br>
                        Twoja odpowiedź: <span class="twoja-odpowiedz"><?php echo htmlspecialchars($blad['twoja_odpowiedz']); ?></span><br>
                        Poprawna odpowiedź: <span class="poprawna-odpowiedz"><?php echo htmlspecialchars($blad['poprawna_odpowiedz']); ?></span>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="test-summary">
                <h3>Gratulacje! Wszystkie odpowiedzi są poprawne.</h3>
            </div>
        <?php endif; ?>

        <div class="test-summary">
            <a href="test.php" class="back-button">Powrót do testu</a>
        </div>
    </div>
</body>
</html>
