<?php
// Mock data for user profile
$user = [
    'full_name' => 'kaveesha rathnayake',
    'email' => 'kaveesha123@gmail.com',
    'address' => '29/A, hambanthota',
    'nic_no' => '200456789900',
    'dob' => '2002/09/06',
    'mobile' => '0776890789',
    'university_email' => '2020cs058stu.cmb.ucsc.ac.lk',
    'university_id' => '21000678'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stu_view_profile.css"> <!-- Link to CSS file -->
    <title>User Profile</title>
</head>
<body>
    <div class="profile-container">
    <div class="profile-sidebar">
        <div class="menu-icon">
        <img src="./Assests/menu_icon.png" alt="Menu Icon" class="menu-icon">
        </div>
        <div class="profile-pic-container">

            <img src="./Assests/user.png" alt="Profile Picture" class="profile-pic"> <!-- Add your profile picture image path -->
        </div>
        <ul class="nav-links">
            <li><a href="#">Profile</a></li>
            <li><a href="#">Deactivate Account</a></li>
            <li><a href="#">Sign out</a></li>
        </ul>
    </div>
        <div class="profile-content">
            <div class="profile-info">
                <h2>My information</h2>
                <table>
                    <tr><td class="label">Full Name</td><td class="colon">:</td><td><?php echo $user['full_name']; ?></td></tr>
                    <tr><td class="label">Email</td><td class="colon">:</td><td><?php echo $user['email']; ?></td></tr>
                    <tr><td class="label">Address</td><td class="colon">:</td><td><?php echo $user['address']; ?></td></tr>
                    <tr><td class="label">NIC No</td><td class="colon">:</td><td><?php echo $user['nic_no']; ?></td></tr>
                    <tr><td class="label">Date Of Birth</td><td class="colon">:</td><td><?php echo $user['dob']; ?></td></tr>
                    <tr><td class="label">Mobile</td><td class="colon">:</td><td><?php echo $user['mobile']; ?></td></tr>
                    <tr><td class="label">Uploaded CV</td><td class="colon">:</td><td><a href="#" class="cv-link">📄</a></td></tr>
                </table>

                <h2>University Information</h2>
                <table>
                    <tr><td class="label">University Email</td><td class="colon">:</td><td><?php echo $user['university_email']; ?></td></tr>
                    <tr><td class="label">University ID number</td><td class="colon">:</td><td><?php echo $user['university_id']; ?></td></tr>
                </table>
                <button class="edit-info">Edit info</button>
            </div>
        </div>
    </div>
</body>
</html>
