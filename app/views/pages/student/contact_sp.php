<?php require APPROOT . '/views/components/stu_header.php'; ?>

<header class="header">

</header>

<body>
<?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <div class="contact-container">
        <div class="contact-left">
            <h1>Contact Service Provider</h1>
            <p>Fill out the form below to reach out about jobs, internships, or other opportunities</p>
            <form class="contactForm">
                <label for="name">Name:</label>
                <input type="text" placeholder="Enter your Name" required>

                <label for="email">Email:</label>
                <input type="email" placeholder="Email" required>
                <span class="error-message" id="emailError"></span>

                <label for="message">Message:</label>
                <textarea placeholder="Message" required></textarea>

                <button type="submit">Send</button>
            </form>
        </div>
        <div class="contact-right">
            <img src="<?php echo URLROOT; ?>/images/Contact-us.png" alt="Contact Us Image">
        </div>
    </div>
</body>

<script>
document.getElementById("contactForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission

    let isValid = true;

    // Email validation
    const email = document.getElementById("email").value;
    const emailError = document.getElementById("emailError");
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email regex
    if (!emailPattern.test(email)) {
        emailError.textContent = "Please enter a valid email address.";
        emailError.style.display = "block";
        isValid = false;
    } else {
        emailError.style.display = "none";
    }

    // Submit the form if all fields are valid
    if (isValid) {
        alert("Form submitted successfully!");
        this.submit();
    }
});

</script>

<style>
.error-message {
    color: red;
    font-size: 0.9em;
    margin-bottom: 10px;
    display: none;
}
</style>


<?php require APPROOT . '/views/components/footer.php'; ?>
