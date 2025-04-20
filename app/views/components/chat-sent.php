<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/chat.css">

<div id="backgroundOverlay" class="background-overlay hidden"></div>
<div id="chatPopup" class="chatPopup hidden">
    <div class="popup-header">
        <span>Chat with 
            <?php 
            if ($_SESSION['user_role'] == 'Admin' || $_SESSION['user_role'] == 'VT-Member' || $_SESSION['user_role'] == 'Student') {
                if ($data['user']['Role'] == 'Company') {
                    echo $data['user']['CompanyName'];
                } else {
                    echo $data['user']['FirstName'];
                }
            }
            else {
                echo $data['user']['FirstName'];
            }
            ?>
        </span>
        <button id="closePopupBtn" class="chat-close-btn"><i class="fa fa-times"></i></button>
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
        </div>
        <form id="messageForm" class="message-form" method="post" action="
            <?php
            if ($_SESSION['user_role'] == 'Admin') {
                echo URLROOT . '/admin/sendMessage/' . $data['user']['UserID'];
            }elseif ($_SESSION['user_role'] == 'Company') {
                    echo URLROOT . '/service_provider/sendMessage/' . $data['user']['UserID'];
            } elseif ($_SESSION['user_role'] == 'Student') {
                echo URLROOT . '/jobs/sendMessage/' . $data['post']->JobID;
            }
            ?>
        ">
            <input type="hidden" name="sender_id" id="sender_id" value="<?php echo $_SESSION['user_id']; ?>" />
            <input type="hidden" name="receiver_id" id="receiver_id" value="<?php echo $data['user']['UserID']; ?>" />
            
            <!-- Ensure topic and email is always set -->
            <input type="hidden" name="topic" id="topic" value="<?php echo htmlspecialchars($data['topic'] ?? 'General Information'); ?>" />
            <input type="hidden" name="email" id="email" value="<?php echo htmlspecialchars($data['email'] ?? null); ?>" />

            <input type="text" name="messageInput" id="messageInput" placeholder="Type a message" required value="<?php echo htmlspecialchars($data['message_details'] ?? ''); ?>" />
            <button type="submit" class="send-btn">Send</button>
        </form>
    </div>
</div>

<!-- Trigger Button -->


<script type="module" src="<?php echo URLROOT; ?>/public/js/components/chat.js"></script>