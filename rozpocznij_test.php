<?php
require("baza_danych.php");
require("session.php");

$idKategorii = $_GET['kategoria'];
$idUzytkownika = $_SESSION['id'];

// Zmiana zapytania SQL, aby uwzględnić tabelę `slowo_kategoria`
$sql = "
    SELECT s.id, s.slowo_eng, s.slowo_pl 
    FROM słownik s
    JOIN slowo_kategoria sk ON s.id = sk.idSlowa
    WHERE sk.idKategorii = ? 
    ORDER BY RAND() 
    LIMIT 10
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idKategorii);
$stmt->execute();
$slowa = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$_SESSION['slowa'] = $slowa;

$sql_wszystkie = "
    SELECT s.slowo_eng 
    FROM słownik s
    JOIN slowo_kategoria sk ON s.id = sk.idSlowa
    WHERE sk.idKategorii = ?
";
$stmt_wszystkie = $conn->prepare($sql_wszystkie);
$stmt_wszystkie->bind_param("i", $idKategorii);
$stmt_wszystkie->execute();
$wszystkie_slowa = $stmt_wszystkie->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt_wszystkie->close();

function pobierz_losowe_bledne_odpowiedzi($poprawna_odpowiedz, $wszystkie_slowa, $liczba = 3) {
    $bledne_odpowiedzi = [];
    $wszystkie_bledne_slowa = array_filter($wszystkie_slowa, function($slowo) use ($poprawna_odpowiedz) {
        return $slowo['slowo_eng'] !== $poprawna_odpowiedz;
    });
    shuffle($wszystkie_bledne_slowa);
    return array_slice($wszystkie_bledne_slowa, 0, $liczba);
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rozpocznij test</title>
    <link rel="stylesheet" href="/fiszki/style2.css">
</head>
<body>
    <div class="testy">
        <h2>Test - Kategoria: <?php echo htmlspecialchars($idKategorii); ?></h2>
        <form method="post" action="sprawdz_test.php">
            <input type="hidden" name="kategoria" value="<?php echo htmlspecialchars($idKategorii); ?>">

            <h3>Pytania wielokrotnego wyboru:</h3>
            <?php
            for ($i = 0; $i < 4; $i++) {
                echo "<label>Pytanie " . ($i + 1) . ": Co oznacza '" . htmlspecialchars($slowa[$i]['slowo_pl']) . "'?</label><br>";

                $bledne_odpowiedzi = pobierz_losowe_bledne_odpowiedzi($slowa[$i]['slowo_eng'], $wszystkie_slowa);
                $opcje = array_merge([$slowa[$i]['slowo_eng']], array_column($bledne_odpowiedzi, 'slowo_eng'));

                shuffle($opcje);

                foreach ($opcje as $opcja) {
                    echo '<input type="radio" name="pytanie' . $i . '" value="' . htmlspecialchars($opcja) . '">' . htmlspecialchars($opcja) . '<br>';
                }
                echo "<br>";
            }

            echo "<h3>Pytania otwarte:</h3>";
            for ($i = 4; $i < 10; $i++) {
                echo "<label>Pytanie " . ($i + 1) . ": Przetłumacz '" . htmlspecialchars($slowa[$i]['slowo_eng']) . "'</label><br>";
                echo '<input type="text" name="pytanie_otwarte' . $i . '" class="form-control" placeholder="Wpisz tłumaczenie"><br><br>';
            }
            ?>
            <button type="submit" class="submit-button">Zakończ test</button>
        </form>
    </div>
</body>
</html>
