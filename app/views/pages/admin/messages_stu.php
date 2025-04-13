<?php require APPROOT . '/views/components/adm_header.php'; ?>
<?php require APPROOT . '/views/components/chat-sent.php'; ?>

<!-- Sidebar and Content Layout -->
<div class="main-container">
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Content Area -->
    <main class="content-area">
        <?php
        $columns = [
            "Topic" => "Topic",
            "Email" => "Email",
            "Message" => "Message",
            "Date" => "Date",
            "Status" => "Status",
            "Actions" => "Actions"
        ];
        ?>
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
                <?php require APPROOT . '/views/components/adminTableheader.php'; ?>
                <tbody>
                    <?php if ($data['messages_stu']) : ?>
                        <?php foreach ($data['messages_stu'] as $message): ?>
                            <tr>
                                <td><?php echo $message->topic ?></td>
                                <td><?php echo $message->user_email ?></td>
                                <td><?php echo $message->message ?></td>
                                <td><?php echo $message->created_at ?></td>
                                <td><span class="status active"><?php echo $message->read_status ?></span></td>
                                <td class="action">
                                <?php if ($message->sender_role == 'Student') : ?>
                                    <button id="openPopupBtn" class="open-btn-2 material-symbols-outlined action-btn view" 
                                        onclick="window.location.href='<?php echo URLROOT; ?>/admin/messages_stu/<?php echo $message->sender_id; ?>'">
                                        preview
                                    </button>
                                    <?php elseif ($message->receiver_role == 'Student'):?>
                                        <button id="openPopupBtn" class="open-btn-2 material-symbols-outlined action-btn view" 
                                        onclick="window.location.href='<?php echo URLROOT; ?>/admin/messages_stu/<?php echo $message->receiver_id; ?>'">
                                        preview
                                    </button>
                                <?php endif; ?>
                                    
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td class="no-data" colspan="6">No messages available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php 
            // require APPROOT . '/views/components/pagination.php'; 
            ?>
        </div>
    </main>
</div>

<script src="<?php echo URLROOT; ?>/public/js/admin/popups.js"></script>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminAddButton.js"></script>

<?php require APPROOT . '/views/components/footer.php'; ?>