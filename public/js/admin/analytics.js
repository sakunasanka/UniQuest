// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {
    // Process data for charts
    const months = processMonthLabels(analyticsData.registrationStats);
    const registrationData = processRegistrationData(analyticsData.registrationStats);
    const jobData = processJobData(analyticsData.jobStats);
    const revenueData = processRevenueData(analyticsData.revenueStats);
    const loginData = processLoginData(analyticsData.loginStats);

    // User Registrations Chart
    var registrationsCtx = document.getElementById('registrationsChart').getContext('2d');
    var registrationsChart = new Chart(registrationsCtx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Students',
                    backgroundColor: 'rgba(72, 207, 173, 0.6)',
                    data: registrationData.students,
                },
                {
                    label: 'Companies',
                    backgroundColor: 'rgba(45, 156, 128, 0.6)',
                    data: registrationData.companies,
                }
            ]
        },
        options: getChartOptions('Monthly User Registrations')
    });

    // Job Listings Chart
    var jobListingsCtx = document.getElementById('jobListingsChart').getContext('2d');
    var jobListingsChart = new Chart(jobListingsCtx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Part Time Jobs',
                    backgroundColor: 'rgba(72, 207, 173, 0.6)',
                    data: jobData.partTime,
                },
                {
                    label: 'Internships',
                    backgroundColor: 'rgba(45, 156, 128, 0.6)',
                    data: jobData.internships,
                }
            ]
        },
        options: getChartOptions('Job Listings by Type')
    });

    // Revenue Curve Chart
    var revenueCtx = document.getElementById('revenueChart').getContext('2d');
    var revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Revenue',
                    backgroundColor: 'rgba(45, 156, 128, 0.6)',
                    borderColor: 'rgba(45, 156, 128, 0.8)',
                    data: revenueData,
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(72, 207, 173, 1)',
                    pointBorderColor: 'rgba(45, 156, 128, 0.8)',
                    pointHoverBackgroundColor: 'rgba(72, 207, 173, 1)',
                    pointHoverBorderColor: 'rgba(45, 156, 128, 1)',
                }
            ]
        },
        options: getChartOptions('Revenue Over the Months', true)
    });

    // User Logins Chart
    var loginsCtx = document.getElementById('loginsChart').getContext('2d');
    var loginsChart = new Chart(loginsCtx, {
        type: 'doughnut',
        data: {
            labels: loginData.labels,
            datasets: [
                {
                    label: 'User Logins',
                    backgroundColor: ['rgba(72, 207, 173, 0.6)', 'rgba(45, 156, 128, 0.6)'],
                    data: loginData.data,
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
    });

    // Helper functions
    function processMonthLabels(stats) {
        if (!stats || stats.length === 0) return getDefaultMonths(5);
        
        return stats.map(item => {
            const date = new Date(item.month + '-01');
            return date.toLocaleString('default', { month: 'short' });
        });
    }

    function processRegistrationData(stats) {
        if (!stats || stats.length === 0) {
            return {
                students: Array(5).fill(0),
                companies: Array(5).fill(0)
            };
        }
        
        return {
            students: stats.map(item => item.students || 0),
            companies: stats.map(item => item.companies || 0)
        };
    }

    function processJobData(stats) {
        if (!stats || stats.length === 0) {
            return {
                partTime: Array(5).fill(0),
                internships: Array(5).fill(0)
            };
        }
        
        return {
            partTime: stats.map(item => item.part_time || 0),
            internships: stats.map(item => item.internships || 0)
        };
    }

    function processRevenueData(stats) {
        if (!stats || stats.length === 0) return Array(5).fill(0);
        
        return stats.map(item => item.revenue || 0);
    }

    function processLoginData(stats) {
        if (!stats || stats.length === 0) {
            return {
                labels: ['Students', 'Companies'],
                data: [0, 0]
            };
        }
        
        // Initialize counts
        let studentCount = 0;
        let companyCount = 0;
        
        // Sum up counts from the stats array
        stats.forEach(item => {
            if (item.Role === 'Student') {
                studentCount = item.count || 0;
            } else if (item.Role === 'Company') {
                companyCount = item.count || 0;
            }
        });
        
        return {
            labels: ['Students', 'Companies'],
            data: [studentCount, companyCount]
        };
    }

    function getChartOptions(title, isLineChart = false) {
        // Calculate max values based on actual data
        let maxValue;
        if (isLineChart) {
            maxValue = Math.max(...revenueData, 1) * 1.2;
        } else {
            const allValues = [
                ...registrationData.students,
                ...registrationData.companies,
                ...jobData.partTime,
                ...jobData.internships
            ];
            maxValue = Math.max(...allValues, 1) * 1.2;
        }
        
        // Calculate appropriate step size
        const stepSize = isLineChart ? 
            Math.ceil(maxValue / 5 / 1000) * 1000 : 
            Math.ceil(maxValue / 5);
        
        return {
            responsive: true,
            maintainAspectRatio: false, 
            plugins: {
                title: {
                    display: true,
                    text: title,
                    font: {
                        size: 22
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: maxValue,
                    ticks: {
                        stepSize: stepSize,
                        callback: isLineChart ? function(value) {
                            return '$' + value.toLocaleString();
                        } : undefined
                    }
                }
            }
        };
    }

    function getDefaultMonths(count) {
        const months = [];
        const date = new Date();
        
        for (let i = count - 1; i >= 0; i--) {
            const tempDate = new Date();
            tempDate.setMonth(date.getMonth() - i);
            months.push(tempDate.toLocaleString('default', { month: 'short' }));
        }
        
        return months;
    }
});