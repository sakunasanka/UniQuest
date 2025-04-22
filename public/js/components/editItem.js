document.addEventListener('DOMContentLoaded', function () {
    const popup = document.getElementById('editItemPopup');
    const closeBtn = popup.querySelector('.close-btn');
    const cancelBtn = popup.querySelector('.cancel-btn');
    const form = popup.querySelector('.editItemForm');
    const popupTitle = popup.querySelector('.popup-title');
    
    // Form elements
    const itemIDInput = popup.querySelector('.itemID');
    const itemTypeInput = popup.querySelector('.itemType');
    const nameInput = popup.querySelector('.itemName');
    const reasonTextarea = popup.querySelector('.itemReason');
    const reasonField = popup.querySelector('.reason-field');

    // Event delegation for edit buttons
    document.addEventListener('click', function(e) {
        // Handle reason edit buttons
        if (e.target.classList.contains('reason-edit-btn')) {
            const row = e.target.closest('tr');
            const table = row.closest('table');
            const itemType = table.dataset.itemType;
            const itemID = row.dataset.id || e.target.dataset.id;
            const itemName = row.querySelector('.reason-name').textContent.trim();
            const itemReason = row.querySelector('.reason-text').textContent.trim();
            
            openEditPopup({
                type: itemType,
                id: itemID,
                name: itemName,
                reason: itemReason,
                isIndustry: false
            });
        }
        
        // Handle industry edit buttons
        if (e.target.classList.contains('industry-edit-btn')) {
            const row = e.target.closest('tr');
            const itemType = 'industries';
            const itemID = row.dataset.id || e.target.dataset.id;
            const itemName = row.querySelector('.industry-name').textContent.trim();
            
            openEditPopup({
                type: itemType,
                id: itemID,
                name: itemName,
                isIndustry: true
            });
        }
    });

    function openEditPopup(data) {
        // Clear any previous values
        nameInput.value = '';
        reasonTextarea.value = '';
        
        // Configure popup based on item type
        popupTitle.textContent = data.isIndustry 
            ? 'Edit Industry' 
            : `Edit ${data.type.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}`;
        
        // Toggle reason field visibility and requirement
        if (data.isIndustry) {
            reasonField.style.display = 'none';
            reasonTextarea.removeAttribute('required');
        } else {
            reasonField.style.display = 'block';
            reasonTextarea.setAttribute('required', 'required');
        }

        // Set form values (trimming to remove any whitespace)
        itemIDInput.value = data.id.toString().trim();
        itemTypeInput.value = data.type.trim();
        nameInput.value = data.name.trim();
        
        // Only set reason if it exists (for non-industry items)
        if (!data.isIndustry && data.reason) {
            reasonTextarea.value = data.reason.trim();
        }

        // Show popup
        popup.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Focus on the first visible input without selecting text
        // setTimeout(() => {
        //     nameInput.focus();
        //     // Move cursor to end of text instead of selecting all
        //     nameInput.selectionStart = nameInput.selectionEnd = nameInput.value.length;
        // }, 100);
    }

    function closePopup() {
        popup.classList.remove('active');
        document.body.style.overflow = '';
        form.reset();
    }

    // Close event handlers
    closeBtn.addEventListener('click', closePopup);
    cancelBtn.addEventListener('click', closePopup);
    popup.addEventListener('click', (e) => {
        if (e.target === popup) {
            closePopup();
        }
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && popup.classList.contains('active')) {
            closePopup();
        }
    });

    // Form submission with proper validation
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Prepare form data with proper field names for each type
        const formData = {
            id: itemIDInput.value.trim(),
            type: itemTypeInput.value.trim()
        };

        // Add type-specific fields
        if (formData.type === 'industries') {
            formData.industryID = formData.id;
            formData.industryName = nameInput.value.trim();
            
            // Remove unused fields
            delete formData.id;
        } else {
            formData.reasonID = formData.id;
            formData.reasonName = nameInput.value.trim();
            formData.reason = reasonTextarea.value.trim();
            
            // Remove unused fields
            delete formData.id;
        }

        // Validate name field
        if (!formData[formData.type === 'industries' ? 'industryName' : 'reasonName']) {
            alert('Please enter a name');
            nameInput.focus();
            return;
        }

        // For non-industry items, validate reason field
        if (formData.type !== 'industries' && !formData.reason) {
            alert('Please enter a reason');
            reasonTextarea.focus();
            return;
        }

        try {
            // Determine the appropriate endpoint
            const endpoint = formData.type === 'industries' 
                ? '/UniQuest/admin/updateIndustry' 
                : '/UniQuest/admin/updateReason';

            // Show loading state
            const submitBtn = form.querySelector('.submit-btn');
            const originalBtnText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing...';

            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            });

            // Restore button state
            submitBtn.disabled = false;
            submitBtn.textContent = originalBtnText;

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            
            if (result.success) {
                closePopup();
                location.reload(); // Refresh to show changes
            } else {
                alert(result.message || 'Failed to update item.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            
            // Restore button state in case of error
            const submitBtn = form.querySelector('.submit-btn');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Update';
        }
    });

    // Better accessibility - allow closing with Enter key on buttons
    [closeBtn, cancelBtn].forEach(btn => {
        btn.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                btn.click();
            }
        });
    });
});