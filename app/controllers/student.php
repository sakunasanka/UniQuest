<?php
class Student extends Controller
{
    private $model;

    private function prepareData($post = [], $files = [])
    {
        return [
            'firstName' => ucfirst(trim($post['firstName'] ?? '')),
            'lastName' => ucfirst(trim($post['lastName'] ?? '')),
            'email' => trim($post['email'] ?? ''),
            'password' => trim($post['password'] ?? ''),
            'confirm_password' => trim($post['confirm_password'] ?? ''),
            'contactNo' => trim($post['contactNo'] ?? ''),
            'streetNo' => trim($post['streetNo'] ?? ''),
            'addressLine1' => ucfirst(trim($post['addressLine1'] ?? '')),
            'addressLine2' => ucfirst(trim($post['addressLine2'] ?? '')),
            'city' => ucfirst(trim($post['city'] ?? '')),
            'gender' => ucfirst(trim($post['gender'] ?? '')),
            'dob' => trim($post['dob'] ?? ''),
            'profilePic' => $files['profilePic'] ?? '',
            'nicNo' => trim($post['nicNo'] ?? ''),
            'nicCopy' => $files['nicCopy'] ?? '',
            'cv' => $files['cv'] ?? '',
            'university' => ucfirst(trim($post['university'] ?? '')),
            'universityID' => trim($post['universityID'] ?? ''),
            'universityIDCopy' => $files['universityIDCopy'] ?? '',
            'terms' => trim($post['terms'] ?? ''),
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
            'nicNo_err' => '',
            'profilePic_err' => '',
            'nicCopy_err' => '',
            'cv_err' => '',
            'university_err' => '',
            'universityID_err' => '',
            'universityIDCopy_err' => '',
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

            // Init data
            $data = $this->prepareData($_POST, $_FILES);

            //check email is already registered
            if ($this->model->findUserByEmail($data['email'])) {
                $data['email_err'] = 'Email is already registered';
            }

            //vallidate input data
            $validationResponse = Validator::isValidRegistrationData($data);
            if (!$validationResponse['is_valid']) {
                $data = array_merge($data, $validationResponse['error']);
            }

            //vallidate files
            $fileValidationResponse = FileUploadHelper::validateFiles([
                'profilePic' => ['file' => $data['profilePic'],'allowedExtensions' => FileUploadHelper::ALLOWED_IMAGE_EXTENSIONS],
                'nicCopy' => ['file' => $data['nicCopy'],'allowedExtensions' => FileUploadHelper::ALLOWED_DOC_EXTENSIONS],
                'cv' => ['file' => $data['cv'],'allowedExtensions' => FileUploadHelper::ALLOWED_DOC_EXTENSIONS],
                'universityIDCopy' => ['file' => $data['universityIDCopy'],'allowedExtensions' => FileUploadHelper::ALLOWED_DOC_EXTENSIONS]
            ]);

            if (!$fileValidationResponse['is_valid']) {
                $data = array_merge($data, $fileValidationResponse['error']);
            }

            //check if there are no validation errors
            if (empty($data['firstName_err']) && empty($data['lastName_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['contactNo_err']) && empty($data['streetNo_err']) && empty($data['addressLine1_err']) && empty($data['city_err']) && empty($data['gender_err']) && empty($data['dob_err']) && empty($data['nicNo_err']) && empty($data['university_err']) && empty($data['universityID_err']) && empty($data['role_err']) && empty($data['status_err']) && empty($data['profilePic_err']) && empty($data['nicCopy_err']) && empty($data['cv_err']) && empty($data['universityIDCopy_err'])) {
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                //upload each file
                $uploadedFilesResponse = FileUploadHelper::uploadFiles([
                    'profilePic' => ['file' => $data['profilePic'],'path' => PUBROOT . '/uploads/profile_pictures/student'],
                    'nicCopy' => ['file' => $data['nicCopy'],'path' => PUBROOT . '/uploads/nic_copies'],
                    'cv' => ['file' => $data['cv'],'path' => PUBROOT . '/uploads/cvs'],
                    'universityIDCopy' => ['file' => $data['universityIDCopy'],'path' => PUBROOT . '/uploads/university_id_copies']
                ]);

                //check if all files are uploaded successfully
                if ($uploadedFilesResponse['success']) {
                    //set file names to data array
                    $data = array_merge($data, $uploadedFilesResponse['file_name']);
                } else {
                    //merge data with errors
                    $data = array_merge($data, $uploadedFilesResponse['error']);
                    // Load view with errors
                    $this->view('pages/student/register', $data);
                    return;
                }

                //register student
                if ($this->model->studentRegister($data)) {
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
            // Init data
            $data = $this->prepareData();

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

    public function saveCompanies()
    {
        $this->view('pages/student/saveCompanies');
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

