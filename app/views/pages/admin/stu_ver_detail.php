<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/view_details.css">

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

        <!-- User Details and File Preview Section -->
        <div class="user-layout">
            <!-- Left Side: User Details -->
            <div class="user-details">
                <h2>User Details</h2>
                <div class="profile-pic">
                    <img src="<?php echo empty($data['user']['ProfilePic'])
                                    ? URLROOT . '/images/profile_pic_preview.png'
                                    : UPLOADROOT . '/profile_pictures/student/' . $data['user']['ProfilePic']; ?>"
                        alt="Profile Picture">
                </div>
                <div class="detail-row">
                    <strong>First Name </strong>
                    <span class="col">:</span>
                    <span><?php echo htmlspecialchars($data['user']['FirstName']); ?></span>
                </div>
                <div class="detail-row">
                    <strong>Last Name </strong>
                    <span class="col">:</span>
                    <span><?php echo htmlspecialchars($data['user']['LastName']); ?></span>
                </div>
                <div class="detail-row">
                    <strong>DOB </strong>
                    <span class="col">:</span>
                    <span><?php echo htmlspecialchars($data['user']['DOB']); ?></span>
                </div>
                <div class="detail-row">
                    <strong>Gender </strong>
                    <span class="col">:</span>
                    <span><?php echo htmlspecialchars($data['user']['Gender']); ?></span>
                </div>
                <div class="detail-row">
                    <strong>Email </strong>
                    <span class="col">:</span>
                    <span><?php echo htmlspecialchars($data['user']['Email']); ?></span>
                </div>
                <div class="detail-row">
                    <strong>Contact No </strong>
                    <span class="col">:</span>
                    <span><?php echo htmlspecialchars($data['user']['ContactNo']); ?></span>
                </div>
                <div class="detail-row">
                    <strong>NIC No </strong>
                    <span class="col">:</span>
                    <span><?php echo htmlspecialchars($data['user']['NIC_No']); ?></span>
                </div>
                <div class="detail-row">
                    <strong>Address </strong>
                    <span class="col">:</span>
                    <span class="kk"><?php echo $data['user']['StreetNo'] ?>, <?php echo $data['user']['AddressLine1'] ?>, <?php echo $data['user']['AddressLine2'] ?><?php echo empty($data['user']['AddressLine2']) ? '' : ',' ?> <?php echo $data['user']['City'] ?>
                </div>
                <div class="detail-row">
                    <strong>Role </strong>
                    <span class="col">:</span>
                    <span><?php echo htmlspecialchars($data['user']['Role']); ?></span>
                </div>
                <div class="detail-row">
                    <strong>University </strong>
                    <span class="col">:</span>
                    <span><?php echo htmlspecialchars($data['user']['University']); ?></span>
                </div>
                <div class="detail-row">
                    <strong>University ID </strong>
                    <span class="col">:</span>
                    <span><?php echo htmlspecialchars($data['user']['UniversityID']); ?></span>
                </div>
                <div class="detail-row">
                    <strong>Register Date </strong>
                    <span class="col">:</span>
                    <span><?php echo substr($data['user']['RegisterDate'], 0, 10); ?></span>
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

                <div class="btn-row">
                    <form action="<?php echo URLROOT; ?>/admin/user_ver_reject/<?php echo $data['user']['UserID']; ?>" method="GET">
                        <select class="reason" name="reason" required>
                            <option value="" disabled selected>Select Reason</option>
                            <?php foreach ($data['rejectReasons'] as $reason) : ?>
                                <option value="<?php echo $reason->ReasonID; ?>"><?php echo $reason->ReasonName; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="reject-btn">Reject</button>
                    </form>
                    <button class="approve-btn" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_ver_approve/<?php echo $data['user']['UserID']; ?>'">Approve</button>
                </div>
            </div>

            <!-- Right Side: File Previews -->
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