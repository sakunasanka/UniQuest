// Chart configuration constants
const CHART_CONFIG = {
    type: 'pie',
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'top' },
            title: { 
                display: true,
                font: { size: 18 }
            },
            tooltip: {
                callbacks: {
                    label: (context) => {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        return `${context.label}: ${((context.raw / total) * 100).toFixed(1)}%`;
                    }
                }
            },
            datalabels: {
                formatter: (value, ctx) => {
                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                    return total > 0 ? `${((value / total) * 100).toFixed(1)}%` : '0%';
                },
                color: '#fff',
                font: { size: 11, weight: 'bold' }
            }
        }
    },
    colors: {
        gender: ['#2f2d92', '#e89611', '#17616e'],
        age: ['#2f2d92', '#e89611', '#17616e', '#e36c14', '#666667'],
        location: ['#2f2d92', '#e89611', '#17616e', '#e36c14', '#666667']
    }
};

document.addEventListener('DOMContentLoaded', function() {
    // Ensure reportData is defined and log it for debugging
    console.log(reportData.totalApplicants);
    if (typeof reportData === 'undefined' || !reportData) {
        console.error('reportData is not defined or invalid');
        hideAllChartCards();
        return;
    }
    console.debug('Demographic Data:', reportData);

    // Hide all charts if no applicants
    if (!reportData.totalApplicants || parseInt(reportData.totalApplicants) === 0) {
        hideAllChartCards();
        return; // Prevent further chart initialization
    }

    try {
        // Initialize all charts
        initChart('gender', processGenderData);
        initChart('age', processAgeData);
        initChart('location', processLocationData);
    } catch (error) {
        console.error('Chart initialization failed:', error);
    }
});

// Function to hide all chart cards
function hideAllChartCards() {
    const chartContainers = document.querySelectorAll('.demographic-card');
    chartContainers.forEach(container => {
        container.style.display = 'none';
    });
    
    // Optional: Show a message
    const demographicsSection = document.querySelector('.applicant-demographics');
    if (demographicsSection) {
        const noDataMessage = document.createElement('p');
        noDataMessage.textContent = 'No applicant data available';
        noDataMessage.style.textAlign = 'center';
        noDataMessage.style.padding = '20px';
        noDataMessage.style.fontStyle = 'italic';
        noDataMessage.style.color = '#666';
        demographicsSection.appendChild(noDataMessage);
    }
}

// Function to hide gender distribution chart
function hideGenderDistribution() {
    const genderChartCard = document.querySelector('.gender-distribution-card');
    if (genderChartCard) {
        genderChartCard.style.display = 'none';
    }
}
// Generic chart initialization
function initChart(type, dataProcessor) {
    const canvasId = `${type}Chart`;
    const canvas = document.getElementById(canvasId);
    
    if (!canvas) {
        console.error(`Canvas element not found: ${canvasId}`);
        return;
    }

    const rawData = reportData[type];
    if (!rawData || Object.keys(rawData).length === 0) {
        showChartError(canvasId, `No ${type} data available`);
        return;
    }

    // Remove any existing no-data message when showing charts
    const demographicSection = document.querySelector('.applicant-demographics');
    if (demographicSection) {
        const msg = demographicSection.querySelector('.no-data-message');
        if (msg) msg.style.display = 'none';
        
        // Ensure the grid is visible
        const grid = demographicSection.querySelector('.demographic-grid');
        if (grid) grid.style.display = 'grid';
        
        // Show all cards
        const cards = demographicSection.querySelectorAll('.demographic-card, .card');
        cards.forEach(card => {
            card.style.display = 'block';
        });
    }

    const processedData = dataProcessor(rawData);
    if (processedData.labels.length === 0) {
        showChartError(canvasId, `No ${type} data available`);
        return;
    }

    renderPieChart(
        canvasId,
        processedData.labels,
        processedData.values,
        CHART_CONFIG.colors[type],
        `${type.charAt(0).toUpperCase() + type.slice(1)} Distribution`
    );
}

// Data processors
function processGenderData(data) {
    return {
        labels: Object.keys(data),
        values: Object.values(data)
    };
}

function processAgeData(data) {
    const ranges = {
        '18-21': 0, '22-25': 0, '26-30': 0, 
        '31-35': 0, '36+': 0
    };

    Object.entries(data).forEach(([age, percent]) => {
        const ageNum = parseInt(age);
        if (ageNum <= 21) ranges['18-21'] += percent;
        else if (ageNum <= 25) ranges['22-25'] += percent;
        else if (ageNum <= 30) ranges['26-30'] += percent;
        else if (ageNum <= 35) ranges['31-35'] += percent;
        else ranges['36+'] += percent;
    });

    // Filter empty ranges
    const result = { labels: [], values: [] };
    Object.entries(ranges).forEach(([range, percent]) => {
        if (percent > 0) {
            result.labels.push(range);
            result.values.push(percent);
        }
    });

    return result;
}

function processLocationData(data) {
    const sorted = Object.entries(data)
        .map(([city, percent]) => ({ city, percent }))
        .sort((a, b) => b.percent - a.percent);

    const top3 = sorted.slice(0, 3);
    const other = sorted.slice(3).reduce((sum, loc) => sum + loc.percent, 0);

    const result = {
        labels: top3.map(loc => loc.city),
        values: top3.map(loc => loc.percent)
    };

    if (other > 0) {
        result.labels.push('Other');
        result.values.push(other);
    }

    return result;
}

// Chart rendering
function renderPieChart(canvasId, labels, data, colors, title) {
    try {
        const ctx = document.getElementById(canvasId).getContext('2d');
        
        // Destroy existing chart if it exists
        const existingChart = Chart.getChart(canvasId);
        if (existingChart) existingChart.destroy();
        
        new Chart(ctx, {
            ...CHART_CONFIG,
            data: {
                labels,
                datasets: [{
                    label: title,
                    data,
                    backgroundColor: colors,
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                ...CHART_CONFIG.options,
                plugins: {
                    ...CHART_CONFIG.options.plugins,
                    title: {
                        ...CHART_CONFIG.options.plugins.title,
                        text: title
                    }
                }
            }
        });
    } catch (error) {
        console.error(`Failed to render ${canvasId}:`, error);
        showChartError(canvasId, 'Chart rendering failed');
    }
}

// Error handling
function showChartError(canvasId, message) {
    const canvas = document.getElementById(canvasId);
    if (canvas) {
        const existingChart = Chart.getChart(canvasId);
        if (existingChart) existingChart.destroy();
        
        // Clear any existing content
        canvas.innerHTML = '';
        
        // Create error message element
        const errorDiv = document.createElement('div');
        errorDiv.className = 'chart-error';
        errorDiv.innerHTML = `
            <span class="material-icons">error_outline</span>
            <p>${message}</p>
        `;
        
        // Append to canvas container
        canvas.parentNode.appendChild(errorDiv);
    }
    console.warn(`Chart Error [${canvasId}]: ${message}`);
}
// Add this function to handle PDF generation
