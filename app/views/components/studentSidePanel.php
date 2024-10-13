
<body>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/studentSidePanel.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="sidebar">
        <button class="menu-btn"><i class="fas fa-briefcase"></i> Browse Opportunities</button>
        <div class="dropdown">
            <button class="menu-btn dropdown-btn"><i class="fas fa-file-alt"></i> My Applications</button>
            <div class="dropdown-content">
                <button class="dropdown-item"><i class="fas fa-list"></i> All</button>
                <button class="dropdown-item"><i class="fas fa-check"></i> Accepted</button>
                <button class="dropdown-item"><i class="fas fa-times"></i> Rejected</button>
            </div>
        </div>
        <button class="menu-btn"><i class="fas fa-bookmark"></i> Saved Opportunities</button>
        <button class="menu-btn"><i class="fas fa-calendar-alt"></i> View Calendar</button>
        <button class="menu-btn"><i class="fas fa-chart-line"></i> Trending Companies</button>
        <button class="menu-btn"><i class="fas fa-exclamation-circle"></i> Make a complaint</button>
        <button class="menu-btn"><i class="fas fa-life-ring"></i> Help and Support</button>
    </div>

</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".dropdown-btn").click(function(){
                $(this).next(".dropdown-content").slideToggle("fast");
            });
        });
     </script>
