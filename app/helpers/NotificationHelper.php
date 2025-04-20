<?php

function sendNotification($userId, $message, $type = 'info', $link = null) {
    $notificationModel = new NotificationModel();
    return $notificationModel->create($userId, $type, substr($message, 0, 100), $message, $link);
}