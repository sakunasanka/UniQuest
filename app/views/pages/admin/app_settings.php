<?php require APPROOT . '/views/components/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/admin/reason_mng.css">

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <?php
        // Define all table types and their display names
        $tableTypes = [
            'industries' => 'Industries',
            'user_activate' => 'User Activate',
            'user_deactivate' => 'User Deactivate',
            'user_reject' => 'User Reject',
            'job_activate' => 'Job Activate',
            'job_deactivate' => 'Job Deactivate',
            'job_reject' => 'Job Reject'
        ];

        // Get the selected table type from GET parameter or default to first one
        $selectedTable = $_GET['table'] ?? 'industries';
        if (!array_key_exists($selectedTable, $tableTypes)) {
            $selectedTable = 'industries';
        }

        // Define columns for each table type
        $columns = [
            'user_activate' => [
                'ReasonName' => 'Reason Name',
                'Reason' => 'Reason',
                'Actions' => 'Actions'
            ],
            'user_deactivate' => [
                'ReasonName' => 'Reason Name',
                'Reason' => 'Reason',
                'Actions' => 'Actions'
            ],
            'user_reject' => [
                'ReasonName' => 'Reason Name',
                'Reason' => 'Reason',
                'Actions' => 'Actions'
            ],
            'job_activate' => [
                'ReasonName' => 'Reason Name',
                'Reason' => 'Reason',
                'Actions' => 'Actions'
            ],
            'job_deactivate' => [
                'ReasonName' => 'Reason Name',
                'Reason' => 'Reason',
                'Actions' => 'Actions'
            ],
            'job_reject' => [
                'ReasonName' => 'Reason Name',
                'Reason' => 'Reason',
                'Actions' => 'Actions'
            ],
            'industries' => [
                'index' => 'Number',
                'IndustryName' => 'Industry Name',
                'Actions' => 'Actions'
            ]
        ];
        ?>

        <div class="table-block">
            <div class="content-header">
                <h2 class="table-title"><?php echo $tableTypes[$selectedTable]; ?></h2>

                <div class="header-actions-container">
                    <!-- Table Type Selector Form -->
                    <form method="get" class="table-selector-form">
                        <select id="table-type" name="table" onchange="this.form.submit()">
                            <?php foreach ($tableTypes as $key => $name): ?>
                                <option value="<?php echo $key; ?>" <?php echo $selectedTable === $key ? 'selected' : ''; ?>>
                                    <?php echo $name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                    <div class="header-actions">
                        <button class="post-btn <?php echo $selectedTable === 'industries' ? 'industry-add-btn' : 'reason-add-btn'; ?>">
                            <span class="material-symbols-outlined">add</span>
                            <span class="add-btn-text">Add</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Single Table Card -->
            <div class="table-card">
                <!-- Dynamic Table -->
                <table data-item-type="<?php echo $selectedTable; ?>">
                    <thead>
                        <tr>
                            <?php foreach ($columns[$selectedTable] as $header): ?>
                                <th class="table-header"><?php echo $header; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data[$selectedTable])): ?>
                            <?php foreach ($data[$selectedTable] as $index => $item): ?>
                                <tr data-id="<?php echo $selectedTable === 'industries' ? $item->IndustryID : $item->ReasonID; ?>">
                                    <?php foreach ($columns[$selectedTable] as $key => $header): ?>
                                        <td class="<?php
                                                    echo $selectedTable === 'industries' ?
                                                        ($key === 'index' ? 'industry-index' : ($key === 'IndustryName' ? 'industry-name' :
                                                            'actions')) : ($key === 'Actions' ? 'actions' : ($key === 'ReasonName' ? 'reason-name' : ($key === 'Reason' ? 'reason-text' :
                                                            strtolower(str_replace(' ', '-', $key)))));
                                                    ?>">
                                            <?php if ($key === 'index'): ?>
                                                <?php echo $index + 1; ?>
                                            <?php elseif ($key === 'Actions'): ?>
                                                <span class="material-symbols-outlined action-btn edit-icon <?php echo $selectedTable === 'industries' ? 'industry-edit-btn' : 'reason-edit-btn'; ?>"
                                                    role="button"
                                                    tabindex="0"
                                                    data-id="<?php echo $selectedTable === 'industries' ? $item->IndustryID : $item->ReasonID; ?>">
                                                    edit_note
                                                </span>
                                                <span class="material-symbols-outlined action-btn delete-icon <?php echo $selectedTable === 'industries' ? 'industry-delete-btn' : 'reason-delete-btn'; ?>"
                                                    role="button"
                                                    tabindex="0"
                                                    data-id="<?php echo $selectedTable === 'industries' ? $item->IndustryID : $item->ReasonID; ?>">
                                                    delete
                                                </span>
                                            <?php else: ?>
                                                <?php echo htmlspecialchars($item->$key); ?>
                                            <?php endif; ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td class="no-data" colspan="<?php echo count($columns[$selectedTable]); ?>">No data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Popup Overlays -->
        <?php require APPROOT . '/views/popups/admin/addReason.php'; ?>
        <?php require APPROOT . '/views/popups/admin/deleteReason.php'; ?>
        <?php require APPROOT . '/views/popups/admin/addIndustry.php'; ?>
        <?php require APPROOT . '/views/popups/admin/editItem.php'; ?>
        <?php require APPROOT . '/views/popups/admin/deleteIndustry.php'; ?>
    </main>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminAddButton.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>