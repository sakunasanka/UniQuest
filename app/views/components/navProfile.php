
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/navProfile.css">

<div class="profile-dropdown">
    <img src="<?php echo empty($_SESSION['user_profile_pic'])
                    ? URLROOT . '/images/profile_pic_preview.png'
                    : UPLOADROOT . '/profile_pictures/' . lcfirst($_SESSION['user_role']) .'/' . $_SESSION['user_profile_pic']; ?>"
        alt="Profile Picture" class="nav-profile-pic">
    <div class="profile-dropdown-content">
        <span><?php echo $_SESSION['user_name']; ?></span>
        <span><?php echo $_SESSION['user_email']; ?></span>
        <hr>
        <a href="/UniQuest/user/profile">Profile</a>
        <a href="/UniQuest/user/logout">Log out</a>
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