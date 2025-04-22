<?php
class Verification_team extends Controller
{
    private $model;

    public function __construct()
    {
        // Check if user is logged in
        AuthMiddleware::requireAuth();
        // Check if user has the required role
        AuthMiddleware::requireRole('VT-Member');

        // Load model
        $this->model = $this->model('userModel');
    }

    public function index()
    {
        $this->user_ver_pending();
    }

    public function user_verified($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'UserID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            $users = $this->model->getVerifiedUsersByMe($_SESSION['user_id'], $page, $limit, $sort, $order, $search);
            $data = [
                'users' => $users['data'],
                'currentPage' => $users['currentPage'],
                'rowsPerPage' => $users['limit'],
                'totalRows' => $users['totalRows'],
                'totalPages' => $users['totalPages'],
                'isLastPage' => $users['isLastPage'] ? 'yes' : 'no',
            ];
            $this->view('pages/verification_team/user_verified', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function job_verified($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'JobID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            $jobs = $this->model('jobModel')->getVerifiedJobsByMe($_SESSION['user_id'], $page, $limit, $sort, $order, $search);
            $data = [
                'jobs' => $jobs['data'],
                'currentPage' => $jobs['currentPage'],
                'rowsPerPage' => $jobs['limit'],
                'totalRows' => $jobs['totalRows'],
                'totalPages' => $jobs['totalPages'],
                'isLastPage' => $jobs['isLastPage'] ? 'yes' : 'no',
            ];
            $this->view('pages/verification_team/job_verified', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function user_ver_pending($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'UserID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            $users = $this->model->getPendingStudentsAndCompanies($page, $limit, $sort, $order, $search);
            $data = [
                'users' => $users['data'],
                'currentPage' => $users['currentPage'],
                'rowsPerPage' => $users['limit'],
                'totalRows' => $users['totalRows'],
                'totalPages' => $users['totalPages'],
                'isLastPage' => $users['isLastPage'] ? 'yes' : 'no',
            ];
            $this->view('pages/verification_team/user_ver_pending', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function user_ver_not($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'UserID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            $users = $this->model->getNotVerifiedStudentsAndCompanies($page, $limit, $sort, $order, $search);
            $data = [
                'users' => $users['data'],
                'currentPage' => $users['currentPage'],
                'rowsPerPage' => $users['limit'],
                'totalRows' => $users['totalRows'],
                'totalPages' => $users['totalPages'],
                'isLastPage' => $users['isLastPage'] ? 'yes' : 'no',
            ];
            $this->view('pages/verification_team/user_ver_not', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function user_ver_detail($userID)
    {
        try {
            $user = $this->model->getUserDetails($userID);
            $rejectReasons = $this->model('AdminModel')->getReasonsByType('user_reject');
            $verifyDetails = $this->model('AdminModel')->getLastVerificationLog($userID);
            $data = [
                'user' => $user,
                'rejectReasons' => $rejectReasons['data'],
                'verifyDetails' => $verifyDetails,
            ];
            if ($user['Role'] == 'Student') {
                $this->view('pages/verification_team/stu_ver_detail', $data);
            } else if ($user['Role'] == 'Company') {
                $this->view('pages/verification_team/com_ver_detail', $data);
            }
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function user_detail($userID)
    {
        try {
            $user = $this->model->getUserDetails($userID);
            $verifyDetails = $this->model('AdminModel')->getLastVerificationLog($userID);
            $data = [
                'user' => $user,
                'verifyDetails' => $verifyDetails,
            ];

            if ($user['Role'] == 'Student') {
                $this->view('pages/verification_team/stu_detail', $data);
            } else if ($user['Role'] == 'Company') {
                $this->view('pages/verification_team/com_detail', $data);
            }
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function user_ver_approve($userID)
    {
        try {
            $this->model->approveUser($userID);
            // Send email to user
            $user = $this->model->getUserDetails($userID);
            $email = $user['Email'];
            if ($user['Role'] == 'Company') {
                $name = $user['CompanyName'];
                MailHelper::sendEmailCompAccountApproved($email, $name);
                notifyUserApproval($userID);
            } elseif ($user['Role'] == 'Student') {
                $name = $user['FirstName'];
                MailHelper::sendEmailStuAccountApproved($email, $name);
                notifyUserApproval($userID);
            }
            //add verificationlogs
            $this->model('AdminModel')->addVerificationLog($userID, 'User', 'Approve');
            Redirect::to(URLROOT . '/verification_team/user_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function user_ver_reject($userID, $queryParam = [])
    {
        try {
            $reasonID = isset($queryParam['reason']) ? $queryParam['reason'] : 1;
            $this->model->rejectUser($userID);
            $user = $this->model->getUserDetails($userID);
            $email = $user['Email'];
            $reason = $this->model('AdminModel')->getReasonByID($reasonID)->Reason;
            if ($user['Role'] == 'Company') {
                $name = $user['CompanyName'];
                MailHelper::sendEmailAccountRejected($email, $name, $reason);
                notifyUserRejection($userID, $reason);
            } elseif ($user['Role'] == 'Student') {
                $name = $user['FirstName'];
                MailHelper::sendEmailAccountRejected($email, $name, $reason);
                notifyUserRejection($userID, $reason);
            }
            //add verificationlogs
            $this->model('AdminModel')->addVerificationLog($userID, 'User', 'Reject', $reasonID);
            Redirect::to(URLROOT . '/verification_team/user_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function job_ver_pending($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'JobID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            $jobs = $this->model('jobModel')->getPendingJobs($page, $limit, $sort, $order, $search);
            $data = [
                'jobs' => $jobs['data'],
                'currentPage' => $jobs['currentPage'],
                'rowsPerPage' => $jobs['limit'],
                'totalRows' => $jobs['totalRows'],
                'totalPages' => $jobs['totalPages'],
                'isLastPage' => $jobs['isLastPage'] ? 'yes' : 'no',
            ];
            $this->view('pages/verification_team/job_ver_pending', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function job_ver_detail($jobID)
    {
        try {
            $job = $this->model('jobModel')->getJobDetails($jobID);
            $rejectReasons = $this->model('AdminModel')->getReasonsByType('job_reject');
            $verifyDetails = $this->model('AdminModel')->getLastVerificationLog($jobID);
            $data = [
                'job' => $job,
                'rejectReasons' => $rejectReasons['data'],
                'verifyDetails' => $verifyDetails,
            ];
            $this->view('pages/verification_team/job_ver_detail', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function job_detail($jobID)
    {
        try {
            $job = $this->model('jobModel')->getJobDetails($jobID);
            $verifyDetails = $this->model('AdminModel')->getLastVerificationLog($jobID);
            $data = [
                'job' => $job,
                'verifyDetails' => $verifyDetails,
            ];
            $this->view('pages/verification_team/job_detail', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function job_ver_not($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'JobID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            $jobs = $this->model('jobModel')->getNotApprovedJobs($page, $limit, $sort, $order, $search);
            $data = [
                'jobs' => $jobs['data'],
                'currentPage' => $jobs['currentPage'],
                'rowsPerPage' => $jobs['limit'],
                'totalRows' => $jobs['totalRows'],
                'totalPages' => $jobs['totalPages'],
                'isLastPage' => $jobs['isLastPage'] ? 'yes' : 'no',
            ];
            $this->view('pages/verification_team/job_ver_not', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function job_ver_approve($jobID)
    {
        try {
            $job = $this->model('jobModel')->getJobDetails($jobID);
            $email = $job->Email;
            $name = $job->CompanyName;
            $title = $job->Title;
            $publishDate = $job->PublishDate;
            $this->model('jobModel')->approveJob($jobID);
            // Send email to user
            MailHelper::sendEmailJobApproved($email, $name, $title, $publishDate);

            // Notify the user about the approval
            notifyPostApproval($job->CompanyID, $job->Title);
            notifyPostPublish($job->CompanyID, $jobID, $title, $publishDate);


            //add verificationlogs
            $this->model('AdminModel')->addVerificationLog($jobID, 'Job', 'Approve', 16);
            Redirect::to(URLROOT . '/verification_team/job_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function job_ver_reject($jobID)
    {
        try {
            $reasonID = isset($queryParam['reason']) ? $queryParam['reason'] : 1;
            $this->model('jobModel')->rejectJob($jobID);
            $reason = $this->model('AdminModel')->getReasonByID($reasonID)->Reason;
            // Send email to user
            $job = $this->model('jobModel')->getJobDetails($jobID);
            $email = $job->Email;
            $name = $job->CompanyName;
            $title = $job->Title;
            MailHelper::sendEmailJobRejected($email, $name, $title, $reason);
            //add verificationlogs

            // Notify the user about the rejection
            notifyPostRejection($job->CompanyID, $job->Title, $reason);

            $this->model('AdminModel')->addVerificationLog($jobID, 'Job', 'Reject', $reasonID);
            Redirect::to(URLROOT . '/verification_team/job_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function messages_adm($userID = null)
    {
        // Check if a user ID was submitted via POST
        if (isset($_POST['selectedUserID'])) {
            $userID = $_POST['selectedUserID'];
        }
        
        // Fetch all admin messages
        $messages_adm = $this->model('ContactModel')->getMessagesVerAdm();

        // Initialize data with the message list
        $data = [
            'messages_adm' => $messages_adm,
            
        ];
        
        // Check if we need to load chat data only if userID is valid AND form was submitted
        $loadChatData = !empty($userID) && isset($_POST['selectedUserID']);
        
        // If we should load chat data, add the additional info
        if ($loadChatData) {
            // Ensure session user ID exists before accessing
            if (!isset($_SESSION['user_id'])) {
                die("Unauthorized access. Please log in.");
            }
            // Fetch user details and chat messages
            $data['userID'] = $userID;
            $data['user'] = $this->model->getUserDetails($userID);
            $data['sender_id'] = $_SESSION['user_id'];
            $data['receiver_id'] = $userID;
            $data['messages'] = $this->model('chatModel')->getMessages($_SESSION['user_id'], $userID);
            $data['messageInput'] = '';
            $data['messageInput_err'] = '';
        }

        $this->view('pages/verification_team/messages_adm', $data);
    }
    
    public function sendMessage($userID)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Fetch previous messages to determine the last topic if not provided
            $previousMessage = $this->model('chatModel')->getLastMessageBetween($_SESSION['user_id'], $userID);
            $lastTopic = $previousMessage ? $previousMessage->topic : 'General Information';

            // Use the submitted topic if provided, otherwise use the last topic
            $submittedTopic = trim($_POST['topic'] ?? '');

            // Fetch email logic
            $email = null; // Default to null

            // 1. Check if the previous message has an email
            if ($previousMessage && !empty($previousMessage->user_email)) {
                $email = $previousMessage->user_email;
            }
            // 2. If previous message email is null, fetch email from the user table
            elseif ($this->model->getUserDetails($userID)) {
                $userDetails = $this->model->getUserDetails($userID);
                $email = $userDetails->email ?? null; // Use email if available, else null
            }

            $data = [
                'userID' => $userID,
                'email' => $email, 
                'user' => $this->model->getUserDetails($userID),
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => $userID,
                'messages' => $this->model('chatModel')->getMessages($_SESSION['user_id'], $userID),
                'messageInput' => trim($_POST['messageInput'] ?? ''),
                'topic' => !empty($submittedTopic) ? $submittedTopic : $lastTopic, // Ensure topic is never empty
                'messageInput_err' => '',
            ];

            // Validation
            if (empty($data['messageInput'])) {
                $data['messageInput_err'] = 'Message cannot be empty';
            }

            // Ensure no errors before proceeding
            if (empty($data['messageInput_err'])) {
                if ($this->model('chatModel')->sendMessage($data['email'], $data['sender_id'], $data['receiver_id'], $data['topic'], $data['messageInput'], $data['email'])) {
                    $_SESSION['show_contact_us_success'] = true;
                    notifyMessageToAdminFromVt($data['receiver_id'], $data['messageInput'], $data['sender_id'], $_SESSION['user_name']);
                    redirect('verification_team/messages_adm/' . $userID);
                } else {
                    $_SESSION['show_contact_us_error'] = true;
                    die('Something went wrong while sending the message.');
                }
            } else {
                // Reload view with errors
                $this->view('pages/verification_team/messages_adm', $data);
            }
        } else {
            // Load initial view without POST request
            
            $data = [
                'userID' => $userID,
                'email' => '',
                'user' => $this->model->getUserDetails($userID),
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => $userID,
                'messages' => $this->model('chatModel')->getMessages($_SESSION['user_id'], $userID),
                'messageInput' => '',
                'messageInput_err' => '',
                'topic' => '', // Default to empty until a message is sent
            ];

            $this->view('pages/verification_team/messages_adm', $data);
        }
    }

    public function markAllRead() {

        $this->model('NotificationModel')->markAllAsRead($_SESSION['user_id']);
        $previousURL = $_SERVER['HTTP_REFERER'] ?? URLROOT . '/verification_team/notifications';
        Redirect::to($previousURL);
    }

    public function markAsRead($notificationId) {
        if ($this->model('NotificationModel')->markAsRead($notificationId)) {
            $unreadCount = $this->model('NotificationModel')->getUnreadCount($_SESSION['user_id']);
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'unreadCount' => $unreadCount]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Failed to mark notification as read']);
        }
        exit;
    }

    public function getRecentNotifications() {
        $notifications = $this->model('NotificationModel')->getRecentNotifications($_SESSION['user_id'], 5);
        $unreadCount = $this->model('NotificationModel')->getUnreadCount($_SESSION['user_id']);
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true, 
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ]);
        exit;
    }

}
