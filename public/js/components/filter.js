document.addEventListener("DOMContentLoaded", function () {
    const filterContainer = document.querySelector(".filter-container");
    const toggleFiltersBtn = document.getElementById("toggleFilters");
    const applyFiltersBtn = document.getElementById("applyFilters");
    const filtersApplied = filterContainer.getAttribute("data-filters-applied") === "true";
    const form = document.getElementById("filterForm");

    if (filtersApplied) {
        filterContainer.classList.add("visible");
        toggleFiltersBtn.querySelector("span").textContent = "Hide Filters";
    }

    toggleFiltersBtn.addEventListener("click", function () {
        filterContainer.classList.toggle("visible");
        toggleFiltersBtn.querySelector("span").textContent = 
            filterContainer.classList.contains("visible") ? "Hide Filters" : "Show Filters";
    });

    applyFiltersBtn.addEventListener("click", function () {
        const formData = new FormData(form);
        const params = new URLSearchParams();

        for (let [key, value] of formData.entries()) {
            if (value.trim() !== "") {
                params.append(key, value);
            }
        }

        const newUrl = `${window.location.pathname}?${params.toString()}`;
        window.location.href = newUrl; // Redirect to new URL with filters
    });
});
