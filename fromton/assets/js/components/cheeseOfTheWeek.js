const data = {};
data['cheese'] = $('#cheeseOfTheWeek').data('id');
console.log(data);
$('#cheeseOfTheWeek a').click( (e) => {
    e.preventDefault();
    fetch('/cheeseOfTheWeek/clicked', {
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