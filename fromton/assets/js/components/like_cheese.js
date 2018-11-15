$('.like_cheese_link').click(function (e) {
    e.preventDefault();
    let link = e.target;
    let cheeseId = $(link).data('cheese');

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
        }).fail(function (err) {
            console.log(err);
        });
    }
});
