<?php require APPROOT . '/views/components/adm_header.php'; ?>
<?php require APPROOT . '/views/components/chat-sent.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">

        <div class="tabs-header">
            <button class="tab" style="border-radius: 10px 0px 0px 10px;" data-path="/UniQuest/admin/messages_stu">Students</button>
            <button class="tab" style="border-radius: 0px 0px 0px 0px;" data-path="/UniQuest/admin/messages_com">Companies</button>
            <button class="tab" style="border-radius: 0px 10px 10px 0px;" data-path="/UniQuest/admin/messages_ver">Verification Team</button>
        </div>
    
        <div class="table-block">
            <div class="content-header">
                <?php require APPROOT . '/views/components/tableSearchBar.php'; ?>
            </div>
            <table>
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Topic</th>
                        <th onclick="sortTable(1)">Email</th>
                        <th onclick="sortTable(2)">Message</th>
                        <th onclick="sortTable(3)">Date</th>
                        <th onclick="sortTable(4)">Status</th>
                        <th class="no-sort">View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['messages'] as $message):?>
                    <tr>
                        <td><?php echo $message->topic?></td>
                        <td><?php echo $message->receiver_email?></td>
                        <td><?php echo $message->message?></td>
                        <td><?php echo $message->created_at?></td>
                        <td><span class="status active"><?php echo $message->read_status?></span></td>
                        <td class="action">
                        <button id="openPopupBtn" class="open-btn-2 material-symbols-outlined action-btn view">
                                preview
                        </button>   
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php require APPROOT . '/views/components/pagination.php'; ?>
        </div>
    </main>
</div>

<script src="<?php echo URLROOT; ?>/public/js/admin/popups.js"></script>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminAddButton.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>