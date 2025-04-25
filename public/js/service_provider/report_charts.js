// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {
    // Check if reportData is available
    if (typeof reportData === 'undefined') {
        console.error('Report data is not available');
        return;
    }

    // Initialize demographic charts
    if (document.getElementById('genderChart')) {
        initializeGenderChart(reportData.gender);
    }
    
    if (document.getElementById('ageChart')) {
        initializeAgeChart(reportData.age);
    }
    
    if (document.getElementById('locationChart')) {
        // Update this to match the new field name if needed
        // (if you changed from location to university in the backend)
        initializeLocationChart(reportData.location);
    }

    // Function to initialize gender distribution chart
    function initializeGenderChart(data) {
        const ctx = document.getElementById('genderChart').getContext('2d');
        const labels = Object.keys(data);
        const values = Object.values(data);
        
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(201, 203, 207, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(201, 203, 207, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Gender Distribution',
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        position: 'bottom'
                    },
                    datalabels: {
                        formatter: (value) => {
                            if (value === 0) return '';
                            return value + '%';
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }

    // Function to initialize age distribution chart
    function initializeAgeChart(data) {
        const ctx = document.getElementById('ageChart').getContext('2d');
        const labels = Object.keys(data);
        const values = Object.values(data);
        
        // Show a message if no age data is available
        if (labels.length === 0) {
            displayNoDataMessage(ctx, 'No age data available');
            return;
        }
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Age Distribution',
                    data: values,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Age Distribution',
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        display: false
                    },
                    datalabels: {
                        formatter: (value) => {
                            if (value === 0) return '';
                            return value + '%';
                        },
                        color: '#000',
                        anchor: 'end',
                        align: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        max: 100
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }

    // Function to initialize location distribution chart
    function initializeLocationChart(data) {
        const ctx = document.getElementById('locationChart').getContext('2d');
        const labels = Object.keys(data);
        const values = Object.values(data);
    
        if (labels.length === 0 || (labels.length === 1 && values[0] === 100 && labels[0].toLowerCase() === 'other')) {
            displayNoDataMessage(ctx, 'No university data available');
            return;
        }
    
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: [
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 205, 86, 0.7)',
                        'rgba(201, 203, 207, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 159, 64, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(201, 203, 207, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'University Distribution', // changed
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        position: 'bottom'
                    },
                    datalabels: {
                        formatter: (value) => {
                            if (value === 0) return '';
                            return value + '%';
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }
    
    
    // Helper function to display a message when no data is available
    function displayNoDataMessage(ctx, message) {
        // Clear the canvas
        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
        
        // Display the message
        ctx.font = '14px Arial';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillStyle = '#666';
        ctx.fillText(message, ctx.canvas.width / 2, ctx.canvas.height / 2);
    }
});