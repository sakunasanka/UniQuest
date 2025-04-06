// Job Post Form Validation
document.addEventListener('DOMContentLoaded', function() {
    // Get the form element
    const jobPostForm = document.querySelector('form');
    
    // Get form field elements
    const jobName = document.getElementById('jobName');
    const jobDescription = document.getElementById('jobDescription');
    const jobBenefits = document.getElementById('jobBenefits');
    const jobTypeRadios = document.querySelectorAll('input[name="jobType"]');
    const salaryRange = document.getElementById('salaryRange');
    const salaryType = document.getElementById('salaryType');
    const qualifications = document.getElementById('qualifications');
    const jobLocation = document.getElementById('jobLocation');
    const nextBtn = document.querySelector('.next-btn');
    
    // Function to validate form on submission
    function validateForm(e) {
        let isValid = true;
        clearErrors();
        
        // Check each field
        if (!validateField(jobName, 'Please enter a job name')) isValid = false;
        if (!validateRadioGroup(jobTypeRadios, 'Please select a job type')) isValid = false;
        if (!validateField(salaryRange, 'Please specify a salary range')) isValid = false;
        if (!validateField(jobLocation, 'Please specify the job location')) isValid = false;
        
        // Validate salary format (only accept single values like "1000" or "1,000")
        if (salaryRange.value.trim() !== '' && !validateSalaryFormat(salaryRange.value)) {
            displaySalaryError(salaryRange, 'Please enter a valid salary amount (e.g., 1000 or 1,000)');
            isValid = false;
        }
        
        // If the form is not valid, prevent submission
        if (!isValid) {
            e.preventDefault();
            // Scroll to the first error
            const firstError = document.querySelector('.error-message');
            if (firstError) {
                firstError.parentElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
        
        return isValid;
    }
    
    // Function to validate a field is not empty
    function validateField(field, errorMessage) {
        if (field.value.trim() === '') {
            // Special handling for salary field
            if (field === salaryRange) {
                displaySalaryError(field, errorMessage);
            } else {
                displayError(field, errorMessage);
            }
            return false;
        }
        return true;
    }
    
    // Function to validate radio button group
    function validateRadioGroup(radioGroup, errorMessage) {
        let checked = false;
        radioGroup.forEach(radio => {
            if (radio.checked) checked = true;
        });
        
        if (!checked) {
            // Display error near the radio group
            const radioContainer = radioGroup[0].closest('.employment-types');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = errorMessage;
            radioContainer.after(errorDiv);
            return false;
        }
        return true;
    }
    
    // Function to validate salary format - only single values allowed
    function validateSalaryFormat(salary) {
        const salaryRegex = /^[0-9]+(\,[0-9]{3})*(\.[0-9]+)?$/; 
        return salaryRegex.test(salary);
    }
    
    // Function to display error message
    function displayError(field, message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        errorDiv.style.color = 'red';
        errorDiv.style.fontSize = '12px';
        errorDiv.style.marginTop = '-5px';
        errorDiv.style.marginBottom = '5px';
        field.classList.add('error-field');
        field.style.borderColor = 'red';
        
        // Add error message after the field
        field.after(errorDiv);
    }
    
    // Function to display error message specifically for salary field
    function displaySalaryError(field, message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        errorDiv.style.color = 'red';
        errorDiv.style.fontSize = '12px';
        errorDiv.style.marginTop = '-5px';
        errorDiv.style.marginBottom = '5px';
        field.classList.add('error-field');
        field.style.borderColor = 'red';
        
        // Find the salary container or parent element
        const salaryContainer = field.closest('.salary-container') || field.parentElement;
        
        // Remove any existing error messages
        const existingError = salaryContainer.nextElementSibling;
        if (existingError && existingError.classList.contains('error-message')) {
            existingError.remove();
        }
        
        // Add error message after the salary container
        salaryContainer.after(errorDiv);
    }
    
    // Function to clear all errors
    function clearErrors() {
        // Remove all error messages
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(error => error.remove());
        
        // Remove error styling from fields
        const errorFields = document.querySelectorAll('.error-field');
        errorFields.forEach(field => {
            field.classList.remove('error-field');
            field.style.borderColor = '';
        });
    }
    
    // Handle real-time validation for better user experience
    function setupRealTimeValidation() {
        const fields = [jobName, salaryRange, jobLocation];
        
        fields.forEach(field => {
            field.addEventListener('blur', function() {
                // Clear previous error for this field
                if (field === salaryRange) {
                    // Special handling for salary container
                    const salaryContainer = field.closest('.salary-container') || field.parentElement;
                    const existingError = salaryContainer.nextElementSibling;
                    if (existingError && existingError.classList.contains('error-message')) {
                        existingError.remove();
                    }
                } else {
                    const previousError = field.nextElementSibling;
                    if (previousError && previousError.classList.contains('error-message')) {
                        previousError.remove();
                    }
                }
                
                field.style.borderColor = '';
                
                // Validate this field
                if (field.value.trim() === '') {
                    if (field === salaryRange) {
                        displaySalaryError(field, `Please enter ${field.placeholder || field.name}`);
                    } else {
                        displayError(field, `Please enter ${field.placeholder || field.name}`);
                    }
                }
                
                // Special case for salary
                if (field === salaryRange && field.value.trim() !== '' && !validateSalaryFormat(field.value)) {
                    displaySalaryError(field, 'Please enter a valid salary amount (e.g., 1000 or 1,000)');
                }
                
                // Check if all fields are valid to enable/disable next button
                updateNextButtonState();
            });
            
            // Also add input event for real-time validation while typing
            field.addEventListener('input', function() {
                updateNextButtonState();
            });
        });
        
        // For radio buttons
        jobTypeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const radioContainer = radio.closest('.employment-types');
                const nextElement = radioContainer.nextElementSibling;
                if (nextElement && nextElement.classList.contains('error-message')) {
                    nextElement.remove();
                }
                updateNextButtonState();
            });
        });
    }
    
    // Function to check if all fields are valid and update next button state
    function updateNextButtonState() {
        if (validateAllFields()) {
            nextBtn.removeAttribute('disabled');
            nextBtn.style.opacity = '1';
            nextBtn.style.cursor = 'pointer';
        } else {
            nextBtn.setAttribute('disabled', 'disabled');
            nextBtn.style.opacity = '0.5';
            nextBtn.style.cursor = 'not-allowed';
        }
    }
    
    // Validate all fields without showing error messages
    function validateAllFields() {
        // Check if all required fields are filled
        if (jobName.value.trim() === '' || 
            salaryRange.value.trim() === '' || 
            jobLocation.value.trim() === '') {
            return false;
        }
        
        // Check if job type is selected
        let jobTypeSelected = false;
        jobTypeRadios.forEach(radio => {
            if (radio.checked) jobTypeSelected = true;
        });
        if (!jobTypeSelected) return false;
        
        // Check salary format
        if (!validateSalaryFormat(salaryRange.value)) {
            return false;
        }
        
        // All validations passed
        return true;
    }
    
    // Initialize the form validation
    function init() {
        // Add form submission validation
        jobPostForm.addEventListener('submit', validateForm);
        
        // Setup real-time validation
        setupRealTimeValidation();
        
        // Initial state of next button (disabled by default)
        nextBtn.setAttribute('disabled', 'disabled');
        nextBtn.style.opacity = '0.5';
        nextBtn.style.cursor = 'not-allowed';
        
        // Add validation for the next button click
        if (nextBtn) {
            nextBtn.addEventListener('click', function(e) {
                // Only proceed if all validations pass
                if (!validateForm(e)) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
        }
        
        // Check initial state of the form
        updateNextButtonState();
    }
    
    // Initialize the form
    init();
});