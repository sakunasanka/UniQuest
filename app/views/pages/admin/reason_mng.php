<?php require APPROOT . '/views/components/adm_header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/reason_mng.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <?php $columns = [
            "ReasonName" => "Reason Name",
            "Reason" => "Reason",
            "Actions" => "Actions"
        ];
        ?>
        <div class="table-block">
            <!-- User Activate Table -->
            <div class="table-card">
                <div class="content-header">
                    <div class="table-title-container">
                        <h2 class="table-title">User Activate</h2>
                    </div>
                    <div class="header-actions">
                        <button class="add-btn">
                            <span class="material-symbols-outlined">add</span>
                            <span class="add-btn-text">Add</span>
                        </button>
                    </div>
                </div>
                <table>
                    <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                    <tbody>
                        <?php if ($data['user_activate']) : ?>
                            <?php foreach ($data['user_activate'] as $reason) : ?>
                                <tr data-reason-id="<?php echo $reason->ReasonID; ?>">
                                    <td><?php echo $reason->ReasonName; ?></td>
                                    <td><?php echo $reason->Reason; ?></td>
                                    <td class="actions">
                                        <span class="material-symbols-outlined action-btn edit-icon">
                                            edit_note
                                        </span>
                                        <span class="material-symbols-outlined action-btn delete-icon">
                                            delete
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td class="no-data" colspan="3">No data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- User Deactivate Table -->
            <div class="table-card">
                <div class="content-header">
                    <div class="table-title-container">
                        <h2 class="table-title">User Deactivate</h2>
                    </div>
                    <div class="header-actions">
                        <button class="add-btn">
                            <span class="material-symbols-outlined">add</span>
                            <span class="add-btn-text">Add</span>
                        </button>
                    </div>
                </div>
                <table>
                    <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                    <tbody>
                        <?php if ($data['user_deactivate']) : ?>
                            <?php foreach ($data['user_deactivate'] as $reason) : ?>
                                <tr data-reason-id="<?php echo $reason->ReasonID; ?>">
                                    <td><?php echo $reason->ReasonName; ?></td>
                                    <td><?php echo $reason->Reason; ?></td>
                                    <td class="actions">
                                        <span class="material-symbols-outlined action-btn edit-icon">
                                            edit_note
                                        </span>
                                        <span class="material-symbols-outlined action-btn delete-icon">
                                            delete
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td class="no-data" colspan="3">No data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- User Reject Table -->
            <div class="table-card">
                <div class="content-header">
                    <div class="table-title-container">
                        <h2 class="table-title">User Reject</h2>
                    </div>
                    <div class="header-actions">
                        <button class="add-btn">
                            <span class="material-symbols-outlined">add</span>
                            <span class="add-btn-text">Add</span>
                        </button>
                    </div>
                </div>
                <table>
                    <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                    <tbody>
                        <?php if ($data['user_reject']) : ?>
                            <?php foreach ($data['user_reject'] as $reason) : ?>
                                <tr data-reason-id="<?php echo $reason->ReasonID; ?>">
                                    <td><?php echo $reason->ReasonName; ?></td>
                                    <td><?php echo $reason->Reason; ?></td>
                                    <td class="actions">
                                        <span class="material-symbols-outlined action-btn edit-icon">
                                            edit_note
                                        </span>
                                        <span class="material-symbols-outlined action-btn delete-icon">
                                            delete
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td class="no-data" colspan="3">No data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Job Reject Table -->
            <div class="table-card">
                <div class="content-header">
                    <div class="table-title-container">
                        <h2 class="table-title">Job Reject</h2>
                    </div>
                    <div class="header-actions">
                        <button class="add-btn">
                            <span class="material-symbols-outlined">add</span>
                            <span class="add-btn-text">Add</span>
                        </button>
                    </div>
                </div>
                <table>
                    <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                    <tbody>
                        <?php if ($data['job_reject']) : ?>
                            <?php foreach ($data['job_reject'] as $reason) : ?>
                                <tr data-reason-id="<?php echo $reason->ReasonID; ?>">
                                    <td><?php echo $reason->ReasonName; ?></td>
                                    <td><?php echo $reason->Reason; ?></td>
                                    <td class="actions">
                                        <span class="material-symbols-outlined action-btn edit-icon">
                                            edit_note
                                        </span>
                                        <span class="material-symbols-outlined action-btn delete-icon">
                                            delete
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td class="no-data" colspan="3">No data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Popup Overlay -->
        <?php require APPROOT . '/views/popups/admin/addReason.php'; ?>
    </main>
</div>


<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminAddButton.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>