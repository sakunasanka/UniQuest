function populateDropdown() {
    var tableHeaders, columnSelect, option, i;
    
    // Get all the table headers (th elements)
    tableHeaders = document.querySelectorAll(".table-block table thead th");
    
    // Get the dropdown element
    columnSelect = document.querySelector(".column-select");
    
    // Loop through the headers and create an option for each one, excluding the last header
    for (i = 0; i < tableHeaders.length - 1; i++) { // -1 to skip the last column
        option = document.createElement("option");
        option.value = i; // Use the index of the header as the value
        option.textContent = tableHeaders[i].textContent; // Set the option text to the header's text
        columnSelect.appendChild(option); // Add the option to the dropdown
    }
}

function searchByName() {
    var input, filter, table, tr, td, i, txtValue, selectedColumn;
    input = document.querySelector(".search");
    filter = input.value.toUpperCase();
    table = document.querySelector(".table-block table");
    tr = table.getElementsByTagName("tr");
    
    // Get the selected column index from the dropdown
    selectedColumn = document.querySelector(".column-select").value;

    // Loop through all table rows and hide those that don't match the search query in the selected column
    for (i = 1; i < tr.length; i++) { // Start at 1 to skip header
        td = tr[i].getElementsByTagName("td")[selectedColumn]; // Use selected column
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

// Ensure the function runs when the DOM is fully loaded
document.addEventListener("DOMContentLoaded", function() {
    populateDropdown(); // Populate dropdown dynamically
    document.querySelector(".search").addEventListener("keyup", searchByName);
    document.querySelector(".column-select").addEventListener("change", searchByName);
});