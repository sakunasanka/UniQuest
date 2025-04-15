document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const deleteButtons = document.querySelectorAll('.industry-delete-btn');
    const popup = document.getElementById('deleteIndustryPopup');
    const closeBtn = popup.querySelector('.close-btn');
    const cancelBtn = popup.querySelector('.cancel-btn');
    const deleteForm = document.querySelector('.deleteIndustryForm');
    const industryIDInput = document.querySelector('.industryID');

    // Open delete confirmation popup
    deleteButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            industryIDInput.value = button.dataset.id;
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
            const response = await fetch('/UniQuest/admin/deleteIndustry', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    industryID: industryIDInput.value.trim()
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                closePopup();
                refreshIndustryPage();
            } else {
                alert(result.message || 'Failed to delete industry.');
            }
        } catch (error) {
            console.error('Delete error:', error);
            alert('Failed to delete industry. Please try again.');
        }
    });

    function refreshIndustryPage() {
        window.location.href = '/UniQuest/admin/reason_mng';
    }
});