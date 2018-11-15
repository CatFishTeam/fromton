import Konami from 'konami/konami.js';

var easter_egg = new Konami(function () {
    console.log("konami");

    var htmlcontent = `<iframe src="/pacman"></iframe>`;

    swal({
        title: "Fromton-man",
        content: {
            element: "iframe",
            attributes: {
                src: "/pacman",
                width: "600",
                height: "660",
            },
        },

    });

    $("#pacman-iframe").load(function () {
      $(this)[0].contentWindow.focus();
    })

    // $("#pacman-iframe").attr("src", '/pacman');
    // $("#pacman-popup").fadeIn('slow');
});