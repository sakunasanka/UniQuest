<?php
// Load notification data if user is logged in
if (isset($_SESSION['user_id'])) {
    $notificationModel = model('NotificationModel');
    $notifications = $notificationModel->getRecentNotifications($_SESSION['user_id'], 5);
    $unreadCount = $notificationModel->getUnreadCount($_SESSION['user_id']);
}
?>
<?php 
    if ($_SESSION['user_role'] == 'Student')
        $role = 'student';
    elseif ($_SESSION['user_role'] == 'Company')
        $role = 'service_provider';
    elseif ($_SESSION['user_role'] == 'Admin')
        $role = 'admin';
    elseif ($_SESSION['user_role'] == 'VT-Member')
        $role = 'verification_team';
    else
        $role = 'Guest';
?>
<script>
    const userRole = "<?= $role ?>";
    function handleNotificationClick(event, notificationId, role) {
        event.preventDefault();
        fetch(`/UniQuest/${role}/markAsRead/${notificationId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).finally(() => {
            window.location.href = event.currentTarget.href;
        });
    }
</script>

<button class="notification-btn" id="notificationDropdown">
    <span class="material-symbols-outlined">notifications</span>
    <?php if (isset($unreadCount) && $unreadCount > 0): ?>
        <span class="notification-badge"><?= $unreadCount ?></span>
    <?php endif; ?>
</button>
<div class="notification-dropdown" id="notificationDropdownContent">
    <div class="notification-header">
        <h4>Notifications</h4>
        <a href="<?= URLROOT . '/' . $role . '/markAllRead' ?>" class="mark-all-read">Mark all as read</a>
    </div>
    <div class="notification-items">
        <?php if (!empty($notifications)): ?>
            <?php foreach ($notifications as $notification): ?>
                <div class="notification-item <?= $notification->is_read ? 'read' : 'unread' ?> <?= $notification->type ?>"
                    data-id="<?= $notification->id ?>">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-notification">
                <p>No notifications</p>
            </div>
        <?php endif; ?>
    </div>
    <div class="notification-footer">
        <a href="#" id="viewAllNotificationsBtn">View all notifications</a>
    </div>
</div>