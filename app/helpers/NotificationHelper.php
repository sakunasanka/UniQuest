<?php

function model($model)
{
    require_once APPROOT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'ModelFactory.php';
    
    try {
        // Use ModelFactory to create an instance of the model
        return ModelFactory::createModel($model);
    } catch (Exception $e) {
        // Handle exceptions
        error_log("Error loading model: " . $e->getMessage());
        throw new Exception("Error loading model: " . $e->getMessage());
    }
}


 // Send a notification to a user
function sendNotification($userId, $message, $title, $type = 'info', $link = null) {
    try {
        $notificationModel = model('NotificationModel');
        return $notificationModel->create($userId, $type, $title, $message, $link);
    } catch (Exception $e) {
        error_log("Failed to send notification: " . $e->getMessage());
        return false;
    }
}

 // Notify a student that their application has been accepted
 function notifyStudentApplicationAccepted($applicationId, $studentId, $jobTitle) {
    try {
        $message = "Congratulations! Your application for '{$jobTitle}' has been accepted";
        $link = "/student/view_application/{$applicationId}";
        $title = "Application Accepted";
        $type = 'success';
        
        return sendNotification(
            $studentId,
            $message,
            $title,
            $type,
            $link
        );
    } catch (Exception $e) {
        error_log("Failed to send application acceptance notification: " . $e->getMessage());
        return false;
    }
}