<?php require APPROOT . '/views/components/header.php'; ?>

<?php require APPROOT . '/views/popups/student/deletepostjob_popup.php'; ?>
<?php require APPROOT . '/views/popups/service_provider/activepostjob_popup.php'; ?>
<div class="main-container">

    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <main class="content-area">
        <?php
        $columns = [
            "Title" => "Title",
            "Location" => "Location",
            "Category" => "Category",
            "jobs_create_at" => "Date Published",
            "Views" => "Views",
            "Applicants" => "Applicants",
            "Actions" => "Actions"
        ];
        ?>
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/service_provider/pending_jobs">Pending Jobs</button>
            <button class="tab" style="border-radius: 0px 0px 0px 0px;" data-path="/UniQuest/service_provider/active_jobs">Active Jobs</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/service_provider/deactive_jobs">Deactive Jobs</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
                <button class="post-btn" onclick="goToPostJob()">
                    <span class="material-symbols-outlined">post_add</span>
                    <span class="add-btn-text">Post Job</span>
                </button>
            </div>
            <table>
                <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                <tbody>
                    <?php if ($data['posts']) : ?>
                        <?php foreach ($data['posts'] as $post): ?>
                            <tr>
                                <td><?php echo $post->Title; ?></td>
                                <td><?php echo $post->City; ?></td>
                                <td><?php echo $post->Category; ?></td>
                                <td><?php echo date('Y-m-d', strtotime($post->PublishDate)); ?></td>
                                <td><?php echo $post->ViewCount; ?></td>
                                <td><?php echo $post->ApplicationCount; ?></td>
                                <td class="action">
                                    <div class="tooltip">
                                    <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/jobs/jobsdescription/<?php echo $post->JobID; ?>'">
                                        preview
                                    </span>
                                        <span class="tooltiptext view">View</span>
                                    </div>
                                    <div class="tooltip">
                                    <?php if ($post->Status == 'Deactive'):?>
                                        <span class="material-symbols-outlined action-btn activate1" onclick="showActivatePostConfirm(<?= $post->JobID ?>)">
                                    <?php elseif($post->Status == 'Admin-Deactive'):?>   
                                        <span class="material-symbols-outlined action-btn activate1" onclick="showAdminDeactive()">
                                    <?php endif;?>         
                                        check_circle
                                    </span>
                                        <span class="tooltiptext activate">Activate</span>
                                    </div> 
                                    <div class="tooltip">                                        
                                    <span class="material-symbols-outlined action-btn deactivate" onclick="showdeletereviewconfirm(<?= $post->JobID ?>)">
                                        delete
                                    </span>
                                        <span class="tooltiptext deactivate">Delete</span>
                                    </div>        
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td class="no-data" colspan="6">No data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>

<script>
    function goToPostJob() {
        window.location.href = "<?php echo URLROOT; ?>/service_provider/jobpost";
    }

    function showAdminDeactive() {
        Flash.show("This job is deactivated by admin. Please contact admin for more information.", "error");
    }
</script>