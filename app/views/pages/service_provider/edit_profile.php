<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/edit_Profile.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?> 

    <div class="s_e_p_content">

    <form action="process_form.php" method="post" enctype="multipart/form-data">
    <h2>Company Info Form</h2>
    
    <label for="companyLogo">Company Logo</label>
    <input type="file" id="companyLogo" name="companyLogo">
    
    <label for="companyName">Company Name</label>
    <input type="text" id="companyName" name="companyName" value="Acme Inc." required>
    
    <label for="industry">Industry</label>
    <input type="text" id="industry" name="industry" value="Software & Technology" required>
    
    <label for="description">Company Description</label>
    <textarea id="description" name="description" required>Acme Inc. is a leading software company that specializes in developing innovative solutions for businesses of all sizes. With a team of talented engineers and designers, we are committed to delivering high-quality products that help our clients achieve their goals. Our mission is to revolutionize the way businesses operate through cutting-edge technology.</textarea>
    
    <label for="address">Address</label>
    <input type="text" id="address" name="address" value="123 Main Street, Colombo" required>
    
    <label for="phone">Phone</label>
    <input type="text" id="phone" name="phone" value="123 Main Street, Colombo" required>
    
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="info@acmeinc.com" required>
    
    <label for="website">Website</label>
    <input type="url" id="website" name="website" value="www.acmeinc.com" required>
    
    <input type="submit" value="Save Changes">
    <input type="button" value="Cancel" onclick="window.location.href='index.php';">
</form>
</div>

</div>
<footer class="footer">

</footer>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>