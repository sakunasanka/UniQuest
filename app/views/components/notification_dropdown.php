<?php
// Load notification data if user is logged in
if (isset($_SESSION['user_id'])) {
    $notificationModel = model('NotificationModel');
    $notifications = $notificationModel->getRecentNotifications($_SESSION['user_id'], 5); // Get 5 most recent
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
    const role = "<?= $role ?>";
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
                    <div class="notification-icon">
                        <i class="fas <?= 
                            $notification->type == 'success' ? 'fa-check-circle text-success' : 
                            ($notification->type == 'warning' ? 'fa-exclamation-triangle text-warning' : 
                            ($notification->type == 'danger' ? 'fa-times-circle text-danger' : 'fa-info-circle text-info'))
                        ?>"></i>
                    </div>
                    <div class="notification-content">
                        <?php if ($notification->related_url): ?>
                            <a href="<?= URLROOT . $notification->related_url ?>">
                                <?= htmlspecialchars($notification->message) ?>
                            </a>
                        <?php else: ?>
                            <?= htmlspecialchars($notification->message) ?>
                        <?php endif; ?>
                        <small><?= date('M j, Y g:i A', strtotime($notification->created_at)) ?></small>
                    </div>
                    <?php if (!$notification->is_read): ?>
                        <button class="mark-read" data-id="<?= $notification->id ?>" data-role="<?= $role ?>">
                            <span class="material-symbols-outlined">check_circle</span>
                        </button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-notification">
                <p>No notifications</p>
            </div>
        <?php endif; ?>
    </div>
    <div class="notification-footer">
        <a href="<?= URLROOT . '/' . $role ?>/notifications">View all notifications</a>
    </div>
</div>