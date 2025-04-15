<?php 
    if (!isset($_SESSION['user_role'])) {
        require APPROOT . '/views/components/header.php';
    }
    else if ($_SESSION['user_role'] == 'Student') {
        require APPROOT . '/views/components/stu_header.php';
    } else if ($_SESSION['user_role'] == 'Company') {
        require APPROOT . '/views/components/ser_header.php';
    } 
    else if ($_SESSION['user_role'] == 'Admin') {
        require APPROOT . '/views/components/adm_header.php';
    }
    else if ($_SESSION['user_role'] == 'VT-Member') {
        require APPROOT . '/views/components/ver_header.php';
    }
?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/userAgreement/privacyStatement.css">

<div class="main-container">
    <main class="container">
        
        <h1>Privacy Statement</h1>

        <h2>Introduction</h2>
        <p>At UniQuest, your privacy is our priority. This Privacy Statement explains how we collect, use, and safeguard your personal information when you use our services. By accessing or using UniQuest, you consent to the practices outlined in this statement.</p>

        <h2>Information We Collect</h2>
        <p>We collect the following types of information:</p>
        <ul>
            <li><strong>Personal Information:</strong> Name, email address, phone number, and other details provided during registration.</li>
            <li><strong>Usage Data:</strong> Information about how you use our platform, including pages visited and actions taken.</li>
        </ul>

        <h2>How We Use Your Information</h2>
        <p>Your information is used for the following purposes:</p>
        <ul>
            <li>To provide and improve our services.</li>
            <li>To communicate with you about your account, job applications, or inquiries.</li>
            <li>To ensure a secure and personalized experience on UniQuest.</li>
        </ul>

        <h2>Information Sharing</h2>
        <p>We do not sell or share your personal information with third parties, except:</p>
        <ul>
            <li>To comply with legal obligations.</li>
            <li>To trusted partners who assist us in operating the platform, under strict confidentiality agreements.</li>
        </ul>

        <h2>Your Privacy Choices</h2>
        <p>We respect your privacy choices. You can:</p>
        <ul>
            <li>Access, update, or delete your personal information through your account settings.</li>
            <li>You have full control over your account information and can choose what types of notifications you wish to receive through your account settings.</li>
        </ul>

        <h2>Data Security</h2>
        <p>We prioritize the security of your data and implement advanced, industry-leading measures to safeguard it. While we continuously work to maintain the highest standards of protection, we also encourage users to take proactive steps to secure their accounts for an added layer of safety.</p>

        <h2>Changes to This Privacy Statement</h2>
        <p>We may update this Privacy Statement from time to time. Any changes will be communicated through our platform, and your continued use of UniQuest constitutes your acceptance of the updated terms.</p>

        <h2>Contact Us</h2>
        <p>If you have any questions or concerns about this Privacy Statement, please contact us at <a href="mailto:support@uniquest.com">support@uniquest.com</a>.</p>
    </main>
</div>

<?php require APPROOT . '/views/components/footer.php'; ?>