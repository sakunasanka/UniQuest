<?php
class Service_provider extends Controller
{
    private $model;

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

            $data = [
                'companyName' => ucfirst(trim($_POST['companyName'])),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'contactNo' => trim($_POST['contactNo']),
                'streetNo' => trim($_POST['streetNo']),
                'addressLine1' => ucfirst(trim($_POST['addressLine1'])),
                'addressLine2' => ucfirst(trim($_POST['addressLine2'])),
                'city' => ucfirst(trim($_POST['city'])),
                'description' => '',
                'companyLogo' => '',
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
                'companyLogo_err' => ''
            ];

            // Validate email
            $data['email_err'] = Validator::isEmpty($data['email']) ? 'Please enter email' : 
                (!Validator::isValidEmail($data['email']) ? 'Please enter a valid email' : 
                ($this->model->findUserByEmail($data['email']) ? 'Email is already taken' : ''));

            // Validate password
            $data['password_err'] = Validator::isEmpty($data['password']) ? 'Please enter password' : 
                (!Validator::isValidPassword($data['password']) ? 'Password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, and one number' : '');

            // Validate confirm password
            $data['confirm_password_err'] = Validator::isEmpty($data['confirm_password']) ? 'Please confirm password' : 
                (!Validator::isValidConfirmPassword($data['password'], $data['confirm_password']) ? 'Passwords do not match' : '');

            // Validate company name
            $data['companyName_err'] = Validator::isEmpty($data['companyName']) ? 'Please enter company name' : 
                (!Validator::isValidName($data['companyName']) ? 'Company name can only contain letters and spaces' : '');

            // Validate contact number
            $data['contactNo_err'] = Validator::isEmpty($data['contactNo']) ? 'Please enter contact number' : 
                (!Validator::isValidContactNo($data['contactNo']) ? 'Please enter a valid contact number' : '');

            // Validate street number
            $data['streetNo_err'] = Validator::isEmpty($data['streetNo']) ? 'Please enter street number' : '';

            // Validate address line 1
            $data['addressLine1_err'] = Validator::isEmpty($data['addressLine1']) ? 'Please enter address line 1' : '';

            // Validate city
            $data['city_err'] = Validator::isEmpty($data['city']) ? 'Please enter city' : '';

            //validate role
            $data['role_err'] = Validator::isEmpty($data['role']) ? 'Please enter role' : 
                (!Validator::isValidRole($data['role']) ? 'Invalid role' : '');

            //validate status
            $data['status_err'] = Validator::isEmpty($data['status']) ? 'Please enter status' : 
                (!Validator::isValidStatus($data['status']) ? 'Invalid status' : '');

            // Validate description

            // Validate profile picture

            // Check if there are no errors
            if (empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['companyName_err']) && empty($data['contactNo_err']) && empty($data['streetNo_err']) && empty($data['addressLine1_err']) && empty($data['city_err']) && empty($data['role_err']) && empty($data['status_err'])) {
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user
                if ($this->model->companyRegister($data)) {
                    // Redirect to login page
                    Redirect::to('/login');
                } else {
                    die('Something went wrong');//TODO: Handle this
                }
            } else {
                // Load view with errors
                $this->view('pages/service_provider/register', $data);
            }

        } else {
            $data = [
                'companyName' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'contactNo' => '',
                'streetNo' => '',
                'addressLine1' => '',
                'addressLine2' => '',
                'city' => '',
                'description' => '',
                'companyLogo' => '',

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
                'companyLogo_err' => ''
            ];

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
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            // Validate email
            $data['email_err'] = Validator::isEmpty($data['email']) ? 'Please enter email' : 
                (!Validator::isValidEmail($data['email']) ? 'Please enter a valid email' : 
                (!$this->model->findUserByEmail($data['email']) ? 'No user found' : ''));

            // Validate password
            $data['password_err'] = Validator::isEmpty($data['password']) ? 'Please enter password' : '';

            // Check if there are no errors
            if (empty($data['email_err']) && empty($data['password_err'])) {
                // Check for user
                $loggedInUser = $this->model->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    // Create session
                    die('Logged in');//TODO: Handle this
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('pages/service_provider/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('pages/service_provider/login', $data);
            }

        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            // Load view
            $this->view('pages/service_provider/login', $data);
        }
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