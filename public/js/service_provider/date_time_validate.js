document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('jobPostDate');
    
    // Set min date to 2 days ahead
    const today = new Date();
    const minDate = new Date();
    minDate.setDate(today.getDate() + 2);
    const minDateString = minDate.toISOString().split('T')[0];
    dateInput.setAttribute('min', minDateString);
    
    // Set max date to 30 days from today
    const maxDate = new Date();
    maxDate.setDate(maxDate.getDate() + 30);
    const maxDateString = maxDate.toISOString().split('T')[0];
    dateInput.setAttribute('max', maxDateString);
    
    // Set default date to 2 days ahead of today
    dateInput.value = minDateString;

    // Function to validate the date when the user changes it
    dateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const currentDate = new Date();
        currentDate.setHours(0, 0, 0, 0); // Reset time part for accurate comparison
        
        const maxAllowedDate = new Date();
        maxAllowedDate.setDate(maxAllowedDate.getDate() + 30);
        
        let errorMessage = '';
        
        if (selectedDate < minDate) {
            errorMessage = 'Date cannot be earlier than 2 days from today (For verification purposes)';
            this.value = minDateString; // Reset to 2 days ahead
        } else if (selectedDate > maxAllowedDate) {
            errorMessage = 'Date cannot be more than 30 days in the future';
            this.value = maxDateString; // Reset to max allowed date
        }
        
        // Display error message if any
        const errorSpan = this.nextElementSibling;
        if (errorMessage) {
            errorSpan.textContent = errorMessage;
        } else {
            errorSpan.textContent = ''; // Clear any previous error
        }
    });
});