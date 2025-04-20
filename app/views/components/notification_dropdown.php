<!-- app/views/notifications/index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Your Notifications</h1>
        
        <?php if (!empty($notifications)): ?>
            <div class="notification-actions">
                <a href="/notifications/mark-all-read" class="btn">Mark All as Read</a>
            </div>
            
            <div class="notifications-list">
                <?php foreach ($notifications as $notification): ?>
                    <div class="notification-item <?= $notification['is_read'] ? 'read' : 'unread' ?>" 
                         data-id="<?= $notification['id'] ?>">
                        <div class="notification-type <?= $notification['type'] ?>">
                            <!-- Icon based on type -->
                            <?php if ($notification['type'] == 'success'): ?>
                                <i class="icon-success"></i>
                            <?php elseif ($notification['type'] == 'warning'): ?>
                                <i class="icon-warning"></i>
                            <?php elseif ($notification['type'] == 'error'): ?>
                                <i class="icon-error"></i>
                            <?php else: ?>
                                <i class="icon-info"></i>
                            <?php endif; ?>
                        </div>
                        
                        <div class="notification-content">
                            <div class="notification-message">
                                <?php if ($notification['link']): ?>
                                    <a href="<?= $notification['link'] ?>" 
                                       onclick="markAsRead(<?= $notification['id'] ?>)">
                                        <?= htmlspecialchars($notification['message']) ?>
                                    </a>
                                <?php else: ?>
                                    <?= htmlspecialchars($notification['message']) ?>
                                <?php endif; ?>
                            </div>
                            <div class="notification-time">
                                <?= date('M j, Y g:i A', strtotime($notification['created_at'])) ?>
                            </div>
                        </div>
                        
                        <div class="notification-actions">
                            <?php if (!$notification['is_read']): ?>
                                <button onclick="markAsRead(<?= $notification['id'] ?>)" class="btn-small">
                                    Mark as Read
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <!-- Add your pagination logic here -->
            
        <?php else: ?>
            <div class="empty-state">
                <p>You have no notifications.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        function markAsRead(id) {
            fetch('/notifications/mark-read/' + id, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`.notification-item[data-id="${id}"]`).classList.add('read');
                    document.querySelector(`.notification-item[data-id="${id}"]`).classList.remove('unread');
                    updateNotificationCount();
                }
            });
            
            return true; // Allow link navigation to continue
        }
        
        function updateNotificationCount() {
            // Update the notification counter in your navigation/header
            fetch('/notifications/unread', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const counter = document.querySelector('.notification-counter');
                if (counter) {
                    counter.textContent = data.count;
                    if (data.count === 0) {
                        counter.style.display = 'none';
                    } else {
                        counter.style.display = 'block';
                    }
                }
            });
        }
    </script>
</body>
</html>