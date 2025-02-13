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
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 2;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'UserID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';

            $students = $this->model->getVerifiedUsersByRole('Student', $page, $limit, $sort, $order);
            $data = [
                'students' => $students['data'],
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
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 2;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'UserID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';
            // $page = $_GET['page'] ?? 1;
            // $limit = $_GET['limit'] ?? 2;
            // $sort = $_GET['sort'] ?? 'UserID';
            // $order = $_GET['order'] ?? 'ASC';

            $companies = $this->model->getVerifiedUsersByRole('Company', $page, $limit, $sort, $order);
            $data = [
                'companies' => $companies['data'],
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
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 2;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'UserID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';

            $vtMembers = $this->model->getVerifiedUsersByRole('VT-Member', $page, $limit, $sort, $order);
            $data = [
                'vtMembers' => $vtMembers['data'],
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
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 2;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'ComplaintID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';

            $complaints_job = $this->model('ComplaintModel')->getAllComplaints($page, $limit, $sort, $order);

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
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 2;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'CompanyID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';

            $complaints_com = $this->model('ComplaintModel')->getComplaintsGroupedByCompany($page, $limit, $sort, $order);

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
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 2;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'ComplaintID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';

            $complaints = $this->model('ComplaintModel')->getComplaintsByCompany($company, $page, $limit, $sort, $order);

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
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 2;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'JobID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';

            $ptjobs = $this->model('jobModel')->getVerifiedJobsByCategory('Part-time', $page, $limit, $sort, $order);
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
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 2;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'JobID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';

            $interns = $this->model('jobModel')->getVerifiedJobsByCategory('Internship', $page, $limit, $sort, $order);
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

    public function sendMessage()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize input
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Data for the chat message
            $data = [
                'sender_id' => $_SESSION['user_id'], // Admin ID from session
                'receiver_id' => trim($_POST['receiver_id'] ?? ''), // Student ID
                'message' => trim($_POST['message'] ?? ''),

                // Error handling
                'receiver_id_err' => '',
                'message_err' => ''
            ];

            // Validation checks
            if (empty($data['receiver_id'])) {
                $data['receiver_id_err'] = 'Receiver ID is required.';
            }

            if (empty($data['message'])) {
                $data['message_err'] = 'Message cannot be empty.';
            }

            // Ensure no errors before submitting
            if (empty($data['receiver_id_err']) && empty($data['message_err'])) {
                $chatModel = $this->model('ChatModel');

                // Attempt to send the message
                if ($chatModel->sendMessage($data['sender_id'], $data['receiver_id'], $data['message'], 'Admin')) {
                    flash('chat-msg', 'Message sent successfully.');
                    redirect('admin/stu_detail' . $data['receiver_id']);
                } else {
                    die('Something went wrong while sending the message.');
                }
            } else {
                // Reload view with validation errors
                $this->view('pages/admin/stu_detail', $data);
            }
        } else {
            // For a GET request, redirect back
            redirect('admin/students');
        }
    }

    public function user_ver_pending($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 2;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'UserID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';

            $users = $this->model->getPendingStudentsAndCompanies($page, $limit, $sort, $order);
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
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 2;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'UserID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';

            $users = $this->model->getNotVerifiedStudentsAndCompanies($page, $limit, $sort, $order);
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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Fetch previous messages to determine the last topic if not provided
            $previousMessage = $this->model('chatModel')->getLastMessageBetween($_SESSION['user_id'], $userID);
            $lastTopic = $previousMessage ? $previousMessage->topic : 'General Information';

            // Use the submitted topic if provided, otherwise use the last topic
            $submittedTopic = trim($_POST['topic'] ?? '');

            $data = [
                'userID' => $userID,
                'user' => $this->model->getUserDetails($userID),
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
                if ($this->model('chatModel')->sendMessage($data['sender_id'], $data['receiver_id'], $data['topic'], $data['messageInput'])) {
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
                'user' => $this->model->getUserDetails($userID),
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
            $data = [
                'user' => $user
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
            Redirect::to(URLROOT . '/admin/user_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function user_ver_reject($userID)
    {
        try {
            $this->model->rejectUser($userID);
            Redirect::to(URLROOT . '/admin/user_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function user_activate($userID, $role)
    {
        try {
            $this->model->activateAccount($userID);
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

    public function user_deactivate($userID, $role)
    {
        try {
            $this->model->deactivateAccount($userID);
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
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 2;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'JobID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';

            $jobs = $this->model('jobModel')->getPendingJobs($page, $limit, $sort, $order);
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
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 2;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'JobID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';

            $jobs = $this->model('jobModel')->getNotApprovedJobs($page, $limit, $sort, $order);
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
        $messages = $this->model('ContactModel')->getMessages();

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

    public function messages_stu()
    {
        $messages = $this->model('ContactModel')->getMessagesStu();

        // Load the view with the messages
        $data = [
            'messages' => $messages
        ];

        $this->view('pages/admin/messages_stu', $data);
    }

    public function messages_com()
    {
        $messages = $this->model('ContactModel')->getMessagesCom();

        // Load the view with the messages
        $data = [
            'messages' => $messages
        ];

        $this->view('pages/admin/messages_com', $data);
    }

    public function messages_ver()
    {
        $messages = $this->model('ContactModel')->getMessagesVer();

        // Load the view with the messages
        $data = [
            'messages' => $messages
        ];

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
            $_POST = json_decode(file_get_contents("php://input"), true);

            if ($this->model('chatModel')->canEditMessage($messageId, $_SESSION['user_id'])) {
                if ($this->model('chatModel')->editMessage($messageId, $_POST['message'])) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to edit message.']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Edit time limit expired.']);
            }
        }
    }

    public function deleteMessage($messageId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->model('chatModel')->canDeleteMessage($messageId, $_SESSION['user_id'])) {
                if ($this->model('chatModel')->deleteMessage($messageId)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Failed to delete message.']);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Delete time limit expired.']);
            }
        }
    }
}
