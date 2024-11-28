document.addEventListener("DOMContentLoaded", function() {
    let popup1 = document.getElementById("popup-verify");

    function open_verify() {
        popup1.classList.toggle("active");

        document.body.style.overflow = 'hidden';
    }

    // Automatically open the popup when the page is loaded
    open_verify(); 
});