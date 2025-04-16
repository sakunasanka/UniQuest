<?php 
require APPROOT . '/views/components/stu_header.php'; 
?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/viewApplication.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="main-container">
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <div class="content-area">
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

            <!-- File Previews Section -->
            <div class="file-previews">
                <h2>File Previews</h2>
                <?php if (!empty($data['application']['nic_copy'])): ?>
                    <div class="detail-row">
                        <strong>NIC Copy</strong>
                    </div>
                    <iframe src="<?php echo UPLOADROOT; ?>/nic_copy/<?php echo htmlspecialchars($data['application']['nic_copy']); ?>" frameborder="0"></iframe>
                <?php endif; ?>
                <?php if (!empty($data['application']['cv'])): ?>
                    <div class="detail-row<div class="detail-row">
                        <strong>View CV</strong>
                    </div>
                    <iframe src="<?php echo UPLOADROOT; ?>/cv/<?php echo htmlspecialchars($data['application']['cv']); ?>" frameborder="0"></iframe>
                    <?php endif; ?>
                
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