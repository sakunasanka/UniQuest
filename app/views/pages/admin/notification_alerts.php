<?php require APPROOT . '/views/components/header.php'; ?>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/pages/student/notification.css">

<div class="main-container">
    
    <!-- Sidebar -->
    <?php require APPROOT . '/views/components/adminSidePanel.php'; ?>

    <!-- Main Content -->
    <div class="content-area">
        <div class="notification-header">
            <h2>Notifications</h2>
            <input type="text" class="search-bar" placeholder="Search Notifications" oninput="filterNotifications(this.value)">
            <button class="mark-all-read-btn" onclick="markAllRead()">Mark All as Read</button>
            
        </div>

        <div class="notifications" id="notificationsList">
            <?php 
            // Example notifications with read status
            $notifications = [
              [
                  "type" => "joined",
                  "title" => "New Registration: Finibus Bonorum",
                  "content" => "A new user has registered successfully.",
                  "author" => "Allen Deu",
                  "time" => "24 Nov 2018",
                  "read" => false
              ],
              [
                  "type" => "message",
                  "title" => "Darren Smith sent a new message",
                  "content" => "You have received a new message from Darren Smith.",
                  "author" => "Darren",
                  "time" => "24 Nov 2018",
                  "read" => true
              ],
              [
                  "type" => "comment",
                  "title" => "New Comment on Your Post",
                  "content" => "Someone has left a comment on your post.",
                  "author" => "Maria Gomez",
                  "time" => "25 Nov 2018",
                  "read" => false
              ],
              [
                  "type" => "connect",
                  "title" => "John Doe sent you a connection request",
                  "content" => "You have received a new connection request from John Doe.",
                  "author" => "John Doe",
                  "time" => "25 Nov 2018",
                  "read" => true
              ]
          ];
          
            foreach ($data['messages'] as $message) {
                $readClass = $message->read_status ? "read" : "unread";
                echo "
                <div class='notification-item $readClass' data-id='{$message->id}' 
                    onclick='selectNotification(
                        \"{$message->id}\",
                        \"{$message->topic}\",
                        \"{$message->message}\",
                        \"{$message->sender_email}\",
                        \"{$message->created_at}\"
                    )'>
                    <div class='badge message'>message</div> 
                    <div class='content'>
                        <h4>{$message->topic}</h4>
                        <p>{$message->message}</p>
                    </div>
                    <div class='time'>{$message->created_at}</div>
                </div>";
            }
            ?>
        </div>
    </div>

    <!-- Notification Details Sidebar -->
    <div class="notification-details" id="notificationDetails">
        <h3>Notification Details</h3>
        <p>Select a notification to view its details here.</p>
    </div>
</div>

<script>
    function markAllRead() {
        const items = document.querySelectorAll('.notification-item.unread');
        items.forEach(item => item.classList.remove('unread'));
        alert("All notifications marked as read!");
    }

    function filterNotifications(query) {
        const items = document.querySelectorAll('.notification-item');
        items.forEach(item => {
            const title = item.querySelector('h4').textContent.toLowerCase();
            if (title.includes(query.toLowerCase())) {
                item.style.display = "flex";
            } else {
                item.style.display = "none";
            }
        });
    }

    function selectNotification(id, topic, content, author,email, time) {
        // Update the sidebar with notification details
        const details = document.getElementById('notificationDetails');
        details.innerHTML = `
            <h3>${topic}</h3>
            <p>${content}</p>
            <br>
            <span>From: ${author}  <br> ${email}</span>
            <br>
            <br>
            <span>Received: ${time}</span>
        `;

    function markAsRead(notificationId) {
        // Select the notification element
        const notificationItem = document.querySelector(`.notification-item[data-id="${notificationId}"]`);

        if (notificationItem && notificationItem.classList.contains('unread')) {
            // Remove 'unread' class to indicate it's been read
            notificationItem.classList.remove('unread');

            // Send an AJAX request to mark it as read in the database
            fetch('<?php echo URLROOT; ?>/admin/updateReadStatus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: notificationId })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert("Failed to mark as read in the database.");
                    // Add the 'unread' class back in case of failure
                    notificationItem.classList.add('unread');
                }
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
                alert("An error occurred while marking as read.");
                // Revert the visual change if the request fails
                notificationItem.classList.add('unread');
            });
        }
    }

}

</script>