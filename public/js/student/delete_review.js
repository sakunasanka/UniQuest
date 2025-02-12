let dapopup = document.getElementById("popup-deactivate");

// Function to show the delete review confirmation popup
function showdeletereviewconfirm(reviewID) {
    
    dapopup.classList.add("active");
    disableScrolling();
    scrollToTop();

    document.getElementById("reviewID").value = reviewID;
    
    const deletereviewForm = document.getElementById("delete-review-form");
    deletereviewForm.action = `http://localhost/UniQuest/student/deleteReview/${reviewID}`;
}

// Function to close the delete review confirmation popup
function closedeletereviewconfirm() {
    dapopup.classList.remove("active");
    enableScrolling();
}

// Function to cancel the delete review confirmation popup
function canceldeletereviewconfirm() {
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