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
            $this->model('AdminModel')->addVerificationLog($jobID, 'Job', 'Reject', $reasonID);
            Redirect::to(URLROOT . '/verification_team/job_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }


    public function notifications()
    {
        $this->view('pages/verification_team/notification_alerts');
    }

    public function contact_admin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Data for the contact form
            $data = [
                'email' => trim($_POST['email'] ?? ''),
                'topic' => trim($_POST['topic'] ?? ''),
                'message' => trim($_POST['message'] ?? ''),

                'email_err' => '',
                'topic_err' => '',
                'message_err' => ''
            ];

            // Validation checks
            if (empty($data['email'])) {
                $data['name_err'] = 'Please enter your email';
            }

            if (empty($data['topic'])) {
                $data['topic_err'] = 'Please select a topic';
            }

            if (empty($data['message'])) {
                $data['message_err'] = 'Please enter your message';
            }

            // Ensure no errors before submitting
            if (empty($data['email_err']) && empty($data['topic_err']) && empty($data['message_err'])) {
                if ($this->model('ContactModel')->sendMessage($data)) {
                    flash('contact-msg', 'Your message has been sent successfully.');
                    redirect('verification_team/contact_admin');
                } else {
                    die('Something went wrong. Please try again.');
                }
            } else {
                $this->view('pages/verification_team/contact_admin', $data);
            }
        } else {
            // Initialize default data for the view on GET request
            $data = [
                'email' => '',
                'topic' => '',
                'message' => '',
                'email_err' => '',
                'topic_err' => '',
                'message_err' => ''
            ];

            $this->view('pages/verification_team/contact_admin', $data);
        }
    }

    public function markAllRead() {

        $this->model('NotificationModel')->markAllAsRead($_SESSION['user_id']);
        $previousURL = $_SERVER['HTTP_REFERER'] ?? URLROOT . '/verification_team/notifications';
        Redirect::to($previousURL);
    }

    public function markAsRead($notificationId) {
        $this->model('NotificationModel')->markAsRead($notificationId);
        // $previousURL = $_SERVER['HTTP_REFERER'] ?? URLROOT . '/verification_team/notifications';
        // Redirect::to($previousURL);
    }
}
