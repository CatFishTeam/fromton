import 'rateyo'

//Home
const levels = $(".homecheeserating .rating");
if(levels.length > 0){
    for(const key in Object.keys(levels)){
        let rating = $(levels[key]).data('rating');
        $(levels[key]).rateYo({
            starWidth: '26px',
            readOnly: true,
            rating: rating
        });
    }
}

//Show Cheese
const stars = $('.showcheeserating--user');
stars.rateYo({rating: stars.data('rating')})
    .on("rateyo.set", (e, data) => {
        if(window.isAuthenticated === "false"){
            window.toastr.error('Vous devez être authentifié pour voter.<br><a href="/login">Se connecter &larr;</a>');
            return;
        }
        data['cheese'] =  stars.data('cheese');
        fetch('/cheese/setNote', {
            method: "POST",
            body: JSON.stringify(data),
        })
            .then(function(response) {
                console.log(response);
                return response.json();
            })
            .then(function(myJson) {
                window.toastr.success('Votre note a bien été enregistrée !');
                console.log(JSON.stringify(myJson));
            });
    });

$('.showcheeserating--global').rateYo({
    rating: $('.showcheeserating--global').data('rating'),
    readOnly: true,
});