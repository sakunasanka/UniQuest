let popup1 = document.getElementById("popup-1");

function toggleMoreReviews() {
    // Scroll to the top of the page
    window.scrollTo(0, 0);

    // Toggle the popup
    popup1.classList.toggle("active");

    // Disable scrolling when popup is active
    if (popup1.classList.contains("active")) {
        document.body.style.overflow = 'hidden'; // Disable scroll
    } else {
        document.body.style.overflow = 'auto';   // Enable scroll
        window.scrollTo(0, document.body.scrollHeight); //scroll to bottom of the page  
    }
}