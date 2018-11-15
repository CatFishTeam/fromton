$('.like_publication_link').click(function (e) {
    e.preventDefault();
    let link = e.target;
    let publicationId = $(link).data('publication');

    $(link).addClass('like_loading');

    let data = { publicationId };

    if ($(link).hasClass('like_publication')) {
        $.ajax({
            type: "POST",
            url: '/like_publication',
            data: data
        }).done(function () {
            $(link)
                .removeClass('like_loading')
                .removeClass('like_publication')
                .removeClass('like')
                .addClass('like_on')
                .addClass('unlike_publication');
        }).fail(function (err) {
            console.log(err);
        });
    } else if ($(link).hasClass('unlike_publication')) {
        $.ajax({
            type: "POST",
            url: '/unlike_publication',
            data: data
        }).done(function () {
            $(link)
                .removeClass('like_loading')
                .removeClass('unlike_publication')
                .removeClass('like_on')
                .addClass('like')
                .addClass('like_publication');
        }).fail(function (err) {
            console.log(err);
        });
    }
});
