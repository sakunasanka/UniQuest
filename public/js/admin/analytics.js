// User Registrations Chart
var registrationsCtx = document.getElementById('registrationsChart').getContext('2d');
var registrationsChart = new Chart(registrationsCtx, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May'],
        datasets: [
            {
                label: 'Students',
                backgroundColor: 'rgba(72, 207, 173, 0.6)',
                data: [50, 100, 200, 180, 250],
            },
            {
                label: 'Companies',
                backgroundColor: 'rgba(45, 156, 128, 0.6)',
                data: [20, 40, 100, 80, 120],
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, 
        plugins: {
            title: {
                display: true,
                text: 'Monthly User Registrations',
                font: {
                    size: 22
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 300,
                ticks: {
                    stepSize: 100, 
                }
            }
        }
    },
    width: 200, 
    height: 200 
});

// Job Listings Chart
var jobListingsCtx = document.getElementById('jobListingsChart').getContext('2d');
var jobListingsChart = new Chart(jobListingsCtx, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May'],
        datasets: [
            {
                label: 'Part Time Jobs',
                backgroundColor: 'rgba(72, 207, 173, 0.6)',
                data: [30, 50, 60, 80, 90],
            },
            {
                label: 'Internships',
                backgroundColor: 'rgba(45, 156, 128, 0.6)',
                data: [20, 40, 50, 70, 65],
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Job Listings by Type',
                font: {
                    size: 22
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                ticks: {
                    stepSize: 25, 
                }
            }
        }
    },
    width: 200, 
    height: 200 
});

// Revenue Curve Chart
var revenueCtx = document.getElementById('revenueChart').getContext('2d');
var revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May'],
        datasets: [
            {
                label: 'Revenue',
                backgroundColor: 'rgba(45, 156, 128, 0.6)',
                borderColor: 'rgba(45, 156, 128, 0.8)',
                data: [10000, 15000, 12000, 22000, 20000],
                fill: false,
                tension: 0.4,
                pointBackgroundColor: 'rgba(72, 207, 173, 1)',
                pointBorderColor: 'rgba(45, 156, 128, 0.8)',
                pointHoverBackgroundColor: 'rgba(72, 207, 173, 1)',
                pointHoverBorderColor: 'rgba(45, 156, 128, 1)',
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Revenue Over the Months',
                font: {
                    size: 22
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 25000,
                ticks: {
                    stepSize: 5000, 
                }
            }
        }
    },
    width: 200, 
    height: 200 
});

// User Logins Chart
var loginsCtx = document.getElementById('loginsChart').getContext('2d');
var loginsChart = new Chart(loginsCtx, {
    type: 'doughnut',
    data: {
        labels: ['Students', 'Companies'],
        datasets: [
            {
                label: 'User Logins',
                backgroundColor: ['rgba(72, 207, 173, 0.6)', 'rgba(45, 156, 128, 0.6)'],
                data: [200, 120],
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'User Logins Breakdown',
                font: {
                    size: 22
                }
            }
        }
    },
    width: 200, 
    height: 200 
});
