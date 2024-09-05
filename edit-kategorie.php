<?php
require("baza_danych.php");
require("session.php");


if ($_SESSION['rola'] !== 'admin') {
    header("Location: kategorie.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT Kategoria, obraz, Opis FROM kategorie WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();
$stmt->close();

$sql = "SELECT idSlowa, slowo_eng, slowo_pl FROM slowo_kategoria JOIN słownik ON slowo_kategoria.idSlowa = słownik.id WHERE idKategorii = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$words = $stmt->get_result();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kategoria = $_POST['kategoria'];
    $opis = $_POST['opis'];

    if (isset($_FILES['obraz']) && $_FILES['obraz']['error'] == UPLOAD_ERR_OK) {
        $obraz = $_FILES['obraz']['name'];
        $temp = $_FILES['obraz']['tmp_name'];
        $uploadDir = 'path/to/your/upload/directory/';
        move_uploaded_file($temp, $uploadDir . $obraz);
    } else {
        $obraz = $category['obraz'];
    }

 
    $sql = "UPDATE kategorie SET Kategoria = ?, obraz = ?, Opis = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $kategoria, $obraz, $opis, $id);
    $stmt->execute();
    $stmt->close();

    foreach ($_POST['slowa'] as $wordId => $wordData) {
        $slowoEng = $wordData['eng'];
        $slowoPl = $wordData['pl'];

        if ($slowoEng && $slowoPl) {
            $sql = "UPDATE słownik SET slowo_eng = ?, slowo_pl = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $slowoEng, $slowoPl, $wordId);
            $stmt->execute();
            $stmt->close();
        }
    }


    if (isset($_POST['new_words'])) {
        foreach ($_POST['new_words'] as $newWord) {
            $slowoEng = $newWord['eng'];
            $slowoPl = $newWord['pl'];

            if ($slowoEng && $slowoPl) {
   
                $sql = "INSERT INTO słownik (slowo_eng, slowo_pl) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $slowoEng, $slowoPl);
                $stmt->execute();
                $newWordId = $stmt->insert_id;
                $stmt->close();

                $sql = "INSERT INTO slowo_kategoria (idKategorii, idSlowa) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $id, $newWordId);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    $conn->close();
    header("Location: kategorie.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edytuj kategorię</title>
    <link rel="stylesheet" href="/fiszki/style2.css">
</head>

<body>
    <div class="header">
        <h1>Edytuj kategorię</h1>
        <div class="user-info">
            <span>Użytkownik</span>
            <a href="logout.php" class="logout-btn">Wyloguj</a>
        </div>
    </div>

    <div class="menu">
        <a href="home.php">Strona główna</a>
        <a href="kategorie.php">Kategorie</a>
        <a href="profil.php">Profil</a>
    </div>

    <div class="content">
        <div class="ketegorie">
            <h2>Edytuj kategorię</h2>
            <form method="post" action="edit-kategorie.php?id=<?php echo htmlspecialchars($id); ?>" enctype="multipart/form-data" class="add-category-form">
                <div class="form-group">
                    <label for="kategoria">Nazwa kategorii:</label>
                    <input type="text" id="kategoria" name="kategoria" value="<?php echo htmlspecialchars($category['Kategoria']); ?>" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="obraz">Obraz:</label>
                    <input type="file" id="obraz" name="obraz" accept="image/*" class="form-control">
                </div>
                <div class="form-group">
                    <label for="opis">Opis:</label>
                    <textarea id="opis" name="opis" required class="form-control"><?php echo htmlspecialchars($category['Opis']); ?></textarea>
                </div>

                <h3>Słowa przypisane do tej kategorii</h3>
                <?php if ($words->num_rows > 0): ?>
                    <?php while ($row = $words->fetch_assoc()): ?>
                        <div class="form-group">
                            <input type="hidden" name="slowa[<?php echo htmlspecialchars($row['idSlowa']); ?>][id]" value="<?php echo htmlspecialchars($row['idSlowa']); ?>">
                            <label for="eng-<?php echo htmlspecialchars($row['idSlowa']); ?>">Słowo (angielski):</label>
                            <input type="text" id="eng-<?php echo htmlspecialchars($row['idSlowa']); ?>" name="slowa[<?php echo htmlspecialchars($row['idSlowa']); ?>][eng]" value="<?php echo htmlspecialchars($row['slowo_eng']); ?>" class="form-control">
                            <label for="pl-<?php echo htmlspecialchars($row['idSlowa']); ?>">Słowo (polski):</label>
                            <input type="text" id="pl-<?php echo htmlspecialchars($row['idSlowa']); ?>" name="slowa[<?php echo htmlspecialchars($row['idSlowa']); ?>][pl]" value="<?php echo htmlspecialchars($row['slowo_pl']); ?>" class="form-control">
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Brak słów przypisanych do tej kategorii.</p>
                <?php endif; ?>

                <h3>Dodaj nowe słowa do tej kategorii</h3>
                <div id="new-words-container">
                    <div class="form-group new-word">
                        <label for="new-eng-1">Słowo (angielski):</label>
                        <input type="text" id="new-eng-1" name="new_words[0][eng]" class="form-control">
                        <label for="new-pl-1">Słowo (polski):</label>
                        <input type="text" id="new-pl-1" name="new_words[0][pl]" class="form-control">
                    </div>
                </div>
                <button type="button" id="add-new-word" class="submit-button">Dodaj kolejne słowo</button>

                <button type="submit" class="submit-button">Zapisz zmiany</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('add-new-word').addEventListener('click', function () {
            const container = document.getElementById('new-words-container');
            const index = container.children.length;
            const newWordHTML = `
                <div class="form-group new-word">
                    <label for="new-eng-${index + 1}">Słowo (angielski):</label>
                    <input type="text" id="new-eng-${index + 1}" name="new_words[${index}][eng]" class="form-control">
                    <label for="new-pl-${index + 1}">Słowo (polski):</label>
                    <input type="text" id="new-pl-${index + 1}" name="new_words[${index}][pl]" class="form-control">
                </div>
            `;
            container.insertAdjacentHTML('beforeend', newWordHTML);
        });
    </script>
</body>

</html>
