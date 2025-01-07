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

