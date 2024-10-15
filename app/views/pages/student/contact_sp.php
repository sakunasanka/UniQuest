<?php require APPROOT . '/views/components/stu_header.php'; ?>

<header class="header">

</header>

<body>
    <div class="contact-container">
        <div class="contact-left">
            <h1>Contact Service Provider</h1>
            <p>Fill out the form below to reach out about jobs, internships, or other opportunities</p>
            <form>
                <label for="name">Name:</label>
                <input type="text" placeholder="Enter your Name" required>
                <label for="email">Email:</label>
                <input type="email" placeholder="Email" required>
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

<?php require APPROOT . '/views/components/footer.php'; ?>
