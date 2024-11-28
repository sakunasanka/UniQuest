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
        // $this->dashboard();
    }

    public function students_mng()
    {
        $this->view('pages/admin/students_mng');
    }

    public function add_student()
    {
        $this->view('pages/admin/add_student');
    }

    public function company_mng()
    {
        $this->view('pages/admin/company_mng');
    }

    public function add_company()
    {
        $this->view('pages/admin/add_company');
    }

    public function verTeam_mng()
    {
        $this->view('pages/admin/verTeam_mng');
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
                $profilePicResponse = FileUploadHelper::uploadFile($data['profilePic'], PUBROOT . '/uploads/profile_pictures/vt_member');
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

    public function job_complaint()
    {
        $complaints_job = $this->model('jobModel')->getComplaintsJob();

        $data = [
            'complaints_job' => $complaints_job
        ];

        $this->view('pages/admin/job_complaint', $data);
    }

    public function company_complaint()
    {
        // $complaints_com = $this->model('jobModel')->getComplains();

        // $data = [
        //     'complaints_com' => $complaints_com
        // ];

        $this->view('pages/admin/company_complaint');
    }

    public function complaint_detail()
    {
        $this->view('pages/admin/complaint_detail');
    }

    public function ptjobs_mng()
    {
        $this->view('pages/admin/ptjobs_mng');
    }

    public function intern_mng()
    {
        $this->view('pages/admin/intern_mng');
    }

    public function stu_detail()
    {
        $this->view('pages/admin/stu_detail');
    }

    public function com_detail()
    {
        $this->view('pages/admin/com_detail');
    }

    public function user_ver_pending()
    {
        try {
            $users = $this->model->getPendingStudentsAndCompanies();
            $data = [
                'users' => $users
            ];
            $this->view('pages/admin/user_ver_pending', $data);
        } catch (Exception $e) {
            die($e->getMessage());//TODO: Handle this
        }
    }

    public function user_ver_not()
    {
        try {
            $users = $this->model->getNotVerifiedStudentsAndCompanies();
            $data = [
                'users' => $users
            ];
            $this->view('pages/admin/user_ver_not', $data);
        } catch (Exception $e) {
            die($e->getMessage());//TODO: Handle this
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
            }
        } catch (Exception $e) {
            die($e->getMessage());//TODO: Handle this
        }
    }

    public function user_ver_approve($userID)
    {
        try {
            $this->model->approveUser($userID);
            Redirect::to(URLROOT . '/admin/user_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage());//TODO: Handle this
        }
    }

    public function user_ver_reject($userID)
    {
        try {
            $this->model->rejectUser($userID);
            Redirect::to(URLROOT . '/admin/user_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage());//TODO: Handle this
        }
    }

    // public function job_ver_all()
    // {
    //     $this->view('pages/admin/job_ver_all');
    // }

    public function ptjob_detail()
    {
        $this->view('pages/admin/ptjob_detail');
    }

    public function job_ver_pending()
    {
        $this->view('pages/admin/job_ver_pending');
    }

    public function ptjob_ver_detail()
    {
        $this->view('pages/admin/ptjob_ver_detail');
    }

    public function job_ver_not()
    {
        $this->view('pages/admin/job_ver_not');
    }

    public function dashboard()
    {
        $this->view('pages/admin/adminDash');
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
        $this->view('pages/student/notification_alerts');
    }

}