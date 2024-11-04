<?php
class Service_provider extends Controller
{
    private $model;

    private function prepareData($post = [], $files = [])
    {
        return [
            'companyName' => ucfirst(trim($post['companyName'] ?? '')),
            'email' => trim($post['email'] ?? ''),
            'password' => trim($post['password'] ?? ''),
            'confirm_password' => trim($post['confirm_password'] ?? ''),
            'contactNo' => trim($post['contactNo'] ?? ''),
            'streetNo' => trim($post['streetNo'] ?? ''),
            'addressLine1' => ucfirst(trim($post['addressLine1'] ?? '')),
            'addressLine2' => ucfirst(trim($post['addressLine2'] ?? '')),
            'city' => ucfirst(trim($post['city'] ?? '')),
            'terms' => trim($post['terms'] ?? ''),
            'companyLogo' => $files['companyLogo'] ?? '',
            'companyLogoName' => '',
            'description' => '',
            'role' => 'Company',
            'date' => date('Y-m-d H:i:s'),
            'status' => 'Pending',

            'companyName_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => '',
            'contactNo_err' => '',
            'streetNo_err' => '',
            'addressLine1_err' => '',
            'addressLine2_err' => '',
            'city_err' => '',
            'description_err' => '',
            'companyLogo_err' => '',
            'terms_err' => '',
            'role_err' => '',
            'status_err' => ''
        ];
    }

    public function __construct()
    {
        // Load model
        $this->model = $this->model('userModel');
    }

    public function index()
    {
        echo 'service_provider/index';
    }

    public function contact_admin()
    {
        $this->view('pages/service_provider/contact_admin');
    }

    public function register()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = $this->prepareData($_POST, $_FILES);

            //check email is already registered
            if ($this->model->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email is already registered';
            }

            $validationResponse = Validator::isValidRegistrationData($data);
            if (!$validationResponse['is_valid']) {
                $data = array_merge($data, $validationResponse['error']);
            }

            $logoValidationResponse = FileUploadHelper::validateFile($data['companyLogo'], FileUploadHelper::ALLOWED_IMAGE_EXTENSIONS);
            if (!$logoValidationResponse['is_valid']) {
                $data['companyLogo_err'] = $logoValidationResponse['error'];
            }

            // Check if there are no errors
            if (empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['companyName_err']) && empty($data['contactNo_err']) && empty($data['streetNo_err']) && empty($data['addressLine1_err']) && empty($data['city_err']) && empty($data['role_err']) && empty($data['status_err']) && empty($data['companyLogo_err'])) {
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Upload company logo
                $companyLogoResponse = FileUploadHelper::uploadFile($data['companyLogo'], PUBROOT . '/uploads/profile_pictures/company');
                if ($companyLogoResponse['success']) {
                    $data['companyLogoName'] = $companyLogoResponse['fileName'];
                } else {
                    $data['companyLogo_err'] = $companyLogoResponse['error'];
                    $this->view('pages/service_provider/register', $data);
                    return;
                }

                // Register user
                if ($this->model->companyRegister($data)) {
                    // Redirect to login page
                    Redirect::to(URLROOT . '/service_provider/login');
                } else {
                    die('Something went wrong');//TODO: Handle this
                }
            } else {
                // Load view with errors
                $this->view('pages/service_provider/register', $data);
            }

        } else {
            $data = $this->prepareData();

            // Load view
            $this->view('pages/service_provider/register', $data);
        }
    }    

    public function dashboard()
    {
        $this->view('pages/service_provider/ser_dashboard');
    }

    public function report()
    {
        $this->view('pages/service_provider/job_report');
    }
  
    public function login()
    {
        $this->view('pages/service_provider/login');
    }

    public function ongoing_jobs()
    {
        $this->view('pages/service_provider/ongoing_jobs');
    }

    public function offered_jobs()
    {
        $this->view('pages/service_provider/offered_jobs');
    }

    public function offered_applications()
    {
        $this->view('pages/service_provider/offered_applications');
    }

    public function new_applications()
    {
        $this->view('pages/service_provider/new_applications');
    }

    public function rejected_applications()
    {
        $this->view('pages/service_provider/rejected_applications');
    }
  
    public function premium()
    {
        $this->view('pages/service_provider/premiumFeatures');
    }

    public function analytics()
    {
        $this->view('pages/service_provider/ser_analytics');
    }

    public function edit_job()
    {
        $this->view('pages/service_provider/edit_job');
    }
  
    public function view_job()
    {
        $this->view('pages/service_provider/view_job');
    }
  
    public function edit_profile()
    {
        $this->view('pages/service_provider/edit_profile');
    }
  
    public function view_profile()
    {
        $this->view('pages/service_provider/view_profile');
    }
  
}