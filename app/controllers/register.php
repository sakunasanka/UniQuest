<?php
class Register extends Controller
{
    private $model;

    public function __construct()
    {
        // Load model
        $this->model = $this->model('userModel');
    }

    private function prepareDataCompany($post = [], $files = [])
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

    private function prepareDataStudent($post = [], $files = [])
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

    public function index()
    {
        $this->view('pages/register/register');
    }

    public function company()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = $this->prepareDataCompany($_POST, $_FILES);

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
                    $data['companyLogoName'] = $companyLogoResponse['file_name'];
                } else {
                    $data['companyLogo_err'] = $companyLogoResponse['error'];
                    $this->view('pages/register/company_register', $data);
                    return;
                }

                // Register user
                if ($this->model->companyRegister($data)) {
                    //clear data array
                    $data = [];
                    // Redirect to login page
                    Redirect::to(URLROOT . '/user/login');
                } else {
                    die('Something went wrong');//TODO: Handle this
                }
            } else {
                // Load view with errors
                $this->view('pages/register/company_register', $data);
            }

        } else {
            $data = $this->prepareDataCompany();

            // Load view
            $this->view('pages/register/company_register', $data);
        }
    } 

    public function student()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = $this->prepareDataStudent($_POST, $_FILES);

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
                    $this->view('pages/register/student_register', $data);
                    return;
                }

                //register student
                if ($this->model->studentRegister($data)) {
                    //clear data array
                    $data = [];
                    // Redirect to login page
                    Redirect::to(URLROOT . '/user/login');
                } else {
                    die('Something went wrong');//TODO: Handle this
                }

            } else {
                // Load view with errors
                $this->view('pages/register/student_register', $data);
            }

        } else {
            // Init data
            $data = $this->prepareDataStudent();

            // Load view
            $this->view('pages/register/student_register', $data);
        }
    }

}

?>