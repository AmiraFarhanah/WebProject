document.addEventListener('DOMContentLoaded', function() {
    // Fetch data from the server (you need to implement this)
    fetch('get_sales_data.php')
        .then(response => response.json())
        .then(data => {
            // Extract data for menu chart
            const menuLabels = data.map(item => item.menu_name);
            const menuData = data.map(item => item.quantity_sold);

            // Extract data for total sales chart
            const totalSalesLabels = data.map(item => item.menu_name);
            const totalSalesData = data.map(item => item.total_sales);

            // Render Menu Chart
            renderChart('menuChart', 'Menu Sales', menuLabels, menuData);

            // Render Total Sales Chart
            renderChart('totalSalesChart', 'Total Sales', totalSalesLabels, totalSalesData);
        })
        .catch(error => console.error('Error fetching data:', error));
});

function renderChart(canvasId, chartLabel, labels, data) {
    const ctx = document.getElementById(canvasId).getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: chartLabel,
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
