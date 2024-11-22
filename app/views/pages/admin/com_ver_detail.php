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
            <button class="back-btn"  onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_ver_pending'">
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

                <ul class="view-card-options">
                    <li><a onclick="showdeleteaccountconfirm()">Deactivate Account</a></li>
                    <li><a href="<?php echo URLROOT ?>/user/logout">Log Out</a></li>
                </ul>
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
                    <button class="reject-btn" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_ver_reject/<?php echo $data['user']['UserID']; ?>'">Reject</button>
                    <button class="approve-btn" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_ver_approve/<?php echo $data['user']['UserID']; ?>'">Approve</button>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>