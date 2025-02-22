<?php require APPROOT . '/views/components/ser_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/ser_analytics.css">

<header class="header">
    <div class="logo-block"></div>
    <div class="nav-block"></div>
</header>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?> 
    
    <!-- Content Area -->
    <main class="content-area">
        <!-- Stats -->
        <div class="stats">
            <div class="card stat-card">
                <div>
                    <h3>Total Jobs</h3>
                    <p><?php echo $data['job_count']; ?></p>
                    <?php 
                    print_r($data['registrationsData']);
                    echo($_SESSION['user_id'])
                    ?>
                    <?php echo json_encode($data['Jobspermonth']); ?>

                </div>
                <div class="icon_">
                    <span class="material-symbols-outlined large-icon">work</span>
                </div>
            </div>
            <div class="card stat-card">
                <div>
                    <h3>Active Jobs</h3>
                    <p><?php echo $data['activeJobCount']; ?></p>
                </div>
                <div class="icon_">
                    <span class="material-symbols-outlined large-icon">work</span>
                </div>
            </div>
            <div class="card stat-card">
                <div>
                    <h3>Applicants</h3>
                    <p><?php echo $data['applicationCount'];?></p>
                </div>
                <div class="icon_">
                    <span class="material-symbols-outlined large-icon">school</span>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts">
            <div class="card chart-card">
                <canvas id="registrationsChart"></canvas>
            </div>
            
            <div class="card chart-card">
                <canvas id="loginsChart"></canvas>
            </div>
            
            <div class="card chart-card">
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="card chart-card">
                <div class="top-jobs-card">
                    <h2>Top Performing Jobs</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Applications</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Software Engineer</td>
                                <td>280</td>
                            </tr>
                            <tr>
                                <td>Marketing Manager</td>
                                <td>252</td>
                            </tr>
                            <tr>
                                <td>Sales Representative</td>
                                <td>232</td>
                            </tr>
                            <tr>
                                <td>Product Designer</td>
                                <td>150</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    var chartData = {
        registrations: <?php echo json_encode($data['registrationsData']); ?>,
        revenue: <?php echo json_encode($data['revenueData']); ?>,
        monthNames: <?php echo json_encode($data['month_names']); ?>
    };

</script>

<script src="<?php echo URLROOT; ?>/js/service_provider/ser_analytics.js"></script>
<?php require APPROOT . '/views/components/footer.php'; ?>