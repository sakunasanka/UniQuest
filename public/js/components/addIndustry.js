// This script handles the popup for adding a new industry in the admin panel.
document.addEventListener('DOMContentLoaded', function () {
    const addButtons = document.querySelectorAll('.industry-add-btn');
    const popup = document.getElementById('industryPopup');
    const closeBtn = popup.querySelector('.close-btn');
    const cancelBtn = popup.querySelector('.cancel-btn');
    const industryForm = document.getElementById('industryForm');
    const industryError = document.getElementById('industryError');

    // Open popup
    addButtons.forEach(button => {
        button.addEventListener('click', () => {
            popup.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Close popup function
    const closePopup = () => {
        popup.classList.remove('active');
        document.body.style.overflow = '';
        industryForm.reset();
        industryError.textContent = '';
    };

    // Close popup on button clicks or background click
    closeBtn.addEventListener('click', closePopup);
    cancelBtn.addEventListener('click', closePopup);
    popup.addEventListener('click', e => e.target === popup && closePopup());
    document.addEventListener('keydown', e => e.key === 'Escape' && popup.classList.contains('active') && closePopup());

    // Form submit
    industryForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const industryName = document.getElementById('industryName').value.trim();

        if (!industryName) {
            industryError.textContent = 'Please enter an industry name.';
            return;
        }

        try {
            const response = await fetch('/UniQuest/admin/addIndustry', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ industryName })
            });

            const result = await response.json();

            if (result.success) {
                closePopup();
                refreshIndustryTable(); // or location.reload();
            } else {
                industryError.textContent = result.message || 'Failed to save industry.';
            }
        } catch (error) {
            console.error('Error:', error);
            industryError.textContent = 'An error occurred while saving.';
        }
    });

    function refreshIndustryTable() {
        // You can refresh data dynamically or reload the page here
        location.reload();
    }
});