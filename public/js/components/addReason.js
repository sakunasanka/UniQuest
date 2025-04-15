document.addEventListener('DOMContentLoaded', function () {
    // Table type mapping
    const tableTypes = {
        'User Activate': 'user_activate',
        'User Deactivate': 'user_deactivate',
        'User Reject': 'user_reject',
        'Job Reject': 'job_reject'
    };

    // Get all elements
    const addButtons = document.querySelectorAll('.reason-add-btn');
    const popup = document.getElementById('reasonPopup');
    const closeBtn = popup.querySelector('.close-btn');
    const cancelBtn = popup.querySelector('.cancel-btn');
    const reasonForm = document.getElementById('reasonForm');

    // Create hidden input for ReasonType if it doesn't exist
    let reasonType = document.getElementById('reasonType');
    if (!reasonType) {
        reasonType = document.createElement('input');
        reasonType.type = 'hidden';
        reasonType.name = 'ReasonType';
        reasonType.id = 'reasonType';
        reasonForm.prepend(reasonType);
    }

    // Open popup when any add button is clicked
    addButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            // Get the reason type from the table title
            const tableCard = e.target.closest('.table-card');
            const tableTitle = tableCard.querySelector('.table-title').textContent.trim();
            const reasonTypeValue = tableTypes[tableTitle];

            if (!reasonTypeValue) {
                console.error('Unknown table type:', tableTitle);
                return;
            }

            // Set the ReasonType in the form
            reasonType.value = reasonTypeValue;

            // Update popup title based on reason type
            const popupTitle = popup.querySelector('h3');
            popupTitle.textContent = `Add New ${tableTitle} Reason`;

            // Show the popup
            popup.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Function to close popup - MOVED TO TOP
    const closePopup = function () {
        popup.classList.remove('active');
        document.body.style.overflow = ''; // Restore scrolling
    };

    // Close popup with close button
    closeBtn.addEventListener('click', closePopup);

    // Close popup with cancel button
    cancelBtn.addEventListener('click', closePopup);

    // Close when clicking outside content
    popup.addEventListener('click', (e) => {
        if (e.target === popup) {
            closePopup();
        }
    });

    // Close with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && popup.classList.contains('active')) {
            closePopup();
        }
    });

    // Form submission
    reasonForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Get form values
        const reasonType = document.getElementById('reasonType').value;
        const reasonName = document.getElementById('reasonName').value.trim();
        const reason = document.getElementById('reason').value.trim();

        // Basic validation
        if (!reasonName) {
            alert('Please enter a reason name');
            return;
        }

        try {
            const response = await fetch('/UniQuest/admin/addReason', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    reasonName: reasonName,
                    reason: reason,
                    reasonType: reasonType
                })
            });

            const result = await response.json();

            if (result.success) {
                // Close popup and reset form
                closePopup();
                reasonForm.reset();

                // Refresh the specific table
                refreshReasonPage();

                // Show success message
                // alert('Reason added successfully!');
            } else {
                alert(result.message || 'Failed to save reason. Please try again.');
            }
        } catch (error) {
            console.error('Error submitting reason:', error);
            alert('Failed to save reason. Please try again.');
        }
    });

    function refreshReasonPage() {
        location.reload();
    }

});