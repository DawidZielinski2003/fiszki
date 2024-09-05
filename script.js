document.addEventListener('DOMContentLoaded', function() {
    var words = JSON.parse(document.getElementById('words-data').textContent);
    var currentIndex = 0;
    var showingEnglish = true;
    var wordElement = document.getElementById('word');
    var counterElement = document.getElementById('counter');
    var currentId = words.length > 0 ? words[currentIndex].id : null;

    function updateCounter() {
        counterElement.textContent = `${currentIndex + 1} / ${words.length}`;
    }

    function updateWord() {
        wordElement.textContent = showingEnglish ? words[currentIndex].slowo_eng : words[currentIndex].slowo_pl;
        currentId = words[currentIndex].id;
        $(".fav").data("slowo", currentId); 
        updateCounter();
        updateFavoriteIcon(currentId); 
        updateProgress();
    }

    function updateFavoriteIcon(currentId) {
        $.post("checkFav.php", { idslowa: currentId }, function(response) {
            console.log("Odpowiedź z checkFav.php:", response.trim());
            if (response.trim() === "saved") {
                $(".fav").attr("src", "gwiazda_pełna.png");  
            } else {
                $(".fav").attr("src", "gwiazda_pusta.png");  
            }
        });
    }

    function updateProgress() {
        $.post("updateProgres.php", { idSlowa: currentId, idKategorii: idKategorii }, function(response) {
            console.log("Odpowiedź z updateProgres.php:", response.trim());
        });
    }

    function deleteProgress() {
        $.post("deleteProgres.php", { idKategorii: idKategorii }, function(response) {
            console.log("Odpowiedź z deleteProgres.php:", response.trim());
        });
    }

    function checkAndDeleteProgress() {
        if (currentIndex === words.length - 1) {
            deleteProgress();
        }
    }

    if (words.length > 0) {
        updateWord();
    }

    wordElement.addEventListener('click', function() {
        showingEnglish = !showingEnglish;
        updateWord();
    });

    document.getElementById('prev-btn').addEventListener('click', function() {
        if (currentIndex > 0) {
            currentIndex--;
            showingEnglish = true;
            updateWord();
        }
    });

    document.getElementById('next-btn').addEventListener('click', function() {
        if (currentIndex < words.length - 1) {
            currentIndex++;
            showingEnglish = true;
            updateWord();
        } else {
            // Jeżeli jesteśmy na ostatniej fiszce, wywołaj usunięcie postępu
            checkAndDeleteProgress();
        }
    });
});
