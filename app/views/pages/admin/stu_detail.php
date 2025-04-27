<?php require APPROOT . '/views/components/header.php'; ?>
<?php require APPROOT . '/views/components/chat-sent.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/view_details.css">
<div class="main-container">
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>
    <main class="content-area">
        <div class="content-header">
            <button class="back-btn" onclick="window.location.href='<?php echo URLROOT; ?>/admin/students_mng'">
                <span class="material-symbols-outlined">arrow_back_ios</span>
                <h1>User Management</h1>
            </button>
        </div>
        <div class="user-layout">
            <div class="user-details">
                <h2>User Details</h2>
                <div class="profile-pic">
                    <img
                        src="<?php echo empty($data['user']['ProfilePic'])
                                    ? URLROOT . '/images/profile_pic_preview.png'
                                    : UPLOADROOT . '/profile_pictures/student/' . $data['user']['ProfilePic']; ?>"
                        alt="Profile Picture">
                </div>
                <div class="detail-row">
                    <strong>First Name </strong>
                    <span class="col">:</span>
                    <span><?php echo $data['user']['FirstName'] ?></span>
                </div>
                <div class="detail-row">
                    <strong>Last Name </strong>
                    <span class="col">:</span>
                    <span><?php echo $data['user']['LastName'] ?></span>
                </div>
                <div class="detail-row">
                    <strong>DOB </strong>
                    <span class="col">:</span>
                    <span><?php echo $data['user']['DOB'] ?></span>
                </div>
                <div class="detail-row">
                    <strong>Gender </strong>
                    <span class="col">:</span>
                    <span><?php echo $data['user']['Gender'] ?></span>
                </div>
                <div class="detail-row">
                    <strong>Email </strong>
                    <span class="col">:</span>
                    <span><?php echo $data['user']['Email'] ?></span>
                </div>
                <div class="detail-row">
                    <strong>Contact No </strong>
                    <span class="col">:</span>
                    <span><?php echo $data['user']['ContactNo'] ?></span>
                </div>
                <div class="detail-row">
                    <strong>NIC No </strong>
                    <span class="col">:</span>
                    <span><?php echo $data['user']['NIC_No'] ?></span>
                </div>
                <div class="detail-row">
                    <strong>Address </strong>
                    <span class="col">:</span>
                    <span><?php echo $data['user']['StreetNo'] ?>, <?php echo $data['user']['AddressLine1'] ?>, <?php echo $data['user']['AddressLine2'] ?><?php echo empty($data['user']['AddressLine2']) ? '' : ',' ?> <?php echo $data['user']['City'] ?></span>
                </div>
                <div class="detail-row">
                    <strong>Role </strong>
                    <span class="col">:</span>
                    <span><?php echo $data['user']['Role'] ?></span>
                </div>
                <div class="detail-row">
                    <strong>University </strong>
                    <span class="col">:</span>
                    <span><?php echo $data['user']['University'] ?></span>
                </div>
                <div class="detail-row">
                    <strong>University ID </strong>
                    <span class="col">:</span>
                    <span><?php echo $data['user']['UniversityID'] ?></span>
                </div>
                <div class="detail-row">
                    <strong>Register Date </strong>
                    <span class="col">:</span>
                    <span><?php echo $data['user']['RegisterDate'] ?></span>
                </div>
                <div class="detail-row">
                    <strong>CV </strong>
                    <span class="col">:</span>
                    <span>
                        <?php if ($data['user']['CV']): ?>
                            <a href="<?php echo UPLOADROOT; ?>/cvs/<?php echo $data['user']['CV']; ?>" target="_blank">View CV</a>
                        <?php else: ?>
                            No uploaded CV
                        <?php endif; ?>
                    </span>
                </div>
                <div class="detail-row">
                    <?php if ($data['verifyDetails']->Action == 'Approve'): ?>
                        <div class="status-act">
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
                        <div class="status-deact">
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
                <div class="detail-row">
                    <?php if ($data['user']['Status'] == 'Deactive' || $data['user']['Status'] == 'Pendind Deletion' && $data['acc_log'] != NULL): ?>
                        <div class="status-deact">
                            <span>Status: <?php echo $data['user']['Status'] ?></span><br>
                            <span>Reason: <?php echo $data['acc_log']->Reason ?></span><br>
                            <span>Deactivated on: <?php echo substr($data['acc_log']->ActionDate, 0, 10); ?></span><br>
                        </div>
                    <?php elseif ($data['user']['Status'] == 'Active' && $data['acc_log'] != NULL): ?>
                        <div class="status-act">
                            <span>Status: <?php echo $data['user']['Status'] ?></span><br>
                            <span>Reason: <?php echo $data['acc_log']->Reason ?></span><br>
                            <span>Activated on: <?php echo substr($data['acc_log']->ActionDate, 0, 10); ?></span><br>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="btn-row">
                    <div></div>
                    <button id="openPopupBtn" class="open-btn">Contact</button>
                </div>
            </div>
            <div class="file-previews">
                <h2>File Previews</h2>
                <div class="detail-row">
                    <strong>NIC Copy </strong>
                </div>
                <iframe src="<?php echo UPLOADROOT; ?>/nic_copies/<?php echo htmlspecialchars($data['user']['NIC_Copy']); ?>" frameborder="0"></iframe>
                <div class="detail-row">
                    <strong>University ID Copy </strong>
                </div>
                <iframe src="<?php echo UPLOADROOT; ?>/university_id_copies/<?php echo htmlspecialchars($data['user']['UniversityID_Copy']); ?>" frameborder="0"></iframe>
            </div>
        </div>
    </main>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>