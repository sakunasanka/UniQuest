let dapopup1 = document.getElementById("popup-active");

// Function to show the delete review confirmation popup
function showActivePostconfirm(postID) {
    
    dapopup1.classList.add("active");
    disableScrolling();
    scrollToTop();

    document.getElementById("postID").value = postID;
    
    const ActivePostForm = document.getElementById("activate-job-form");
    ActivePostForm.action = `http://localhost/UniQuest/service_provider/active/${postID}`;
}

// Function to close the delete review confirmation popup
function closeActiveJobConfirm() {
    dapopup1.classList.remove("active");
    enableScrolling();
}

// Function to cancel the delete review confirmation popup
function cancelActiveJobConfirm() {
    dapopup1.classList.remove("active");
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