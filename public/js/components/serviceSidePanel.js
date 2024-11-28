document.addEventListener("DOMContentLoaded", function () {
    const currentPath = window.location.pathname;
    const navMenu = document.querySelector(".nav-menu");
    
    // Use event delegation to handle click events
    navMenu.addEventListener("click", function (event) {
        const button = event.target.closest(".nav-btn");
        if (!button) return;

        const targetPaths = button.dataset.paths ? button.dataset.paths.split(",") : [button.dataset.path];
        
        // Remove 'active' class from all buttons and add to the clicked one
        document.querySelectorAll(".nav-btn").forEach((btn) => btn.classList.remove("active"));
        button.classList.add("active");

        // Navigate to the first target path
        const targetPath = targetPaths[0];
        if (targetPath) {
            window.location.href = targetPath;
        }
    });

    // Set the active class based on the current URL
    document.querySelectorAll(".nav-btn").forEach((button) => {
        const targetPaths = button.dataset.paths ? button.dataset.paths.split(",") : [button.dataset.path];
        if (targetPaths.includes(currentPath)) {
            button.classList.add("active");
        }
    });
});

// Handle dropdown toggles and state persistence
document.addEventListener('DOMContentLoaded', () => {
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    // Load dropdown state from localStorage
    dropdownToggles.forEach((toggle, index) => {
        const dropdownMenu = toggle.nextElementSibling;
        const storedState = localStorage.getItem(`dropdown-${index}`);

        if (storedState === 'expanded') {
            dropdownMenu.style.display = 'block';
            toggle.querySelector('.dropdown-icon').textContent = 'expand_less'; // Icon for collapse
        } else {
            dropdownMenu.style.display = 'none';
            toggle.querySelector('.dropdown-icon').textContent = 'expand_more'; // Icon for expand
        }
    });

    // Handle click events on dropdowns and save the state in localStorage
    dropdownToggles.forEach((toggle, index) => {
        toggle.addEventListener('click', (event) => {
            const dropdownMenu = toggle.nextElementSibling;

            // Toggle the visibility of the dropdown menu
            if (dropdownMenu.style.display === 'block') {
                dropdownMenu.style.display = 'none';
                toggle.querySelector('.dropdown-icon').textContent = 'expand_more'; // Change the icon back
                localStorage.setItem(`dropdown-${index}`, 'collapsed'); // Save collapsed state
            } else {
                dropdownMenu.style.display = 'block';
                toggle.querySelector('.dropdown-icon').textContent = 'expand_less'; // Change the icon to collapse
                localStorage.setItem(`dropdown-${index}`, 'expanded'); // Save expanded state
            }
        });
    });
});