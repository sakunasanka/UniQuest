<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/view_complaint.css">

<!-- Sidebar and Content Layout -->
<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="content-header">
            <button class="back-btn" onclick="window.location.href='<?php echo URLROOT; ?>/admin/job_complaint'">
                <span class="material-symbols-outlined">arrow_back_ios</span>
                <h1>Complaint Management</h1>
            </button>
        </div>

        <!-- User Details and File Preview Section -->
        <div class="user-layout">
            <!-- Left Side: User Details -->
            <div class="user-details">
                <h2>Complaint Details</h2>
                <div class="profile-pic">
                    <div class="profile-card" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_detail/<?php echo $data['complaint']->StudentID; ?>'">
                        <img
                            src="<?php echo empty($data['complaint']->StudentProfilePic)
                                        ? URLROOT . '/images/profile_pic_preview.png'
                                        : UPLOADROOT . '/profile_pictures/student/' . $data['complaint']->StudentProfilePic; ?>"
                            alt="Profile Picture">
                        <strong>Student </strong>
                    </div>
                    <div class="profile-card" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_detail/<?php echo $data['complaint']->CompanyID; ?>'">
                        <img
                            src="<?php echo empty($data['complaint']->CompanyLogo)
                                        ? URLROOT . '/images/profile_pic_preview.png'
                                        : UPLOADROOT . '/profile_pictures/company/' . $data['complaint']->CompanyLogo; ?>"
                            alt="Profile Picture">
                        <strong>Company </strong>
                    </div>
                </div>
                <div class="detail-row">
                    <strong>Job Post </strong>
                    <span class="col">:</span>
                    <span><a href="<?php echo URLROOT; ?>/admin/job_detail/<?php echo $data['complaint']->JobID; ?>">
                            <?php echo $data['complaint']->JobTitle ?>
                        </a></span>
                </div>
                <div class="detail-row">
                    <strong>Complaint Date </strong>
                    <span class="col">:</span>
                    <span><?php echo $data['complaint']->ComplainedDate ?></span>
                </div>
                <div class="detail-row">
                    <strong>Complaint Discription </strong>
                    <span class="col">:</span>
                </div>
                <div class="detail-row">
                    <span>
                        <?php echo $data['complaint']->Complaint ?>
                    </span>
                </div>
                <div class="btn-row">
                    <button class="reject-btn" onclick="">Reject</button>
                    <button class="approve-btn" onclick="">Resolve</button>
                </div>
            </div>

            <!-- Right Side: File Previews -->
            <div class="file-previews">
                <h2>Proof Previews</h2>
                <iframe src="" frameborder="0"></iframe>
            </div>
        </div>
    </main>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>