<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/verification_team/stu_registration.css">

<!-- Sidebar and Content Layout -->
<div class="content-area">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?> 

    <div class="vreg_form-container">
        <h2 class="vreg_form-header">Student Registration</h2>
        
        <!-- Status Dropdown -->
        <div class="vreg_status-dropdown">
            <select name="status" class="vreg_input">
                <option value="to_verify">To Verify</option>
            </select>
        </div>

        <!-- Form Fields -->
        <form action="submit_registration.php" method="POST">
            <!-- Name Field -->
            <div class="vreg_form-group">
                <label for="name" class="vreg_label">Name</label>
                <input type="text" id="name" name="name" class="vreg_input" value="kavishka senarathna" required>
            </div>

            <!-- NIC Field -->
            <div class="vreg_form-group vreg_nic-container">
                <label for="nic" class="vreg_label">NIC</label>
                <input type="text" id="nic1" name="nic1" class="vreg_input" value="nic.png" required>
                <!-- <input type="text" id="nic2" name="nic2" class="vreg_input"  required> -->
            </div>

            <!-- Email Field -->
            <div class="vreg_form-group">
                <label for="email" class="vreg_label">Email</label>
                <input type="email" id="email" name="email" class="vreg_input"  value="kavishkasenarathna@student.lk" required>
            </div>

            <!-- Mobile Number Field -->
            <div class="vreg_form-group">
                <label for="mobile" class="vreg_label">Mobile No:</label>
                <input type="text" id="mobile" name="mobile" class="vreg_input"  value="0771234567" required>
            </div>

            <!-- University Field -->
            <div class="vreg_form-group">
                <label for="university" class="vreg_label">University</label>
                <input type="text" id="university" name="university" class="vreg_input" value="University of Colombo" required>
            </div>

            <!-- Buttons for Accept/Reject -->
            <div class="vreg_button-container">
                <button type="submit" name="action" value="accept" class="vreg_button vreg_accept">Accept</button>
                <button type="submit" name="action" value="reject" class="vreg_button vreg_reject">Reject</button>
            </div>
        </form>
    </div>
</div>
<footer class="footer">

</footer>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>
