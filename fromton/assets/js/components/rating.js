import 'rateyo'

//Home
const levels = $(".home__cheese__rating .rating");
if(levels.length > 0){
    Object.keys(levels).forEach(function(key) {
        let rating = $(levels[key]).data('rating')
        $(levels[key]).rateYo({
            readOnly: true,
            rating: rating
        });
    });
}

//Show Cheese
const stars = $('.show__cheese__rating--user');
stars.rateYo().on("rateyo.set", function (e, data) {
    //@TODO add cheese
    fetch('/cheese/setNote', {
        method: "POST",
        body: JSON.stringify(data),
    })
        .then(function(response) {
            console.log(response);
            return response.json();
        })
        .then(function(myJson) {
            console.log(JSON.stringify(myJson));
        });
});