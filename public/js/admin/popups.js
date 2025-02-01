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


function showMessageDetails(topic, email, name, createdAt, message, status) {
    // Update the popup content with the message details
    document.getElementById('msg-topic').innerText = topic;
    document.getElementById('msg-email').innerText = email;
    document.getElementById('msg-name').innerText = name;
    document.getElementById('msg-created').innerText = createdAt;
    document.getElementById('msg-status').innerText = status;
    document.getElementById('msg-message').innerText = message;

    // Show the popup
    togglePopup2();
}

function togglePopup2() {
    const popup = document.getElementById('popup-2');
    popup.classList.toggle('active');
}
