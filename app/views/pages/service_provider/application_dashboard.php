<?php require APPROOT . '/views/components/ser_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/application_dashboard.css">

<div class="main-container">
<?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <div class="content-area">
    <?php    
//         $jobs = [
//     [
//         'title' => 'Senior Frontend Developer',
//         'location' => 'San Francisco',
//         'posted' => 'Jan 15, 2025',
//         'stats' => [
//             'total' => 124,
//             'accepted' => 32,
//             'rejected' => 67,
//             'pending' => 25
//         ]
//     ],
//     [
//         'title' => 'Product Manager',
//         'location' => 'New York',
//         'posted' => 'Jan 22, 2025',
//         'stats' => [
//             'total' => 87,
//             'accepted' => 18,
//             'rejected' => 42,
//             'pending' => 27
//         ]
//     ],
//     [
//         'title' => 'UX Designer',
//         'location' => 'Remote',
//         'posted' => 'Feb 01, 2025',
//         'stats' => [
//             'total' => 56,
//             'accepted' => 12,
//             'rejected' => 31,
//             'pending' => 13
//         ]
//     ],
//     [
//         'title' => 'Data Scientist',
//         'location' => 'Boston',
//         'posted' => 'Feb 10, 2025',
//         'stats' => [
//             'total' => 93,
//             'accepted' => 22,
//             'rejected' => 45,
//             'pending' => 26
//         ]
//     ]
// ];
?>


    <div class="containera">
        <div class="headerb">
            <h1>Job Applications Dashboard</h1>
            <div class="header-buttons">
                <button class="btn-primary">Add New Job</button>
                <button class="btn-secondary">Filter</button>
            </div>
        </div>

        <div class="job-listings">
            <?php foreach ($jobs as $job): ?>
                <div class="job-card">
                    <div class="job-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="job-details">
                        <h2><?php echo $job['title']; ?></h2>
                        <p>
                            
                            <?php echo $job['location']; ?> •
                            Posted: <?php echo $job['posted']; ?>
                        </p>
                    </div>
                    <div class="job-stats">
                        <div class="stat-item">
                            <i class="fas fa-file-alt total-icon"></i>
                            <span><?php echo $job['stats']['total']; ?></span> Total
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-check-circle accepted-icon"></i>
                            <span><?php echo $job['stats']['accepted']; ?></span> Accepted
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-times-circle rejected-icon"></i>
                            <span><?php echo $job['stats']['rejected']; ?></span> Rejected
                        </div>
                        <div class="stat-item pending-stat">
                            <i class="fas fa-clock pending-icon"></i>
                            <span><?php echo $job['stats']['pending']; ?></span> Pending
                        </div>
                    </div>
                    <div class="job-actions">
                        
                        <!-- Corrected onclick with proper quotes and PHP embedding -->
                        <span class="view-link" onclick="window.location.href='<?php echo URLROOT; ?>/service_provider/new_applications/<?php echo $job['jobID']; ?>'">
                            View Applications <i class="fas fa-chevron-right"></i>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>
    
    
