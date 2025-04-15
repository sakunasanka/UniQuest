document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const deleteButtons = document.querySelectorAll('.reason-delete-btn');
    const popup = document.getElementById('deleteReasonPopup');
    const closeBtn = popup.querySelector('.close-btn');
    const cancelBtn = popup.querySelector('.cancel-btn');
    const deleteForm = document.querySelector('.deleteReasonForm');
    const reasonIDInput = document.querySelector('.reasonID');

    // Open delete confirmation popup
    deleteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            reasonIDInput.value = button.dataset.id;
            popup.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Close popup function
    const closePopup = () => {
        popup.classList.remove('active');
        document.body.style.overflow = '';
    };

    // Close event handlers
    closeBtn.addEventListener('click', closePopup);
    cancelBtn.addEventListener('click', closePopup);
    popup.addEventListener('click', (e) => e.target === popup && closePopup());
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closePopup();
    });

    // Delete form submission
    deleteForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        try {
            const response = await fetch('/UniQuest/admin/deleteReason', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    reasonID: reasonIDInput.value.trim()
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                closePopup();
                refreshReasonPage();
            } else {
                alert(result.message || 'Failed to delete reason.');
            }
        } catch (error) {
            console.error('Delete error:', error);
            alert('Failed to delete reason. Please try again.');
        }
    });

    function refreshReasonPage() {
        window.location.href = '/UniQuest/admin/reason_mng';
    }
});