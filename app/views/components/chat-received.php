<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/chat.css">

<div id="backgroundOverlay" class="background-overlay hidden"></div>
<div id="chatPopup" class="popup hidden">
    <div class="popup-header">
        <span>Chat</span>
        <button id="closePopupBtn" class="close-btn"><i class="fa fa-times"></i></button>
    </div>
    <div class="popup-content">
        <div class="messages">
            <div class="message sent">I need assistance with my account.</div>
            <div class="message received">Hello! How can I help you?</div>
        </div>
        <form id="messageForm" class="message-form" method="post" action="process_chat.php">
            <input type="text" name="message" id="messageInput" placeholder="Message" required />
            <button type="submit" class="send-btn">Send</button>
        </form>
    </div>
</div>

<button id="openPopupBtn" class="open-btn">Contact</button>


<script type="module" src="<?php echo URLROOT; ?>/public/js/components/chat.js"></script>