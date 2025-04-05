let editPopup = document.getElementById("popup-editreview");

// Function to show the edit review popup
function showEditReviewPopup(reviewID, rating, comment, companyID) {
    editPopup.classList.add("active");
    disableScrolling();
    scrollToTop();

    // Set the form values
    document.getElementById("reviewID").value = reviewID;
    document.getElementById("companyID").value = companyID;
    document.getElementById("rating").value = rating;
    document.getElementById("comment").value = comment;
    
    // Set the rating stars
    const stars = document.querySelectorAll('#popup-editreview .rating-stars label');
    stars.forEach((star, index) => {
        star.style.color = index < rating ? '#f5b301' : '#ccc';
    });
    
    // Check the corresponding radio button
    const radioInputs = document.querySelectorAll('#popup-editreview .rating-stars input[type="radio"]');
    radioInputs.forEach(input => input.checked = false); // Reset all
    if (rating > 0 && rating <= 5) {
        radioInputs[rating - 1].checked = true;
    }
    
    // Set the comment
    document.querySelector('#popup-editreview textarea[name="comment"]').value = comment;
    
    // Update the form action
    const editreviewForm = document.getElementById("edit-review-form");
    editreviewForm.action = `http://localhost/UniQuest/student/updateReview/${reviewID}`;
}

// Function to close the edit review popup
function closeEditReviewPopup() {
    editPopup.classList.remove("active");
    enableScrolling();
}

// Helper functions
function disableScrolling() {
    document.body.style.overflow = "hidden";
}

function enableScrolling() {
    document.body.style.overflow = "auto";
}

function scrollToTop() {
    window.scrollTo(0, 0);
}