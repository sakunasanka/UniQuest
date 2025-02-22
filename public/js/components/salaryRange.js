document.addEventListener("DOMContentLoaded", function () {
    const minSlider = document.getElementById("minSalaryRange");
    const maxSlider = document.getElementById("maxSalaryRange");
    const minSalaryInput = document.getElementById("minSalary");
    const maxSalaryInput = document.getElementById("maxSalary");
    const minSalaryValue = document.getElementById("minSalaryValue");
    const maxSalaryValue = document.getElementById("maxSalaryValue");

    function updateSalaryValues() {
        let min = parseInt(minSlider.value);
        let max = parseInt(maxSlider.value);

        // Prevent min from exceeding max
        if (min >= max) {
            min = max - 5000; 
            minSlider.value = min;
        }

        // Prevent max from going below min
        if (max <= min) {
            max = min + 5000;
            maxSlider.value = max;
        }

        // Update displayed values
        minSalaryValue.textContent = min.toLocaleString();
        maxSalaryValue.textContent = max.toLocaleString();

        // Update hidden inputs for form submission
        minSalaryInput.value = min;
        maxSalaryInput.value = max;
    }

    // Listen for changes on both sliders
    minSlider.addEventListener("input", updateSalaryValues);
    maxSlider.addEventListener("input", updateSalaryValues);

    // Initialize values on page load
    updateSalaryValues();
});
