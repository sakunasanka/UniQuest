<?php
class Student extends Controller
{
    private $model;

    public function __construct()
    {
        // Load model
        $this->model = $this->model('userModel');
    }

    public function index()
    {
        echo 'student/index';
    }

    public function contact_sp()
    {
        $this->view('pages/student/contact_sp');
    }

    public function contact_admin()
    {
        $this->view('pages/student/contact_admin');
    }
    
     public function students_mng()
    {
        $this->view('pages/student/students_mng');
    }

    public function searchJob()
    {
        $this->view('pages/student/searchJob');
    }

    public function searchCompany()
    {
        $this->view('pages/student/searchCompany');
    }

    public function noMatch()
    {
        $this->view('pages/student/noMatch');
    }
  
    public function login()
    {
        $this->view('pages/student/login');
    }
    public function rate_review_company()
    {
        $this->view('pages/student/rate_review_company');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST);

            $data = [
                'firstName' => ucfirst(trim($_POST['firstName'])),
                'lastName' => ucfirst(trim($_POST['lastName'])),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'contactNo' => trim($_POST['contactNo']),
                'streetNo' => trim($_POST['streetNo']),
                'addressLine1' => ucfirst(trim($_POST['addressLine1'])),
                'addressLine2' => ucfirst(trim($_POST['addressLine2'])),
                'city' => ucfirst(trim($_POST['city'])),
                'gender' => ucfirst(trim($_POST['gender'])),
                'dob' => trim($_POST['dob']),
                'profilePic' => $_FILES['profilePic'],
                'nicNo' => trim($_POST['nicNo']),
                'nicCopy' => $_FILES['nicCopy'],
                'cv' => $_FILES['cv'],
                'university' => ucfirst(trim($_POST['university'])),
                'universityID' => trim($_POST['universityID']),
                'universityIDCopy' => $_FILES['universityIDCopy'],
                'profilePicName' => '',
                'nicCopyName' => $_FILES['nicCopy']['name'],//TODO: implement this
                'cvName' => $_FILES['cv']['name'],//TODO: implement this
                'universityIDCopyName' => $_FILES['universityIDCopy']['name'],//TODO: implement this
                'role' => 'Student',
                'status' => 'Pending',
                'date' => date('Y-m-d H:i:s'),

                'firstName_err' => '',
                'lastName_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'contactNo_err' => '',
                'streetNo_err' => '',
                'addressLine1_err' => '',
                'addressLine2_err' => '',
                'city_err' => '',
                'gender_err' => '',
                'dob_err' => '',
                'profilePic_err' => '',
                'nicNo_err' => '',
                'nicCopy_err' => '',
                'cv_err' => '',
                'university_err' => '',
                'universityID_err' => '',
                'universityIDCopy_err' => ''
            ];

            // Validate First Name
            $data['firstName_err'] = Validator::isEmpty($data['firstName']) ? 'Please enter first name' : 
                (!Validator::isValidName($data['firstName']) ? 'First name can only contain letters and spaces' : '');

            // Validate Last Name
            $data['lastName_err'] = Validator::isEmpty($data['lastName']) ? 'Please enter last name' : 
                (!Validator::isValidName($data['lastName']) ? 'Last name can only contain letters and spaces' : '');

            // Validate email
            $data['email_err'] = Validator::isEmpty($data['email']) ? 'Please enter email' : 
                (!Validator::isValidEmail($data['email']) ? 'Please enter a valid email' : 
                ($this->model->findUserByEmail($data['email']) ? 'Email is already taken' : ''));

            // Validate password
            $data['password_err'] = Validator::isEmpty($data['password']) ? 'Please enter password' : 
                (!Validator::isValidPassword($data['password']) ? 'Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter and one number' : '');

            // Validate confirm password
            $data['confirm_password_err'] = Validator::isEmpty($data['confirm_password']) ? 'Please confirm password' : 
                (!Validator::isValidConfirmPassword($data['password'], $data['confirm_password']) ? 'Passwords do not match' : '');

            // Validate contact number
            $data['contactNo_err'] = Validator::isEmpty($data['contactNo']) ? 'Please enter contact number' : 
                (!Validator::isValidContactNo($data['contactNo']) ? 'Please enter a valid contact number' : '');
            
            // Validate street number
            $data['streetNo_err'] = Validator::isEmpty($data['streetNo']) ? 'Please enter street number' : '';

            // Validate address line 1
            $data['addressLine1_err'] = Validator::isEmpty($data['addressLine1']) ? 'Please enter address line 1' : '';

            // Validate city
            $data['city_err'] = Validator::isEmpty($data['city']) ? 'Please enter city' : '';

            //Validate gender
            $data['gender_err'] = Validator::isEmpty($data['gender']) ? 'Please select gender' :
                (!Validator::isValidGender($data['gender']) ? 'Please select a valid gender' : '');

            // Validate date of birth
            $data['dob_err'] = Validator::isEmpty($data['dob']) ? 'Please enter date of birth' : 
                (!Validator::isValidBirthdate($data['dob']) ? 'You must be at least 18 years old' : '');

            // Validate NIC
            $data['nicNo_err'] = Validator::isEmpty($data['nicNo']) ? 'Please enter NIC number' : 
                (!Validator::isValidNIC($data['nicNo']) ? 'Please enter a valid NIC number' : '');

            // Validate university
            $data['university_err'] = Validator::isEmpty($data['university']) ? 'Please enter university' : '';

            // Validate university ID
            $data['universityID_err'] = Validator::isEmpty($data['universityID']) ? 'Please enter university ID' : '';

            // Validate role
            $data['role_err'] = Validator::isEmpty($data['role']) ? 'Please select a role' : 
                (!Validator::isValidRole($data['role']) ? 'Please select a valid role' : '');

            // Validate status
            $data['status_err'] = Validator::isEmpty($data['status']) ? 'Please select a status' : 
                (!Validator::isValidStatus($data['status']) ? 'Please select a valid status' : '');

            // Validate and upload profile picture
            $response = ImageUploadHelper::uploadImage($data['profilePic'], PUBROOT.'/images/profile_pictures/student');
            if ($response['success']) {
                $data['profilePicName'] = $response['file_name'];
            } else {
                $data['profilePic_err'] = $response['error'];
            }

            // Validate and upload NIC copy

            // Validate and upload CV

            // Validate and upload university ID copy

            // Check for errors
            if (empty($data['firstName_err']) && empty($data['lastName_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['contactNo_err']) && empty($data['streetNo_err']) && empty($data['addressLine1_err']) && empty($data['city_err']) && empty($data['gender_err']) && empty($data['dob_err']) && empty($data['nicNo_err']) && empty($data['university_err']) && empty($data['universityID_err']) && empty($data['profilePic_err'])) {
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user
                if ($this->model->studentRegister($data)) {
                    // TODO: Flash success message
                    // Redirect to login page
                    Redirect::to(URLROOT . '/student/login');
                } else {
                    die('Something went wrong');//TODO: Handle this
                }
            } else {
                // Load view with errors
                $this->view('pages/student/register', $data);
            }

        } else {
            $data = [
                'firstName' => '',
                'lastName' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'contactNo' => '',
                'streetNo' => '',
                'addressLine1' => '',
                'addressLine2' => '',
                'city' => '',
                'gender' => '',
                'dob' => '',
                'profilePic' => '',
                'nicNo' => '',
                'nicCopy' => '',
                'cv' => '',
                'university' => '',
                'universityID' => '',
                'universityIDCopy' => '',

                'firstName_err' => '',
                'lastName_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'contactNo_err' => '',
                'streetNo_err' => '',
                'addressLine1_err' => '',
                'addressLine2_err' => '',
                'city_err' => '',
                'gender_err' => '',
                'dob_err' => '',
                'profilePic_err' => '',
                'nicNo_err' => '',
                'nicCopy_err' => '',
                'cv_err' => '',
                'university_err' => '',
                'universityID_err' => '',
                'universityIDCopy_err' => ''
            ];

            // Load view
            $this->view('pages/student/register', $data);
        }
    }

    public function make_complain()
    {
        $this->view('pages/student/make_complain');
    }

    public function all_app()
    {
        $this->view('pages/student/all_applications');
    }

    public function accepted_app()
    {
        $this->view('pages/student/accepted_applications');
    }

    public function rejected_app()
    {
        $this->view('pages/student/rejected_applications');
    }
  
    public function jobs()
    {
        $this->view('pages/student/jobs');
    }

    public function company()
    {
        $this->view('pages/student/company');
    }

    public function trendyCompany()
    {
        $this->view('pages/student/trendyCompany');
    }

    public function saveJobs()
    {
        $this->view('pages/student/saveJobs');
    }
  
    public function jobsDescription()
    {
        $this->view('pages/student/jobsDescription');
    }
    
    public function jobsApply()
    {
        $this->view('pages/student/jobsApply');
    }
}

