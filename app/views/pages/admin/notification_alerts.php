<?php require APPROOT . '/views/components/adm_header.php'; ?>
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
                $readClass = $message['read'] ? "read" : "unread";
                echo "
                <div class='notification-item $readClass' onclick='selectNotification(\"{$message->topic}\")'>
                    <div class='badge message'>message</div> 
                    <div class='content'>
                        <h4>{$message->topic}</h4>
                        <p>{$message->message}</p>
                        <span class='author'>{$message->name}</span>
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

    function selectNotification(title) {
        const details = document.getElementById('notificationDetails');
        details.innerHTML = `<h3>${title}</h3><p>Details about "${title}" will be displayed here.</p>`;
    }
</script>