document.addEventListener("DOMContentLoaded", function () {
    const navButtons = document.querySelectorAll(".nav-btn");
    const currentPath = window.location.pathname;

    // Set the active class based on the current URL
    navButtons.forEach((button) => {
        const targetPath = button.dataset.path;

        // Check if the current URL matches the button's path
        if (currentPath === targetPath) {
            button.classList.add("active");
        }

        // Add click event listener to handle navigation and active class toggling
        button.addEventListener("click", function () {
            // Remove 'active' class from all buttons
            navButtons.forEach((btn) => btn.classList.remove("active"));

            // Add 'active' class to the clicked button
            this.classList.add("active");

            // Navigate to the target path
            if (targetPath) {
                window.location.href = targetPath;
            }
        });
    });
});
