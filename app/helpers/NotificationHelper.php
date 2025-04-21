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

 // Notify a student that their application has been rejected
 function notifyStudentApplicationRejected($applicationId, $studentId, $jobTitle) {
    try {
        $message = "Unfortunately, your application for '{$jobTitle}' has been rejected";
        $link = "/student/view_application/{$applicationId}";
        $title = "Application Rejected";
        $type = 'danger';
        
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

// Admin approves a User
function notifyUserApproval($userId) {
    try {
        $message = "Congratulations! Your account has been approved.";
        $title = "Account Approved";
        $type = 'success';
        
        return sendNotification(
            $userId,
            $message,
            $title,
            $type,
        );
    } catch (Exception $e) {
        error_log("Failed to send user approval notification: " . $e->getMessage());
        return false;
    }
}

// Admin rejects a User
function notifyUserRejection($userId, $reason) {
    try {
        $message = "Your account has been rejected. Reason: {$reason}";
        $title = "Account Rejected";
        $type = 'danger';
        
        return sendNotification(
            $userId,
            $message,
            $title,
            $type,
        );
    } catch (Exception $e) {
        error_log("Failed to send user rejection notification: " . $e->getMessage());
        return false;
    }
}

// Account acticated
function notifyAccountActivation($userId) {
    try {
        $message = "Congratulations! Your account has been activated.";
        $title = "Account Activated";
        $type = 'success';
        
        return sendNotification(
            $userId,
            $message,
            $title,
            $type,
        );
    } catch (Exception $e) {
        error_log("Failed to send account activation notification: " . $e->getMessage());
        return false;
    }
}

// Account deactivated
function notifyAccountDeactivation($userId, $reason) {
    try {
        $message = "Sorry! Your account has been deactivated. Reason: {$reason}";
        $title = "Account Deactivated";
        $type = 'warning';
        
        return sendNotification(
            $userId,
            $message,
            $title,
            $type,
        );
    } catch (Exception $e) {
        error_log("Failed to send account deactivation notification: " . $e->getMessage());
        return false;
    }
}

// Notify a student about a new message from admin
function notifyMessageFromAdmin($userID, $messageFromAdmin) {
    try {
        $message = $messageFromAdmin;
        $title = "Message from Admin";
        $type = 'message';
        
        return sendNotification(
            $userID,
            $message,
            $title,
            $type
        );
    } catch (Exception $e) {
        error_log("Failed to send application acceptance notification: " . $e->getMessage());
        return false;
    }
}

// Notify a admin about a new message from student
function notifyMessageToAdminFromStudent($adminID, $messageFromAdmin, $studentID, $studentName) {
    try {
        $message = "From: {$studentName}<br>{$messageFromAdmin}";
        $title = "Message from Student";
        $type = 'message';
        $link = "/admin/messages_stu?userID={$studentID}";
        
        return sendNotification(
            $adminID,
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

function notifyMessageToAdminFromCompany($adminID, $messageFromAdmin, $companyID, $companyName) {
    try {
        $message = "From: {$companyName}<br>{$messageFromAdmin}";
        $title = "Message from Company";
        $type = 'message';
        $link = "/admin/messages_com?userID={$companyID}";
        
        return sendNotification(
            $adminID,
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