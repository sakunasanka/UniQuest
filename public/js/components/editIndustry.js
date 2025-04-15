document.addEventListener('DOMContentLoaded', function () {
    // Get all elements
    const editButtons = document.querySelectorAll('.industry-edit-btn');
    const popup = document.getElementById('editIndustryPopup');
    const closeBtn = popup.querySelector('.close-btn');
    const cancelBtn = popup.querySelector('.cancel-btn');
    const industryForm = popup.querySelector('.editIndustryForm');

    // Form elements (renamed to avoid conflicts)
    const industryNameInput = popup.querySelector('.industryName');
    const industryIDInput = popup.querySelector('.industryID');

    // Open popup when edit button is clicked
    editButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const row = button.closest('tr');
            const industryName = row.querySelector('.industry-name').textContent;
            const industryID = button.dataset.id;

            // Set the values in the form
            industryIDInput.value = industryID;
            industryNameInput.value = industryName;

            // Show the popup
            popup.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Function to close popup
    const closePopup = function () {
        popup.classList.remove('active');
        document.body.style.overflow = '';
        industryForm.reset();
    };

    // Event listeners for closing
    closeBtn.addEventListener('click', closePopup);
    cancelBtn.addEventListener('click', closePopup);
    popup.addEventListener('click', (e) => e.target === popup && closePopup());
    document.addEventListener('keydown', (e) => {
        e.key === 'Escape' && popup.classList.contains('active') && closePopup();
    });

    // Form submission
    industryForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = {
            industryID: industryIDInput.value.trim(),
            industryName: industryNameInput.value.trim(),
        };

        if (!formData.industryName) {
            alert('Please enter a industry name');
            return;
        }

        try {
            const response = await fetch('/UniQuest/admin/updateIndustry', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            });
        
            // First check if the response is OK
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
        
            // Then try to parse as JSON
            const result = await response.json();
        
            if (result.success) {
                closePopup();
                refreshIndustryPage();
            } else {
                alert(result.message || 'Failed to update industry.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred. Please check console for details.');
        }
    });

    function refreshIndustryPage() {
        location.reload();
    }
});