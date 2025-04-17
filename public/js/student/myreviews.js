// Status trackers for each review
const reviewStatus = {};

// Initialize all event listeners
function initializeEventListeners() {
    document.querySelectorAll('.like-btn, .dislike-btn').forEach(button => {
        const reviewId = button.getAttribute('data-id');
        const dbReviewId = button.getAttribute('data-review-id');

        // Initialize state once per reviewId
        if (!reviewStatus[reviewId]) {
            reviewStatus[reviewId] = {
                liked: false,
                disliked: false,
                dbReviewId: dbReviewId
            };
        }

        if (button.classList.contains('like-btn')) {
            reviewStatus[reviewId].liked = button.classList.contains('liked');
            button.addEventListener('click', () => toggleLike(reviewId));
        } else if (button.classList.contains('dislike-btn')) {
            reviewStatus[reviewId].disliked = button.classList.contains('disliked');
            button.addEventListener('click', () => toggleDislike(reviewId));
        }
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

        // Remove like if active
        if (isDisliked && dislikeCount > 0) {
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

    if (isDisliked && dislikeCount > 0) {
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
        if (isLiked && likeCount > 0) {
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

    // Create a new XMLHttpRequest to send the data to the server

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/UniQuest/jobs/updateLikeStatus", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("review_id=" + reviewId + "&is_liked=" + isLiked);
}

function updateDislikeStatus(reviewId, isDisliked) {
    const formData = new FormData();

    // Create a new XMLHttpRequest to send the data to the server

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/UniQuest/jobs/updateDislikeStatus", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("review_id=" + reviewId + "&is_disliked=" + isDisliked);
}

// Call on page load
document.addEventListener('DOMContentLoaded', initializeEventListeners);