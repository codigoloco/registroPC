import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('statsChart').getContext('2d');
    
    // Generate dummy data
    const labels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'];
    const data = {
        labels: labels,
        datasets: [{
            label: 'Casos Mensuales',
            data: [70, 55, 54, 55, 75, 48],
            backgroundColor: [
                'rgba(59, 130, 246, 0.7)', // Blue
                'rgba(30, 64, 175, 0.8)', // Dark Blue
                'rgba(96, 165, 250, 0.7)',
                'rgba(59, 130, 246, 0.7)',
                'rgba(30, 64, 175, 0.8)',
                'rgba(96, 165, 250, 0.7)',
            ],
            borderColor: [
                'rgb(59, 130, 246)',
                'rgb(30, 64, 175)',
                'rgb(96, 165, 250)',
                'rgb(59, 130, 246)',
                'rgb(30, 64, 175)',
                'rgb(96, 165, 250)',
            ],
            borderWidth: 1,
            borderRadius: 5,
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    };

    new Chart(ctx, config);
});
