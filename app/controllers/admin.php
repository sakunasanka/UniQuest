<?php
class Admin extends Controller
{
    private $model;

    public function __construct()
    {
        // Check if user is logged in
        AuthMiddleware::requireAuth();
        // Check if user has the required role
        AuthMiddleware::requireRole('Admin');

        // Load model
        $this->model = $this->model('userModel');
    }

    private function prepareData($post = [], $files = [])
    {
        return [
            'firstName' => ucfirst(trim($post['firstName'] ?? '')),
            'lastName' => ucfirst(trim($post['lastName'] ?? '')),
            'email' => trim($post['email'] ?? ''),
            'password' => trim($post['password'] ?? ''),
            'confirm_password' => trim($post['confirm_password'] ?? ''),
            'contactNo' => trim($post['contactNo'] ?? ''),
            'profilePic' => $files['profilePic'] ?? '',
            'profilePicName' => '',
            'role' => 'VT-Member',
            'date' => date('Y-m-d H:i:s'),
            'status' => 'Active',

            'firstName_err' => '',
            'lastName_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => '',
            'contactNo_err' => '',
            'profilePic_err' => '',
            'role_err' => '',
            'status_err' => ''
        ];
    }

    public function index()
    {
        $this->dashboard();
    }

    public function students_mng($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'UserID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';
            $searchBy = isset($queryParam['searchBy']) ? $queryParam['searchBy'] : 'UserID';

            $students = $this->model->getVerifiedUsersByRole('Student', $page, $limit, $sort, $order, $search, $searchBy);
            $deactReasons = $this->model('AdminModel')->getReasonsByType('user_deactivate');
            $actReasons = $this->model('AdminModel')->getReasonsByType('user_activate');

            $data = [
                'students' => $students['data'],
                'deactReasons' => $deactReasons['data'],
                'actReasons' => $actReasons['data'],
                'currentPage' => $students['currentPage'],
                'rowsPerPage' => $students['limit'],
                'totalRows' => $students['totalRows'],
                'totalPages' => $students['totalPages'],
                'isLastPage' => $students['isLastPage'] ? 'yes' : 'no',
            ];
            $this->view('pages/admin/students_mng', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function add_student()
    {
        $this->view('pages/admin/add_student');
    }

    public function company_mng($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'UserID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';
            $searchBy = isset($queryParam['searchBy']) ? $queryParam['searchBy'] : 'UserID';
            // $page = $_GET['page'] ?? 1;
            // $limit = $_GET['limit'] ?? 2;
            // $sort = $_GET['sort'] ?? 'UserID';
            // $order = $_GET['order'] ?? 'ASC';

            $companies = $this->model->getVerifiedUsersByRole('Company', $page, $limit, $sort, $order, $search, $searchBy);
            $deactReasons = $this->model('AdminModel')->getReasonsByType('user_deactivate');
            $actReasons = $this->model('AdminModel')->getReasonsByType('user_activate');

            $data = [
                'companies' => $companies['data'],
                'deactReasons' => $deactReasons['data'],
                'actReasons' => $actReasons['data'],
                'currentPage' => $companies['currentPage'],
                'rowsPerPage' => $companies['limit'],
                'totalRows' => $companies['totalRows'],
                'totalPages' => $companies['totalPages'],
                'isLastPage' => $companies['isLastPage'] ? 'yes' : 'no',
            ];
            $this->view('pages/admin/company_mng', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function add_company()
    {
        $this->view('pages/admin/add_company');
    }

    public function verTeam_mng($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'UserID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';
            $searchBy = isset($queryParam['searchBy']) ? $queryParam['searchBy'] : 'UserID';

            $vtMembers = $this->model->getVerifiedUsersByRole('VT-Member', $page, $limit, $sort, $order, $search, $searchBy);
            $deactReasons = $this->model('AdminModel')->getReasonsByType('user_deactivate');
            $actReasons = $this->model('AdminModel')->getReasonsByType('user_activate');

            $data = [
                'vtMembers' => $vtMembers['data'],
                'deactReasons' => $deactReasons['data'],
                'actReasons' => $actReasons['data'],
                'currentPage' => $vtMembers['currentPage'],
                'rowsPerPage' => $vtMembers['limit'],
                'totalRows' => $vtMembers['totalRows'],
                'totalPages' => $vtMembers['totalPages'],
                'isLastPage' => $vtMembers['isLastPage'] ? 'yes' : 'no',
            ];
            $this->view('pages/admin/verTeam_mng', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function add_member()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST);

            //init data
            $data = $this->prepareData($_POST, $_FILES);

            //check email is already registered
            if ($this->model->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email is already registered';
            }

            //email verification
            $emailVerificationResponse = $this->model('AdminModel')->verifyEmail($data['email']);
            if (!$emailVerificationResponse) {
                $data['email_err'] = 'Email verification failed';
            }

            $validationResponse = Validator::isValidRegistrationData($data);
            if (!$validationResponse['is_valid']) {
                $data = array_merge($data, $validationResponse['error']);
            }

            $profilePicValidationResponse = FileUploadHelper::validateFile($data['profilePic'], FileUploadHelper::ALLOWED_IMAGE_EXTENSIONS);
            if (!$profilePicValidationResponse['is_valid']) {
                $data['profilePic_err'] = $profilePicValidationResponse['error'];
            }

            // Check if there are no errors
            if (empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['firstName_err']) && empty($data['lastName_err']) && empty($data['contactNo_err']) && empty($data['role_err']) && empty($data['status_err']) && empty($data['profilePic_err'])) {
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Upload profile picture
                $profilePicResponse = FileUploadHelper::uploadFile($data['profilePic'], PUBROOT . '/uploads/profile_pictures/vT-Member');
                if ($profilePicResponse['success']) {
                    $data['profilePicName'] = $profilePicResponse['file_name'];
                } else {
                    $data['profilePic_err'] = $profilePicResponse['error'];
                }

                // Register user
                if ($this->model->addVTMember($data)) {
                    // Redirect to verification team management page
                    Redirect::to(URLROOT . '/admin/verTeam_mng');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('pages/admin/add_member', $data);
            }
        } else {
            // Init data
            $data = $this->prepareData();
            // Load view
            $this->view('pages/admin/add_member', $data);
        }
    }

    public function job_complaint($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'ComplaintID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';
            $searchBy = isset($queryParam['searchBy']) ? $queryParam['searchBy'] : 'ComplaintID';

            $complaints_job = $this->model('ComplaintModel')->getAllComplaints($page, $limit, $sort, $order, $search, $searchBy);

            $data = [
                'complaints_job' => $complaints_job['data'],
                'currentPage' => $complaints_job['currentPage'],
                'rowsPerPage' => $complaints_job['limit'],
                'totalRows' => $complaints_job['totalRows'],
                'totalPages' => $complaints_job['totalPages'],
                'isLastPage' => $complaints_job['isLastPage'] ? 'yes' : 'no',
            ];

            $this->view('pages/admin/job_complaint', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function company_complaint($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'CompanyID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';
            $searchBy = isset($queryParam['searchBy']) ? $queryParam['searchBy'] : 'CompanyID';

            $complaints_com = $this->model('ComplaintModel')->getComplaintsGroupedByCompany($page, $limit, $sort, $order, $search, $searchBy);

            $data = [
                'complaints_com' => $complaints_com['data'],
                'currentPage' => $complaints_com['currentPage'],
                'rowsPerPage' => $complaints_com['limit'],
                'totalRows' => $complaints_com['totalRows'],
                'totalPages' => $complaints_com['totalPages'],
                'isLastPage' => $complaints_com['isLastPage'] ? 'yes' : 'no',
            ];

            $this->view('pages/admin/company_complaint', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function complaint_detail($complaintID)
    {
        $complaint = $this->model('ComplaintModel')->getComplaintDetails($complaintID);

        $data = [
            'complaint' => $complaint
        ];

        $this->view('pages/admin/complaint_detail', $data);
    }

    public function complaint_company($company, $queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'ComplaintID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';
            $searchBy = isset($queryParam['searchBy']) ? $queryParam['searchBy'] : 'ComplaintID';

            $complaints = $this->model('ComplaintModel')->getComplaintsByCompany($company, $page, $limit, $sort, $order, $search, $searchBy);

            $data = [
                'complaints' => $complaints['data'],
                'currentPage' => $complaints['currentPage'],
                'rowsPerPage' => $complaints['limit'],
                'totalRows' => $complaints['totalRows'],
                'totalPages' => $complaints['totalPages'],
                'isLastPage' => $complaints['isLastPage'] ? 'yes' : 'no',
            ];

            $this->view('pages/admin/complaint_company', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function resolve_complaint($complaintID)
    {
        try {
            $this->model('ComplaintModel')->resolveComplaint($complaintID);
            Redirect::to(URLROOT . '/admin/job_complaint');
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function reject_complaint($complaintID)
    {
        try {
            $this->model('ComplaintModel')->rejectComplaint($complaintID);
            Redirect::to(URLROOT . '/admin/job_complaint');
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function ptjobs_mng($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'JobID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';
            $searchBy = isset($queryParam['searchBy']) ? $queryParam['searchBy'] : 'JobID';

            $ptjobs = $this->model('jobModel')->getVerifiedJobsByCategory('Part-time', $page, $limit, $sort, $order, $search, $searchBy);
            $data = [
                'ptjobs' => $ptjobs['data'],
                'currentPage' => $ptjobs['currentPage'],
                'rowsPerPage' => $ptjobs['limit'],
                'totalRows' => $ptjobs['totalRows'],
                'totalPages' => $ptjobs['totalPages'],
                'isLastPage' => $ptjobs['isLastPage'] ? 'yes' : 'no',
            ];
            $this->view('pages/admin/ptjobs_mng', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function intern_mng($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'JobID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';
            $searchBy = isset($queryParam['searchBy']) ? $queryParam['searchBy'] : 'JobID';

            $interns = $this->model('jobModel')->getVerifiedJobsByCategory('Internship', $page, $limit, $sort, $order, $search, $searchBy);
            $data = [
                'interns' => $interns['data'],
                'currentPage' => $interns['currentPage'],
                'rowsPerPage' => $interns['limit'],
                'totalRows' => $interns['totalRows'],
                'totalPages' => $interns['totalPages'],
                'isLastPage' => $interns['isLastPage'] ? 'yes' : 'no',
            ];
            $this->view('pages/admin/intern_mng', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
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
                    // flash('message_sent', 'Message sent successfully');
                    redirect('admin/user_detail/' . $userID);
                } else {
                    die('Something went wrong while sending the message.');
                }
            } else {
                // Reload view with errors
                $this->loadUserDetailView($data);
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

            $this->loadUserDetailView($data);
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
            $this->view('pages/admin/user_ver_pending', $data);
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
            $this->view('pages/admin/user_ver_not', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function user_detail($userID)
    {
        $data = [
            'userID' => $userID,
            'user' => $this->model->getUserDetails($userID),
            'sender_id' => $_SESSION['user_id'],
            'receiver_id' => $userID,
            'messages' => $this->model('chatModel')->getMessages($_SESSION['user_id'], $userID),
            'messageInput' => '',
            'messageInput_err' => '',
        ];

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
                'acc_log' => $this->model('AdminModel')->getLastAccountLogReason($userID, 'Deactivate'),
                'verifyDetails' => $this->model('AdminModel')->getLastVerificationLog($userID),
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => $userID,
                'messages' => $this->model('chatModel')->getMessagesForAdmin($_SESSION['user_id'], $userID),
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
                $this->loadUserDetailView($data);
            }
        } else {
            // Load initial view without POST request

            $data = [
                'userID' => $userID,
                'email' => '',
                'user' => $this->model->getUserDetails($userID),
                'acc_log' => $this->model('AdminModel')->getLastAccountLogReason($userID),
                'verifyDetails' => $this->model('AdminModel')->getLastVerificationLog($userID),
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => $userID,
                'messages' => $this->model('chatModel')->getMessagesForAdmin($_SESSION['user_id'], $userID),
                'messageInput' => '',
                'messageInput_err' => '',
                'topic' => '', // Default to empty until a message is sent
            ];

            $this->loadUserDetailView($data);
        }
    }

    private function loadUserDetailView($data)
    {
        if ($data['user']['Role'] == 'Student') {
            $this->view('pages/admin/stu_detail', $data);
        } elseif ($data['user']['Role'] == 'Company') {
            $this->view('pages/admin/com_detail', $data);
        } elseif ($data['user']['Role'] == 'VT-Member') {
            $this->view('pages/admin/vt_detail', $data);
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
                $this->view('pages/admin/stu_ver_detail', $data);
            } else if ($user['Role'] == 'Company') {
                $this->view('pages/admin/com_ver_detail', $data);
            } else if ($user['Role'] == 'VT-Member') {
                $this->view('pages/admin/vt_ver_detail', $data);
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
            Redirect::to(URLROOT . '/admin/user_ver_pending');
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
            Redirect::to(URLROOT . '/admin/user_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function user_activate($userID, $role, $email, $queryParam = [])
    {
        try {
            $reasonID = isset($queryParam['reason']) ? $queryParam['reason'] : 1;
            $reason = $this->model('AdminModel')->getReasonByID($reasonID)->Reason;
            $this->model->activateAccount($userID);
            $this->model('AdminModel')->addUserAccountLog($userID, 'Activate', $reasonID);
            MailHelper::sendEmailAccountReactivatedByAdmin($email, $reason);
            if ($role == 'Company') {
                Redirect::to(URLROOT . '/admin/company_mng');
            } else if ($role == 'Student') {
                Redirect::to(URLROOT . '/admin/students_mng');
            } else if ($role == 'VT-Member') {
                Redirect::to(URLROOT . '/admin/verTeam_mng');
            }
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function user_deactivate($userID, $role, $email, $queryParam = [])
    {
        try {
            $reasonID = isset($queryParam['reason']) ? $queryParam['reason'] : 1;
            $reason = $this->model('AdminModel')->getReasonByID($reasonID)->Reason;
            $this->model->deactivateAccount($userID);
            $this->model('AdminModel')->addUserAccountLog($userID, 'Deactivate', $reasonID);
            MailHelper::sendEmailAccountDeactivatedByAdmin($email, $reason);
            if ($role == 'Company') {
                Redirect::to(URLROOT . '/admin/company_mng');
            } else if ($role == 'Student') {
                Redirect::to(URLROOT . '/admin/students_mng');
            } else if ($role == 'VT-Member') {
                Redirect::to(URLROOT . '/admin/verTeam_mng');
            }
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    // public function job_ver_all()
    // {
    //     $this->view('pages/admin/job_ver_all');
    // }

    public function job_detail($jobID)
    {
        try {
            $job = $this->model('jobModel')->getJobDetails($jobID);
            $data = [
                'job' => $job
            ];
            $this->view('pages/admin/job_detail', $data);
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
            $this->view('pages/admin/job_ver_pending', $data);
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
            $this->view('pages/admin/job_ver_detail', $data);
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
            $this->view('pages/admin/job_ver_not', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function job_ver_approve($jobID)
    {
        try {
            $this->model('jobModel')->approveJob($jobID);
            Redirect::to(URLROOT . '/admin/job_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function job_ver_reject($jobID)
    {
        try {
            $this->model('jobModel')->rejectJob($jobID);
            Redirect::to(URLROOT . '/admin/job_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function job_activate($jobID, $jobType)
    {
        try {
            $this->model('jobModel')->activateJob($jobID);
            if ($jobType == 'Part-time') {
                Redirect::to(URLROOT . '/admin/ptjobs_mng');
            } else if ($jobType == 'Internship') {
                Redirect::to(URLROOT . '/admin/intern_mng');
            }
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function job_deactivate($jobID, $jobType)
    {
        try {
            $this->model('jobModel')->deactivateJob($jobID);
            if ($jobType == 'Part-time') {
                Redirect::to(URLROOT . '/admin/ptjobs_mng');
            } else if ($jobType == 'Internship') {
                Redirect::to(URLROOT . '/admin/intern_mng');
            }
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function dashboard()
    {
        try {
            $studentCount = $this->model->getCountRegisteredUsers('Student');
            $companyCount = $this->model->getCountRegisteredUsers('Company');
            $activeJobCount = $this->model('jobModel')->getCountActiveJobs();
            $pendingUserCount = $this->model->getCountPendingUsers();
            $pendingJobCount = $this->model('jobModel')->getCountPendingJobs();
            $pendingComplaintCount = $this->model('ComplaintModel')->getCountPendingComplaints();

            $data = [
                'studentCount' => $studentCount,
                'companyCount' => $companyCount,
                'activeJobCount' => $activeJobCount,
                'pendingUserCount' => $pendingUserCount,
                'pendingJobCount' => $pendingJobCount,
                'pendingComplaintCount' => $pendingComplaintCount
            ];

            $this->view('pages/admin/adminDash', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function jobPost()
    {
        $this->view('pages/admin/jobPost');
    }
    public function analytics()
    {
        $this->view('pages/admin/analytics');
    }

    public function notifications()
    {
        $messages = $this->model('ContactModel')->getMessagesAll();

        // Load the view with the messages
        $data = [
            'messages' => $messages
        ];

        $this->view('pages/admin/notification_alerts', $data);
    }

    public function updateReadStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];

            if ($this->model('ContactModel')->updateReadStatus($id)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update read status.']);
            }
        } else {
            http_response_code(405);
        }
    }

    public function messages_stu($userID = null)
    {
        // Fetch all student messages
        $messages_stu = $this->model('ContactModel')->getMessagesStu();

        // If no specific user is selected, just load the messages
        if (!isset($userID)) {
            $data = [
                'messages_stu' => $messages_stu,
            ];
        } else {
            // Ensure session user ID exists before accessing
            if (!isset($_SESSION['user_id'])) {
                die("Unauthorized access. Please log in."); // Redirect or handle it better
            }

            // Fetch user details and chat messages
            $data = [
                'userID' => $userID,
                'user' => $this->model->getUserDetails($userID),
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => $userID,
                'messages_stu' => $messages_stu,
                'messages' => $this->model('chatModel')->getMessages($_SESSION['user_id'], $userID),
                'messageInput' => '',
                'messageInput_err' => '',
            ];
        }

        $this->view('pages/admin/messages_stu', $data);
    }

    public function messages_com($userID = null)
    {
        // Fetch all company messages
        $messages_com = $this->model('ContactModel')->getMessagesCom();

        // If no specific user is selected, just load the messages
        if (!isset($userID)) {
            $data = [
                'messages_com' => $messages_com,
            ];
        } else {
            // Ensure session user ID exists before accessing
            if (!isset($_SESSION['user_id'])) {
                die("Unauthorized access. Please log in."); // Redirect or handle it better
            }

            // Fetch user details and chat messages
            $data = [
                'userID' => $userID,
                'user' => $this->model->getUserDetails($userID),
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => $userID,
                'messages_com' => $messages_com,
                'messages' => $this->model('chatModel')->getMessages($_SESSION['user_id'], $userID),
                'messageInput' => '',
                'messageInput_err' => '',
            ];
        }

        $this->view('pages/admin/messages_com', $data);
    }
    

    public function messages_ver($userID = null)
    {
        // Fetch all verification team messages
        $messages_ver = $this->model('ContactModel')->getMessagesVer();

        // If no specific user is selected, just load the messages
        if (!isset($userID)) {
            $data = [
                'messages_ver' => $messages_ver,
            ];
        } else {
            // Ensure session user ID exists before accessing
            if (!isset($_SESSION['user_id'])) {
                die("Unauthorized access. Please log in."); // Redirect or handle it better
            }

            // Fetch user details and chat messages
            $data = [
                'userID' => $userID,
                'user' => $this->model->getUserDetails($userID),
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => $userID,
                'messages_ver' => $messages_ver,
                'messages' => $this->model('chatModel')->getMessages($_SESSION['user_id'], $userID),
                'messageInput' => '',
                'messageInput_err' => '',
            ];
        }

        $this->view('pages/admin/messages_ver', $data);
    }
   
    // In AdminController.php
    public function fetchMessageDetails($id)
    {
        // Check if the user has the right role and permissions
        if (!isset($_SESSION['user_role'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        // Get the database connection
        $db = $this->model('ContactModel');

        // Fetch the message details by ID
        $message = $db->getMessageById($id);

        if ($message) {
            http_response_code(200);
            echo json_encode($message); // Send message as JSON
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Message not found']);
        }
        $this->view('pages/admin/messages/messageview');
        //correct this line
    }

    public function editMessage($messageId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $newMessage = $data['message'] ?? '';

            if (!empty($newMessage)) {
                $chatModel = $this->model('chatModel');
                $senderId = $_SESSION['user_id']; // Get the sender's ID from session

                if ($chatModel->editMessage($messageId, $newMessage, $senderId)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to edit message.']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Message cannot be empty.']);
            }
        } else {
            http_response_code(405);
        }
    }

    public function deleteMessage($messageId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $senderId = $_SESSION['user_id']; // Get the sender's ID from session

            if ($this->model('chatModel')->deleteMessage($messageId, $senderId)) {
                Redirect::to(URLROOT . '/admin/user_detail');
            } else {
                die('Something went wrong while deleting the message.');
            }
        } else {
            Redirect::to(URLROOT . '/admin/user_detail');
        }
    }

    //retrieve reasons
    public function app_settings()
    {
        try {
            $data = [
                'user_activate' => $this->model('AdminModel')->getReasonsByType('user_activate')['data'],
                'user_deactivate' => $this->model('AdminModel')->getReasonsByType('user_deactivate')['data'],
                'user_reject' => $this->model('AdminModel')->getReasonsByType('user_reject')['data'],
                'job_reject' => $this->model('AdminModel')->getReasonsByType('job_reject')['data'],
                'industries' => $this->model('AdminModel')->getIndustries()['data']
            ];
            $this->view('pages/admin/app_settings', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function addReason()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get raw POST data and decode it
            $input = json_decode(file_get_contents('php://input'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
                return;
            }

            // Sanitize inputs
            $reasonName = trim(filter_var($input['reasonName'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $reason = trim(filter_var($input['reason'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $reasonType = trim(filter_var($input['reasonType'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            // Validate inputs
            if (empty($reasonName) || empty($reasonType)) {
                echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
                return;
            }

            try {
                // Add reason to the database
                if ($this->model('AdminModel')->addReason($reasonName, $reason, $reasonType)) {
                    echo json_encode(['success' => true, 'message' => 'Reason added successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to add reason.']);
                }
            } catch (Exception $e) {
                error_log('Error adding reason: ' . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'An error occurred while adding the reason.']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
        }
        exit;
    }

    public function updateReason()
    {
        // Set proper header first
        header('Content-Type: application/json');

        try {
            // Get input data
            $input = json_decode(file_get_contents('php://input'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON input');
            }

            // Validate required fields
            if (empty($input['reasonID']) || empty($input['reasonName'])) {
                throw new Exception('Missing required fields');
            }

            // Sanitize data
            $reasonID = filter_var($input['reasonID'], FILTER_SANITIZE_NUMBER_INT);
            $reasonName = filter_var($input['reasonName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $reason = filter_var($input['reason'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update in model
            $success = $this->model('AdminModel')->updateReason($reasonID, $reasonName, $reason);

            if ($success) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Reason updated successfully'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to update reason'
                ]);
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }

    public function deleteReason()
    {
        header('Content-Type: application/json');

        try {
            // Get JSON input
            $input = json_decode(file_get_contents('php://input'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON input');
            }

            // Validate reasonID
            if (empty($input['reasonID'])) {
                throw new Exception('Invalid reason ID');
            }

            $reasonID = filter_var($input['reasonID'], FILTER_SANITIZE_NUMBER_INT);

            // Delete in model
            $success = $this->model('AdminModel')->deleteReason($reasonID);

            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Reason deleted successfully' : 'Failed to delete reason'
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }

    public function addIndustry()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
            exit;
        }

        $industryName = trim(filter_var($input['industryName'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        if (empty($industryName)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Please enter an industry name.']);
            exit;
        }

        try {
            if ($this->model('AdminModel')->addIndustry($industryName)) {
                http_response_code(201);
                echo json_encode(['success' => true, 'message' => 'Industry added successfully.']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Failed to add industry.']);
            }
        } catch (Exception $e) {
            error_log('Error adding industry: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'An error occurred while adding the industry.']);
        }

        exit;
    }

    // Update industry
    public function updateIndustry()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
            exit;
        }

        $industryID = filter_var($input['industryID'], FILTER_SANITIZE_NUMBER_INT);
        $industryName = trim(filter_var($input['industryName'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        if (empty($industryID) || empty($industryName)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
            exit;
        }

        try {
            if ($this->model('AdminModel')->updateIndustry($industryID, $industryName)) {
                http_response_code(200);
                echo json_encode(['success' => true, 'message' => 'Industry updated successfully.']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Failed to update industry.']);
            }
        } catch (Exception $e) {
            error_log('Error updating industry: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'An error occurred while updating the industry.']);
        }

        exit;
    }

    // Delete industry
    public function deleteIndustry()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
            exit;
        }

        $industryID = filter_var($input['industryID'], FILTER_SANITIZE_NUMBER_INT);

        if (empty($industryID)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid industry ID']);
            exit;
        }

        try {
            if ($this->model('AdminModel')->deleteIndustry($industryID)) {
                http_response_code(200);
                echo json_encode(['success' => true, 'message' => 'Industry deleted successfully.']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Failed to delete industry.']);
            }
        } catch (Exception $e) {
            error_log('Error deleting industry: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'An error occurred while deleting the industry.']);
        }

        exit;
    }
}
