document.addEventListener('DOMContentLoaded', (event) => {
    // Drivers by Status Chart
    var ctx = document.getElementById('driversByStatusChart').getContext('2d');
    var driversByStatusChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: JSON.parse(document.getElementById('driversByStatusLabels').textContent),
            datasets: [{
                label: 'Drivers by Status',
                data: JSON.parse(document.getElementById('driversByStatusData').textContent),
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (context.parsed !== null) {
                                label += ': ' + context.parsed + ' drivers';
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });

    // Trips by Month Chart
    var ctx2 = document.getElementById('tripsByMonthChart').getContext('2d');
    var tripsByMonthChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Trips by Month',
                data: JSON.parse(document.getElementById('tripsByMonthData').textContent),
                backgroundColor: '#4e73df',
                borderColor: '#4e73df',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (context.parsed !== null) {
                                label += ': ' + context.parsed + ' trips';
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e3e6f0'
                    }
                }
            }
        }
    });
});