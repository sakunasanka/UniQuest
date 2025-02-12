document.addEventListener("DOMContentLoaded", function () {
    const addButton = document.querySelector(".add-btn");

    if (addButton) {
        const targetPath = addButton.dataset.path;

        // Add click event listener to handle navigation
        addButton.addEventListener("click", function () {
            if (targetPath) {
                window.location.href = targetPath;
            }
        });
    }
});