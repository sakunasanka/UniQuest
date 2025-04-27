<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/navProfile.css">

<div class="profile-dropdown">
    <img src="<?php echo empty($_SESSION['user_profile_pic'])
                    ? URLROOT . '/images/profile_pic_preview.png'
                    : UPLOADROOT . '/profile_pictures/' . lcfirst($_SESSION['user_role']) . '/' . $_SESSION['user_profile_pic']; ?>"
        alt="Profile" class="nav-profile-pic">
    <div class="profile-dropdown-content">
        <div class="user-info">
            <div class="user-avatar">
                <img src="<?php echo empty($_SESSION['user_profile_pic'])
                                ? URLROOT . '/images/profile_pic_preview.png'
                                : UPLOADROOT . '/profile_pictures/' . lcfirst($_SESSION['user_role']) . '/' . $_SESSION['user_profile_pic']; ?>"
                    alt="Profile">
            </div>
            <div class="user-details1">
                <strong><?php echo $_SESSION['user_name']; ?></strong>
                <small><?php echo $_SESSION['user_email']; ?></small>
            </div>
        </div>

        <div class="dropdown-actions">
            <a href="/UniQuest/user/profile" class="dropdown-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                </svg>
                <span>My Profile</span>
            </a>
            <a href="/UniQuest/user/logout" class="dropdown-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z" />
                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
                </svg>
                <span>Log Out</span>
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profilePic = document.querySelector('.nav-profile-pic');
        const dropdownContent = document.querySelector('.profile-dropdown-content');

        profilePic.addEventListener('click', function() {
            dropdownContent.classList.toggle('show');

            // Adjust dropdown position dynamically if overflowing
            const rect = dropdownContent.getBoundingClientRect();
            const isOverflowingRight = rect.right > window.innerWidth;
            const isOverflowingLeft = rect.left < 0;

            if (isOverflowingRight) {
                dropdownContent.style.left = 'auto';
                dropdownContent.style.right = '0'; // Align to the right edge of the parent
            } else if (isOverflowingLeft) {
                dropdownContent.style.right = 'auto';
                dropdownContent.style.left = '0'; // Align to the left edge of the parent
            }
        });

        window.addEventListener('click', function(event) {
            if (!event.target.closest('.profile-dropdown')) {
                dropdownContent.classList.remove('show');
            }
        });
    });
</script>