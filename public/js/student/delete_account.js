let dapopup = document.getElementById("popup-deactivate");

// Function to show the delete account confirmation popup
function showdeleteaccountconfirm() {
    dapopup.classList.add("active");
    disableScrolling();
    scrollToTop();
}

// Function to close the delete account confirmation popup
function closedeleteaccountconfirm() {
    dapopup.classList.remove("active");
    enableScrolling();
}

// Function to cancel the delete account confirmation popup
function canceldeleteaccountconfirm() {
    dapopup.classList.remove("active");
    enableScrolling();
}

// Helper function to disable scrolling
function disableScrolling() {
    document.body.style.overflow = "hidden";
}

// Helper function to enable scrolling
function enableScrolling() {
    document.body.style.overflow = "auto";
}

// Helper function to scroll to the top of the page
function scrollToTop() {
    window.scrollTo(0, 0);
}