<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="/fiszki/style.css">
</head>
<body>
<?php 
require("baza_danych.php");

if (isset($_POST["login"])) {
    $login = $_POST["login"];
    $haslo = $_POST["haslo"];
    $email = $_POST["email"];

    if (isset($_FILES["obrazek"]) && $_FILES["obrazek"]["error"] == 0) {
        $target_dir = "profilowe/";
        $target_file = $target_dir . basename($_FILES["obrazek"]["name"]);
        move_uploaded_file($_FILES["obrazek"]["tmp_name"], $target_file);
        $profil = $_FILES["obrazek"]["name"];
    } else {
        $profil = $_POST["profilowe"];
    }

    $sql = "INSERT INTO uzytkownicy (login, haslo, email, profilowe) VALUES ('$login', '" . md5($haslo) . "', '$email', '$profil')";
    $result = $conn->query($sql);

    if ($result) {
        echo "<div class='form'>
                <h3>Zostałeś pomyślnie zarejestrowany.</h3><br/>
                <p class='link'>Kliknij tutaj, aby się <a href='login.php'>zalogować</a></p>
              </div>";
    } else {
        echo "<div class='form'>
                <h3>Nie wypełniłeś wymaganych pól.</h3><br/>
                <p class='link'>Kliknij tutaj, aby ponowić próbę <a href='registration.php'>rejestracji</a>.</p>
              </div>";
    }
} else {
?>

<form class="form" action="" method="post" enctype="multipart/form-data">
    <h1 class="login-title">Rejestracja</h1>
    <input type="text" class="login-input" name="login" placeholder="Login" required/>
    <input type="password" class="login-input" name="haslo" placeholder="Hasło" required/>
    <input type="email" class="login-input" name="email" placeholder="Adres email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Wprowadź poprawny adres email"/>
    
    <h2>Wybierz zdjęcie profilowe:</h2>
    <div class="profile-gallery">
        <label>
            <input type="radio" name="profilowe" value="profilowe1.jpg">
            <div class="profile-pic-container">
                <img src="/fiszki/profilowe/profilowe1.jpg" alt="Profil 1" class="profile-pic">
            </div>
        </label>
        <label>
            <input type="radio" name="profilowe" value="profilowe2.jpg">
            <div class="profile-pic-container">
                <img src="/fiszki/profilowe/profilowe2.jpg" alt="Profil 2" class="profile-pic">
            </div>
        </label>
        <label>
            <input type="radio" name="profilowe" value="profilowe3.jpg">
            <div class="profile-pic-container">
                <img src="/fiszki/profilowe/profilowe3.jpg" alt="Profil 3" class="profile-pic">
            </div>
        </label>
        <label>
            <input type="radio" name="profilowe" value="profilowe4.jpg">
            <div class="profile-pic-container">
                <img src="/fiszki/profilowe/profilowe4.jpg" alt="Profil 4" class="profile-pic">
            </div>
        </label>
        <label>
            <input type="radio" name="profilowe" value="profilowe5.jpg">
            <div class="profile-pic-container">
                <img src="/fiszki/profilowe/profilowe5.jpg" alt="Profil 5" class="profile-pic">
            </div>
        </label>
        <label>
            <input type="radio" name="profilowe" value="profilowe6.jpg">
            <div class="profile-pic-container">
                <img src="/fiszki/profilowe/profilowe6.jpg" alt="Profil 6" class="profile-pic">
            </div>
        </label>
    </div>
    
    <p class="dodawanie_p">Nowe profilowe: <input type="file" name="obrazek"></p>
    
    <input type="submit" name="submit" value="Zarejestruj się" class="login-button">
    <p class="link"><a href="login.php">Zaloguj się</a></p>
</form>


<?php 
}
?>
    
</body>
</html>
