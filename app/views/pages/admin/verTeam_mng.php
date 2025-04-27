<?php require APPROOT . '/views/components/header.php'; ?>
<?php require APPROOT . '/views/popups/admin/activateDeactivateAcc.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <?php $columns = [
            "FullName" => "Full Name",
            "Email" => "Email",
            "ContactNo" => "Mobile Number",
            "RegisterDate" => "Registered Date",
            "Status" => "Status",
            "Actions" => "Actions"
        ];
        ?>
        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/admin/students_mng">Students</button>
            <button class="tab" data-path="/UniQuest/admin/company_mng">Companies</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/admin/verTeam_mng">Verification Team</button>
        </div>
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
                <button class="post-btn" id="add-btn" data-path="/UniQuest/admin/add_member">
                    <span class="material-symbols-outlined">person_add</span>
                    <span class="add-btn-text">Add Member</span>
                </button>
            </div>
            <table>
                <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                <tbody>

                    <?php if ($data['vtMembers']) : ?>
                        <?php foreach ($data['vtMembers'] as $user) : ?>
                            <tr>
                            <td><?php echo $user->FullName; ?></td>
                            <td><?php echo $user->Email; ?></td>
                            <td><?php echo $user->ContactNo; ?></td>
                            <td><?php echo substr($user->RegisterDate, 0, 10); ?></td>
                            <?php if ($user->Status == 'Active') : ?>
                                <td><span class="status active">Active</span></td>
                                <td class="action">
                                    <div class="tooltip">
                                        <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_detail/<?php echo $user->UserID; ?>'">
                                            account_box
                                        </span>
                                            <span class="tooltiptext view">View</span>
                                    </div>
                                    
                                    <div class="tooltip"> 
                                        <span class="material-symbols-outlined action-btn deactivate" onclick='deactivateUser(<?php echo $user->UserID; ?>, "VT-Member", <?php echo htmlspecialchars(json_encode($data["deactReasons"]), ENT_QUOTES, "UTF-8"); ?>, "<?php echo addslashes($user->Email); ?>")'>
                                            person_remove
                                        </span>
                                            <span class="tooltiptext deactivate">Deactivate</span>
                                    </div>
                                    
                                </td>
                            <?php elseif ($user->Status == 'Deactive') : ?>
                                <td><span class="status inactive">Deactive</span></td>
                                <td class="action">
                                        <div class="tooltip">
                                            <span class="material-symbols-outlined action-btn view" onclick="window.location.href='<?php echo URLROOT; ?>/admin/user_detail/<?php echo $user->UserID; ?>'">
                                                account_box
                                            </span>
                                            <span class="tooltiptext view">View</span>
                                        </div>

                                        <div class="tooltip"> 
                                            <span class="material-symbols-outlined action-btn activate" onclick='activateUser(<?php echo $user->UserID; ?>, "VT-Member", <?php echo htmlspecialchars(json_encode($data["actReasons"]), ENT_QUOTES, "UTF-8"); ?>, "<?php echo addslashes($user->Email); ?>")'>
                                                person_add
                                            </span>
                                            <span class="tooltiptext activate">Activate</span>
                                        </div> 
                                       
                                </td>
                            <?php endif; ?>
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
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminAddButton.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>