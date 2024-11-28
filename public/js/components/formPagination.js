document.addEventListener("DOMContentLoaded", function() {
    const steps = document.querySelectorAll(".form-step");
    let currentStep = 0;

    function showStep(step) {
        steps.forEach((stepElement, index) => {
            stepElement.style.display = index === step ? "block" : "none";
        });
    }

    document.querySelectorAll(".next-btn").forEach((button) => {
        button.addEventListener("click", () => {
            currentStep++;
            showStep(currentStep);
        });
    });

    document.querySelectorAll(".prev-btn").forEach((button) => {
        button.addEventListener("click", () => {
            currentStep--;
            showStep(currentStep);
        });
    });

    showStep(currentStep); // Show the first step initially
});