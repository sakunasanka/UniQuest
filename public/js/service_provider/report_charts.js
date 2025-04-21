// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {
    // Ensure analyticsData exists and has proper structure
    if (!window.analyticsData) {
        window.analyticsData = {
            registrationStats: [],
            jobStats: [],
            revenueStats: [],
            loginStats: []
        };
    }

    // Process data for charts
    const months = processMonthLabels(analyticsData.registrationStats);
    const registrationData = processRegistrationData(analyticsData.registrationStats);
    const jobData = processJobData(analyticsData.jobStats);
    const revenueData = processRevenueData(analyticsData.revenueStats);
    const loginData = processLoginData(analyticsData.loginStats);

    // Initialize charts only if their containers exist
    if (document.getElementById('registrationsChart')) {
        initializeRegistrationsChart(months, registrationData);
    }
    
    if (document.getElementById('jobListingsChart')) {
        initializeJobListingsChart(months, jobData);
    }
    
    if (document.getElementById('revenueChart')) {
        initializeRevenueChart(months, revenueData);
    }
    
    if (document.getElementById('loginsChart')) {
        initializeLoginsChart(loginData);
    }

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
            students: stats.map(item => parseInt(item.students) || 0),
            companies: stats.map(item => parseInt(item.companies) || 0)
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
            partTime: stats.map(item => parseInt(item.part_time) || 0),
            internships: stats.map(item => parseInt(item.internships) || 0)
        };
    }

    function processRevenueData(stats) {
        if (!stats || stats.length === 0) return Array(5).fill(0);
        
        return stats.map(item => parseFloat(item.revenue) || 0);
    }

    function processLoginData(stats) {
        if (!stats || stats.length === 0) {
            return {
                labels: ['Students', 'Companies'],
                data: [0, 0]
            };
        }
        
        let studentCount = 0;
        let companyCount = 0;
        
        stats.forEach(item => {
            if (item.Role === 'Student') {
                studentCount = parseInt(item.count) || 0;
            } else if (item.Role === 'Company') {
                companyCount = parseInt(item.count) || 0;
            }
        });
        
        return {
            labels: ['Students', 'Companies'],
            data: [studentCount, companyCount]
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

    function initializeRegistrationsChart(months, data) {
        var ctx = document.getElementById('registrationsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Students',
                        backgroundColor: 'rgba(72, 207, 173, 0.6)',
                        data: data.students,
                    },
                    {
                        label: 'Companies',
                        backgroundColor: 'rgba(45, 156, 128, 0.6)',
                        data: data.companies,
                    }
                ]
            },
            options: getChartOptions('Monthly User Registrations')
        });
    }

    function initializeJobListingsChart(months, data) {
        var ctx = document.getElementById('jobListingsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Part Time Jobs',
                        backgroundColor: 'rgba(72, 207, 173, 0.6)',
                        data: data.partTime,
                    },
                    {
                        label: 'Internships',
                        backgroundColor: 'rgba(45, 156, 128, 0.6)',
                        data: data.internships,
                    }
                ]
            },
            options: getChartOptions('Job Listings by Type')
        });
    }

    function initializeRevenueChart(months, data) {
        var ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        label: 'Revenue',
                        backgroundColor: 'rgba(45, 156, 128, 0.6)',
                        borderColor: 'rgba(45, 156, 128, 0.8)',
                        data: data,
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
    }

    function initializeLoginsChart(data) {
        var ctx = document.getElementById('loginsChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'User Logins',
                        backgroundColor: ['rgba(72, 207, 173, 0.6)', 'rgba(45, 156, 128, 0.6)'],
                        data: data.data,
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
            }
        });
    }

    function getChartOptions(title, isLineChart = false) {
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
                    ticks: {
                        callback: isLineChart ? function(value) {
                            return '$' + value.toLocaleString();
                        } : undefined
                    }
                }
            }
        };
    }
});