<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/view_Profile.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?> 
    
    <div class="view-card-container">
    <div class="view-card">
        <img src="placeholder.png" alt="Company Logo"> <!-- Placeholder image -->

        <div class="view-card-content">
            <h1>Acme Inc.</h1>
            <h2>Software & Technology</h2>
            <p>Acme Inc. is a leading software company that specializes in developing innovative solutions for businesses of all sizes. With a team of talented engineers and designers, we are committed to delivering high-quality products that help our clients achieve their goals.</p>

            <div class="view-card-info">
                <div>
                    <span>Address</span>
                    123 Main Street, Colombo
                </div>
                <div>
                    <span>Phone</span>
                    +94 11-345-2686
                </div>
                <div>
                    <span>Email</span>
                    info@academic.com
                </div>
                <div>
                    <span>Website</span>
                    <a href="http://www.acmeinc.com" target="_blank">www.acmeinc.com</a>
                </div>
            </div>
        </div>

        <button class="view-card-button">Edit info</button>
    </div>
</div>
</div>
<footer class="footer">

</footer>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>

