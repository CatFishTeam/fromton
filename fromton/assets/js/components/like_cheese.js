$('.like_cheese_link').click(function (e) {
    e.preventDefault();
    let link = e.target;
    let cheeseId = $(link).data('cheese');

    if(window.isAuthenticated === "false"){
        window.toastr.error('Vous devez être authentifié pour cheezé.<br><a href="/login">Se connecter &larr;</a>');
        return;
    }
    $(link).addClass('like_loading');

    let data = { cheeseId };

    if ($(link).hasClass('like_cheese')) {
        $.ajax({
            type: "POST",
            url: '/like_cheese',
            data: data
        }).done(function () {
            $(link)
                .removeClass('like_loading')
                .removeClass('like_cheese')
                .removeClass('like')
                .addClass('like_on')
                .addClass('unlike_cheese');
            window.toastr.success('Votre cheeze a bien été pris en compte !');
        }).fail(function (err) {
            console.log(err);
        });
    } else if ($(link).hasClass('unlike_cheese')) {
        $.ajax({
            type: "POST",
            url: '/unlike_cheese',
            data: data
        }).done(function () {
            $(link)
                .removeClass('like_loading')
                .removeClass('unlike_cheese')
                .removeClass('like_on')
                .addClass('like')
                .addClass('like_cheese');
            window.toastr.success('Votre n\'êtes plus fondu de ce fromage.');
        }).fail(function (err) {
            console.log(err);
        });
    }
});
