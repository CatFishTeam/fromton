import 'rateyo'

//Home
const levels = $(".home__cheese__rating .rating");
if(levels.length > 0){
    for(const key in Object.keys(levels)){
        let rating = $(levels[key]).data('rating');
        $(levels[key]).rateYo({
            readOnly: true,
            rating: rating
        });
    }
}

//Show Cheese
const stars = $('.show__cheese__rating--user');
stars.rateYo({rating: stars.data('rating')})
    .on("rateyo.set", function (e, data) {
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
            console.log(JSON.stringify(myJson));
        });
});