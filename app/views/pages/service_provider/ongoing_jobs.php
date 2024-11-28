<?php require APPROOT . '/views/components/ser_header.php'; ?>

<?php require APPROOT . '/views/popups/student/deactivatepostjob_popup.php'; ?>
<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/serviceSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/uniquest/service_provider/ongoing_jobs">Active Jobs</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/uniquest/service_provider/offered_jobs">Offered Jobs</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
                <button class="add-btn">
                    <span class="material-symbols-outlined">post_add</span>
                    <span class="add-btn-text">Post Job</span>
                </button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Title</th>
                        <th onclick="sortTable(1)">Location</th>
                        <th onclick="sortTable(2)">Date Posted</th>
                        <th onclick="sortTable(3)">Views</th>
                        <th onclick="sortTable(4)">Applicants</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['posts'] as $post): ?>
                        <tr>
                            <td><?php echo $post->Title; ?></td>
                            <td><?php echo $post->Location; ?></td>
                            <td><?php echo date('Y-m-d', strtotime($post->jobs_create_at)); ?></td>
                            <td>35</td>
                            <td>18</td>
                            <td class="action">
                                <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/service_provider/view_job/<?php echo $post->JobID; ?>'" >
                                    preview
                                </span>
                                <span class="material-symbols-outlined action-btn edit"  onclick="window.location.href='<?php echo URLROOT; ?>/service_provider/edit_job/<?php echo $post->JobID; ?>'">
                                    edit_square
                                </span>
                                <span  class="material-symbols-outlined action-btn deactivate"  onclick=showdeletereviewconfirm(<?=$post->JobID?>)>
                                    block
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>