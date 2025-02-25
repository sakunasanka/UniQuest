document.addEventListener("DOMContentLoaded", function () {
    const minSlider = document.getElementById("minSalaryRange");
    const maxSlider = document.getElementById("maxSalaryRange");
    const minSalaryInput = document.getElementById("minSalary");
    const maxSalaryInput = document.getElementById("maxSalary");
    const minSalaryValue = document.getElementById("minSalaryValue");
    const maxSalaryValue = document.getElementById("maxSalaryValue");
    const salaryFrequencySelect = document.getElementById("salaryFrequency");
    const salaryFrequencyHidden = document.getElementById("salaryFrequencyHidden");

    // Function to update the salary values and hidden inputs
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

    // Function to update the salary frequency hidden input
    function updateSalaryFrequency() {
        salaryFrequencyHidden.value = salaryFrequencySelect.value;
    }

    // Listen for changes on both sliders
    minSlider.addEventListener("input", updateSalaryValues);
    maxSlider.addEventListener("input", updateSalaryValues);

    // Listen for changes on the salary frequency dropdown
    salaryFrequencySelect.addEventListener("change", updateSalaryFrequency);

    // Initialize values on page load
    updateSalaryValues();
    updateSalaryFrequency(); // Ensure the hidden input reflects the current frequency
});
