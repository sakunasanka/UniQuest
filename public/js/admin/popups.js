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
