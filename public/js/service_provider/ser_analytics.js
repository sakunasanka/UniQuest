// Function to get the maximum value from the datasets
function getMaxValue(datasets) {
    let max = 0;  // Initialize max value to 0
    datasets.forEach(dataset => {
        dataset.data.forEach(value => {
            if (value > max) {
                max = value;
            }
        });
    });
    return max;
}

// Function to round the max value to a rounded number (nearest 10, 50, etc.)
function getRoundedMaxValue(maxValue) {
    let stepSize = getStepSize(maxValue);
    
    if (maxValue < 10) {
        return maxValue + stepSize; 
    } else if (maxValue % 10 === 0) {
        return (Math.ceil(maxValue / 10) * 10) + stepSize - 1; 
    } else {
        return Math.ceil(maxValue / 10) * 10; 
    }
}

// Function to set step size based on the max value
function getStepSize(maxValue) {
    return Math.ceil(maxValue / 4); 
}

// Data for the charts
var registrationsData = [
    {
        label: 'Part Time Jobs',
        backgroundColor: 'rgba(72, 207, 173, 0.6)',
        data: [2, 4, 5, 6, 5],
    },
    {
        label: 'Internships',
        backgroundColor: 'rgba(45, 156, 128, 0.6)',
        data: [0, 2, 1, 4, 2],
    }
];

var revenueData = [
    {
        label: 'Applications',
        backgroundColor: 'rgba(45, 156, 128, 0.6)',
        borderColor: 'rgba(45, 156, 128, 0.8)',
        data: [5, 10, 4, 8],
        fill: false,
        tension: 0.4,
        pointBackgroundColor: 'rgba(72, 207, 173, 1)',
        pointBorderColor: 'rgba(45, 156, 128, 0.8)',
        pointHoverBackgroundColor: 'rgba(72, 207, 173, 1)',
        pointHoverBorderColor: 'rgba(45, 156, 128, 1)',
    }
];

var jobListingsData = [
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
];

// Calculate max values after data is defined
var registrationsMax = getRoundedMaxValue(getMaxValue(registrationsData));
var revenueMax = getRoundedMaxValue(getMaxValue(revenueData));
var jobListingsMax = getRoundedMaxValue(getMaxValue(jobListingsData));

// Registration Chart
var registrationsCtx = document.getElementById('registrationsChart')?.getContext('2d');
if (registrationsCtx) {
    var registrationsChart = new Chart(registrationsCtx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May'],
            datasets: registrationsData
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Job Postings by Month',
                    font: {
                        size: 22
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: registrationsMax,
                    ticks: {
                        stepSize: getStepSize(registrationsMax), 
                    }
                }
            }
        }
    });
}

// User Logins Chart (Doughnut Chart)
var loginsCtx = document.getElementById('loginsChart')?.getContext('2d');
if (loginsCtx) {
    var loginsChart = new Chart(loginsCtx, {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [
                {
                    label: 'User Logins',
                    backgroundColor: ['rgba(72, 207, 173, 0.6)', 'rgba(45, 156, 128, 0.6)'],
                    data: [10, 6], 
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
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            let total = 0;
                            tooltipItem.dataset.data.forEach(value => {
                                total += value;
                            });
                            let value = tooltipItem.raw;
                            let percentage = (value / total * 100).toFixed(2);
                            return tooltipItem.label + ': ' + percentage + '%';
                        }
                    }
                }
            }
        }
    });
}

// Revenue Curve Chart
var revenueCtx = document.getElementById('revenueChart')?.getContext('2d');
if (revenueCtx) {
    var revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Week1', 'Week2', 'Week3', 'Week4'],
            datasets: revenueData
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Application trends',
                    font: {
                        size: 22
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: revenueMax,
                    ticks: {
                        stepSize: getStepSize(revenueMax), 
                    }
                }
            }
        }
    });
}

// Job Listings Chart
var jobListingsCtx = document.getElementById('jobListingsChart')?.getContext('2d');
if (jobListingsCtx) {
    var jobListingsChart = new Chart(jobListingsCtx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May'],
            datasets: jobListingsData
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
                    max: jobListingsMax,
                    ticks: {
                        stepSize: getStepSize(jobListingsMax), 
                    }
                }
            }
        }
    });
}
