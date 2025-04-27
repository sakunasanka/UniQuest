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
            'verifiedBy' => $_SESSION['user_id'],
            'verifiedDate' => date('Y-m-d H:i:s'),

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
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            $students = $this->model->getVerifiedUsersByRole('Student', $page, $limit, $sort, $order, $search);
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
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';
            // $page = $_GET['page'] ?? 1;
            // $limit = $_GET['limit'] ?? 2;
            // $sort = $_GET['sort'] ?? 'UserID';
            // $order = $_GET['order'] ?? 'ASC';

            $companies = $this->model->getVerifiedUsersByRole('Company', $page, $limit, $sort, $order, $search);
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
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            $vtMembers = $this->model->getVerifiedUsersByRole('VT-Member', $page, $limit, $sort, $order, $search);
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

    public function all_complaints($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'ComplainedDate';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            $complaints_job = $this->model('ComplaintModel')->getAllComplaints($page, $limit, $sort, $order, $search);

            $data = [
                'complaints_job' => $complaints_job['data'],
                'currentPage' => $complaints_job['currentPage'],
                'rowsPerPage' => $complaints_job['limit'],
                'totalRows' => $complaints_job['totalRows'],
                'totalPages' => $complaints_job['totalPages'],
                'isLastPage' => $complaints_job['isLastPage'] ? 'yes' : 'no',
            ];

            $this->view('pages/admin/all_complaints', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function job_complaints($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'LastComplainedDate';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            $complaints_job = $this->model('ComplaintModel')->getComplaintsGroupedByJob($page, $limit, $sort, $order, $search);

            $data = [
                'complaints_job' => $complaints_job['data'],
                'currentPage' => $complaints_job['currentPage'],
                'rowsPerPage' => $complaints_job['limit'],
                'totalRows' => $complaints_job['totalRows'],
                'totalPages' => $complaints_job['totalPages'],
                'isLastPage' => $complaints_job['isLastPage'] ? 'yes' : 'no',
            ];

            $this->view('pages/admin/job_complaints', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function company_complaints($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'LastComplainedDate';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            $complaints_com = $this->model('ComplaintModel')->getComplaintsGroupedByCompany($page, $limit, $sort, $order, $search);

            $data = [
                'complaints_com' => $complaints_com['data'],
                'currentPage' => $complaints_com['currentPage'],
                'rowsPerPage' => $complaints_com['limit'],
                'totalRows' => $complaints_com['totalRows'],
                'totalPages' => $complaints_com['totalPages'],
                'isLastPage' => $complaints_com['isLastPage'] ? 'yes' : 'no',
            ];

            $this->view('pages/admin/company_complaints', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    protected function prepareComplaintData($complaintID)
    {
        $complaint = $this->model('ComplaintModel')->getComplaintDetails($complaintID);
        $complaintStatus = $complaint->Status;
        //load reasons with respect to status
        switch ($complaintStatus) {
            case 'Pending':
                $reasons = [
                    'start' => $this->model('AdminModel')->getReasonsByType('complaint_in_review')['data']
                ];
                break;
            case 'In-Review':
                $reasons = [
                    'resolve' => $this->model('AdminModel')->getReasonsByType('complaint_resolved')['data'],
                    'reject' => $this->model('AdminModel')->getReasonsByType('complaint_rejected')['data']
                ];
                break;
            default:
                $reasons = null; // Handle unexpected status
        }

        // get last complaint log
        $lastComplaintLog = $this->model('ComplaintModel')->getLastComplaintLog($complaintID);

        $data = [
            'complaint' => $complaint,
            'reasons' => $reasons ?? [],
            'reasonID_err' => '',
            'actionDetail' => $lastComplaintLog,
        ];

        // Check for session error
        if (isset($_SESSION['reasonID_err'])) {
            $data['reasonID_err'] = $_SESSION['reasonID_err'];
            unset($_SESSION['reasonID_err']);
        }

        return $data;
    }

    public function complaint_detail($complaintID)
    {
        $data = $this->prepareComplaintData($complaintID);
        $this->view('pages/admin/complaint_detail', $data);
    }

    public function complaint_company($company, $queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'ComplainedDate';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            $complaints = $this->model('ComplaintModel')->getComplaintsByCompany($company, $page, $limit, $sort, $order, $search);

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

    public function complaint_job($company, $queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'ComplainedDate';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            $complaints = $this->model('ComplaintModel')->getComplaintsByJob($company, $page, $limit, $sort, $order, $search);

            $data = [
                'complaints' => $complaints['data'],
                'currentPage' => $complaints['currentPage'],
                'rowsPerPage' => $complaints['limit'],
                'totalRows' => $complaints['totalRows'],
                'totalPages' => $complaints['totalPages'],
                'isLastPage' => $complaints['isLastPage'] ? 'yes' : 'no',
            ];

            $this->view('pages/admin/complaint_job', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function start_review($complaintID)
    {
        try {
            $reason = $this->model('AdminModel')->getReasonByType('complaint_in_review');
            $data = [
                'complaintID' => $complaintID,
                'note' => '',
                'reasonID' => $reason->ReasonID,
                'statusAfter' => 'In-Review',
                'reasonID_err' => ''
            ];
            //add complaint log
            $this->model('ComplaintModel')->addComplaintLog($data);
            //update complaint status to in-review
            $this->model('ComplaintModel')->startReview($complaintID);
            Redirect::to(URLROOT . '/admin/complaint_detail/' . $complaintID);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function handle_complaint_action($complaintID)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'complaintID' => $complaintID,
                'note' => trim($_POST['note']) ?? null,
                'reasonID' => ($_POST['reasonID']) ?? null,
                'jobID' => ($_POST['jobID']) ?? null,
                'jobTitle' => ($_POST['jobTitle']) ?? null,
                'companyID' => ($_POST['companyID']) ?? null,
                'companyEmail' => trim($_POST['companyEmail']) ?? null,
                'studentID' => ($_POST['studentID']) ?? null,
                'deactivate_job' => isset($_POST['deactivate_job']) ? 1 : 0,
                'deactivate_company' => isset($_POST['deactivate_company']) ? 1 : 0,
                'send_warning' => isset($_POST['send_warning']) ? 1 : 0,
                'restrict_posting' => isset($_POST['restrict_posting']) ? 1 : 0,
                'statusAfter' => '',
                'reasonID_err' => ''
            ];

            if (isset($_POST['resolve_submit'])) {
                // call resolve_complaint method
                $this->resolve_complaint($data);
            } elseif (isset($_POST['reject_submit'])) {
                // call reject_complaint method
                $this->reject_complaint($data);
            } else {
                Redirect::to(URLROOT . '/admin/complaint_detail/' . $complaintID);
            }
        } else {
            Redirect::to(URLROOT . '/admin/complaint_detail/' . $complaintID);
        }
    }

    protected function reject_complaint($data)
    {
        try {
            //check if reasonID is not empty
            if (!empty($data['reasonID'])) {
                //set statusAfter to rejected
                $data['statusAfter'] = 'Rejected';
                //add complaint log
                $this->model('ComplaintModel')->addComplaintLog($data);
                //update complaint status to in-review
                $this->model('ComplaintModel')->rejectComplaint($data['complaintID']);
                Redirect::to(URLROOT . '/admin/complaint_detail/' . $data['complaintID']);
            } else {
                //set error message for reasonID
                $_SESSION['reasonID_err'] = 'Please select a reason for rejecting the complaint';
                // Redirect to the complaint detail page with error message
                Redirect::to(URLROOT . '/admin/complaint_detail/' . $data['complaintID']);
            }
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    protected function resolve_complaint($data)
    {
        try {
            //check if reasonID is not empty
            if (!empty($data['reasonID'])) {
                //check secondary actions are selected
                if ($data['deactivate_job'] == 1) {
                    $this->model('jobModel')->deactivateJob($data['jobID']);
                    //todo : get correct reason by type
                    //add job log
                }
                if ($data['deactivate_company'] == 1) {
                    $reason = $this->model('AdminModel')->getReasonByID($data['reasonID'])->Reason; //todo : get correct reason by type
                    $this->model->deactivateAccount($data['companyID']);
                    $this->model('AdminModel')->addUserAccountLog($data['companyID'], 'Deactivate', $data['reasonID']);
                    notifyComAboutJobDeactivation($data['companyID'], $reason, $data['jobID'], $data['jobTitle']);
                    MailHelper::sendEmailAccountDeactivatedByAdmin($data['companyEmail'], $reason);
                }
                if ($data['send_warning'] == 1) {
                    sendWarningToCompany($data['companyID'], $data['jobID'], $data['jobTitle']);
                }
                if ($data['restrict_posting'] == 1) {
                    $this->model('AdminModel')->restrictPosting($data['companyID']);
                    $notificationDate = date('Y-m-d H:i:s', strtotime('+7 days'));
                    notifyComAboutCanPostAgain($data['companyID'], $notificationDate);
                }
                //set statusAfter to resolved
                $data['statusAfter'] = 'Resolved';
                //add complaint log
                $this->model('ComplaintModel')->addComplaintLog($data);
                //update complaint status to resolved
                $this->model('ComplaintModel')->resolveComplaint($data['complaintID']);
                Redirect::to(URLROOT . '/admin/complaint_detail/' . $data['complaintID']);
            } else {
                //set error message for reasonID
                $_SESSION['reasonID_err'] = 'Please select a reason for resolving the complaint';
                // Redirect to the complaint detail page with error message
                Redirect::to(URLROOT . '/admin/complaint_detail/' . $data['complaintID']);
            }
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
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            $ptjobs = $this->model('jobModel')->getVerifiedJobsByCategory('Part-time', $page, $limit, $sort, $order, $search);
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
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            $interns = $this->model('jobModel')->getVerifiedJobsByCategory('Internship', $page, $limit, $sort, $order, $search);
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
            $userRole = $this->model->getUserRoleByID($userID)->Role;

            // Use the submitted topic if provided, otherwise use the last topic
            $submittedTopic = trim($_POST['topic'] ?? '');

            // Fetch email logic
            $email = null; // Default to null

            // 1. Check if the previous message has an email
            if (!empty($previousMessage) && !empty($previousMessage->user_email)) {
                $email = $previousMessage->user_email;
            }
            // 2. If previous message email is null, fetch email from the user table
            else {
                $userDetails = $this->model->getUserDetails($userID);
                $email = $userDetails['Email'] ?? null; // Use email if available, else null
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
                    if ($_SESSION['user_role'] == 'Admin') {
                        notifyMessageFromAdmin($data['receiver_id'], $data['messageInput']);
                        if ($userRole == 'Student') {
                            Redirect::to(URLROOT . '/admin/messages_stu');
                        } elseif ($userRole == 'Company') {
                            Redirect::to(URLROOT . '/admin/messages_com');
                        } elseif ($userRole == 'VT-Member') {
                            Redirect::to(URLROOT . '/admin/messages_ver');
                        } else {
                            die('Something went wrong');
                        }
                    }
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

    public function markMessageRead()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $messageId = $_POST['message_id'] ?? null;

            if ($messageId) {
                $this->model('chatModel')->updateReadStatus($messageId);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Invalid message ID']);
            }
        }
    }

    public function user_ver_pending($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'UserID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
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
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
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
                $email = $userDetails['Email'] ?? null; // Use email if available, else null
            }

            $data = [
                'userID' => $userID,
                'email' => $email,
                'user' => $this->model->getUserDetails($userID),
                'acc_log' => $this->model('AdminModel')->getLastAccountLogReason($userID, 'Deactivate'),
                'verifyDetails' => $this->model('AdminModel')->getLastVerificationLog($userID),
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
                'acc_log' => $this->model('AdminModel')->getLastAccountLogReason($userID),
                'verifyDetails' => $this->model('AdminModel')->getLastVerificationLog($userID),
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
                notifyUserApproval($userID);
            } elseif ($user['Role'] == 'Student') {
                $name = $user['FirstName'];
                MailHelper::sendEmailStuAccountApproved($email, $name);
                notifyUserApproval($userID);
            }
            //get reasonID by type
            $reasonID = $this->model('AdminModel')->getReasonByType('user_approve')->ReasonID;
            //add verificationlogs
            $this->model('AdminModel')->addVerificationLog($userID, 'User', 'Approve', $reasonID);
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
                notifyUserRejection($userID, $reason);
            } elseif ($user['Role'] == 'Student') {
                $name = $user['FirstName'];
                MailHelper::sendEmailAccountRejected($email, $name, $reason);
                notifyUserRejection($userID, $reason);
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
            notifyAccountActivation($userID);
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
            notifyAccountDeactivation($userID, $reason);
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
            $rejectReasons = $this->model('AdminModel')->getReasonsByType('job_reject');
            $verifyDetails = $this->model('AdminModel')->getLastVerificationLog($jobID);
            $data = [
                'job' => $job,
                'rejectReasons' => $rejectReasons['data'],
                'verifyDetails' => $verifyDetails,
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
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
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
            $this->view('pages/admin/job_ver_pending', $data);
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
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'PublishDate';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
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
            $this->view('pages/admin/job_ver_not', $data);
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

            // Notify students about the new job
            $students = $this->model->getStudentIds();
            foreach ($students as $student) {
                notifyPostPublishStu($student->StudentID, $jobID, $title, $publishDate);
            }
            //get reasonID by type
            $reasonID = $this->model('AdminModel')->getReasonByType('job_approve')->ReasonID;
            //add verificationlogs
            $this->model('AdminModel')->addVerificationLog($jobID, 'Job', 'Approve', $reasonID);
            Redirect::to(URLROOT . '/admin/job_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function job_ver_reject($jobID, $queryParam = [])
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
            $mostPopularJob = $this->model('M_applicationFields')->getMostAppliedJob();
            $mostPopularCompany = $this->model('RateAndReviewModel')->getMostReviewedCompany();
            $revenueOfMonth = $this->model('AdminModel')->getRevenueOfMonth();

            $data = [
                'studentCount' => $studentCount,
                'companyCount' => $companyCount,
                'activeJobCount' => $activeJobCount,
                'pendingUserCount' => $pendingUserCount,
                'pendingJobCount' => $pendingJobCount,
                'pendingComplaintCount' => $pendingComplaintCount,
                'mostPopularJob' => $mostPopularJob,
                'mostPopularCompany' => $mostPopularCompany,
                'revenueOfMonth' => $revenueOfMonth,
            ];

            $this->view('pages/admin/adminDash', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function reports()
    {
        try {
            // // System Overview Reports
            // $systemHealthMetrics = $this->model('reportModel')->getSystemHealthData();
            // $revenueSubscriptionStats = $this->model('reportModel')->getRevenueData();
            // // $executiveSummary = $this->model('reportModel')->getExecutiveSummaryData();

            // // User Activity Reports
            // $userGrowthTrends = $this->model('reportModel')->getUserGrowthData();
            // // $userActivityByRole = $this->model('reportModel')->getUserActivityByRoleData();
            // $verificationTeamPerformance = $this->model('reportModel')->getVerificationPerformanceData();

            // // Job Market Reports
            // $jobPostingPerformance = $this->model('reportModel')->getJobPerformanceData();
            // // $jobActivityByCategory = $this->model('reportModel')->getJobActivityByCategoryData();
            // $studentPlacementStats = $this->model('reportModel')->getStudentPlacementData();

            // // Complaint & Engagement Reports
            // $complaintResolutionMetrics = $this->model('reportModel')->getComplaintData();
            // $userEngagementBookmarks = $this->model('reportModel')->getBookmarkAnalysisData();

            // $data = [
            //     // System Overview
            //     'systemHealth' => $systemHealthMetrics,
            //     'revenueStats' => $revenueSubscriptionStats,
            //     // 'executiveSummary' => $executiveSummary,

            //     // User Analytics
            //     'userGrowth' => $userGrowthTrends,
            //     // 'userActivityByType' => $userActivityByRole,
            //     'verificationPerformance' => $verificationTeamPerformance,

            //     // Job Analytics
            //     'jobPerformance' => $jobPostingPerformance,
            //     // 'jobsByCategory' => $jobActivityByCategory,
            //     'placementStats' => $studentPlacementStats,

            //     // Complaint & Engagement
            //     'complaintResolution' => $complaintResolutionMetrics,
            //     'bookmarkAnalysis' => $userEngagementBookmarks
            // ];

            $this->view('pages/admin/reports');
        } catch (Exception $e) {
            // TODO: Implement proper error handling
            error_log("Reports Error: " . $e->getMessage());
            $this->view('pages/error', ['message' => 'Failed to generate reports. Please try again later.']);
        }
    }

    // View specific report
    public function viewReport($reportName)
    {
        try {
            $model = $this->model('reportModel');
            $method = 'get' . ucfirst($reportName) . 'Data';

            if (!method_exists($model, $method)) {
                throw new Exception("Report not found");
            }

            // Get time period filter from query params
            $timePeriod = $_GET['timePeriod'] ?? 'all';
            $startDate = $_GET['startDate'] ?? null;
            $endDate = $_GET['endDate'] ?? null;

            // Calculate dates based on time period
            $dateRange = $this->calculateDateRange($timePeriod, $startDate, $endDate);

            $data = [
                'reportData' => $model->$method($dateRange['startDate'], $dateRange['endDate']),
                'reportName' => ucwords(str_replace('-', ' ', $reportName)),
                'reportSlug' => $reportName,
                'timePeriod' => $timePeriod,
                'startDate' => $dateRange['startDate'],
                'endDate' => $dateRange['endDate']
            ];

            $this->view('pages/admin/report_view', $data);
        } catch (Exception $e) {
            $this->view('pages/error', ['message' => $e->getMessage()]);
        }
    }

    private function calculateDateRange($timePeriod, $customStart = null, $customEnd = null)
    {
        $endDate = $customEnd ? new DateTime($customEnd) : new DateTime();
        $startDate = new DateTime();

        switch ($timePeriod) {
            case '1month':
                $startDate->modify('-1 month');
                break;
            case '3months':
                $startDate->modify('-3 months');
                break;
            case '6months':
                $startDate->modify('-6 months');
                break;
            case '1year':
                $startDate->modify('-1 year');
                break;
            case 'custom':
                $startDate = $customStart ? new DateTime($customStart) : $startDate;
                break;
            case 'all':
            default:
                $startDate = null; // No date filtering
                break;
        }

        return [
            'startDate' => $startDate ? $startDate->format('Y-m-d') : null,
            'endDate' => $endDate->format('Y-m-d')
        ];
    }

    // Download report
    public function downloadReport($reportName)
    {
        try {
            $model = $this->model('ReportModel');
            $method = 'get' . ucfirst($reportName) . 'Data';

            if (!method_exists($model, $method)) {
                throw new Exception("Report not found");
            }

            $data = $model->$method();
            $filename = $reportName . '_report_' . date('Y-m-d') . '.csv';

            $this->generateCSV($data, $filename);
        } catch (Exception $e) {
            header('Content-Type: text/plain');
            echo "Error generating report: " . $e->getMessage();
        }
    }

    private function generateCSV($data, $filename)
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Write headers
        if (!empty($data)) {
            fputcsv($output, array_keys((array)$data[0]));
        }

        // Write data
        foreach ($data as $row) {
            fputcsv($output, (array)$row);
        }

        fclose($output);
        exit;
    }

    public function downloadPdf($reportSlug)
    {
        try {
            // Load report data
            $model = $this->model('ReportModel');
            $method = 'get' . ucfirst($reportSlug) . 'Data';

            if (!method_exists($model, $method)) {
                throw new Exception("Report not found");
            }

            // Get time period filter from query params
            $timePeriod = $_GET['timePeriod'] ?? 'all';
            $startDate = $_GET['startDate'] ?? null;
            $endDate = $_GET['endDate'] ?? null;

            // Calculate dates based on time period
            $dateRange = $this->calculateDateRange($timePeriod, $startDate, $endDate);

            // Get filtered report data
            $reportData = $model->$method($dateRange['startDate'], $dateRange['endDate']);
            $reportName = ucwords(str_replace('-', ' ', $reportSlug));

            // Prepare data for PDF
            $data = [
                'reportName' => $reportName,
                'reportData' => $reportData,
                'timePeriod' => $timePeriod,
                'startDate' => $dateRange['startDate'],
                'endDate' => $dateRange['endDate'],
                'reportGeneratedAt' => date('F j, Y \a\t H:i:s')
            ];

            // Render the view into a string
            ob_start();
            extract($data);
            require TEMPLATEROOT . '/pdf/report_view.php'; // Path to your PDF template
            $html = ob_get_clean();

            // Generate PDF filename with time period info
            $filename = "{$reportName}_Report";
            if ($timePeriod !== 'all') {
                $filename .= "_" . str_replace(' ', '', ucfirst($timePeriod));
            }
            if ($timePeriod === 'custom' && $startDate && $endDate) {
                $filename .= "_" . date('Y-m-d', strtotime($startDate)) . "_to_" . date('Y-m-d', strtotime($endDate));
            }
            $filename .= "_" . date('Y-m-d');

            // Generate the PDF
            PDFHelper::generate($html, $filename);
        } catch (Exception $e) {
            error_log("PDF Generation Error: " . $e->getMessage());
            flash('pdf_error', 'Failed to generate PDF: ' . $e->getMessage(), 'alert alert-danger');
            redirect('admin/reports');
        }
    }

    public function jobPost()
    {
        $this->view('pages/admin/jobPost');
    }
    // Add this method to your Admin controller class

    public function analytics()
    {
        try {
            $months = 5; // Number of months to show in charts

            $registrationStats = $this->model('AdminModel')->getRegistrationStats($months);
            $jobStats = $this->model('AdminModel')->getJobListingStats($months);
            $revenueStats = $this->model('AdminModel')->getRevenueStats($months);
            $loginStats = $this->model('AdminModel')->getLoginStats();
            $activeCounts = $this->model('AdminModel')->getActiveCounts();

            $data = [
                'registrationStats' => $registrationStats,
                'jobStats' => $jobStats,
                'revenueStats' => $revenueStats,
                'loginStats' => $loginStats,
                'activeCounts' => $activeCounts
            ];

            $this->view('pages/admin/analytics', $data);
        } catch (Exception $e) {
            // Handle error appropriately
            error_log("Error in analytics: " . $e->getMessage());
            $this->view('pages/admin/analytics', []);
        }
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
        // Check if a user ID was submitted via POST
        if (isset($_POST['selectedUserID'])) {
            $userID = $_POST['selectedUserID'];
        }

        // Fetch all student messages
        $messages_stu = $this->model('ContactModel')->getMessagesStu();

        // Initialize data with the message list
        $data = [
            'messages_stu' => $messages_stu,
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

        $this->view('pages/admin/messages_stu', $data);
    }

    public function messages_com($userID = null)
    {
        // Check if a user ID was submitted via POST
        if (isset($_POST['selectedUserID'])) {
            $userID = $_POST['selectedUserID'];
        }

        // Fetch all student messages
        $messages_com = $this->model('ContactModel')->getMessagesCom();

        // Initialize data with the message list
        $data = [
            'messages_com' => $messages_com,
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

        $this->view('pages/admin/messages_com', $data);
    }


    public function messages_ver($userID = null)
    {
        // Check if a user ID was submitted via POST
        if (isset($_POST['selectedUserID'])) {
            $userID = $_POST['selectedUserID'];
        }

        // Fetch all student messages
        $messages_ver = $this->model('ContactModel')->getMessagesVer();

        // Initialize data with the message list
        $data = [
            'messages_ver' => $messages_ver,
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
                'job_activate' => $this->model('AdminModel')->getReasonsByType('job_activate')['data'],
                'job_deactivate' => $this->model('AdminModel')->getReasonsByType('job_deactivate')['data'],
                'complaint_rejected' => $this->model('AdminModel')->getReasonsByType('complaint_rejected')['data'],
                'complaint_resolved' => $this->model('AdminModel')->getReasonsByType('complaint_resolved')['data'],
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

    public function markAllRead()
    {

        $this->model('NotificationModel')->markAllAsRead($_SESSION['user_id']);
        $previousURL = $_SERVER['HTTP_REFERER'] ?? URLROOT . '/admin/dashboard';
        Redirect::to($previousURL);
    }

    public function markAsRead($notificationId)
    {
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

    public function getRecentNotifications()
    {
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

    public function getAllNotifications()
    {

        $notifications = $this->model('NotificationModel')->getAllNotifications($_SESSION['user_id']);
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
