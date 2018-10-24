$('#searchbar').on('keyup', (data) => {
    if (data.target.value.length >= 3) {
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
                    li.innerHTML = `<a href="/cheese/${value.name}">
                                        <img src='/build/assets/images/svg/roundedChesse.c4eacb29.svg'>
                                        <div class="search-result-content">
                                            <p>${value.name}</p>
                                            <span>${value.category.name} - ${value.animal.name}</span>
                                            <span>${value.location.name} - ${value.location.country.name}</span>
                                        </div>
                                    </a>`
                    ul.append(li);
                }
            })
    }
});

$('#searchbar').focusout(() => {
    $('#searchbar-dropdown').hide();
});