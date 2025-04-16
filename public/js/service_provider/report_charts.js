const ctxGender = document.getElementById('genderChart').getContext('2d');
const genderChart = new Chart(ctxGender, {
    type: 'pie',
    data: {
        labels: ['Male', 'Female'],
        datasets: [{
            label: 'Gender Distribution',
            data: [58, 42], 
            backgroundColor: ['#2f2d92', '#e89611'],
            borderColor: '#fff',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Gender Distribution',
                font: {
                    size: 18 
                }
            },
            datalabels: {
                formatter: (value, ctx) => {
                    const total = ctx.dataset.data.reduce((acc, val) => acc + val, 0);
                    const percentage = ((value / total) * 100).toFixed(1) + '%';
                    return percentage;
                },
                color: '#fff',
                font: {
                    size: 11
                }
            }
        }
    },
    plugins: [ChartDataLabels] 
});

const ctxAge = document.getElementById('ageChart').getContext('2d');
const ageChart = new Chart(ctxAge, {
    type: 'pie',
    data: {
        labels: ['21', '22', '23', '24', 'Other'],
        datasets: [{
            label: 'Age Distribution',
            data: [37, 28, 23, 12, 5], 
            backgroundColor: ['#2f2d92', '#e89611', '#17616e', '#e36c14', '#666667'],
            borderColor: '#fff',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Age Distribution',
                font: {
                    size: 18 
                }
            },
            datalabels: {
                formatter: (value, ctx) => {
                    const total = ctx.dataset.data.reduce((acc, val) => acc + val, 0);
                    const percentage = ((value / total) * 100).toFixed(1) + '%';
                    return percentage;
                },
                color: '#fff',
                font: {
                    size: 11
                }
            }
        }
    },
    plugins: [ChartDataLabels] 
});

const ctxLocation = document.getElementById('locationChart').getContext('2d');
const locationChart = new Chart(ctxLocation, {
    type: 'pie',
    data: {
        labels: ['Galle', 'Matara', 'Colombo', 'Other'],
        datasets: [{
            label: 'Location Distribution',
            data: [38, 36, 36, 10], 
            backgroundColor: ['#2f2d92', '#e89611', '#17616e', '#666667'],
            borderColor: '#fff',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Location Distribution',
                font: {
                    size: 18 
                }
            },
            datalabels: {
                formatter: (value, ctx) => {
                    const total = ctx.dataset.data.reduce((acc, val) => acc + val, 0);
                    const percentage = ((value / total) * 100).toFixed(1) + '%';
                    return percentage;
                },
                color: '#fff',
                font: {
                    size: 11
                }
            }
        }
    },
    plugins: [ChartDataLabels] 
});