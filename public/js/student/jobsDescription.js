// Navigation functions
function goToApplyPage() {
    window.location.href = "/uniquest/student/jobsapply"; 
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

// Track likes, dislikes, and their status for each review
const likeCounts = {};
const dislikeCounts = {};
const likedStatus = {};
const dislikedStatus = {};

// Initialize event listeners for all like and dislike buttons
function initializeEventListeners() {
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', () => toggleLike(button.getAttribute('data-id')));
    });

    document.querySelectorAll('.dislike-btn').forEach(button => {
        button.addEventListener('click', () => toggleDislike(button.getAttribute('data-id')));
    });
}

// Toggle like function
function toggleLike(reviewId) {
    if (!likeCounts[reviewId]) likeCounts[reviewId] = 0;
    if (!likedStatus[reviewId]) likedStatus[reviewId] = false;

    const likeButtons = document.querySelectorAll(`.like-btn[data-id="${reviewId}"] .like-icon`);
    const likeCountElems = document.querySelectorAll(`.like-count[data-id="${reviewId}"]`);

    if (likedStatus[reviewId]) {
        likeCounts[reviewId]--;
        likedStatus[reviewId] = false;
        likeButtons.forEach(btn => btn.style.color = "");
    } else {
        likeCounts[reviewId]++;
        likedStatus[reviewId] = true;
        likeButtons.forEach(btn => btn.style.color = "#299b63");

        if (dislikedStatus[reviewId]) {
            toggleDislike(reviewId); // Remove dislike if active
        }
    }

    likeCountElems.forEach(elem => elem.textContent = `${likeCounts[reviewId]} likes`);
}

// Toggle dislike function
function toggleDislike(reviewId) {
    if (!dislikeCounts[reviewId]) dislikeCounts[reviewId] = 0;
    if (!dislikedStatus[reviewId]) dislikedStatus[reviewId] = false;

    const dislikeButtons = document.querySelectorAll(`.dislike-btn[data-id="${reviewId}"] .dislike-icon`);
    const dislikeCountElems = document.querySelectorAll(`.dislike-count[data-id="${reviewId}"]`);

    if (dislikedStatus[reviewId]) {
        dislikeCounts[reviewId]--;
        dislikedStatus[reviewId] = false;
        dislikeButtons.forEach(btn => btn.style.color = "");
    } else {
        dislikeCounts[reviewId]++;
        dislikedStatus[reviewId] = true;
        dislikeButtons.forEach(btn => btn.style.color = "#e74c3c");

        if (likedStatus[reviewId]) {
            toggleLike(reviewId); // Remove like if active
        }
    }

    dislikeCountElems.forEach(elem => elem.textContent = `${dislikeCounts[reviewId]} dislikes`);
}

// Initialize all event listeners on page load
initializeEventListeners();