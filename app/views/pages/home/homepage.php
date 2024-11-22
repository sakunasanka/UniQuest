<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/home/homepage.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- Hero Section -->
<section class="hero">
    <div class="hero-text">
        <h1>Welcome to UniQuest!</h1>
        <p>Empowering students with part time jobs and internship opportunities.</p>
        <a href="#services" class="cta-button">
            Read More
        </a>
    </div>
</section>

<!-- Services Section -->
<div class="content">
    <section id="services" class="services">
        <h2>Our Services <i class="material-icons">work_outline</i></h2>
        <p>We offer part-time job opportunities for university students.</p>
        <div class="service-cards">
            <div class="service-card">
                <h3><i class="material-icons">work</i> Part Time Jobs</h3>
                <p>Find part-time positions that fit your academic schedule and career interests.</p>
            </div>
            <div class="service-card">
                <h3><i class="material-icons">school</i> Internships</h3>
                <p>Browse internship opportunities that offer practical experience in your field of study.</p>
            </div>
        </div>
    </section>

    <!-- Students Section -->
    <section class="students">
        <h2>For Students <i class="material-icons large-icon">groups</i></h2>
        <p>We simplify opportunities for university students by connecting you with part-time jobs and internships.</p>
        <div class="service-cards">
            <div class="service-card">
                <p><i class="material-icons">search</i> Explore jobs and internships tailored for students.</p>
            </div>
            <div class="service-card">
                <p><i class="material-icons">network_check</i> Build your professional network and gain experience.</p>
            </div>
            <div class="service-card">
                <p><i class="material-icons">login</i> Sign up today and start your career journey!</p>
            </div>
        </div>
    </section>

    <!-- Service Providers Section -->
    <section class="service-providers">
        <h2>For Service Providers <i class="material-icons large-icon">business</i></h2>
        <p>Join UniQuest and gain access to a diverse pool of talented students eager to work and learn.</p>
        <div class="service-cards">
            <div class="service-card">
                <p><i class="material-icons">post_add</i> Post your first two jobs for free.</p>
            </div>
            <div class="service-card">
                <p><i class="material-icons">star</i> Access premium features like report generation.</p>
            </div>
            <div class="service-card">
                <p><i class="material-icons">people</i> Connect with motivated students ready to contribute.</p>
            </div>
        </div>
    </section>
</div>

<!-- Footer -->
<?php require APPROOT . '/views/components/footer.php'; ?>
<script src="<?php echo URLROOT; ?>/public/js/home/home_scroll.js"></script>