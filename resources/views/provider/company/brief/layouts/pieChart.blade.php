<div class="d-flex justify-content-center mb-3">
  <div class="order-personel-title f14 text-uppercase text-white border-radius p-1 pl-2 pr-2 shadow-custom bg-secondary">
    маркетплейсы
  </div>
</div>

<canvas id="pie-chart" class="shadow-custom border-radius" width="800" height="450"></canvas>
<script>
    var data = <? echo $market_json;?>;
    new Chart(document.getElementById("pie-chart"), {
        type: 'pie',
        data: {
            labels: ["Rozetka", "PromUa", "Bigl", "Zakupka"],
            datasets: [{
                backgroundColor: ["#008C3C", "#8e5ea2","#F15833","#E1001A"],
                data: data
            }]
        },
        options: {
            legend: {
                position: 'bottom',
                labels : {
                    fontSize: 12,
                    boxWidth: 10,
                }
            },
        }
    });
</script>