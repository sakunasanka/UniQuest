<?php require APPROOT . '/views/components/header.php'; ?>

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
            <div class="content-title-container">
                <h1 class="content-title">Reason Management</h1>
            </div>
            <!-- User Activate Table -->
            <div class="table-card">
                <div class="content-header">
                    <div class="table-title-container">
                        <h2 class="table-title">User Activate</h2>
                    </div>
                    <div class="header-actions">
                        <button class="add-btn reason-add-btn">
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
                                    <td class="reason-name"><?php echo $reason->ReasonName; ?></td>
                                    <td class="reason-text"><?php echo $reason->Reason; ?></td>
                                    <td class="actions">
                                        <span class="material-symbols-outlined action-btn edit-icon reason-edit-btn"
                                            role="button"
                                            tabindex="0"
                                            data-id="<?php echo htmlspecialchars($reason->ReasonID); ?>">
                                            edit_note
                                        </span>
                                        <span class="material-symbols-outlined action-btn delete-icon reason-delete-btn"
                                            role="button"
                                            tabindex="0"
                                            data-id="<?php echo htmlspecialchars($reason->ReasonID); ?>">
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
                        <button class="add-btn reason-add-btn">
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
                                    <td class="reason-name"><?php echo $reason->ReasonName; ?></td>
                                    <td class="reason-text"><?php echo $reason->Reason; ?></td>
                                    <td class="actions">
                                        <span class="material-symbols-outlined action-btn edit-icon reason-edit-btn"
                                            role="button"
                                            tabindex="0"
                                            data-id="<?php echo htmlspecialchars($reason->ReasonID); ?>">
                                            edit_note
                                        </span>
                                        <span class="material-symbols-outlined action-btn delete-icon reason-delete-btn"
                                            role="button"
                                            tabindex="0"
                                            data-id="<?php echo htmlspecialchars($reason->ReasonID); ?>">
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
                        <button class="add-btn reason-add-btn">
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
                                    <td class="reason-name"><?php echo $reason->ReasonName; ?></td>
                                    <td class="reason-text"><?php echo $reason->Reason; ?></td>
                                    <td class="actions">
                                        <span class="material-symbols-outlined action-btn edit-icon reason-edit-btn"
                                            role="button"
                                            tabindex="0"
                                            data-id="<?php echo htmlspecialchars($reason->ReasonID); ?>">
                                            edit_note
                                        </span>
                                        <span class="material-symbols-outlined action-btn delete-icon reason-delete-btn"
                                            role="button"
                                            tabindex="0"
                                            data-id="<?php echo htmlspecialchars($reason->ReasonID); ?>">
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
                        <button class="add-btn reason-add-btn">
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
                                    <td class="reason-name"><?php echo $reason->ReasonName; ?></td>
                                    <td class="reason-text"><?php echo $reason->Reason; ?></td>
                                    <td class="actions">
                                        <span class="material-symbols-outlined action-btn edit-icon reason-edit-btn"
                                            role="button"
                                            tabindex="0"
                                            data-id="<?php echo htmlspecialchars($reason->ReasonID); ?>">
                                            edit_note
                                        </span>
                                        <span class="material-symbols-outlined action-btn delete-icon reason-delete-btn"
                                            role="button"
                                            tabindex="0"
                                            data-id="<?php echo htmlspecialchars($reason->ReasonID); ?>">
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

            <!-- Job Activate Table -->
            <div class="table-card">
                <div class="content-header">
                    <div class="table-title-container">
                        <h2 class="table-title">Job Activate</h2>
                    </div>
                    <div class="header-actions">
                        <button class="add-btn reason-add-btn">
                            <span class="material-symbols-outlined">add</span>
                            <span class="add-btn-text">Add</span>
                        </button>
                    </div>
                </div>
                <table>
                    <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                    <tbody>
                        <?php if ($data['job_activate']) : ?>
                            <?php foreach ($data['job_activate'] as $reason) : ?>
                                <tr data-reason-id="<?php echo $reason->ReasonID; ?>">
                                    <td class="reason-name"><?php echo $reason->ReasonName; ?></td>
                                    <td class="reason-text"><?php echo $reason->Reason; ?></td>
                                    <td class="actions">
                                        <span class="material-symbols-outlined action-btn edit-icon reason-edit-btn"
                                            role="button"
                                            tabindex="0"
                                            data-id="<?php echo htmlspecialchars($reason->ReasonID); ?>">
                                            edit_note
                                        </span>
                                        <span class="material-symbols-outlined action-btn delete-icon reason-delete-btn"
                                            role="button"
                                            tabindex="0"
                                            data-id="<?php echo htmlspecialchars($reason->ReasonID); ?>">
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

            <!-- Job Deactivate Table -->
            <div class="table-card">
                <div class="content-header">
                    <div class="table-title-container">
                        <h2 class="table-title">Job Deactivate</h2>
                    </div>
                    <div class="header-actions">
                        <button class="add-btn reason-add-btn">
                            <span class="material-symbols-outlined">add</span>
                            <span class="add-btn-text">Add</span>
                        </button>
                    </div>
                </div>
                <table>
                    <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                    <tbody>
                        <?php if ($data['job_deactivate']) : ?>
                            <?php foreach ($data['job_deactivate'] as $reason) : ?>
                                <tr data-reason-id="<?php echo $reason->ReasonID; ?>">
                                    <td class="reason-name"><?php echo $reason->ReasonName; ?></td>
                                    <td class="reason-text"><?php echo $reason->Reason; ?></td>
                                    <td class="actions">
                                        <span class="material-symbols-outlined action-btn edit-icon reason-edit-btn"
                                            role="button"
                                            tabindex="0"
                                            data-id="<?php echo htmlspecialchars($reason->ReasonID); ?>">
                                            edit_note
                                        </span>
                                        <span class="material-symbols-outlined action-btn delete-icon reason-delete-btn"
                                            role="button"
                                            tabindex="0"
                                            data-id="<?php echo htmlspecialchars($reason->ReasonID); ?>">
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


            <div class="content-title-container">
                <h1 class="content-title"></h1>
            </div>

            <!-- Industries Table -->
            <div class="table-card">
                <div class="content-header">
                    <div class="table-title-container">
                        <h2 class="table-title">Industries</h2>
                    </div>
                    <div class="header-actions">
                        <button class="add-btn industry-add-btn">
                            <span class="material-symbols-outlined">add</span>
                            <span class="add-btn-text">Add</span>
                        </button>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th class="table-header">Number</th>
                            <th class="table-header">Industry Name</th>
                            <th class="table-header">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data['industries'])) : ?>
                            <?php $index = 1; ?>
                            <?php foreach ($data['industries'] as $industry) : ?>
                                <tr data-industry-id="<?php echo $industry->IndustryID; ?>">
                                    <td class="industry-index"><?php echo $index++; ?></td>
                                    <td class="industry-name"><?php echo htmlspecialchars($industry->IndustryName); ?></td>
                                    <td class="actions">
                                        <span class="material-symbols-outlined action-btn edit-icon industry-edit-btn"
                                            role="button"
                                            tabindex="0"
                                            data-id="<?php echo htmlspecialchars($industry->IndustryID); ?>">
                                            edit_note
                                        </span>
                                        <span class="material-symbols-outlined action-btn delete-icon industry-delete-btn"
                                            role="button"
                                            tabindex="0"
                                            data-id="<?php echo htmlspecialchars($industry->IndustryID); ?>">
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
        <?php require APPROOT . '/views/popups/admin/editReason.php'; ?>
        <?php require APPROOT . '/views/popups/admin/deleteReason.php'; ?>
        <?php require APPROOT . '/views/popups/admin/addIndustry.php'; ?>
        <?php require APPROOT . '/views/popups/admin/editIndustry.php'; ?>
        <?php require APPROOT . '/views/popups/admin/deleteIndustry.php'; ?>
    </main>
</div>


<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminAddButton.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>