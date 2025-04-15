// Navigation functions
function goToApplyPage(jobId) {
    window.location.href = `/uniquest/student/jobsApplyform/${jobId}`;
}

function goToContactPage() {
    window.location.href = "/uniquest/student/contact_sp"; 
}

function goToAddReview() {
    window.location.href = "/uniquest/student/addReview";
}

function goToCompany() {
    window.location.href = "/uniquest/student/companydescription"; 
}

// Status trackers for each review
const reviewStatus = {};

// Initialize all event listeners
function initializeEventListeners() {
    document.querySelectorAll('.like-btn').forEach(button => {
        const reviewId = button.getAttribute('data-id');
        const dbReviewId = button.getAttribute('data-review-id');

        // Initialize state
        if (!reviewStatus[reviewId]) {
            reviewStatus[reviewId] = {
                liked: button.classList.contains('liked'),
                disliked: false,
                dbReviewId: dbReviewId
            };
        }

        button.addEventListener('click', () => toggleLike(reviewId));
    });

    document.querySelectorAll('.dislike-btn').forEach(button => {
        const reviewId = button.getAttribute('data-id');
        const dbReviewId = button.getAttribute('data-review-id');

        // Initialize state
        if (!reviewStatus[reviewId]) {
            reviewStatus[reviewId] = {
                liked: false,
                disliked: button.classList.contains('disliked'),
                dbReviewId: dbReviewId
            };
        }
        
        button.addEventListener('click', () => toggleDislike(reviewId));
    });
}

// Toggle like state
function toggleLike(reviewId) {
    const likeBtn = document.querySelector(`.like-btn[data-id="${reviewId}"]`);
    const dislikeBtn = document.querySelector(`.dislike-btn[data-id="${reviewId}"]`);
    const likeCountElem = document.querySelector(`.like-count[data-id="${reviewId}"]`);
    const dislikeCountElem = document.querySelector(`.dislike-count[data-id="${reviewId}"]`);

    let likeCount = parseInt(likeCountElem.textContent.split(' ')[0]);
    let dislikeCount = parseInt(dislikeCountElem.textContent.split(' ')[0]);

    const isLiked = reviewStatus[reviewId].liked;
    const isDisliked = reviewStatus[reviewId].disliked;
    const dbReviewId = reviewStatus[reviewId].dbReviewId;

    if (isLiked) {
        // Unlike
        likeCount--;
        likeBtn.classList.remove('liked');
        likeBtn.querySelector('.like-icon').style.color = "";
        reviewStatus[reviewId].liked = false;
        updateLikeStatus(dbReviewId, false);
    } else {
        // Like
        likeCount++;
        likeBtn.classList.add('liked');
        likeBtn.querySelector('.like-icon').style.color = "#299b63";
        reviewStatus[reviewId].liked = true;
        updateLikeStatus(dbReviewId, true);

        // Remove dislike if active
        if (isDisliked) {
            dislikeCount--;
            dislikeBtn.classList.remove('disliked');
            dislikeBtn.querySelector('.dislike-icon').style.color = "";
            reviewStatus[reviewId].disliked = false;
            updateDislikeStatus(dbReviewId, false);
        }
    }

    // Update counts
    likeCountElem.textContent = `${likeCount} likes`;
    dislikeCountElem.textContent = `${dislikeCount} dislikes`;
}

// Toggle dislike state
function toggleDislike(reviewId) {
    const dislikeBtn = document.querySelector(`.dislike-btn[data-id="${reviewId}"]`);
    const likeBtn = document.querySelector(`.like-btn[data-id="${reviewId}"]`);
    const dislikeCountElem = document.querySelector(`.dislike-count[data-id="${reviewId}"]`);
    const likeCountElem = document.querySelector(`.like-count[data-id="${reviewId}"]`);

    let dislikeCount = parseInt(dislikeCountElem.textContent.split(' ')[0]);
    let likeCount = parseInt(likeCountElem.textContent.split(' ')[0]);

    const isDisliked = reviewStatus[reviewId].disliked;
    const isLiked = reviewStatus[reviewId].liked;
    const dbReviewId = reviewStatus[reviewId].dbReviewId;

    if (isDisliked) {
        // Undislike
        dislikeCount--;
        dislikeBtn.classList.remove('disliked');
        dislikeBtn.querySelector('.dislike-icon').style.color = "";
        reviewStatus[reviewId].disliked = false;
        updateDislikeStatus(dbReviewId, false);
    } else {
        // Dislike
        dislikeCount++;
        dislikeBtn.classList.add('disliked');
        dislikeBtn.querySelector('.dislike-icon').style.color = "#e74c3c";
        reviewStatus[reviewId].disliked = true;
        updateDislikeStatus(dbReviewId, true);

        // Remove like if active
        if (isLiked) {
            likeCount--;
            likeBtn.classList.remove('liked');
            likeBtn.querySelector('.like-icon').style.color = "";
            reviewStatus[reviewId].liked = false;
            updateLikeStatus(dbReviewId, false);
        }
    }

    // Update counts
    dislikeCountElem.textContent = `${dislikeCount} dislikes`;
    likeCountElem.textContent = `${likeCount} likes`;
}

function updateLikeStatus(reviewId, isLiked) {
    const formData = new FormData();
    formData.append('review_id', reviewId);
    formData.append('is_liked', isLiked);

    // Create a new XMLHttpRequest to send the data to the server

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '<?php echo URLROOT; ?>/jobs/updateLikeStatus', true);

    // Send the request with the form data
    xhr.send(formData);
}

function updateDislikeStatus(reviewId, isDisliked) {
    const formData = new FormData();
    formData.append('review_id', reviewId);
    formData.append('is_disliked', isDisliked);

    // Create a new XMLHttpRequest to send the data to the server

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '<?php echo URLROOT; ?>/jobs/updateDislikeStatus', true);

    // Send the request with the form data
    xhr.send(formData);
}

// Call on page load
document.addEventListener('DOMContentLoaded', initializeEventListeners);