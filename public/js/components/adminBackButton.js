document.addEventListener("DOMContentLoaded", function () {
    const backButton = document.querySelector(".back-btn");

    // Handle Back Button
    if (backButton) {
        backButton.addEventListener("click", function () {
            window.history.back(); // Navigates to the previous page
        });
    }
});
