let popup1 = document.getElementById("popup-1");
let popup2 = document.getElementById("popup-2");

function togglePopup1() {
    popup1.classList.toggle("active");
}

function togglePopup2() {
    popup2.classList.toggle("active");
}

async function fetchMessageDetails(id) {
    try {
        // Fetch message details from the server
        const response = await fetch(`<?php echo URLROOT; ?>/admin/messages/${id}`);
        if (response.ok) {
            const message = await response.json();
            // Populate the popup with message details
            showMessageDetails(message);
        } else {
            alert('Failed to fetch message details. Please check the network or server.');
        }
    } catch (error) {
        console.error('Error fetching message details:', error);
        alert('An error occurred while fetching message details.');
    }
}


function showMessageDetails(message) {
    // Populate popup fields with data
    document.getElementById('message-topic').textContent = message.topic;
    document.getElementById('message-email').textContent = message.email;
    document.getElementById('message-name').textContent = message.name;
    document.getElementById('message-date').textContent = message.created_at;
    document.getElementById('message-content').textContent = message.message;

    // Display the popup
    toggleMessagePopup();
}

function toggleMessagePopup() {
    const popup = document.getElementById('message-popup');
    popup.classList.toggle('active');
}
