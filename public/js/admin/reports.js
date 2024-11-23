// Example Chart Data Fetch
function fetchReportData(period, startDate = null, endDate = null) {
    const data = {
        daily: { newStudents: 10, newCompanies: 8, jobsPosted: 5, internshipsPosted: 3, revenue: 500},
        weekly: { newStudents: 50, newCompanies: 40, jobsPosted: 25, internshipsPosted: 20, revenue: 2500},
        monthly: { newStudents: 200, newCompanies: 140, jobsPosted: 100, internshipsPosted: 85, revenue: 10000},
        yearly: { newStudents: 2400, newCompanies: 1600, jobsPosted: 1200, internshipsPosted: 1000, revenue: 120000},
        custom: { newStudents: 100, newCompanies: 70, jobsPosted: 40, internshipsPosted: 30, revenue: 4000},
    };
    // Example: Simulated API call with filters
    console.log(`Fetching ${period} report data from ${startDate} to ${endDate}`);
    return data[period];
}

// Highlight Active Button
function setActiveButton(button) {
    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');
}

// Event Listener for Filter Buttons
document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', event => {
        const period = event.target.dataset.period;

        // Set active button
        setActiveButton(event.target);

        // Toggle Date Filters for Custom
        const dateFilters = document.querySelector('.date-filters');
        if (period === 'custom') {
            dateFilters.style.display = 'flex';
        } else {
            dateFilters.style.display = 'none';
            const reportData = fetchReportData(period);
            updateReportData(reportData);
        }
    });
});

// Apply Date Filters
document.getElementById('applyFiltersBtn').addEventListener('click', () => {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const reportData = fetchReportData('custom', startDate, endDate);
    updateReportData(reportData);
});

// Update Report Data
function updateReportData(reportData) {
    document.getElementById('newStudentsCount').textContent = reportData.newStudents;
    document.getElementById('newCompaniesCount').textContent = reportData.newCompanies;
    document.getElementById('jobsPostedCount').textContent = reportData.jobsPosted;
    document.getElementById('internshipsPostedCount').textContent = reportData.internshipsPosted;
    document.getElementById('revenueGenerated').textContent = `$${reportData.revenue}`;

    // Update charts (Placeholder)
    updateCharts();
}

// Update Charts Function (Placeholder Implementation)
function updateCharts() {
    console.log('Updating charts...');
}

// Initial Load: Daily Report
document.addEventListener('DOMContentLoaded', () => {
    const dailyButton = document.querySelector('.filter-btn[data-period="daily"]');
    dailyButton.click();
});

// Get reference to canvas elements
var registrationsCtx = document.getElementById('registrationsChart').getContext('2d');
var jobListingsCtx = document.getElementById('jobListingsChart').getContext('2d');
var revenueCtx = document.getElementById('revenueChart').getContext('2d');
var loginsCtx = document.getElementById('loginsChart').getContext('2d');

// Initialize the charts
var registrationsChart, jobListingsChart, revenueChart, loginsChart;

// Function to generate the chart data
function generateChartData(period, startDate, endDate) {
    const dateLabels = [];
    const data = {
        daily: { labels: ['1', '2', '3', '4', '5'], datasets: [50, 100, 200, 180, 250] },
        weekly: { labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5'], datasets: [30, 60, 100, 150, 120] },
        monthly: { labels: ['January', 'February', 'March', 'April', 'May'], datasets: [50, 100, 200, 250, 300] },
        yearly: { labels: ['2020', '2021', '2022', '2023', '2024'], datasets: [500, 1000, 1500, 2000, 2500] },
    };

    if (period === 'daily') {
        dateLabels.push("Today", "Yesterday", "2 days ago", "3 days ago", "4 days ago");
    } else if (period === 'weekly') {
        dateLabels.push("Week 1", "Week 2", "Week 3", "Week 4", "Week 5");
    } else if (period === 'monthly') {
        dateLabels.push("January", "February", "March", "April", "May");
    } else if (period === 'yearly') {
        dateLabels.push("2020", "2021", "2022", "2023", "2024");
    }

    return {
        labels: dateLabels,
        datasets: [
            {
                label: 'Students',
                backgroundColor: 'rgba(72, 207, 173, 0.6)',
                data: data[period].datasets
            },
            {
                label: 'Companies',
                backgroundColor: 'rgba(45, 156, 128, 0.6)',
                data: data[period].datasets
            }
        ]
    };
}

// Create charts based on period
function createChart(period, startDate = null, endDate = null) {
    const chartData = generateChartData(period, startDate, endDate);

    if (registrationsChart) registrationsChart.destroy();
    if (jobListingsChart) jobListingsChart.destroy();
    if (revenueChart) revenueChart.destroy();
    if (loginsChart) loginsChart.destroy();

    // Generate Registration Chart
    registrationsChart = new Chart(registrationsCtx, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            plugins: { title: { display: true, text: 'Monthly User Registrations' } },
            scales: { y: { beginAtZero: true, max: 300, ticks: { stepSize: 100 } } }
        }
    });

    // Generate Job Listings Chart
    jobListingsChart = new Chart(jobListingsCtx, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            plugins: { title: { display: true, text: 'Job Listings by Type' } },
            scales: { y: { beginAtZero: true, max: 100, ticks: { stepSize: 25 } } }
        }
    });

    // Generate Revenue Chart (Line Chart)
    revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            plugins: { title: { display: true, text: 'Revenue Over the Months' } },
            scales: { y: { beginAtZero: true, max: 25000, ticks: { stepSize: 5000 } } }
        }
    });

    // Generate User Logins Chart (Doughnut Chart)
    loginsChart = new Chart(loginsCtx, {
        type: 'doughnut',
        data: {
            labels: ['Students', 'Companies'],
            datasets: [{ data: [200, 120], backgroundColor: ['rgba(72, 207, 173, 0.6)', 'rgba(45, 156, 128, 0.6)'] }]
        },
        options: {
            responsive: true,
            plugins: { title: { display: true, text: 'User Logins Breakdown' } }
        }
    });
}

// Highlight Active Filter Button
function setActiveButton(button) {
    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');
}

// Event Listener for Filter Buttons
document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', event => {
        const period = event.target.dataset.period;

        // Set active button
        setActiveButton(event.target);

        // Show/Hide Date Filters for Custom
        const dateFilters = document.querySelector('.date-filters');
        if (period === 'custom') {
            dateFilters.style.display = 'flex';
        } else {
            dateFilters.style.display = 'none';
            createChart(period);
        }
    });
});

// Apply Date Filters
document.getElementById('applyFiltersBtn').addEventListener('click', () => {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    createChart('custom', startDate, endDate);
});

// Initial Load: Daily Report
document.addEventListener('DOMContentLoaded', () => {
    const dailyButton = document.querySelector('.filter-btn[data-period="daily"]');
    dailyButton.click();
});
