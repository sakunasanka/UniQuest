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

document.addEventListener('DOMContentLoaded', function () {
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageInput');
    const messagesContainer = document.querySelector('.messages');

    messageForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        const messageText = messageInput.value.trim();
        const receiverId = document.querySelector('input[name="receiver_id"]').value;

        if (messageText) {
            // Create a new message element and display it
            const newMessage = document.createElement('div');
            newMessage.classList.add('message', 'sent'); // Assuming the sender is the user
            newMessage.textContent = messageText;
            messagesContainer.appendChild(newMessage);

            // Clear the input field
            messageInput.value = '';

            // Scroll to the bottom of the messages container
            messagesContainer.scrollTop = messagesContainer.scrollHeight;

            // Send the message data to the server using AJAX
            const formData = new FormData(messageForm);
            fetch('process_chat.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Message saved to the database.');
                } else {
                    console.error('Failed to save the message:', data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
});