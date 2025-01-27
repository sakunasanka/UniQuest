<?php require APPROOT . '/views/components/ver_header.php'; ?>

<header class="header">

</header>

<body>
    <div class="contact-container">
        <div class="contact-left">
            <h1>Contact Us</h1>
            <form>
                <label for="name">Name:</label>
                <input type="text" id="name" placeholder="Enter Your Name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" placeholder="Enter Your Email" required>

                <label for="message">Message:</label>
                <textarea id="message" placeholder="Message" required></textarea>

                <button type="submit">Send</button>
            </form>
        </div>

        <div class="contact-right">
            <img src="<?php echo URLROOT; ?>/images/Contact-us.png" alt="Contact Us Image">
        </div>
    </div>
</body>


<?php require APPROOT . '/views/components/footer.php'; ?>