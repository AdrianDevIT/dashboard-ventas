<div>
    <div x-data="{ chart: null }" x-init="chart = new Chart($refs.canvas, {
        type: 'bar',
        data: {
            labels: {{ json_encode(array_keys($salesData)) }},
            datasets: [{
                label: 'Ventas Mensuales',
                data: {{ json_encode(array_values($salesData)) }},
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });">
        <canvas x-ref="canvas"></canvas>
    </div>
</div>
