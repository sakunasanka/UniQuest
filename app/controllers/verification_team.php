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
            $searchBy = isset($queryParam['searchBy']) ? $queryParam['searchBy'] : 'UserID';

            $users = $this->model->getVerifiedUsersByMe($_SESSION['user_id'], $page, $limit, $sort, $order, $search, $searchBy);
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
            $searchBy = isset($queryParam['searchBy']) ? $queryParam['searchBy'] : 'JobID';

            $jobs = $this->model('jobModel')->getVerifiedJobsByMe($_SESSION['user_id'], $page, $limit, $sort, $order, $search, $searchBy);
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
            $searchBy = isset($queryParam['searchBy']) ? $queryParam['searchBy'] : 'UserID';

            $users = $this->model->getPendingStudentsAndCompanies($page, $limit, $sort, $order, $search, $searchBy);
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
            $searchBy = isset($queryParam['searchBy']) ? $queryParam['searchBy'] : 'UserID';

            $users = $this->model->getNotVerifiedStudentsAndCompanies($page, $limit, $sort, $order, $search, $searchBy);
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
            $data = [
                'user' => $user,
                'rejectReasons' => $rejectReasons['data']
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
            $data = [
                'user' => $user
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
            } elseif ($user['Role'] == 'Student') {
                $name = $user['FirstName'];
                MailHelper::sendEmailStuAccountApproved($email, $name);
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
            } elseif ($user['Role'] == 'Student') {
                $name = $user['FirstName'];
                MailHelper::sendEmailAccountRejected($email, $name, $reason);
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
            $searchBy = isset($queryParam['searchBy']) ? $queryParam['searchBy'] : 'JobID';

            $jobs = $this->model('jobModel')->getPendingJobs($page, $limit, $sort, $order, $search, $searchBy);
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
            $data = [
                'job' => $job
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
            $data = [
                'job' => $job
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
            $searchBy = isset($queryParam['searchBy']) ? $queryParam['searchBy'] : 'JobID';

            $jobs = $this->model('jobModel')->getNotApprovedJobs($page, $limit, $sort, $order, $search, $searchBy);
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
            $this->model('jobModel')->approveJob($jobID);
            Redirect::to(URLROOT . '/verification_team/job_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function job_ver_reject($jobID)
    {
        try {
            $this->model('jobModel')->rejectJob($jobID);
            Redirect::to(URLROOT . '/verification_team/job_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }


    public function notifications()
    {
        $this->view('pages/verification_team/notification_alerts');
    }

    public function contact_admin($userID)
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
                    // flash('message_sent', 'Message sent successfully');
                    redirect('admin/user_detail/' . $userID);
                } else {
                    die('Something went wrong while sending the message.');
                }
            } else {
                // Reload view with errors
                $this->view('pages/verification_team/contact_admin', $data);
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

            $this->view('pages/verification_team/contact_admin', $data);;
        }
    }

 }

