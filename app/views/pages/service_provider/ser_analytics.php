<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/service_provider/ser_analytics.css">

<header class="header">
    <div class="logo-block"></div>
    <div class="nav-block"></div>
</header>

<div class="main-container">

    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?> 
    
    <main class="content-area">
        <div class="stats">
            <div class="card stat-card">
                <div>
                    <h3>Total Jobs</h3>
                    <p><?php echo $data['job_count']; ?></p>

                </div>
                <div class="icon_">
                    <span class="material-symbols-outlined large-icon">business_center</span>
                </div>
            </div>
            <div class="card stat-card">
                <div>
                    <h3>Active Jobs</h3>
                    <p><?php echo $data['activeJobCount']; ?></p>
                </div>
                <div class="icon_">
                    <span class="material-symbols-outlined large-icon">work_history</span>
                </div>
            </div>
            <div class="card stat-card">
                <div>
                    <h3>Applicants</h3>
                    <p><?php echo $data['applicationCount'];?></p>
                </div>
                <div class="icon_">
                    <span class="material-symbols-outlined large-icon">groups</span>
                </div>
            </div>
        </div>

        <div class="charts">
            <div class="card chart-card">
                <canvas id="registrationsChart"></canvas>
            </div>
            
            <div class="card chart-card">
                <canvas id="loginsChart"></canvas>
            </div>
            
            <div class="card chart-card">
                <canvas id="applicationChart"></canvas>
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
                            <?php foreach ($data['topPerforming'] as $post): ?>
                                <tr>
                                    <td><?php echo $post->job_title; ?></td>
                                    <td><?php echo $post->application_count; ?></td>
                                </tr>
                            <?php endforeach; ?>
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
        monthNames: <?php echo json_encode($data['month_names']); ?>,
        jobCount: <?php echo json_encode($data['Jobspermonth']); ?>,
        internshipCount: <?php echo json_encode($data['Internshipspermonth']); ?>,
        genderCountMale: <?php echo json_encode($data['applicationsByGender']['Male']); ?>,
        genderCountFemale: <?php echo json_encode($data['applicationsByGender']['Female']); ?>,
        applicationsByWeek: <?php echo json_encode($data['applicationsByWeek']['application_counts']); ?>
    };
</script>

<script src="<?php echo URLROOT; ?>/js/service_provider/ser_analytics.js"></script>
<?php require APPROOT . '/views/components/footer.php'; ?>