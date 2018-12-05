import Chart from 'chart.js';

let myCheeses;
fetch('/cheeseOfTheWeek/stats',{
    method: "POST"
})
.then((response) => {
    console.log(response);
    return response.json();
}).then(function(myJson) {
    myCheeses = myJson;
    console.log(myCheeses);
});

let data;
let label = [];
myCheeses.forEach( (cheese) => {
    label.push(cheese.name)

})

var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: 'n° of Clicks',
            data: [12, 19, 3, 5, 2, 3],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});