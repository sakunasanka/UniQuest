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
    const jobLocation = document.getElementById('job_district');
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
          salaryRange.value.trim() === '') {
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
    function initMainForm() {
      if (!jobPostForm) return; // Exit if form doesn't exist
      
      // Add form submission validation
      jobPostForm.addEventListener('submit', validateForm);
      
      // Setup real-time validation
      setupRealTimeValidation();
      
      // Initial state of next button (disabled by default)
      if (nextBtn) {
        nextBtn.setAttribute('disabled', 'disabled');
        nextBtn.style.opacity = '0.5';
        nextBtn.style.cursor = 'not-allowed';
        
        // Add validation for the next button click
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
    
    // Get all field checkboxes
    const fieldCheckboxes = document.querySelectorAll('.field-checkbox');
    const requiredCheckboxes = document.querySelectorAll('.required-checkbox');
    const submitBtn = document.querySelector('.submit-btn');
    
    // Handle required checkbox logic
    function initCustomFields() {
      if (!fieldCheckboxes.length) return; // Exit if no field checkboxes exist
      
      fieldCheckboxes.forEach(function(checkbox) {
        const fieldId = checkbox.id;
        const requiredCheckbox = document.getElementById(fieldId + '_req');
        
        // Set initial state
        if (requiredCheckbox) {
          requiredCheckbox.disabled = !checkbox.checked;
        }
        
        // Add change event listener
        checkbox.addEventListener('change', function() {
          if (requiredCheckbox) {
            requiredCheckbox.disabled = !this.checked;
            // Uncheck required if field is unchecked
            if (!this.checked) {
              requiredCheckbox.checked = false;
            }
          }
          
          // For custom fields, handle the input and select fields
          if (fieldId.startsWith('other') && fieldId !== 'other4') {
            const nameInput = document.getElementById(fieldId + '_name');
            const typeSelect = document.getElementById(fieldId + '_type');
            if (nameInput) {
              nameInput.disabled = !this.checked;
              nameInput.required = this.checked;
              if (!this.checked) {
                nameInput.value = '';
              }
            }
            if (typeSelect) {
              typeSelect.disabled = !this.checked;
              if (!this.checked) {
                typeSelect.selectedIndex = 0;
              }
            }
          }
          
          // Remove application form error when fields are changed
          removeApplicationFormError();
        });
        
        // Initialize custom field inputs and selects
        if (fieldId.startsWith('other') && fieldId !== 'other4') {
          const nameInput = document.getElementById(fieldId + '_name');
          const typeSelect = document.getElementById(fieldId + '_type');
          if (nameInput) {
            nameInput.disabled = !checkbox.checked;
            nameInput.required = checkbox.checked;
          }
          if (typeSelect) {
            typeSelect.disabled = !checkbox.checked;
          }
        }
      });
      
      // Listen for changes in required checkboxes
      requiredCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
          // Remove application form error when required fields are changed
          removeApplicationFormError();
        });
      });
      
      // Form validation for submit button
      if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
          let isValid = true;
          const errorMessages = [];
          
          // Check if any fields are selected
          const anyFieldSelected = Array.from(fieldCheckboxes).some(checkbox => checkbox.checked);
          if (!anyFieldSelected) {
            errorMessages.push('Please select at least one field for the application form.');
            isValid = false;
          }
          
          // Check if at least one required field is selected
          const anyRequiredSelected = Array.from(requiredCheckboxes).some(checkbox => checkbox.checked);
          if (!anyRequiredSelected) {
            errorMessages.push('Please select at least one field as required.');
            isValid = false;
          }
          
          // Validate custom fields have names when selected
          fieldCheckboxes.forEach(function(checkbox) {
            const fieldId = checkbox.id;
            if (checkbox.checked && fieldId.startsWith('other') && fieldId !== 'other4') {
              const nameInput = document.getElementById(fieldId + '_name');
              if (nameInput && nameInput.value.trim() === '') {
                isValid = false;
                nameInput.classList.add('field-error');
                if (!errorMessages.includes('Please provide names for all custom fields')) {
                  errorMessages.push('Please provide names for all custom fields');
                }
              }
            }
          });
          
          // Validate job post date is not in the past
          const jobPostDate = document.getElementById('jobPostDate');
          if (jobPostDate && jobPostDate.value) {
            const today = new Date();
            const selectedDate = new Date(jobPostDate.value);
            today.setHours(0, 0, 0, 0);
            if (selectedDate < today) {
              isValid = false;
              jobPostDate.classList.add('field-error');
              errorMessages.push('Job post date cannot be in the past');
            }
          }
          
          // Show all error messages if validation failed
          if (!isValid) {
            e.preventDefault();
            
            // Remove previous error messages
            removeApplicationFormError();
            
            // Display application form error message near the submit button
            if (!anyFieldSelected || !anyRequiredSelected) {
              displayApplicationFormError(errorMessages);
            } else {
              // Create and display error message container for other errors
              const errorContainer = document.createElement('div');
              errorContainer.className = 'form-error-message';
              errorContainer.style.color = 'red';
              errorContainer.style.margin = '15px 0';
              errorContainer.style.padding = '10px';
              errorContainer.style.border = '1px solid #ffcccc';
              errorContainer.style.borderRadius = '4px';
              errorContainer.style.backgroundColor = '#fff0f0';
              
              // Add each error message
              errorMessages.forEach(message => {
                const errorMessage = document.createElement('p');
                errorMessage.textContent = message;
                errorMessage.style.margin = '5px 0';
                errorContainer.appendChild(errorMessage);
              });
              
              // Insert error container after the form head
              const formHead = document.querySelector('.form-head');
              if (formHead) {
                formHead.insertAdjacentElement('afterend', errorContainer);
              } else {
                document.querySelector('form').prepend(errorContainer);
              }
              
              // Scroll to error messages
              errorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
          }
        });
      }
      
      // Highlight custom field inputs when clicked
      const customInputs = document.querySelectorAll('.field-col-custom input[type="text"]');
      customInputs.forEach(function(input) {
        input.addEventListener('focus', function() {
          this.classList.add('field-active');
        });
        input.addEventListener('blur', function() {
          this.classList.remove('field-active');
        });
      });
      
      // Clear error styling when user starts typing in custom fields
      customInputs.forEach(input => {
        input.addEventListener('input', function() {
          if (this.classList.contains('field-error')) {
            this.classList.remove('field-error');
          }
        });
      });
      
      // Clear date error when changed
      const jobPostDate = document.getElementById('jobPostDate');
      if (jobPostDate) {
        jobPostDate.addEventListener('change', function() {
          if (this.classList.contains('field-error')) {
            this.classList.remove('field-error');
          }
        });
      }
    }
    
    // Function to display application form validation error
    function displayApplicationFormError(errorMessages) {
      // Remove any existing error
      removeApplicationFormError();
      
      // Create error message container
      const errorContainer = document.createElement('div');
      errorContainer.className = 'application-form-error';
      errorContainer.style.color = 'red';
      errorContainer.style.fontSize = '14px';
      errorContainer.style.fontWeight = 'bold';
      errorContainer.style.padding = '10px';
      errorContainer.style.marginTop = '15px';
      errorContainer.style.backgroundColor = '#fff0f0';
      errorContainer.style.border = '1px solid #ffcccc';
      errorContainer.style.borderRadius = '4px';
      
      // Add error messages relevant to application form
      errorMessages.forEach(message => {
        if (message.includes('field for the application form') || message.includes('field as required')) {
          const errorPara = document.createElement('p');
          errorPara.textContent = message;
          errorPara.style.margin = '5px 0';
          errorContainer.appendChild(errorPara);
        }
      });
      
      // Insert error container before the form actions container (near submit button)
      const formActionsContainer = submitBtn.closest('.form-actions');
      formActionsContainer.insertAdjacentElement('beforebegin', errorContainer);
    }
    
    // Function to remove application form validation error
    function removeApplicationFormError() {
      const existingError = document.querySelector('.application-form-error');
      if (existingError) {
        existingError.remove();
      }
    }
    
    // Initialize both parts
    initMainForm();
    initCustomFields();
});