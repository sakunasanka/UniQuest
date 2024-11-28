let popup_stu = document.getElementById("popup-editreview");

function ToggleEditReview() {
    popup_stu.classList.toggle("active");

    if (popup_stu.classList.contains("active")) {
        // Scroll to the bottom of the page
        window.scrollTo(0, document.body.scrollHeight);

        // Disable scrolling
        document.body.style.overflow = "hidden";
    } else {
        // Enable scrolling
        document.body.style.overflow = "auto";
    }
}