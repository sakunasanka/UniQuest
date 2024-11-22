<?php require APPROOT . '/views/components/ser_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/view_details.css">

<!-- Sidebar and Content Layout -->
<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/verificationTeamSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="content-header">
            <button class="back-btn" onclick="window.location.href='<?php echo URLROOT; ?>/verification_team/user_verified'">
                <span class="material-symbols-outlined">arrow_back_ios</span>
                <h1>Verified By Me</h1>
            </button>
        </div>

        <!-- User Details and File Preview Section -->
        <div class="user-layout">
            <!-- Left Side: User Details -->
            <div class="user-details">
                <h2>User Details</h2>
                <div class="profile-pic">
                    <img src="<?php echo URLROOT . '/images/profile_pic_preview.png' ?>"
                        alt="Profile Picture">
                </div>
                <div class="detail-row">
                    <strong>First Name </strong>
                    <span class="col">:</span>
                    <span>Sunil</span>
                </div>
                <div class="detail-row">
                    <strong>Last Name </strong>
                    <span class="col">:</span>
                    <span>Perera</span>
                </div>
                <div class="detail-row">
                    <strong>DOB </strong>
                    <span class="col">:</span>
                    <span>2002-08-17</span>
                </div>
                <div class="detail-row">
                    <strong>Gender </strong>
                    <span class="col">:</span>
                    <span>Male</span>
                </div>
                <div class="detail-row">
                    <strong>Email </strong>
                    <span class="col">:</span>
                    <span>sunil@uoc.com</span>
                </div>
                <div class="detail-row">
                    <strong>Contact No </strong>
                    <span class="col">:</span>
                    <span>0774585126</span>
                </div>
                <div class="detail-row">
                    <strong>NIC No </strong>
                    <span class="col">:</span>
                    <span>200210122057</span>
                </div>
                <div class="detail-row">
                    <strong>Address </strong>
                    <span class="col">:</span>
                    <span>No. 12, Galle Road, Colombo 03</span>
                </div>
                <div class="detail-row">
                    <strong>Role </strong>
                    <span class="col">:</span>
                    <span>Student</span>
                </div>
                <div class="detail-row">
                    <strong>University </strong>
                    <span class="col">:</span>
                    <span>University of Colombo</span>
                </div>
                <div class="detail-row">
                    <strong>University ID </strong>
                    <span class="col">:</span>
                    <span>2020/mtc/154</span>
                </div>
                <div class="detail-row">
                    <strong>Register Date </strong>
                    <span class="col">:</span>
                    <span>2024-10-25</span>
                </div>
                <div class="detail-row">
                    <strong>CV </strong>
                    <span class="col">:</span>
                    <span>
                            <a href="" target="_blank">View CV</a>
                    </span>
                </div>
            </div>

            <!-- Right Side: File Previews -->
            <div class="file-previews">
                <h2>File Previews</h2>
                <div class="detail-row">
                    <strong>NIC Copy </strong>
                </div>
                <iframe src="" frameborder="0"></iframe>
                <div class="detail-row">
                    <strong>University ID Copy </strong>
                </div>
                <iframe src="" frameborder="0"></iframe>
            </div>
        </div>
    </main>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>