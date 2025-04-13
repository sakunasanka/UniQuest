<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/view_profile.css">

<!-- Sidebar and Content Layout -->
<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="content-header">
            <button class="back-btn" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_ver_pending'">
                <span class="material-symbols-outlined">arrow_back_ios</span>
                <h1>User Verification</h1>
            </button>
        </div>
        <div class="view-card">
            <div class="view-card-pic">
                <img
                    src="<?php echo empty($data['user']['CompanyLogo'])
                                ? URLROOT . '/images/profile_pic_preview.png'
                                : UPLOADROOT . '/profile_pictures/company/' . $data['user']['CompanyLogo']; ?>"
                    alt="Profile Picture">
            </div>

            <div class="view-card-content">
                <h1><?php echo $data['user']['CompanyName'] ?></h1>
                <h2><?php echo $data['user']['Industry'] ?></h2>
                <p><?php echo $data['user']['Description'] ?></p>

                <div class="view-card-info">
                    <div>
                        <span>Address</span>
                        <?php echo $data['user']['StreetNo'] ?>, <?php echo $data['user']['AddressLine1'] ?>, <?php echo $data['user']['AddressLine2'] ?><?php echo empty($data['user']['AddressLine2']) ? '' : ',' ?> <?php echo $data['user']['City'] ?></span>
                    </div>
                    <div>
                        <span>Contact No</span>
                        <?php echo $data['user']['ContactNo'] ?>
                    </div>
                    <div>
                        <span>Email</span>
                        <?php echo $data['user']['Email'] ?>
                    </div>
                    <div>
                        <span>Website</span>
                        <a href="<?php echo $data['user']['Website'] ?>" target="_blank"><?php echo $data['user']['Website'] ?></a>
                    </div>
                </div>
                <div class="btn-row">
                    <?php if ($data['verifyDetails']->Action == 'Approve'): ?>
                        <div class="status-act" style="width: 100%;">
                            <span>Approved By: </span>
                            <?php if ($data['verifyDetails']->ActionByID == $_SESSION['user_id']): ?>
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
                            <?php if ($data['verifyDetails']->ActionByID == $_SESSION['user_id']): ?>
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
                    <form action="<?php echo URLROOT; ?>/admin/user_ver_reject/<?php echo $data['user']['UserID']; ?>" method="GET">
                        <select class="reason" name="reason" required <?php if ($data['user']['Status'] == 'Not Approved') echo 'disabled'; ?>>
                            <option value="" disabled selected>Select Reason</option>
                            <?php foreach ($data['rejectReasons'] as $reason) : ?>
                                <option value="<?php echo $reason->ReasonID; ?>"><?php echo $reason->ReasonName; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="reject-btn" <?php if ($data['user']['Status'] == 'Not Approved') echo 'disabled'; ?>>Reject</button>
                    </form>
                    <button class="approve-btn" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_ver_approve/<?php echo $data['user']['UserID']; ?>'">Approve</button>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>