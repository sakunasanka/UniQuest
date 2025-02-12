<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/chat.css">

<div id="backgroundOverlay" class="background-overlay hidden"></div>
<div id="chatPopup" class="popup hidden">
    <div class="popup-header">
        <span>Chat</span>
        <button id="closePopupBtn" class="close-btn"><i class="fa fa-times"></i></button>
    </div>
    <div class="popup-content">
        <div class="messages">
            <!-- Example messages -->
            <div class="message received">I need assistance with my account.</div>
            <div class="message sent">Hello! How can I help you?</div>
            <?php foreach ($data['message'] as $message): ?>
                <div class="message <?php echo $message->sender_role === 'Admin' ? 'sent' : 'received'; ?>">
                    <?php echo htmlspecialchars($message->message); ?>
                </div>
            <?php endforeach; ?>
        </div>
        <form id="messageForm" class="message-form" method="post" action="process_chat.php">
        <input type="hidden" name="receiver_id" value="" />
        <input type="text" name="message" id="messageInput" placeholder="Type a message" required />
            <button type="submit" class="send-btn">Send</button>
        </form>
    </div>
</div>

<!-- Trigger Button -->
<button id="openPopupBtn" class="open-btn">Contact</button>


<script type="module" src="<?php echo URLROOT; ?>/public/js/components/chat.js"></script>