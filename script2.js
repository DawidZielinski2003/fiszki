$(document).ready(function () {
    console.log("Document ready");

    $(".fav").on("click", function () {
        console.log("Favorite clicked");

        const akapit = $(this);
        const idslowa = akapit.data("slowo");
        console.log("ID słowa:", idslowa);

        $.post("changeFav.php", { idslowa: idslowa }, function (data) {
            console.log("Response data:", data);

            if (data.trim() === "sukces") {
                console.log("Gwiazdka zaktualizowana");
                if (akapit.attr("src") === "gwiazda_pusta.png") {
                    akapit.attr("src", "gwiazda_pełna.png");
                } else {
                    akapit.attr("src", "gwiazda_pusta.png");
                }
            } else {
                console.error("Wystąpił błąd: " + data);
            }
        }).fail(function(xhr, status, error) {
            console.error("Błąd podczas aktualizacji gwiazdki:", status, error);
        });
    });
});
