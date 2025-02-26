<?php require APPROOT . '/views/components/adm_header.php'; ?>
<?php require APPROOT . '/views/popups/admin/activateDeactivateAcc.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/admin/students_mng">Students</button>
            <button class="tab" data-path="/UniQuest/admin/company_mng">Companies</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/admin/verTeam_mng">Verification Team</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
                <!-- <button class="add-btn" data-path="/uniquest/admin/add_company">
                    <span class="material-symbols-outlined">person_add</span>
                    <span class="add-btn-text">Add Company</span>
                </button> -->
            </div>
            <table>
                <thead>
                    <?php
                    $columns = [
                        "UserID" => "UserID",
                        "Email" => "Email",
                        "ContactNo" => "Mobile Number",
                        "RegisterDate" => "Registered Date",
                        "Status" => "Status",
                        "Actions" => "Actions"
                    ];
                    $sorter = Sorter::getInstance($columns);
                    echo $sorter->renderHeaders();
                    ?>
                </thead>
                <tbody>
                    <?php foreach ($data['companies'] as $company) : ?>
                        <tr>
                            <td><?php echo $company->UserID; ?></td>
                            <td><?php echo $company->Email; ?></td>
                            <td><?php echo $company->ContactNo; ?></td>
                            <td><?php echo substr($company->RegisterDate, 0, 10); ?></td>
                            <?php if ($company->Status == 'Active') : ?>
                                <td><span class="status active">Active</span></td>
                                <td class="action">
                                    <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_detail/<?php echo $company->UserID; ?>'">
                                        account_box
                                    </span>
                                    <span class="material-symbols-outlined action-btn deactivate" onclick='deactivateUser(<?php echo $company->UserID; ?>, "Company", <?php echo htmlspecialchars(json_encode($data["deactReasons"]), ENT_QUOTES, "UTF-8"); ?>, "<?php echo addslashes($company->Email); ?>")'>  
                                        person_remove
                                    </span>
                                </td>
                                <?php elseif (in_array($company->Status, ['Deactive', 'Pending Deletion', 'Deleted'])) : ?>
                                    <td><span class="status inactive"><?php echo $company->Status; ?></span></td>
                                <td class="action">
                                    <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_detail/<?php echo $company->UserID; ?>'">
                                        account_box
                                    </span>
                                    <span class="material-symbols-outlined action-btn activate" onclick='activateUser(<?php echo $company->UserID; ?>, "Company", <?php echo htmlspecialchars(json_encode($data["actReasons"]), ENT_QUOTES, "UTF-8"); ?>, "<?php echo addslashes($company->Email); ?>")'>
                                        person_add
                                    </span>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>


<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminAddButton.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>