function seachByName() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.querySelector(".search");
    filter = input.value.toUpperCase();
    table = document.querySelector(".table-block table");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 1; i < tr.length; i++) { // Start at 1 to skip header
        td = tr[i].getElementsByTagName("td")[0];
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

// Ensure that the function is available when the DOM is fully loaded
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector(".search").addEventListener("keyup", seachByName);
});