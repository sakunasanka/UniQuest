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
function sendNotification($userId, $message, $title, $date, $type = 'info', $link = null) {
    try {
        $notificationModel = model('NotificationModel');
        return $notificationModel->create($userId, $type, $title, $date, $message, $link);
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
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $studentId,
            $message,
            $title,
            $date,
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
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $studentId,
            $message,
            $title,
            $date,
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
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $userId,
            $message,
            $title,
            $date,
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
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $userId,
            $message,
            $title,
            $date,
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
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $userId,
            $message,
            $title,
            $date,
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
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $userId,
            $message,
            $title,
            $date,
            $type,
        );
    } catch (Exception $e) {
        error_log("Failed to send account deactivation notification: " . $e->getMessage());
        return false;
    }
}


// Notify job post publish
function notifyPostApproval($userId, $jobTitle) {
    try {
        $message = "Congratulations! Your job post '{$jobTitle}' has been approved. Your job will be published soon.";
        $title = "Job Post Approved";
        $type = 'success';
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $userId,
            $message,
            $title,
            $date,
            $type,
        );
    } catch (Exception $e) {
        error_log("Failed to send job post approval notification: " . $e->getMessage());
        return false;
    }
}

// Notify a student about a new message from admin
function notifyMessageFromAdmin($userID, $messageFromAdmin) {
    try {
        $message = $messageFromAdmin;
        $title = "Message from Admin";
        $type = 'message';
        $link = "/verification_team/messages_adm";
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $userID,
            $message,
            $title,
            $date,
            $type,
            $link
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
        $link = "/admin/messages_stu";
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $adminID,
            $message,
            $title,
            $date,
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
        $link = "/admin/messages_com";
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $adminID,
            $message,
            $title,
            $date,
            $type,
            $link
        );
    } catch (Exception $e) {
        error_log("Failed to send application acceptance notification: " . $e->getMessage());
        return false;
    }
}

function notifyMessageToCompanyFromStudent($companyID, $messageFromStudent, $studentID, $studentName) {
    try {
        $message = "From: {$studentName}<br>{$messageFromStudent}";
        $title = "Message from Student";
        $type = 'message';
        $link = "/service_provider/messages_stu";
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $companyID,
            $message,
            $title,
            $date,
            $type,
            $link
        );
    } catch (Exception $e) {
        error_log("Failed to send application acceptance notification: " . $e->getMessage());
        return false;
    }
}

function notifyMessageToStudentFromCompany($studentID, $messageFromCompany, $companyID, $companyName) {
    try {
        $message = "From: {$companyName}<br>{$messageFromCompany}";
        $title = "Message from Company";
        $type = 'message';
        $link = "/jobs/companydescription/{$companyID}";
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $studentID,
            $message,
            $title,
            $date,
            $type,
            $link
        );
    } catch (Exception $e) {
        error_log("Failed to send application acceptance notification: " . $e->getMessage());
        return false;
    }
}

function notifyMessageToAdminFromVt($adminID, $messageFromVt, $VtID, $VtName) {
    try {
        $message = "From: {$VtName}<br>{$messageFromVt}";
        $title = "Message from VT-Member";
        $type = 'message';
        $link = "/admin/messages_ver";
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $adminID,
            $message,
            $title,
            $date,
            $type,
            $link
        );
    } catch (Exception $e) {
        error_log("Failed to send application acceptance notification: " . $e->getMessage());
        return false;
    }
}

// Notify job post publish
function notifyPostRejection($userId, $jobTitle, $reason) {
    try {
        $message = "Your job post '{$jobTitle}' has been rejected.<br>Reason: {$reason}";
        $title = "Job Post Rejected";
        $type = 'danger';
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $userId,
            $message,
            $title,
            $date,
            $type,
        );
    } catch (Exception $e) {
        error_log("Failed to send job post rejection notification: " . $e->getMessage());
        return false;
    }
}

// Notify job post publish
function notifyPostPublish($userId, $jobID, $jobTitle, $date) {
    try {
        $message = "Congratulations! Your job post '{$jobTitle}' has been published on our platform.";
        $title = "Job Post Published";
        $type = 'success';
        $link = "/jobs/jobsDescription/{$jobID}";
        $date1 = $date;
        
        return sendNotification(
            $userId,
            $message,
            $title,
            $date1,
            $type,
            $link
        );
    } catch (Exception $e) {
        error_log("Failed to send job post publish notification: " . $e->getMessage());
        return false;
    }
}

function notifyAdminAboutJobPost($userID, $jobID, $jobTitle) {
    try {
        $message = "A new job post '{$jobTitle}' has been created.";
        $title = "New Job Post Created";
        $type = 'info';
        $link = "/admin/job_ver_detail/{$jobID}";
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $userID,
            $message,
            $title,
            $date,
            $type,
            $link
        );
    } catch (Exception $e) {
        error_log("Failed to send admin notification about new job post: " . $e->getMessage());
        return false;
    }
}

function notifyVtAboutJobPost($userID, $jobID, $jobTitle) {
    try {
        $message = "A new job post '{$jobTitle}' has been created.";
        $title = "New Job Post Created";
        $type = 'info';
        $link = "/verification_team/job_ver_detail/{$jobID}";
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $userID,
            $message,
            $title,
            $date,
            $type,
            $link
        );
    } catch (Exception $e) {
        error_log("Failed to send admin notification about new job post: " . $e->getMessage());
        return false;
    }
}

function notifyPremiumPlanActive($companyID, $plan) {
    try {
        $message = "Your {$plan} plan is now active.";
        $title = "Plan Activated";
        $type = 'success';
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $companyID,
            $message,
            $title,
            $date,
            $type
        );
    } catch (Exception $e) {
        error_log("Failed to send application acceptance notification: " . $e->getMessage());
        return false;
    }
}

function notifyJobsApply($companyID, $jobTitle, $jobID) {
    try {
        $message = "A new application has been received for the job: {$jobTitle}";
        $title = "New Job Application";
        $type = 'info';
        $link = "/service_provider/new_applications/{$jobID}";
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $companyID,
            $message,
            $title,
            $date,
            $type,
            $link
        );
    } catch (Exception $e) {
        error_log("Failed to send application acceptance notification: " . $e->getMessage());
        return false;
    }
}

function notifyComplaintToAdmin($adminID, $jobName, $studentName) {
    try {
        $message = "A new complaint has been received from {$studentName} regarding job: {$jobName}";
        $title = "New Complaint Received";
        $type = 'complaint';
        $link = "/admin/all_complaints";
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $adminID,
            $message,
            $title,
            $date,
            $type,
            $link
        );
    } catch (Exception $e) {
        error_log("Failed to send application acceptance notification: " . $e->getMessage());
        return false;
    }
}    

function notifyPostPublishStu($userId, $jobID, $jobTitle, $date) {
    try {
        $message = "New job post '{$jobTitle}' has been published on our platform.";    
        $title = "Job Post Published";
        $type = 'info';
        $link = "/jobs/jobsDescription/{$jobID}";
        $date1 = $date;
        return sendNotification(
            $userId,
            $message,
            $title,
            $date1,
            $type,
            $link
        );
    } catch (Exception $e) {
        error_log("Failed to send job post publish notification: " . $e->getMessage());
        return false;
    }
}

function notifyAdminAboutNewStu($adminId, $studentID, $studentName) {
    try {
        $message = "A new student '{$studentName}' has registered and is pending verification.";
        $title = "New Student Registered";
        $type = 'info';
        $link = "/admin/user_ver_detail/{$studentID}";
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $adminId,
            $message,
            $title,
            $date,
            $type,
            $link
        );
    } catch (Exception $e) {
        error_log("Failed to send admin notification about new student: " . $e->getMessage());
        return false;
    }
}    

function notifyVtAboutNewStu($vtID, $studentID, $studentName) {
    try {
        $message = "A new student '{$studentName}' has registered and is pending verification.";
        $title = "New Student Registered";
        $type = 'info';
        $link = "/verification_team/user_ver_detail/{$studentID}";
        $date = date('Y-m-d H:i:s');
        
        return sendNotification(
            $vtID,
            $message,
            $title,
            $date,
            $type,
            $link
        );
    } catch (Exception $e) {
        error_log("Failed to send verification_team notification about new student: " . $e->getMessage());
        return false;
    }
}    

function notifyAdminAboutNewCom($adminId, $companyID, $companyName) {
    try {
        $message = "A new company '{$companyName}' has registered and is pending verification.";
        $title = "New Company Registered";
        $type = 'info';
        $link = "/admin/user_ver_detail/{$companyID}";
        $date = date('Y-m-d H:i:s');
        return sendNotification(
            $adminId,
            $message,
            $title,
            $date,
            $type,
            $link
        );
    } catch (Exception $e) {
        error_log("Failed to send admin notification about new company: " . $e->getMessage());
        return false;
    }
}    

function notifyVtAboutNewCom($vtID, $companyID, $companyName) {
    try {
        $message = "A new company '{$companyName}' has registered and is pending verification.";
        $title = "New Company Registered";
        $type = 'info';
        $link = "/verification_team/user_ver_detail/{$companyID}";
        $date = date('Y-m-d H:i:s');
        return sendNotification(
            $vtID,
            $message,
            $title,
            $date,
            $type,
            $link
        );
    } catch (Exception $e) {
        error_log("Failed to send verification_team notification about new company: " . $e->getMessage());
        return false;
    }
}   