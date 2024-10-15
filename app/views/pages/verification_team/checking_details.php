<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/verification_team/checking_details.css">

<!-- Sidebar and Content Layout -->
<div class="content-area">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?> 

    <div class="container">
        <h2> Checking Details</h2>

       

        <!-- Form Container -->
        <div class="registration-form">
            <div class="input-group">
                <label for="name">Name</label>
                <input type="text" id="name" value="hashan madushanka">
            </div>

            <div class="input-group">
                <label for="regNo">Reg No:</label>
                <input type="text" id="regNo" value="2022/is/234">
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" value="hashan@edu.cmb.ac.lk">
            </div>

            <div class="more-button">
                <button class="more-btn">More..</button>
            </div>

            <div class="confirmation-dialog">
                <p>Verififcation status</p>
            </div>

            <div class="action-buttons">
             
                <button class="reject-btn">Done</button>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/components/footer.php'; ?>