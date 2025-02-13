document.addEventListener("DOMContentLoaded", function () {
    const openPopupBtn = document.getElementById("openPopupBtn");
    const closePopupBtn = document.getElementById("closePopupBtn");
    const chatPopup = document.getElementById("chatPopup");
    const backgroundOverlay = document.getElementById("backgroundOverlay");

    // Open popup
    openPopupBtn.addEventListener("click", function () {
        chatPopup.classList.remove("hidden");
        backgroundOverlay.classList.remove("hidden");
    });

    // Close popup
    closePopupBtn.addEventListener("click", function () {
        chatPopup.classList.add("hidden");
        backgroundOverlay.classList.add("hidden");
    });

    // Close popup when clicking outside it (optional)
    backgroundOverlay.addEventListener("click", function () {
        chatPopup.classList.add("hidden");
        backgroundOverlay.classList.add("hidden");
    });
});

const backgroundOverlay = document.getElementById('backgroundOverlay');
const chatPopup = document.getElementById('chatPopup');
const openPopupBtn = document.getElementById('openPopupBtn');
const closePopupBtn = document.getElementById('closePopupBtn');

openPopupBtn.addEventListener('click', () => {
    backgroundOverlay.classList.remove('hidden');
    chatPopup.classList.remove('hidden');
});

closePopupBtn.addEventListener('click', () => {
    backgroundOverlay.classList.add('hidden');
    chatPopup.classList.add('hidden');
});

document.addEventListener("DOMContentLoaded", function () {
    // Add event listeners for edit buttons
    document.querySelectorAll('.edit-message').forEach(button => {
        button.addEventListener('click', function () {
            const messageId = this.getAttribute('data-message-id');
            const messageElement = this.closest('.message');
            const messageTextElement = messageElement.querySelector('.message-text'); // Ensure this class exists in your HTML
            const currentMessage = messageTextElement.innerText;

            // Prompt the user to edit the message
            const newMessage = prompt('Edit your message:', currentMessage);

            if (newMessage !== null && newMessage.trim() !== '') {
                // Send an AJAX request to update the message
                fetch(`/admin/editMessage/${messageId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ message: newMessage })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the message text in the UI
                        messageTextElement.innerText = newMessage;
                    } else {
                        alert('Failed to edit message: ' + data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });

    // Add event listeners for delete buttons
    document.querySelectorAll('.delete-message').forEach(button => {
        button.addEventListener('click', function () {
            const messageId = this.getAttribute('data-message-id');
            const messageContainer = this.closest('.message-container'); // Ensure this class exists in your HTML

            if (confirm('Are you sure you want to delete this message?')) {
                // Send an AJAX request to delete the message
                fetch(`/admin/deleteMessage/${messageId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the message from the UI
                        messageContainer.remove();
                    } else {
                        alert('Failed to delete message: ' + data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });
});

