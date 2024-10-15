<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/verification_team/stu_registration.css">

<!-- Sidebar and Content Layout -->
<div class="content-area">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?> 

    <!-- Sidebar and Content Layout -->
    <div class="content-area">
        <!-- Sidebar (Optional) -->
        <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

        <!-- Main Container -->
        <div class="container">
            <h1>Student Registration</h1>

            <!-- Dropdown Status Button -->
            <div class="status-dropdown">
                <button class="status-btn">To Verify ▼</button>
            </div>

            <!-- Registration Form -->
            <div class="registration-form">
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" value="Hashan Madushanka" required>
                </div>

                <div class="input-group">
                    <label for="nic">NIC</label>
                    <input type="text" id="nic" value="200233445566" required>
                </div>

                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="hashan@edu.cmb.ac.lk" required>
                </div>

                <div class="input-group">
                    <label for="mobile">Mobile No:</label>
                    <input type="text" id="mobile" value="0777123456" required>
                </div>

                <div class="input-group">
                    <label for="university">University</label>
                    <input type="text" id="university" value="Colombo University" required>
                </div>

                <!-- Buttons -->
                <div class="action-buttons">
                    <button class="accept-btn">Accept</button>
                    <button class="reject-btn">Reject</button>
                </div>
            </div>
        </div>
    </div>

    <?php require APPROOT . '/views/components/footer.php'; ?>
</div>