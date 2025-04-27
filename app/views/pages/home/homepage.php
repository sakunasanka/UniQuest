<?php require APPROOT . '/views/components/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/home/homepage.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/home_footer.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<section class="hero">
    <div class="hero-text">
        <h1>Welcome to UniQuest!</h1>
        <p>Empowering students with part time jobs and internship opportunities.</p>
        <a href="#services" class="cta-button">
            Read More
        </a>
    </div>

    <div class="hero-slideshow">
    <div class="slide">
        <div class="slide-content">
            <h3>Part-Time Jobs</h3>
            <p>Find part-time positions that fit your academic schedule and career interests.</p>
        </div>
    </div>
    <div class="slide">
        <div class="slide-content">
            <h3>Internships</h3>
            <p>Browse internship opportunities that offer practical experience in your field of study.</p>
        </div>
    </div>
    <div class="slide">
        <div class="slide-content">
            <h3>Build Your Network</h3>
                <p>Connect with professionals and grow your career.</p>
            </div>
        </div>
    </div>
</section>

    <section class="students" id="services">
        <h2>For Students <i class="material-icons large-icon">groups</i></h2>
        <p>We simplify opportunities for university students by connecting you with part-time jobs and internships.</p>
    <div class= "service">
        <div class="image-content">
            <img src="<?php echo URLROOT; ?>/images/internships.jpg" alt="Students Image">
        </div>
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
    </div>
    </section>

    <section class="service-providers">
    <h2>For Service Providers <i class="material-icons large-icon">business</i></h2>
    <p>Join UniQuest and gain access to a diverse pool of talented students eager to work and learn.</p>
    <div class="service">
        <div class="image-content">
            <img src="<?php echo URLROOT; ?>/images/service-providers.jpg" alt="Service Providers Image">
        </div>
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
    </div>
</section>

</div>

<?php require APPROOT . '/views/components/footer.php'; ?>
<script src="<?php echo URLROOT; ?>/public/js/home/home_scroll.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll(".slide");
    let currentSlide = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove("active"); // Remove active class from all slides
        });
        slides[index].classList.add("active"); // Add active class to the current slide
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length; // Move to the next slide
        showSlide(currentSlide);
    }

    // Show the first slide initially
    showSlide(currentSlide);

    // Change slide every 3 seconds
    setInterval(nextSlide, 3000);
});

</script>