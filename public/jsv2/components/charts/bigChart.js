// amchart big Chrat
// большой чарт
var ctx = document.getElementById("myChart");

var data = {
    labels: [
        "Rozetka",
        "PromUa",
        "Bigl",
        "Zakupka"
    ],
    datasets: [
        {
            data: [300, 50, 100, 40],
            backgroundColor: [
                "#009c26",
                "#613894",
                "#f15833",
                "#e1001a"
            ],
            hoverBackgroundColor: [
                "#008721",
                "#4a217d",
                "#e03910",
                "#cf0018"
            ],
            borderWidth: [
                "0",
                "0",
                "0",
                "0"
            ],
            borderColor: [
                "transparent",
                "transparent",
                "transparent",
                "transparent"
            ]

        }]
};

var options = {
    cutoutPercentage:40,
    legend: {
        display: false
    },
};


var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});