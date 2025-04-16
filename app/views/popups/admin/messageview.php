<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/popups/admin/adminPopups.css">

<div class="popup-container">
    <div class="popup" id="popup-2">
        <div class="overlay"></div>
        <div class="content">
            <button class="close-btn" onclick="togglePopup2()"><i class="fa fa-times"></i></button>
            <h2>Message Details</h2>
            <div id="message-details">
                <p><strong>Topic:</strong> <span id="msg-topic"></span></p>
                <p><strong>Email:</strong> <span id="msg-email"></span></p>
                <p><strong>Name:</strong> <span id="msg-name"></span></p>
                <p><strong>Received At:</strong> <span id="msg-created"></span></p>
                <p><strong>Status:</strong> <span id="msg-status"></span></p>
                <p><strong>Message:</strong> <span id="msg-message"></span></p>
            </div>
        </div>
    </div>
</div>

<table>
    <tbody>
        <?php foreach($data['messages'] as $message): ?>
        <tr onclick="showMessageDetails('<?php echo $message->topic; ?>', '<?php echo $message->email; ?>', '<?php echo $message->name; ?>', '<?php echo $message->created_at; ?>', '<?php echo addslashes($message->message); ?>', '<?php echo $message->read_status; ?>')">
            <td><?php echo $message->topic; ?></td>
            <td><?php echo $message->email; ?></td>
            <td><?php echo $message->name; ?></td>
            <td><?php echo $message->created_at; ?></td>
            <td><span class="status active"><?php echo $message->read_status; ?></span></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script src="<?php echo URLROOT; ?>/public/js/admin/popups.js"></script>