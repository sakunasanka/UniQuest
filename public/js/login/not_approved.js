document.addEventListener("DOMContentLoaded", function() {
    let popup1 = document.getElementById("popup-not-approved");

    function open_verify() {
        popup1.classList.toggle("active");
    }

    // Automatically open the popup when the page is loaded
    open_verify(); 
});