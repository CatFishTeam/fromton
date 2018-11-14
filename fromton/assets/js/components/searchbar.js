var delayTimer;
$('#searchbar').on('keyup', (data) => {
    if (data.target.value.length >= 3) {

        clearTimeout(delayTimer);
        delayTimer = setTimeout(function() {
            fetch('/search?q=' + data.target.value, {
                method: 'GET',
                object: JSON.stringify(data.target.value)
            })
                .then((resp) => resp.json())
                .then(function (data) {
                    let ul = $('#searchbar-dropdown');

                    ul.empty();
                    ul.show();

                    for (const value of data) {
                        let li = document.createElement('li');
                        li.setAttribute('data-link', '/cheese/'+value.slug)
                        li.innerHTML = `<img src='/build/assets/images/svg/roundedChesse.c4eacb29.svg'>
                                        <div class="search-result-content">
                                            <p>${value.name}</p>
                                            <span>Pate ${value.category.name} - Lait de ${value.animal.name}</span>
                                            <span><i class="fa fa-map-marker"></i> ${value.location.name} - <i class="fa fa-globe"></i> ${value.location.country.name}</span>
                                        </div>`
                        ul.append(li);
                    }
                })
        }, 1000);
    }
});

$(document).on('click', '#searchbar-dropdown li', function(){
    window.location = $(this).data('link')
})

$('#searchbar').focusout(() => {
    if ($('#searchbar-dropdown li:hover').length) {
        return ;
    }

    $('#searchbar-dropdown').hide();
});