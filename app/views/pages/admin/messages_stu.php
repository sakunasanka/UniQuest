<?php require APPROOT . '/views/components/header.php'; ?>
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
                <?php 
                // require APPROOT . '/views/components/tableSearchBar.php'; ?>
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
                                <td><span class="status <?php echo $message->read_status ?>"><?php echo $message->read_status ?></span></td>
                                <td class="action">
                                <div class="tooltip">
                                    <?php if ($message->sender_role == 'Student') : ?>
                                        <button class="open-btn-2 material-symbols-outlined action-btn view" 
                                            onclick="openChatPopup('<?php echo $message->sender_id; ?>', '<?php echo $message->id; ?>')">
                                            preview
                                        </button>
                                    <?php elseif ($message->receiver_role == 'Student'):?>
                                        <button class="open-btn-2 material-symbols-outlined action-btn view" 
                                            onclick="openChatPopup('<?php echo $message->receiver_id; ?>', '<?php echo $message->id; ?>')">
                                            preview
                                        </button>
                                    <?php endif; ?>      
                                    <span class="tooltiptext view">View</span>
                                </div>   
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

<!-- Create a hidden form to submit the user ID -->
<form id="chatForm" action="<?php echo URLROOT; ?>/admin/messages_stu" method="post" style="display: none;">
    <input type="hidden" name="selectedUserID" id="selectedUserID" value="">
</form>

<script src="<?php echo URLROOT; ?>/public/js/admin/popups.js"></script>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminTopPanel.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminSortTable.js"></script>
<script type="module" src="<?php echo URLROOT; ?>/public/js/components/adminAddButton.js"></script>

<!-- Add simple script for opening the chat popup -->
<script>

function scrollToBottom() {
    const messagesContainer = document.querySelector('.messages');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
}

document.addEventListener("DOMContentLoaded", function() {
    // Only open the popup if a userID exists AND it came from a form submission
    <?php if (isset($data['userID']) && isset($_POST['selectedUserID'])): ?>
        document.getElementById('chatPopup').classList.remove('hidden');
        document.getElementById('backgroundOverlay').classList.remove('hidden');
        scrollToBottom();
    <?php endif; ?>
});

//Refresh the page when the popup is closed
closePopupBtn?.addEventListener("click", function () {
    window.location.href = "/UniQuest/admin/messages_stu";
});

backgroundOverlay?.addEventListener("click", function () {
    window.location.href = "/UniQuest/admin/messages_stu";
});

function openChatPopup(userId, messageId = null) {
console.log("User ID:", userId);
    if (messageId) {
        fetch("<?php echo URLROOT; ?>/admin/markMessageRead", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `message_id=${messageId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Message marked as read");
            }
        })
        .catch(error => {
            console.error("Error updating read status:", error);
        });
    }

    // Set the user ID in the hidden form
    document.getElementById('selectedUserID').value = userId;
    // Submit the form
    document.getElementById('chatForm').submit();
}

</script>
<?php require APPROOT . '/views/components/footer.php'; ?>