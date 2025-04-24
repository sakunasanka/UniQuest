<?php require APPROOT . '/views/components/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/viewApplication.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="main-container">
    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Student'): ?>
        <?php require APPROOT . '/views/components/studentSidePanel.php'; ?>
    <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Company'): ?>
        <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>
    <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'Admin'): ?>
        <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>
    <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'VT-Member'): ?>
        <?php require APPROOT . '/views/components/verificationTeamSidePanel.php'; ?>
    <?php endif; ?> 

    <div class="content-area">
        <div class="header">
            <h1>Application Details</h1>
        </div>

        <?php 
            $fields = $data['fields'];
            if ($fields): 
                foreach ($fields as $fieldName => $fieldConfig): 
                    $isRequired = isset($fieldConfig['required']) && $fieldConfig['required'];
            ?>
            <?php 
                endforeach;
            endif; 
            ?>

        <!-- Application Details Section -->
        <div class="application-details">
            <!-- Header -->
            <div class="application-header">
                <div class="applicant-info">
                <?php if (isset($fields['photo'])): ?>
                    <img src="<?php echo empty($data['application']['photo']) 
                            ? URLROOT . '/images/profile_pic_preview.png'
                            : URLROOT . '/public/' . $data['application']['photo']; ?>" 
                        alt="<?php echo !empty($data['application']['fullname']) ? htmlspecialchars($data['application']['fullname']) : 'Applicant photo'; ?>" 
                        class="applicant-photo">
                <?php else: ?>
                    <img src="<?php echo URLROOT . '/images/profile_pic_preview.png'; ?>" 
                        alt="<?php echo !empty($data['application']['fullname']) ? htmlspecialchars($data['application']['fullname']) : 'Applicant photo'; ?>" 
                        class="applicant-photo">
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
            <?php if(isset($fields['email']) || isset($fields['contact']) || isset($fields['address']) || isset($fields['nic']) || isset($fields['gender']) || isset($fields['dob'])):?>
            <div class="personal-info">
                <h3>Personal Information</h3>
                <?php if (isset($fields['email'])): ?>
                    <div class="info-group">
                        <label>
                            Email:
                            <?php if (isset($fields['email']['required']) && $fields['email']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </label>
                        <span class="<?php echo empty($data['application']['email']) ? 'not-provided' : ''; ?>">
                            <?php echo !empty($data['application']['email']) ? $data['application']['email'] : 'Not provided'; ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (isset($fields['contact'])): ?>
                    <div class="info-group">
                        <label>
                            Contact:
                            <?php if (isset($fields['contact']['required']) && $fields['contact']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </label>
                        <span class="<?php echo empty($data['application']['contact']) ? 'not-provided' : ''; ?>">
                            <?php echo !empty($data['application']['contact']) ? $data['application']['contact'] : 'Not provided'; ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (isset($fields['address'])): ?>
                    <div class="info-group">
                        <label>
                            Address:
                            <?php if (isset($fields['address']['required']) && $fields['address']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </label>
                        <span class="<?php echo empty($data['application']['address']) ? 'not-provided' : ''; ?>">
                            <?php echo !empty($data['application']['address']) ? $data['application']['address'] : 'Not provided'; ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (isset($fields['nic'])): ?>
                    <div class="info-group">
                        <label>
                            NIC:
                            <?php if (isset($fields['nic']['required']) && $fields['nic']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </label>
                        <span class="<?php echo empty($data['application']['nic']) ? 'not-provided' : ''; ?>">
                            <?php echo !empty($data['application']['nic']) ? $data['application']['nic'] : 'Not provided'; ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (isset($fields['gender'])): ?>
                    <div class="info-group">
                        <label>
                            Gender:
                            <?php if (isset($fields['gender']['required']) && $fields['gender']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </label>
                        <span class="<?php echo empty($data['application']['gender']) ? 'not-provided' : ''; ?>">
                            <?php echo !empty($data['application']['gender']) ? $data['application']['gender'] : 'Not provided'; ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (isset($fields['dob'])): ?>
                    <div class="info-group">
                        <label>
                            Date of Birth:
                            <?php if (isset($fields['dob']['required']) && $fields['dob']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </label>
                        <span class="<?php echo empty($data['application']['dob']) ? 'not-provided' : ''; ?>">
                            <?php echo !empty($data['application']['dob']) ? $data['application']['dob'] : 'Not provided'; ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Professional Information -->
            <?php if(isset($fields['qualifications']) || isset($fields['experience']) || isset($fields['skills'])):?>
            <div class="professional-info">
                <h3>Professional Information</h3>
                <?php if (isset($fields['qualifications'])): ?>
                    <div class="info-group">
                        <label>
                            Qualifications:
                            <?php if (isset($fields['qualifications']['required']) && $fields['qualifications']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </label>
                        <span class="<?php echo empty($data['application']['qualifications']) ? 'not-provided' : ''; ?>">
                            <?php echo !empty($data['application']['qualifications']) ? nl2br($data['application']['qualifications']) : 'Not provided'; ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (isset($fields['experience'])): ?>
                    <div class="info-group">
                        <label>
                            Experience:
                            <?php if (isset($fields['experience']['required']) && $fields['experience']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </label>
                        <span class="<?php echo empty($data['application']['experience']) ? 'not-provided' : ''; ?>">
                            <?php echo !empty($data['application']['experience']) ? nl2br($data['application']['experience']) : 'Not provided'; ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (isset($fields['skills'])): ?>
                    <div class="info-group">
                        <label>
                            Skills:
                            <?php if (isset($fields['skills']['required']) && $fields['skills']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </label>
                        <span class="<?php echo empty($data['application']['skills']) ? 'not-provided' : ''; ?>">
                            <?php if (!empty($data['application']['skills'])): ?>
                                <div class="skills-list">
                                    <?php
                                    $skillsInput = str_replace(["\r\n", "\r", "\n"], ',', $data['application']['skills']);
                                    $skillsArray = explode(',', $skillsInput);
                                    
                                    foreach ($skillsArray as $skill) {
                                        $trimmedSkill = trim($skill);
                                        if (!empty($trimmedSkill)) {
                                            echo "<span class='skill-badge'>".htmlspecialchars($trimmedSkill)."</span>";
                                        }
                                    }
                                    ?>
                                </div>
                            <?php else: ?>
                                Not provided
                            <?php endif; ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Documents & Links -->
            <?php if(isset($fields['cv']) || isset($fields['nic_copy']) || isset($fields['linkedin']) || isset($fields['other1']) && $data['application']['other1_type'] == 'file' || isset($fields['other2']) && $data['application']['other2_type'] == 'file' || isset($fields['other3']) && $data['application']['other3_type'] == 'file'):?>
            <div class="documents-links">
                <h3>Documents & Links</h3>
                <div class="documents-grid">
                    <?php if (isset($fields['cv'])): ?>
                        <button class="document-button" 
                            <?php if (!empty($data['application']['cv'])): ?>
                                onclick="window.open('<?php echo URLROOT . '/public/' . htmlspecialchars($data['application']['cv']); ?>', '_blank')"
                            <?php else: ?>
                                onclick="notProvidedError()"
                            <?php endif; ?>
                        >
                            <i class="fas fa-id-card"></i> View CV
                            <?php if (isset($fields['cv']['required']) && $fields['cv']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </button>
                    <?php endif; ?>

                    <?php if (isset($fields['nic_copy'])): ?>
                        <button class="document-button" 
                            <?php if (!empty($data['application']['nic_copy'])): ?>
                                onclick="window.open('<?php echo URLROOT . '/public/' . htmlspecialchars($data['application']['nic_copy']); ?>', '_blank')"
                            <?php else: ?>
                                onclick="notProvidedError()"
                            <?php endif; ?>
                        >
                            <i class="fas fa-id-card"></i> View NIC Copy
                            <?php if (isset($fields['nic_copy']['required']) && $fields['nic_copy']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </button>
                    <?php endif; ?>

                    <?php if (isset($fields['linkedin'])): 
                        $linkedinUrl = ($data['application']['linkedin']);
                    ?>
                        <button class="document-button" 
                            <?php if (!empty($data['application']['nic_copy'])): ?>
                                onclick="window.open('<?php echo $linkedinUrl; ?>', '_blank')"
                            <?php else: ?>
                                onclick="notProvidedError()"
                            <?php endif; ?>
                        >
                            <i class="fas fa-id-card"></i> LinkedIn Profile
                            <?php if (isset($fields['linkedin']['required']) && $fields['linkedin']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </button>
                    <?php endif; ?>

                    <?php if (isset($fields['other1']) && $data['application']['other1_type'] == 'file'): ?>
                        <button class="document-button" 
                            <?php if (!empty($data['application']['other1'])): ?>
                                onclick="window.open('<?php echo URLROOT . '/public/' . $data['application']['other1']; ?>', '_blank')"
                            <?php else: ?>
                                onclick="notProvidedError()"
                            <?php endif; ?>
                        >
                            <i class="fas fa-id-card"></i> <?php echo($data['fields']['other1']['label']);?>
                            <?php if (isset($fields['other1']['required']) && $fields['other1']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </button>
                    <?php endif; ?>

                    <?php if (isset($fields['other2']) && $data['application']['other2_type'] == 'file'): ?>
                        <button class="document-button" 
                            <?php if (!empty($data['application']['other2'])): ?>
                                onclick="window.open('<?php echo URLROOT . '/public/' . $data['application']['other2']; ?>', '_blank')"
                            <?php else: ?>
                                onclick="notProvidedError()"
                            <?php endif; ?>
                        >
                            <i class="fas fa-id-card"></i> <?php echo($data['fields']['other2']['label']);?>
                            <?php if (isset($fields['other2']['required']) && $fields['other2']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </button>
                    <?php endif; ?>

                    <?php if (isset($fields['other3']) && $data['application']['other3_type'] == 'file'): ?>
                        <button class="document-button" 
                            <?php if (!empty($data['application']['other3'])): ?>
                                onclick="window.open('<?php echo URLROOT . '/public/' . $data['application']['other3']; ?>', '_blank')"
                            <?php else: ?>
                                onclick="notProvidedError()"
                            <?php endif; ?>
                        >
                            <i class="fas fa-id-card"></i> <?php echo($data['fields']['other3']['label']);?>
                            <?php if (isset($fields['other3']['required']) && $fields['other3']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </button>
                    <?php endif; ?>

                </div>
            </div>
            <?php endif; ?>

            <!-- Other fields section -->
            <?php if((isset($fields['other1']) && $data['application']['other1_type'] != 'file' || isset($fields['other2']) && $data['application']['other2_type'] != 'file' || isset($fields['other3']) && $data['application']['other3_type'] != 'file')):?>
            <div class="other-fields">
                <h3>Other Fields</h3>
                <?php if (isset($fields['other1']) && $data['application']['other1_type'] != 'file'): ?>
                    <div class="info-group">
                        <label>
                            <?php echo($data['fields']['other1']['label']);?>:
                            <?php if (isset($fields['other1']['required']) && $fields['other1']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </label>
                        <span class="<?php echo empty($data['application']['other1']) ? 'not-provided' : ''; ?>">
                            <?php echo !empty($data['application']['other1']) ? nl2br($data['application']['other1']) : 'Not provided'; ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (isset($fields['other2']) && $data['application']['other2_type'] != 'file'): ?>
                    <div class="info-group">
                        <label>
                            <?php echo($data['fields']['other2']['label']);?>:
                            <?php if (isset($fields['other2']['required']) && $fields['other2']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </label>
                        <span class="<?php echo empty($data['application']['other2']) ? 'not-provided' : ''; ?>">
                            <?php echo !empty($data['application']['other2']) ? nl2br($data['application']['other2']) : 'Not provided'; ?>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if (isset($fields['other3']) && $data['application']['other3_type'] != 'file'): ?>
                    <div class="info-group">
                        <label>
                            <?php echo($data['fields']['other3']['label']);?>:
                            <?php if (isset($fields['other3']['required']) && $fields['other3']['required']): ?>
                                <span class="required-asterik" style="color:red;">*</span>
                            <?php endif; ?>
                        </label>
                        <span class="<?php echo empty($data['application']['other3']) ? 'not-provided' : ''; ?>">
                            <?php echo !empty($data['application']['other3']) ? nl2br($data['application']['other3']) : 'Not provided'; ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Footer with Action Buttons -->
            <?php if($_SESSION['user_role'] == 'Company' && $data['application']['status'] == 'Pending'):?>
                <div class="actions-section">
                    <button class="action-button reject-button" onclick="window.location.href='<?php echo URLROOT; ?>/service_provider/reject_application/<?php echo $data['application']['id']; ?>/<?php echo $data['application']['jobID']; ?>'">Reject
                        <i class="fas fa-times-circle"></i> 
                    </button>
                    <button class="action-button approve-button" onclick="window.location.href='<?php echo URLROOT; ?>/service_provider/approve_application/<?php echo $data['application']['id']; ?>/<?php echo $data['application']['jobID']; ?>'">Approve
                        <i class="fas fa-check-circle"></i> 
                    </button>
                </div>

                <?php elseif($_SESSION['user_role'] == 'Company' && $data['application']['status'] == 'Accepted'):?>
                <div class="actions-section">
                    <button class="action-button reject-button" onclick="window.location.href='<?php echo URLROOT; ?>/service_provider/reject_application/<?php echo $data['application']['id']; ?>/<?php echo $data['application']['jobID']; ?>'">Reject
                        <i class="fas fa-times-circle"></i> 
                    </button>
                </div>    

                <?php elseif($_SESSION['user_role'] == 'Company' && $data['application']['status'] == 'Rejected'):?>
                <div class="actions-section">
                    <button class="action-button approve-button" onclick="window.location.href='<?php echo URLROOT; ?>/service_provider/approve_application/<?php echo $data['application']['id']; ?>/<?php echo $data['application']['jobID']; ?>'">Approve
                        <i class="fas fa-check-circle"></i> 
                    </button>
                </div>    
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>

<script>
    function notProvidedError() {
        Flash.show('Not provided', 'error');
    }
</script>

