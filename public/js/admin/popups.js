document.addEventListener("DOMContentLoaded", function () {
    function showPopup(popupId, ID, category) {
        const popup = document.getElementById(popupId);
        popup.classList.add("active");
        popup.setAttribute("aria-hidden", "false");
        document.getElementById("ID").value = ID;
        document.getElementById("category").value = category;
    }

    function closePopup(popupId) {
        const popup = document.getElementById(popupId);
        popup.classList.remove("active");
        popup.setAttribute("aria-hidden", "true");
    }

    function confirmActionAcc(popupId, actionType) {
        const popup = document.getElementById(popupId);
        const ID = document.getElementById("ID").value;
        const role = document.getElementById("category").value;
        const urlRoot = popup.getAttribute("data-urlroot");

        if (ID) {
            window.location.href = `${urlRoot}/admin/user_${actionType}/${ID}/${role}`;
        } else {
            alert("Invalid user ID. Please try again.");
        }
    }

    function confirmActionJob(popupId, actionType) {
        const popup = document.getElementById(popupId);
        const ID = document.getElementById("ID").value;
        const category = document.getElementById("category").value;
        const urlRoot = popup.getAttribute("data-urlroot");

        if (ID) {
            window.location.href = `${urlRoot}/admin/job_${actionType}/${ID}/${category}`;
        } else {
            alert("Invalid user ID. Please try again.");
        }
    }

    // Expose globally
    window.deactivateUser = (id, category) => showPopup("deact-popup", id, category);
    window.activateUser = (id, category) => showPopup("act-popup", id, category);
    window.deactivateJob = (id, category) => showPopup("deact-popup", id, category);
    window.activateJob = (id, category) => showPopup("act-popup", id, category);
    window.closePopup = (popupId) => closePopup(popupId);
    window.confirmDeactivationAcc = () => confirmActionAcc("deact-popup", "deactivate");
    window.confirmActivationAcc = () => confirmActionAcc("act-popup", "activate");
    window.confirmDeactivationJob = () => confirmActionJob("deact-popup", "deactivate");
    window.confirmActivationJob = () => confirmActionJob("act-popup", "activate");

});

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
