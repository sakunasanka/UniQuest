let popup_stu = document.getElementById("popup-changepw");

function ToggleChangePasswordForm() {
    popup_stu.classList.toggle("active");

    if (popup_stu.classList.contains("active")) {
        // Scroll to the top of the page
        window.scrollTo({ top: 0, behavior: "smooth" });

        // Disable scrolling
        document.body.style.overflow = "hidden";
    } else {
        // Enable scrolling
        document.body.style.overflow = "auto";
    }
}