document.addEventListener("DOMContentLoaded", function () {
    const toggleFiltersBtn = document.getElementById("toggleFilters");
    const filterPanel = document.querySelector(".filter-row"); // Adjust selector based on actual structure
    const searchInput = document.getElementById("searchInput");
    const clearSearchBtn = document.getElementById("clearSearch");

    // Check if filters were applied (from PHP)
    const filtersApplied = toggleFiltersBtn.getAttribute("data-filters-applied") === "true";

    // Show filters if filters were applied
    if (filtersApplied) {
        filterPanel.classList.add("visible");
        toggleFiltersBtn.querySelector("span").textContent = "Hide Filters";
    }

    // Toggle filter panel visibility
    toggleFiltersBtn.addEventListener("click", function () {
        filterPanel.classList.toggle("visible");
        toggleFiltersBtn.querySelector("span").textContent = 
            filterPanel.classList.contains("visible") ? "Hide Filters" : "Show Filters";
    });

    // Show/Hide clear button based on input
    searchInput.addEventListener("input", function () {
        clearSearchBtn.style.display = searchInput.value ? "block" : "none";
    });

    // Clear search field on clicking the cross icon
    clearSearchBtn.addEventListener("click", function () {
        searchInput.value = "";
        clearSearchBtn.style.display = "none";
    });

    // Ensure clear button visibility on page load if there's input
    if (searchInput.value) {
        clearSearchBtn.style.display = "block";
    }
});
