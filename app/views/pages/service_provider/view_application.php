<?php 
require APPROOT . '/views/components/stu_header.php'; 
?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/viewApplication.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <div class="content-area">
        <?php
        // Hard-coded data array
        // $data = [
        //     'application' => [
        //         'photo' => 'https://via.placeholder.com/150', // Replace with actual image path
        //         'fullname' => 'John Doe',
        //         'id' => 'APP12345',
        //         'created_at' => '2023-01-15 10:30:00',
        //         'status' => 'Approved',
        //         'email' => 'john.doe@example.com',
        //         'contact' => '+1 555-123-4567',
        //         'address' => '123 Main St, Cityville, ST 12345',
        //         'nic' => '123456789V',
        //         'gender' => 'Male',
        //         'dob' => '1990-05-15',
        //         'qualifications' => "Bachelor's Degree in Computer Science\nCertified Project Manager",
        //         'experience' => "5 years web development experience\n2 years team leadership",
        //         'skills' => 'HTML, CSS, JavaScript, PHP',
        //         'cv' => 'path/to/cv.pdf',
        //         'nic_copy' => 'path/to/nic_copy.pdf',
        //         'linkedin' => 'https://linkedin.com/in/johndoe',
        //         'other1' => 'path/to/other1.pdf',
        //         'other2' => 'path/to/other2.pdf',
        //         'other3' => 'path/to/other3.pdf'
        //     ]
        // ];
        // ?>
        <div class="header">
            <h1>Application Details</h1>
        </div>

        <!-- Application Details Section -->
        <div class="application-details">
            <!-- Header -->
            <div class="application-header">
                <div class="applicant-info">
                    <?php if (!empty($data['application']['photo'])): ?>
                        <img src="<?php echo $data['application']['photo']; ?>" alt="<?php echo $data['application']['fullname']; ?>" class="applicant-photo">
                    <?php endif; ?>
                    <div>
                        <h2><?php echo $data['application']['fullname']; ?></h2>
                        <p>Application ID: <?php echo $data['application']['id']; ?></p>
                        <p>Applied on: <?php echo date('Y-m-d', strtotime($data['application']['created_at'])); ?></p>
                    </div>
                </div>
                <div class="application-status">
                    <span class="status-badge <?php echo strtolower($data['application']['status']); ?>">
                        <?php echo $data['application']['status']; ?>
                    </span>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="personal-info">
                <h3>Personal Information</h3>
                <?php if (!empty($data['application']['email'])): ?>
                    <div class="info-group">
                        <label>Email:</label>
                        <span><?php echo $data['application']['email']; ?></span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($data['application']['contact'])): ?>
                    <div class="info-group">
                        <label>Contact:</label>
                        <span><?php echo $data['application']['contact']; ?></span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($data['application']['address'])): ?>
                    <div class="info-group">
                        <label>Address:</label>
                        <span><?php echo $data['application']['address']; ?></span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($data['application']['nic'])): ?>
                    <div class="info-group">
                        <label>NIC:</label>
                        <span><?php echo $data['application']['nic']; ?></span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($data['application']['gender'])): ?>
                    <div class="info-group">
                        <label>Gender:</label>
                        <span><?php echo $data['application']['gender']; ?></span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($data['application']['dob'])): ?>
                    <div class="info-group">
                        <label>Date of Birth:</label>
                        <span><?php echo $data['application']['dob']; ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Professional Information -->
            <div class="professional-info">
                <h3>Professional Information</h3>
                <?php if (!empty($data['application']['qualifications'])): ?>
                    <div class="info-group">
                        <label>Qualifications:</label>
                        <span><?php echo nl2br($data['application']['qualifications']); ?></span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($data['application']['experience'])): ?>
                    <div class="info-group">
                        <label>Experience:</label>
                        <span><?php echo nl2br($data['application']['experience']); ?></span>
                    </div>
                <?php endif; ?>
                <?php if (!empty($data['application']['skills'])): ?>
                    <div class="info-group">
                        <label>Skills:</label>
                        <div class="skills-list">
                            <?php
                            $skills = explode(', ', $data['application']['skills']);
                            foreach ($skills as $skill) {
                                echo "<span class='skill-badge'>$skill</span>";
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Documents & Links -->
            <div class="documents-links">
                <h3>Documents & Links</h3>
                <div class="documents-grid">
                    <?php if (!empty($data['application']['cv'])): ?>
                        <button class="document-button" onclick="window.open('<?php echo $data['application']['cv']; ?>', '_blank')">
                            <i class="fas fa-file-alt"></i> View CV
                        </button>
                    <?php endif; ?>
                    <?php if (!empty($data['application']['nic_copy'])): ?>
                        <button class="document-button" onclick="window.open('<?php echo $data['application']['nic_copy']; ?>', '_blank')">
                            <i class="fas fa-id-card"></i> View NIC Copy
                        </button>
                    <?php endif; ?>
                    <?php if (!empty($data['application']['linkedin'])): ?>
                        <button class="document-button" onclick="window.open('<?php echo $data['application']['linkedin']; ?>', '_blank')">
                            <i class="fab fa-linkedin"></i> LinkedIn Profile
                        </button>
                    <?php endif; ?>
                    <?php if (!empty($data['application']['other1'])): ?>
                        <button class="document-button" onclick="window.open('<?php echo $data['application']['other1']; ?>', '_blank')">
                            <i class="fas fa-file"></i> Other Document 1
                        </button>
                    <?php endif; ?>
                    <?php if (!empty($data['application']['other2'])): ?>
                        <button class="document-button" onclick="window.open('<?php echo $data['application']['other2']; ?>', '_blank')">
                            <i class="fas fa-file"></i> Other Document 2
                        </button>
                    <?php endif; ?>
                    <?php if (!empty($data['application']['other3'])): ?>
                        <button class="document-button" onclick="window.open('<?php echo $data['application']['other3']; ?>', '_blank')">
                            <i class="fas fa-file"></i> Other Document 3
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Footer with Action Buttons -->
            <div class="actions-section">
                <button class="action-button reject-button" onclick="handleStatusChange('Rejected')">
                    <i class="fas fa-times-circle"></i> Reject
                </button>
                <button class="action-button approve-button" onclick="handleStatusChange('Approved')">
                    <i class="fas fa-check-circle"></i> Approve
                </button>
            </div>
        </div>
    </div>
</div>

<?php 
require APPROOT . '/views/components/footer.php'; 
?>