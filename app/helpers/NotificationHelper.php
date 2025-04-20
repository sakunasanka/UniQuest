<?php

function sendNotification($userId, $message, $type = 'info', $link = null) {
    $notificationModel = new NotificationModel();
    return $notificationModel->create($userId, $type, substr($message, 0, 100), $message, $link);
}

function notifyStudentApplicationAccepted($applicationId, $studentId, $jobTitle) {
    $notificationModel = new NotificationModel();
    
    $message = "Congratulations! Your application for '{$jobTitle}' has been accepted";
    $link = "/student/applications/view/{$applicationId}";
    
    return $notificationModel->create(
        $studentId,
        'success', // notification type
        'Application Accepted', // title
        $message,
        $link
    );
}