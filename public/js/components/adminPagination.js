document.addEventListener("DOMContentLoaded", function () {
    const paginationContainer = document.querySelector(".pagination");
    
    let urlParams = new URLSearchParams(window.location.search);
    let currentPage = urlParams.get("page") || 1;
    let limit = urlParams.get("limit") || 2;

    function updatePagination() {
        paginationContainer.innerHTML = `
            <button class="page-btn prev" data-page="${currentPage - 1}" ${currentPage <= 1 ? "disabled" : ""}>&laquo;</button>
        `;

        for (let i = 1; i <= totalPages; i++) {
            paginationContainer.innerHTML += `
                <button class="page-btn ${i == currentPage ? "active" : ""}" data-page="${i}">${i}</button>
            `;
        }

        paginationContainer.innerHTML += `
            <button class="page-btn next" data-page="${parseInt(currentPage) + 1}" ${currentPage >= totalPages ? "disabled" : ""}>&raquo;</button>
        `;

        attachEventListeners();
    }

    function attachEventListeners() {
        document.querySelectorAll(".page-btn").forEach((btn) => {
            btn.addEventListener("click", function (e) {
                e.preventDefault();

                let newPage = this.getAttribute("data-page");

                if (!newPage || newPage < 1 || newPage > totalPages) return;

                // Update the URL and reload the page
                urlParams.set("page", newPage);
                urlParams.set("limit", limit);

                // Reload the page with new pagination parameters
                window.location.search = urlParams.toString();

            });
        });
    }

    if (totalPages > 1) {
        updatePagination(); // Initial pagination setup
    } else {
        paginationContainer.innerHTML = "";
    }
});


// document.addEventListener('DOMContentLoaded', function () {
//     const content = document.querySelector('.table-block tbody');
//     const itemsPerPage = 10;
//     let currentPage = 0;
//     const items = Array.from(content.getElementsByTagName('tr'));

//     // Function to display items for the current page
//     function showPage(page) {
//         const startIndex = page * itemsPerPage;
//         const endIndex = startIndex + itemsPerPage;

//         // Hide all items first
//         items.forEach(item => {
//             item.classList.add('hidden');
//         });

//         // Show items for the current page
//         items.slice(startIndex, endIndex).forEach(item => {
//             item.classList.remove('hidden');
//         });

//         updateActiveButtonStates();
//     }

//     // Function to create pagination buttons
//     function createPageButtons() {
//         const totalPages = Math.ceil(items.length / itemsPerPage);
//         const paginationContainer = document.querySelector('.pagination');
//         paginationContainer.innerHTML = ''; // Clear existing buttons

//         // Add 'Previous' button
//         const prevButton = document.createElement('button');
//         prevButton.textContent = '«';
//         prevButton.classList.add('page-btn', 'prev');
//         prevButton.addEventListener('click', () => {
//             if (currentPage > 0) {
//                 currentPage--;
//                 showPage(currentPage);
//             }
//         });
//         paginationContainer.appendChild(prevButton);

//         // Add page number buttons
//         for (let i = 0; i < totalPages; i++) {
//             const pageButton = document.createElement('button');
//             pageButton.textContent = i + 1;
//             pageButton.classList.add('page-btn');
//             if (i === currentPage) pageButton.classList.add('active');
//             pageButton.addEventListener('click', () => {
//                 currentPage = i;
//                 showPage(currentPage);
//             });
//             paginationContainer.appendChild(pageButton);
//         }

//         // Add 'Next' button
//         const nextButton = document.createElement('button');
//         nextButton.textContent = '»';
//         nextButton.classList.add('page-btn', 'next');
//         nextButton.addEventListener('click', () => {
//             const totalPages = Math.ceil(items.length / itemsPerPage);
//             if (currentPage < totalPages - 1) {
//                 currentPage++;
//                 showPage(currentPage);
//             }
//         });
//         paginationContainer.appendChild(nextButton);
//     }

//     // Function to update active states for pagination buttons
//     function updateActiveButtonStates() {
//         const pageButtons = document.querySelectorAll('.pagination .page-btn');
//         pageButtons.forEach((button) => {
//             const pageNum = parseInt(button.textContent);
//             if (pageNum === currentPage + 1) {
//                 button.classList.add('active');
//             } else {
//                 button.classList.remove('active');
//             }
//         });
//     }

//     // Initialize pagination
//     createPageButtons();
//     showPage(currentPage);
// });
