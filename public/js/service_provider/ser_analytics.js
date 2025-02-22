function getMaxValue(datasets) {
    if (!datasets?.length) return 0;
    
    return Math.max(
        ...datasets.flatMap(dataset => 
            dataset.data?.length ? dataset.data : [0]
        )
    );
}

function getRoundedMaxValue(maxValue, tickCount = 5) {
    if (maxValue <= 0) return 0;
    
    const orderOfMagnitude = Math.pow(10, Math.floor(Math.log10(maxValue)));
    const scaledValue = maxValue / orderOfMagnitude;
    
    // Find appropriate scaling factor
    const scaleFactors = [1, 2, 5, 10];
    const factor = scaleFactors.find(f => f * orderOfMagnitude * tickCount >= maxValue) || 10;
    
    return Math.ceil(scaledValue / factor) * factor * orderOfMagnitude;
}

function getStepSize(maxValue, desiredTicks = 5) {
    if (maxValue <= 0 || desiredTicks <= 0) return 0;
    
    const rawStep = maxValue / desiredTicks;
    const power = Math.pow(10, Math.floor(Math.log10(rawStep)));
    const roundedStep = Math.ceil(rawStep / power) * power;
    
    // Round to nearest "nice" number (1, 2, 5 multiples)
    const niceSteps = [1, 2, 5, 10].map(n => n * power);
    return niceSteps.find(n => n >= roundedStep) || roundedStep;
}

// Data for the charts
var registrationsData = [
    {
        label: 'Part Time Jobs',
        backgroundColor: 'rgba(72, 207, 173, 0.6)',
        data: chartData.jobCount,
    },
    {
        label: 'Internships',
        backgroundColor: 'rgba(45, 156, 128, 0.6)',
        data: chartData.internshipCount,
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

// var jobListingsData = [
//     {
//         label: 'Part Time Jobs',
//         backgroundColor: 'rgba(72, 207, 173, 0.6)',
//         data: [30, 50, 60, 80, 90],
//     },
//     {
//         label: 'Internships',
//         backgroundColor: 'rgba(45, 156, 128, 0.6)',
//         data: [20, 40, 50, 70, 65],
//     }
// ];

// Calculate max values after data is defined
var registrationsMax = getRoundedMaxValue(getMaxValue(registrationsData));
var revenueMax = getRoundedMaxValue(getMaxValue(revenueData));

// Registration Chart
var registrationsCtx = document.getElementById('registrationsChart')?.getContext('2d');
if (registrationsCtx) {
    var registrationsChart = new Chart(registrationsCtx, {
        type: 'bar',
        data: {
            labels: chartData.monthNames,
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
                    label: 'User Applications',
                    backgroundColor: ['rgba(72, 207, 173, 0.6)', 'rgba(45, 156, 128, 0.6)'],
                    data: [chartData.genderCountMale, chartData.genderCountFemale], 
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'User Applications Breakdown',
                    font: {
                        size: 22
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const label = tooltipItem.label || '';
                            const value = tooltipItem.raw || 0;
                            const total = tooltipItem.dataset.data.reduce((acc, val) => acc + val, 0);
                            const percentage = ((value / total) * 100).toFixed(2);
                            return `${label}: ${value} (${percentage}%)`;
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
            labels: ['3 Weeks Ago', '2 Weeks Ago', '1 Week Ago', 'This Week'],
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

// // Job Listings Chart
// var jobListingsCtx = document.getElementById('jobListingsChart')?.getContext('2d');
// if (jobListingsCtx) {
//     var jobListingsChart = new Chart(jobListingsCtx, {
//         type: 'bar',
//         data: {
//             labels: chartData.monthNames,
//             datasets: jobListingsData
//         },
//         options: {
//             responsive: true,
//             maintainAspectRatio: false,
//             plugins: {
//                 title: {
//                     display: true,
//                     text: 'Job Listings by Type',
//                     font: {
//                         size: 22
//                     }
//                 }
//             },
//             scales: {
//                 y: {
//                     beginAtZero: true,
//                     max: jobListingsMax,
//                     ticks: {
//                         stepSize: getStepSize(jobListingsMax), 
//                     }
//                 }
//             }
//         }
//     });
// }