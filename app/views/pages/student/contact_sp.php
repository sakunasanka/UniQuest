<?php require APPROOT . '/views/components/stu_header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/chat.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/contact_form.css">

<div class="main-container">
<?php require APPROOT . '/views/components/studentSidePanel.php'; ?>

    <div class="content-area">
        <div class="container">
        <div class="contact-left">
        <span>Chat with </span>
        <button id="closePopupBtn" class="close-btn"><i class="fa fa-times"></i></button>
        </div>      
    <div class="popup-content">
        <div class="messages">
            <?php
            $previousDate = null;
            foreach ($data['messages'] as $message): 
                $messageDate = date('d M Y', strtotime($message->created_at));
                $messageTime = date('H:i', strtotime($message->created_at)); 
                
                if ($messageDate !== $previousDate): ?>
                    <div class="date-header"> <?php echo $messageDate; ?> </div>
                    <?php $previousDate = $messageDate; 
                endif; ?>
                <div class="message-container">
                    <div class="message <?php echo $message->sender_id == $_SESSION['user_id'] ? 'sent' : 'received'; ?>">
                        <?php echo htmlspecialchars($message->message); ?>
                        <span class="message-time"> <?php echo $messageTime; ?> </span>

                        <?php if ($message->sender_id == $_SESSION['user_id']): ?>
                            <span class="message-actions">
                                <?php 
                                $timeDiff = time() - strtotime($message->created_at); 
                                if ($timeDiff <= 600): ?>
                                    <i class="fa fa-edit edit-message" data-message-id="<?php echo $message->id; ?>" title="Edit"></i>
                                <?php endif; 
                                if ($timeDiff <= 3600): ?>
                                    <i class="fa fa-trash delete-message" data-message-id="<?php echo $message->id; ?>" title="Delete"></i>
                                <?php endif; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <form id="messageForm" class="message-form" method="post" action="<?php echo URLROOT; ?>/admin/user_detail/<?php echo $data['user']['UserID']; ?>">
            <input type="hidden" name="sender_id" id="sender_id" value="<?php echo $_SESSION['user_id']; ?>" />
            <input type="hidden" name="receiver_id" id="receiver_id" value="<?php echo $data['user']['UserID']; ?>" />
            
            <!-- Ensure topic is always set -->
            <input type="hidden" name="topic" id="topic" value="<?php echo htmlspecialchars($data['topic'] ?? 'General Information'); ?>" />

            <input type="text" name="messageInput" id="messageInput" placeholder="Type a message" required value="<?php echo htmlspecialchars($data['message_details'] ?? ''); ?>" />
            <button type="submit" class="send-btn">Send</button>
        </form>
        </div>
        
    </div>
</div>

    </div>
</div>

<script type="module" src="<?php echo URLROOT; ?>/public/js/components/chat.js"></script>


<?php require APPROOT . '/views/components/footer.php'; ?>