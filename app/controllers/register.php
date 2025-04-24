<?php
class Register extends Controller
{
    private $model;
    private $universityEmailValidator;

    public function __construct()
    {
        // Load model
        $this->model = $this->model('userModel');

        // Load UniversityEmailValidator
        $this->universityEmailValidator = new UniversityEmailValidator();
    }

    private function validateEmail(&$data)
    {
        if (Validator::isEmpty($data['email'])) {
            $data['email_err'] = 'Please enter your email address';
        } elseif (!Validator::isValidEmail($data['email'])) {
            $data['email_err'] = 'Please enter a valid email address';
        } elseif ($this->model->findUserByEmail($data['email'])) {
            $data['email_err'] = 'User found with that email address';
        }
    }

    public function getCitiesByDistrict()
    {
        try {
            // Get the district ID from POST data
            $districtID = $_POST['districtID'] ?? null;

            if (!$districtID) {
                throw new Exception('District ID is required');
            }

            // Fetch cities based on the district ID
            $cities = $this->model('AdminModel')->getCitiesByDistrict($districtID)['data'];

            if (!$cities) {
                throw new Exception('No cities found for the given district ID');
            }

            // Return JSON response
            echo json_encode([
                'success' => true,
                'cities' => $cities
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit; // Important to prevent any additional output
    }

    private function prepareDataCompany($post = [], $files = [])
    {
        // Normalize and validate URLs using the helper class
        $urlResults = URLNormalizer::validateAndNormalizeUrls([
            'website' => $post['website'] ?? '',
            'facebook' => $post['facebook'] ?? '',
            'linkedin' => $post['linkedin'] ?? '',
        ]);

        return [
            'companyName' => ucfirst(trim($post['companyName'] ?? '')),
            'email' => strtolower(trim($post['email'] ?? '')),
            'password' => trim($post['password'] ?? ''),
            'confirm_password' => trim($post['confirm_password'] ?? ''),
            'contactNo' => trim($post['contactNo'] ?? ''),
            'streetNo' => trim($post['streetNo'] ?? ''),
            'addressLine1' => ucfirst(trim($post['addressLine1'] ?? '')),
            'addressLine2' => ucfirst(trim($post['addressLine2'] ?? '')),
            'districtID' => trim($post['districtID'] ?? ''),
            'cityID' => trim($post['cityID'] ?? ''),
            'description' => ucfirst(trim($post['description'] ?? '')),
            'industryID' => trim($post['industryID'] ?? ''),
            'terms' => trim($post['terms'] ?? ''),
            'website' => $urlResults['website'] ?: trim($post['website'] ?? ''),
            'facebook' => $urlResults['facebook'] ?: trim($post['facebook'] ?? ''),
            'linkedin' => $urlResults['linkedin'] ?: trim($post['linkedin'] ?? ''),
            'companyLogo' => $files['companyLogo'] ?? '',
            'companyLogoName' => $files['companyLogo']['name'] ?? '',
            'brCertificate' => $files['brCertificate'] ?? '',
            'brCertificateName' => $files['brCertificate']['name'] ?? '',
            'role' => 'Company',
            'date' => date('Y-m-d H:i:s'),
            'status' => 'Pending',
            'industries' => $this->model('AdminModel')->getIndustries()['data'],
            'districts' => $this->model('AdminModel')->getDistricts()['data'],
            'cities' => [],

            // Error fields
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
            'website_err' => $urlResults['website_err'],
            'industry_err' => '',
            'facebook_err' => $urlResults['facebook_err'],
            'linkedin_err' => $urlResults['linkedin_err'],
            'brCertificate_err' => '',
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
            'email' => strtolower(trim($post['email'] ?? '')),
            'password' => trim($post['password'] ?? ''),
            'confirm_password' => trim($post['confirm_password'] ?? ''),
            'contactNo' => trim($post['contactNo'] ?? ''),
            'streetNo' => trim($post['streetNo'] ?? ''),
            'addressLine1' => ucfirst(trim($post['addressLine1'] ?? '')),
            'addressLine2' => ucfirst(trim($post['addressLine2'] ?? '')),
            'city' => ucfirst(trim($post['city'] ?? '')),
            'gender' => ucfirst(trim($post['gender'] ?? '')),
            'dob' => trim($post['dob'] ?? ''),
            'profilePic' => $files['profilePic'] ?? null,
            'nicNo' => trim($post['nicNo'] ?? ''),
            'nicCopy' => $files['nicCopy'] ?? null,
            'cv' => $files['cv'] ?? null,
            'university' => ucfirst(trim($post['university'] ?? '')),
            'universityID' => trim($post['universityID'] ?? ''),
            'universityIDCopy' => $files['universityIDCopy'] ?? null,
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

    //send verification email to company
    public function sendCompVeriEmail()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = [
                'email' => strtolower(trim($_POST['email'])),
                'email_err' => ''
            ];

            // Validate email
            $this->validateEmail($data);

            // Check if there are no errors
            if (empty($data['email_err'])) {
                //Generate the token
                $token = TokenHelper::generateToken();
                LogHelper::logDebug('Token generated: ' . $token);
                //Generate the expiry date
                $expiryDate = TokenHelper::generateExpiryDate();

                // Save token to database
                if ($this->model('AdminModel')->storeToken($data['email'], $token, $expiryDate)) {
                    LogHelper::logDebug('Token saved to database');
                    // Send token to email
                    MailHelper::sendEmailWithTokenCompany($data['email'], $token);
                    // Redirect to verify email page
                    $this->view('pages/register/email_sent', $data);
                } else {
                    LogHelper::logError('Token not saved to database');
                }
            } else {
                // Load view with errors
                $this->view('pages/register/send_verification_comp', $data);
            }
        } else {
            // Init data
            $data = [
                'email' => '',
                'email_err' => ''
            ];

            // Load view
            $this->view('pages/register/send_verification_comp', $data);
        }
    }

    //verify email using token
    public function verifyCompEmail($queryparams = [])
    {
        //check if token is set
        if (isset($queryparams['token'])) {
            //get token from query params
            $token = $queryparams['token'];

            //get token details
            $tokenDetails = $this->model('AdminModel')->getTokenDetails($token);

            //check if token is valid
            if ($tokenDetails) {
                //check if token is expired
                if (TokenHelper::validateToken($tokenDetails->Expiration)) {
                    //delete token
                    $this->model('AdminModel')->deleteToken($token);

                    //store email as verified
                    $this->model('AdminModel')->verifyEmail($tokenDetails->Email);

                    //store verified email in session
                    $_SESSION['verified_email'] = $tokenDetails->Email;

                    // Redirect to register page
                    Redirect::to(URLROOT . '/register/company');
                } else {
                    //error message for expired token
                    die('Token expired');
                }
            } else {
                //error message for invalid token
                die('Invalid token');
            }
        } else {
            //TODO: Handle this
            die('Token not found');
        }
    }

    //send verification email to company
    public function sendStuVeriEmail()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = [
                'email' => strtolower(trim($_POST['email'])),
                'email_err' => ''
            ];

            // Validate email
            $this->validateEmail($data);

            //validate university email
            if (!$this->universityEmailValidator->isUniversityEmail($data['email'])) {
                $data['email_err'] = 'Please enter a valid university email address';
            }

            // Check if there are no errors
            if (empty($data['email_err'])) {
                //Generate the token
                $token = TokenHelper::generateToken();
                LogHelper::logDebug('Token generated: ' . $token);
                //Generate the expiry date
                $expiryDate = TokenHelper::generateExpiryDate();

                // Save token to database
                if ($this->model('AdminModel')->storeToken($data['email'], $token, $expiryDate)) {
                    LogHelper::logDebug('Token saved to database');
                    // Send token to email
                    MailHelper::sendEmailWithTokenStudent($data['email'], $token, 'register');
                    // Redirect to verify email page
                    $this->view('pages/register/email_sent', $data);
                } else {
                    LogHelper::logError('Token not saved to database');
                }
            } else {
                // Load view with errors
                $this->view('pages/register/send_verification_stu', $data);
            }
        } else {
            // Init data
            $data = [
                'email' => '',
                'email_err' => ''
            ];

            // Load view
            $this->view('pages/register/send_verification_stu', $data);
        }
    }

    //verify email using token
    public function verifyStuEmail($queryparams = [])
    {
        //check if token is set
        if (isset($queryparams['token'])) {
            //get token from query params
            $token = $queryparams['token'];

            //get token details
            $tokenDetails = $this->model('AdminModel')->getTokenDetails($token);

            //check if token is valid
            if ($tokenDetails) {
                //check if token is expired
                if (TokenHelper::validateToken($tokenDetails->Expiration)) {
                    //delete token
                    $this->model('AdminModel')->deleteToken($token);

                    //store email as verified
                    $this->model('AdminModel')->verifyEmail($tokenDetails->Email);

                    //store verified email in session
                    $_SESSION['verified_email'] = $tokenDetails->Email;

                    //store university name in session
                    $_SESSION['university'] = $this->universityEmailValidator->getUniversityForEmail($tokenDetails->Email);

                    // Redirect to register page
                    Redirect::to(URLROOT . '/register/student');
                } else {
                    //error message for expired token
                    die('Token expired');
                }
            } else {
                //error message for invalid token
                die('Invalid token');
            }
        } else {
            //TODO: Handle this
            die('Token not found');
        }
    }

    public function company()
    {
        if (isset($_SESSION['verified_email'])) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST);

                // Init data
                $data = $this->prepareDataCompany($_POST, $_FILES);

                //check email is already registered
                if ($this->model->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already registered';
                } elseif (!$this->model('AdminModel')->isEmailVerified($data['email'])) {
                    $data['email_err'] = 'Email is not verified';
                }

                $validationResponse = Validator::isValidRegistrationData($data);
                if (!$validationResponse['is_valid']) {
                    $data = array_merge($data, $validationResponse['error']);
                }

                // $logoValidationResponse = FileUploadHelper::validateFile($data['companyLogo'], FileUploadHelper::ALLOWED_IMAGE_EXTENSIONS);
                // if (!$logoValidationResponse['is_valid']) {
                //     $data['companyLogo_err'] = $logoValidationResponse['error'];
                // }

                //vallidate files
                $fileValidationResponse = FileUploadHelper::validateFiles([
                    'companyLogo' => ['file' => $data['companyLogo'], 'allowedExtensions' => FileUploadHelper::ALLOWED_IMAGE_EXTENSIONS],
                    'brCertificate' => ['file' => $data['brCertificate'], 'allowedExtensions' => FileUploadHelper::ALLOWED_DOC_EXTENSIONS]
                ]);

                if (!$fileValidationResponse['is_valid']) {
                    $data = array_merge($data, $fileValidationResponse['error']);
                }

                // Check if there are no errors
                if (empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['companyName_err']) && empty($data['contactNo_err']) && empty($data['streetNo_err']) && empty($data['addressLine1_err']) && empty($data['city_err']) && empty($data['role_err']) && empty($data['status_err']) && empty($data['companyLogo_err'])) {
                    // Hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // Upload company logo
                    // $companyLogoResponse = FileUploadHelper::uploadFile($data['companyLogo'], PUBROOT . '/uploads/profile_pictures/company');
                    // if ($companyLogoResponse['success']) {
                    //     $data['companyLogoName'] = $companyLogoResponse['file_name'];
                    // } else {
                    //     $data['companyLogo_err'] = $companyLogoResponse['error'];
                    //     $this->view('pages/register/company_register', $data);
                    //     return;
                    // }

                    //upload each file
                    $uploadedFilesResponse = FileUploadHelper::uploadFiles([
                        'companyLogo' => ['file' => $data['companyLogo'], 'path' => PUBROOT . '/uploads/profile_pictures/company'],
                        'brCertificate' => ['file' => $data['brCertificate'], 'path' => PUBROOT . '/uploads/br_certificates']
                    ]);

                    //check if all files are uploaded successfully
                    if ($uploadedFilesResponse['success']) {
                        //set file names to data array
                        $data = array_merge($data, $uploadedFilesResponse['file_name']);
                    } else {
                        //merge data with errors
                        $data = array_merge($data, $uploadedFilesResponse['error']);
                        // Load view with errors
                        $this->view('pages/register/company_register', $data);
                        return;
                    }

                    // Register user
                    if ($this->model->companyRegister($data)) {
                        //clear data array and session
                        $_SESSION['verified_email'] = '';
                        $data = [];

                        $companyID = $this->model->getLatestCompanyId();
                        $company = $this->model->getCompanyByID($companyID);
                        //Notify admins about new student registration
                        $admins = $this->model->getAdminIds();
                        $vts = $this->model->getVTIds();
                        foreach ($admins as $admin) {
                            notifyAdminAboutNewCom($admin->AdminID, $companyID, $company->FirstName);
                        }
                        foreach ($vts as $vt) {
                            notifyVtAboutNewCom($vt->VT_MemberID, $companyID, $company->FirstName);
                        }

                        // Redirect to login page
                        Redirect::to(URLROOT . '/login');
                    } else {
                        die('Something went wrong'); //TODO: Handle this
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
        } else {
            // Redirect to send verification email page if email is not verified
            Redirect::to(URLROOT . '/register/sendCompVeriEmail');
        }
    }

    public function student()
    {
        if (isset($_SESSION['verified_email'])) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process form
                $_POST = filter_input_array(INPUT_POST);

                // Init data
                $data = $this->prepareDataStudent($_POST, $_FILES);

                //check email is already registered
                if ($this->model->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already registered';
                } elseif (!$this->model('AdminModel')->isEmailVerified($data['email'])) {
                    $data['email_err'] = 'Email is not verified';
                }

                //vallidate input data
                $validationResponse = Validator::isValidRegistrationData($data);
                if (!$validationResponse['is_valid']) {
                    $data = array_merge($data, $validationResponse['error']);
                }

                //validate required files
                if (empty($data['nicCopy']['name'])) {
                    $data['nicCopy_err'] = 'Please upload a NIC copy';
                }
                if (empty($data['universityIDCopy']['name'])) {
                    $data['universityIDCopy_err'] = 'Please upload a university ID copy';
                }

                //vallidate files
                $fileValidationResponse = FileUploadHelper::validateFiles([
                    'profilePic' => ['file' => $data['profilePic'], 'allowedExtensions' => FileUploadHelper::ALLOWED_IMAGE_EXTENSIONS],
                    'nicCopy' => ['file' => $data['nicCopy'], 'allowedExtensions' => FileUploadHelper::ALLOWED_DOC_EXTENSIONS],
                    'cv' => ['file' => $data['cv'], 'allowedExtensions' => FileUploadHelper::ALLOWED_DOC_EXTENSIONS],
                    'universityIDCopy' => ['file' => $data['universityIDCopy'], 'allowedExtensions' => FileUploadHelper::ALLOWED_DOC_EXTENSIONS]
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
                        'profilePic' => ['file' => $data['profilePic'], 'path' => PUBROOT . '/uploads/profile_pictures/student'],
                        'nicCopy' => ['file' => $data['nicCopy'], 'path' => PUBROOT . '/uploads/nic_copies'],
                        'cv' => ['file' => $data['cv'], 'path' => PUBROOT . '/uploads/cvs'],
                        'universityIDCopy' => ['file' => $data['universityIDCopy'], 'path' => PUBROOT . '/uploads/university_id_copies']
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
                        //clear data array and session
                        $_SESSION['verified_email'] = '';
                        $data = [];
                        $studentID = $this->model->getLatestStudentId();
                        $student = $this->model->getStudentByID($studentID);
                        //Notify admins about new student registration
                        $admins = $this->model->getAdminIds();
                        $vts = $this->model->getVTIds();
                        foreach ($admins as $admin) {
                            notifyAdminAboutNewStu($admin->AdminID, $studentID, $student->FirstName);
                        }
                        foreach ($vts as $vt) {
                            notifyVtAboutNewStu($vt->VT_MemberID, $studentID, $student->FirstName);
                        }

                        // Redirect to login page
                        Redirect::to(URLROOT . '/login');
                    } else {
                        die('Something went wrong'); //TODO: Handle this
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
        } else {
            // Redirect to send verification email page if email is not verified
            Redirect::to(URLROOT . '/register/sendStuVeriEmail');
        }
    }
}
