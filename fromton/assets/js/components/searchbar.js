$('#searchbar').on('keyup', (data) => {

    console.log(data.target.value);

    if (data.target.value.length >= 3) {
        fetch('/search?q=' + data.target.value, {
            method: 'GET',
            object: JSON.stringify(data.target.value)
        })
            .then((resp) => resp.json())
            .then(function (data) {
                let ul = $('#searchbar-dropdown');


                for (let value of data) {
                    console.log(value);

                    let li = document.createElement('li');

                    li.innerHTML = `<a href="/cheese/${value.name}">
                                        <img src='/build/assets/images/svg/roundedChesse.c4eacb29.svg'>
                                        <div class="search-result-content">
                                            <p>${value.name}</p>
                                            <span>${value.category.name}</span>
                                            <span>${value.location.name} - ${value.location.country.name}</span>
                                        </div>
                                    </a>`

                    ul.append(li);

                }

            })
    }
});