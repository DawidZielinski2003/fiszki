<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategorie</title>
    <link rel="stylesheet" href="/fiszki/style2.css">
</head>

<body>
    <?php
    require("baza_danych.php");
    require("session.php");

    $login = $_SESSION["login"];
    $profilowe = $_SESSION["profilowe"];
    $rola = $_SESSION["rola"]; 

    $searchQuery = isset($_POST['search']) ? $_POST['search'] : '';
    ?>
    <header class="header">
        <h1>Fiszkonauka</h1>
        <div class="user-info">
            <img src="/fiszki/profilowe/<?php echo htmlspecialchars($profilowe); ?>" alt="Profilowe">
            <span>Zalogowany jako: <?php echo htmlspecialchars($login); ?></span>
            <a href="logout.php" class="logout-btn">Wyloguj się</a>
        </div>
    </header>

    <nav class="menu">
        <a href="menu.php">Strona główna</a>
        <a href="kategorie.php">Kategorie</a>
        <a href="zapamietaj.php">Zapamiętane</a>
        <a href="rencenzje.php">Recenzje</a>
        <a href="test.php">Test</a>
        <a href="wyniki.php">Wyniki</a>
        <a href="zgloszenia.php">Zgłoszenia problemów</a>
    </nav>

    <main class="ketegorie">
        <h2>Kategorie słówek do nauki</h2>

        <form method="post" action="kategorie.php" class="search-form">
            <input type="text" name="search" placeholder="Wyszukaj kategorię..." value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit">Szukaj</button>
        </form>

        <?php
      
        $sql = "SELECT k.id, k.Kategoria, k.obraz, k.Opis, COUNT(sk.idSlowa) AS liczba_slow
            FROM kategorie k
            LEFT JOIN slowo_kategoria sk ON k.id = sk.idKategorii
            WHERE k.Kategoria LIKE ?
            GROUP BY k.id";

        $stmt = $conn->prepare($sql);
        $searchTerm = "%$searchQuery%";
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<ul class="categories-list">';
            while ($row = $result->fetch_assoc()) {
                echo '<li>';
                echo '<img src="/fiszki/kategorie/' . htmlspecialchars($row['obraz']) . '" alt="' . htmlspecialchars($row['Kategoria']) . '" class="category-image"><br>';
                echo '<span class="category-info">Nazwa: ' . htmlspecialchars($row['Kategoria']) . '</span><br>';
                echo '<span class="category-info">Opis: ' . htmlspecialchars($row['Opis']) . '</span><br>';
                echo '<span class="category-info">Ilość słówek: ' . htmlspecialchars($row['liczba_slow']) . '</span><br>';
                echo '<a href="fiszki.php?idKategorii=' . htmlspecialchars($row['id']) . '" class="category-link">Zobacz fiszki</a>';

                if ($rola === 'admin') {
                    echo '<a href="edit-kategorie.php?id=' . htmlspecialchars($row['id']) . '" class="category-button">Edytuj</a>';
                    echo '<a href="delete-kategorie.php?id=' . htmlspecialchars($row['id']) . '" class="category-button">Usuń</a>';
                }

                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>Brak dostępnych kategorii.</p>';
        }

        $stmt->close();
        $conn->close();
        ?>

        <?php if ($rola === 'admin'): ?>
        <h3>Dodaj nową kategorię</h3>
        <form method="post" action="add-kategorie.php" enctype="multipart/form-data" class="add-category-form">
            <div class="form-group">
                <label for="kategoria">Nazwa kategorii:</label>
                <input type="text" id="kategoria" name="kategoria" required>
            </div>
            <div class="form-group">
                <label for="obraz">Obraz:</label>
                <input type="file" id="obraz" name="obraz" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="opis">Opis:</label>
                <textarea id="opis" name="opis" required></textarea>
            </div>
            <button type="submit" class="submit-button">Dodaj kategorię</button>
        </form>
        <?php endif; ?>
    </main>
</body>

</html>
