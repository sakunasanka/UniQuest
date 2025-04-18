<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/job_detail.css">

<!-- Sidebar and Content Layout -->
<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/verificationTeamSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="content-header">
            <button class="back-btn" onclick="window.location.href='<?php echo URLROOT; ?>/verification_team/job_ver_pending'">
                <span class="material-symbols-outlined">arrow_back_ios</span>
                <h1>Jobs Verification</h1>
            </button>
        </div>
        <div class="view-card">
        <div class="view-card-pic">
                <img
                    src="<?php echo empty($data['job']->CompanyLogo)
                                ? URLROOT . '/images/profile_pic_preview.png'
                                : UPLOADROOT . '/profile_pictures/company/' . $data['job']->CompanyLogo; ?>"
                    alt="company logo"
                    onclick="window.location.href='<?php echo URLROOT; ?>/verification_team/user_detail/<?php echo $data['job']->CompanyID; ?>'">
            </div>

            <div class="view-card-content">
            <h1><?php echo $data['job']->Title ?></h1>
                <span><?php echo $data['job']->City ?></span>
                <span><?php echo $data['job']->SalaryRange ?></span>
                <div class="description">
                        <p><?php echo $data['job']->Description ?></p>
                </div>
                <div class="view-card-info">
                    <div>
                        <h3>Qualifications:</h3>
                        <!-- <ul>
                            <li>Age Between 18 - 40</li>
                            <li>With a valid driver's license</li>
                            <li>Should own a Motorbike</li>
                        </ul> -->
                        <?php echo $data['job']->RequiredQualifications ?>
                    </div>
                    <div>
                        <h3>Benefits:</h3>
                        <!-- <ul>
                            <li>Highest salary in the industry</li>
                            <li>Special Extra Allowances</li>
                            <li>Meals during service hours</li>
                            <li>Accommodation is provided</li>
                        </ul> -->
                        <?php echo $data['job']->JobBenefits ?>
                    </div>
                </div>
                <div class="btn-row">
                    <?php if ($data['verifyDetails']->Action == 'Approve'): ?>
                        <div class="status-act" style="width: 100%;">
                            <span>Approved By: </span>
                            <?php if ($data['verifyDetails']->ActionByID == $_SESSION['user_id'] || $data['verifyDetails']->ActionByRole == 'Admin'): ?>
                                <span><?php echo $data['verifyDetails']->ActionByName ?></span><br>
                            <?php else: ?>
                                <span class="actionby-link" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_detail/<?php echo $data['verifyDetails']->ActionByID; ?>'">
                                    <?php echo $data['verifyDetails']->ActionByName ?>
                                </span><br>
                            <?php endif; ?>
                            <span>Approved On: <?php echo substr($data['verifyDetails']->ActionDate, 0, 10); ?></span><br>
                        </div>
                    <?php elseif ($data['verifyDetails']->Action == 'Reject'): ?>
                        <div class="status-deact" style="width: 100%;">
                            <span>Rejected By: </span>
                            <?php if ($data['verifyDetails']->ActionByID == $_SESSION['user_id'] || $data['verifyDetails']->ActionByRole == 'Admin'): ?>
                                <span><?php echo $data['verifyDetails']->ActionByName ?></span><br>
                            <?php else: ?>
                                <span class="actionby-link" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_detail/<?php echo $data['verifyDetails']->ActionByID; ?>'">
                                    <?php echo $data['verifyDetails']->ActionByName ?>
                                </span><br>
                            <?php endif; ?>
                            <span>Reason: <?php echo $data['verifyDetails']->Reason ?></span><br>
                            <span>Rejected On: <?php echo substr($data['verifyDetails']->ActionDate, 0, 10); ?></span><br>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="btn-row">
                    <form action="<?php echo URLROOT; ?>/verification_team/job_ver_reject/<?php echo $data['job']->JobID ?>" method="GET">
                        <select class="reason" name="reason" required <?php if($data['job']->Status == 'Not Approved') echo 'disabled'; ?>>
                            <option value="" disabled selected>Select Reason</option>
                            <?php foreach ($data['rejectReasons'] as $reason) : ?>
                                <option value="<?php echo $reason->ReasonID; ?>"><?php echo $reason->ReasonName; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="reject-btn" <?php if($data['job']->Status == 'Not Approved') echo 'disabled'; ?>>Reject</button>
                    </form>
                    <button class="approve-btn" onclick="window.location.href='<?php echo URLROOT; ?>/verification_team/job_ver_approve/<?php echo $data['job']->JobID ?>'">Approve</button>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>