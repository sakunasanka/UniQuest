<?php require APPROOT . '/views/components/stu_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/contact_form.css">

<div class="main-container">
<?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <div class="content-area">
        <div class="container">
            <div class="contact-left">
                <h1>Contact Us</h1>
                <form id="contactForm" action="<?php echo URLROOT; ?>/student/contact_admin" method="POST">
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" placeholder="Enter Your Email" value="<?php echo $data['email']; ?>" required>
                    <span class="error-message"><?php echo $data['email_err']; ?></span>

                    <label for="topic">Topic:</label>
                    <select id="topic" name="topic" required>
                        <option value="job" <?php echo ($data['topic'] == 'job') ? 'selected' : ''; ?>>Job</option>
                        <option value="internship" <?php echo ($data['topic'] == 'internship') ? 'selected' : ''; ?>>Internship</option>
                        <option value="general information" <?php echo ($data['topic'] == 'general information') ? 'selected' : ''; ?>>General Information</option>
                    </select>

                    <span class="error-message"><?php echo $data['topic_err']; ?></span>

                    <label for="message">Message:</label>
                    <textarea id="message" name="message" placeholder="Message" required><?php echo $data['message']; ?></textarea>
                    <span class="error-message"><?php echo $data['message_err']; ?></span>
                    
                    <button type="submit">Send</button>
                </form>
            </div>

            <div class="contact-right">
                <img src="<?php echo URLROOT; ?>/images/Contact-us.png" alt="Contact Us Image">
            </div>
        </div>    
    </div>
</div>

<script>
document.getElementById("contactForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission

    let isValid = true;

    // Email validation
    //const email = document.getElementById("email").value;
    //const emailError = document.getElementById("emailError");
    //const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email regex
    //if (!emailPattern.test(email)) {
    //  emailError.textContent = "Please enter a valid email address.";
    //  emailError.style.display = "block";
    //isValid = false;
    //} else {
    //   emailError.style.display = "none";
    // }

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