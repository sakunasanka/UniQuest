// Navigation functions
function goToApplyPage() {
    window.location.href = "/uniquest/student/jobsapply"; 
}

function goToContactPage() {
    window.location.href = "/uniquest/student/contact_sp"; 
}

function goToAddReview() {
    window.location.href = "/uniquest/student/rate_review_company"; 
}

function goToCompany() {
    window.location.href = "/uniquest/student/companydescription"; 
}

// Likes and dislikes tracking objects
const likeCounts = {};
const dislikeCounts = {};

// Track whether each review has been liked or disliked
const likedStatus = {};
const dislikedStatus = {};

// Toggle like function
function toggleLike(reviewId) {
    if (!likeCounts[reviewId]) likeCounts[reviewId] = 0;
    if (!likedStatus[reviewId]) likedStatus[reviewId] = false;

    const likeButton = document.getElementById(`like-icon-${reviewId.split('-')[1]}`);
    const likeCountElem = document.getElementById(`like-count-${reviewId.split('-')[1]}`);

    if (likedStatus[reviewId]) {
        // If already liked, remove the like
        likeCounts[reviewId]--;
        likedStatus[reviewId] = false;
        likeButton.style.color = ""; // Reset color
    } else {
        // If not liked, add the like
        likeCounts[reviewId]++;
        likedStatus[reviewId] = true;
        likeButton.style.color = "#299b63"; // Active color for like

        // If dislike was active, remove it
        if (dislikedStatus[reviewId]) {
            toggleDislike(reviewId); // Call toggleDislike to remove it
        }
    }

    likeCountElem.textContent = `${likeCounts[reviewId]} likes`;
}

// Toggle dislike function
function toggleDislike(reviewId) {
    if (!dislikeCounts[reviewId]) dislikeCounts[reviewId] = 0;
    if (!dislikedStatus[reviewId]) dislikedStatus[reviewId] = false;

    const dislikeButton = document.getElementById(`dislike-icon-${reviewId.split('-')[1]}`);
    const dislikeCountElem = document.getElementById(`dislike-count-${reviewId.split('-')[1]}`);

    if (dislikedStatus[reviewId]) {
        // If already disliked, remove the dislike
        dislikeCounts[reviewId]--;
        dislikedStatus[reviewId] = false;
        dislikeButton.style.color = ""; // Reset color
    } else {
        // If not disliked, add the dislike
        dislikeCounts[reviewId]++;
        dislikedStatus[reviewId] = true;
        dislikeButton.style.color = "#e74c3c"; // Active color for dislike

        // If like was active, remove it
        if (likedStatus[reviewId]) {
            toggleLike(reviewId); // Call toggleLike to remove it
        }
    }

    dislikeCountElem.textContent = `${dislikeCounts[reviewId]} dislikes`;
}

// Toggle reply form visibility
function toggleReplyForm(reviewId) {
    const replySection = document.getElementById(`reply-section-${reviewId.split('-')[1]}`);
    replySection.style.display = replySection.style.display === 'none' ? 'block' : 'none';
}

// Submit a reply
function submitReply(reviewId) {
    const replyInput = document.getElementById(`reply-input-${reviewId.split('-')[1]}`);
    const replyText = replyInput.value.trim();
    if (!replyText) return;

    // Add reply to replies list
    const repliesList = document.getElementById(`replies-list-${reviewId.split('-')[1]}`);
    const replyElement = document.createElement('p');
    replyElement.textContent = replyText;
    repliesList.appendChild(replyElement);

    // Clear input and update reply count
    replyInput.value = '';
    if (!replies[reviewId]) replies[reviewId] = [];
    replies[reviewId].push(replyText);
    document.getElementById(`reply-count-${reviewId.split('-')[1]}`).textContent = `${replies[reviewId].length} replies`;
}
