document.addEventListener('DOMContentLoaded', function () {
    // Get all elements
    const editButtons = document.querySelectorAll('.reason-edit-btn');
    const popup = document.getElementById('editReasonPopup');
    const closeBtn = popup.querySelector('.close-btn');
    const cancelBtn = popup.querySelector('.cancel-btn');
    const reasonForm = popup.querySelector('.editReasonForm');

    // Form elements (renamed to avoid conflicts)
    const reasonNameInput = popup.querySelector('.reasonName');
    const reasonTextarea = popup.querySelector('.reason');
    const reasonIDInput = popup.querySelector('.reasonID');

    // Open popup when edit button is clicked
    editButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            const row = button.closest('tr');
            const reasonName = row.querySelector('.reason-name').textContent;
            const reason = row.querySelector('.reason-text').textContent;
            const reasonID = button.dataset.id;

            // Set the values in the form
            reasonIDInput.value = reasonID;
            reasonNameInput.value = reasonName;
            reasonTextarea.value = reason;

            // Show the popup
            popup.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Function to close popup
    const closePopup = function () {
        popup.classList.remove('active');
        document.body.style.overflow = '';
        reasonForm.reset();
    };

    // Event listeners for closing
    closeBtn.addEventListener('click', closePopup);
    cancelBtn.addEventListener('click', closePopup);
    popup.addEventListener('click', (e) => e.target === popup && closePopup());
    document.addEventListener('keydown', (e) => {
        e.key === 'Escape' && popup.classList.contains('active') && closePopup();
    });

    // Form submission
    reasonForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = {
            reasonID: reasonIDInput.value.trim(),
            reasonName: reasonNameInput.value.trim(),
            reason: reasonTextarea.value.trim()
        };

        if (!formData.reasonName) {
            alert('Please enter a reason name');
            return;
        }

        try {
            const response = await fetch('/UniQuest/admin/updateReason', {
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
                refreshReasonPage();
            } else {
                alert(result.message || 'Failed to update reason.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred. Please check console for details.');
        }
    });

    function refreshReasonPage() {
        window.location.href = '/UniQuest/admin/reason_mng';
    }
});