document.addEventListener('DOMContentLoaded', function () {
    const content = document.querySelector('.table-block tbody');
    const itemsPerPage = 10;
    let currentPage = 0;
    const items = Array.from(content.getElementsByTagName('tr'));

    // Function to display items for the current page
    function showPage(page) {
        const startIndex = page * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;

        // Hide all items first
        items.forEach(item => {
            item.classList.add('hidden');
        });

        // Show items for the current page
        items.slice(startIndex, endIndex).forEach(item => {
            item.classList.remove('hidden');
        });

        updateActiveButtonStates();
    }

    // Function to create pagination buttons
    function createPageButtons() {
        const totalPages = Math.ceil(items.length / itemsPerPage);
        const paginationContainer = document.querySelector('.pagination');
        paginationContainer.innerHTML = ''; // Clear existing buttons

        // Add 'Previous' button
        const prevButton = document.createElement('button');
        prevButton.textContent = '«';
        prevButton.classList.add('page-btn', 'prev');
        prevButton.addEventListener('click', () => {
            if (currentPage > 0) {
                currentPage--;
                showPage(currentPage);
            }
        });
        paginationContainer.appendChild(prevButton);

        // Add page number buttons
        for (let i = 0; i < totalPages; i++) {
            const pageButton = document.createElement('button');
            pageButton.textContent = i + 1;
            pageButton.classList.add('page-btn');
            if (i === currentPage) pageButton.classList.add('active');
            pageButton.addEventListener('click', () => {
                currentPage = i;
                showPage(currentPage);
            });
            paginationContainer.appendChild(pageButton);
        }

        // Add 'Next' button
        const nextButton = document.createElement('button');
        nextButton.textContent = '»';
        nextButton.classList.add('page-btn', 'next');
        nextButton.addEventListener('click', () => {
            const totalPages = Math.ceil(items.length / itemsPerPage);
            if (currentPage < totalPages - 1) {
                currentPage++;
                showPage(currentPage);
            }
        });
        paginationContainer.appendChild(nextButton);
    }

    // Function to update active states for pagination buttons
    function updateActiveButtonStates() {
        const pageButtons = document.querySelectorAll('.pagination .page-btn');
        pageButtons.forEach((button) => {
            const pageNum = parseInt(button.textContent);
            if (pageNum === currentPage + 1) {
                button.classList.add('active');
            } else {
                button.classList.remove('active');
            }
        });
    }

    // Initialize pagination
    createPageButtons();
    showPage(currentPage);
});





// const data = [
//     { name: "Sakith", email: "sakiththewmika@gmail.com", mobile: "076 4834398", date: "2024/05/16", status: "Active" },
//     { name: "Sakith", email: "sakiththewmika@gmail.com", mobile: "076 4834398", date: "2024/05/16", status: "Inactive" },
//     { name: "Sakith", email: "sakiththewmika@gmail.com", mobile: "076 4834398", date: "2024/05/16", status: "Active" },
//     { name: "Sakith", email: "sakiththewmika@gmail.com", mobile: "076 4834398", date: "2024/05/16", status: "Active" },
//     { name: "Sakith", email: "sakiththewmika@gmail.com", mobile: "076 4834398", date: "2024/05/16", status: "Active" },
//     { name: "Sakith", email: "sakiththewmika@gmail.com", mobile: "076 4834398", date: "2024/05/16", status: "Inactive" },
//     { name: "Sakith", email: "sakiththewmika@gmail.com", mobile: "076 4834398", date: "2024/05/16", status: "Active" },
//     { name: "Sakith", email: "sakiththewmika@gmail.com", mobile: "076 4834398", date: "2024/05/16", status: "Active" },
//     { name: "Sakith", email: "sakiththewmika@gmail.com", mobile: "076 4834398", date: "2024/05/16", status: "Active" },
//     { name: "Sakith", email: "sakiththewmika@gmail.com", mobile: "076 4834398", date: "2024/05/16", status: "Inactive" },

// ];

// let currentPage = 1;
// const itemsPerPage = 5;

// function renderTable() {
//     const tableBody = document.querySelector('tbody');
//     tableBody.innerHTML = '';

//     const start = (currentPage - 1) * itemsPerPage;
//     const end = start + itemsPerPage;

//     const pageData = data.slice(start, end);

//     pageData.forEach(row => {
//         const tr = document.createElement('tr');
//         tr.innerHTML = `
//             <td>${row.name}</td>
//             <td>${row.email}</td>
//             <td>${row.mobile}</td>
//             <td>${row.date}</td>
//             <td><span class="status ${row.status.toLowerCase()}">${row.status}</span></td>
//             <td class="action">
//                 <span class="material-symbols-outlined action-btn view">account_box</span>
//                 <span class="material-symbols-outlined action-btn edit">edit_square</span>
//                 <span class="material-symbols-outlined action-btn ${row.status === 'Active' ? 'deactivate' : 'activate'}">
//                     ${row.status === 'Active' ? 'person_remove' : 'person_add'}
//                 </span>
//             </td>
//         `;
//         tableBody.appendChild(tr);
//     });

//     document.querySelector('.total-count').textContent = `${end > data.length ? data.length : end} out of ${data.length}`;
// }

// function handlePageChange(direction) {
//     const totalPages = Math.ceil(data.length / itemsPerPage);

//     if (direction === 'prev' && currentPage > 1) {
//         currentPage--;
//     } else if (direction === 'next' && currentPage < totalPages) {
//         currentPage++;
//     }

//     renderTable();
//     updatePaginationButtons(totalPages);
// }

// function updatePaginationButtons(totalPages) {
//     const paginationButtons = document.querySelectorAll('.page-btn');
//     paginationButtons.forEach((button, index) => {
//         if (index === 0) {
//             button.disabled = currentPage === 1;
//         } else if (index === paginationButtons.length - 1) {
//             button.disabled = currentPage === totalPages;
//         } else {
//             button.classList.toggle('active', parseInt(button.textContent) === currentPage);
//         }
//     });
// }

// document.addEventListener('DOMContentLoaded', () => {
//     renderTable();

//     document.querySelector('.prev').addEventListener('click', () => handlePageChange('prev'));
//     document.querySelector('.next').addEventListener('click', () => handlePageChange('next'));

//     document.querySelectorAll('.page-btn:not(.prev, .next)').forEach(button => {
//         button.addEventListener('click', (e) => {
//             currentPage = parseInt(e.target.textContent);
//             renderTable();
//             updatePaginationButtons(Math.ceil(data.length / itemsPerPage));
//         });
//     });
// });