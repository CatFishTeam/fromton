import 'rateyo'
$(function(){
    const levels = $(".rateYo");
    Object.keys(levels).forEach(function(key) {
        let rating = $(levels[key]).data('rating')
        $(levels[key]).rateYo({
            readOnly: true,
            rating: rating
        });
    });
});