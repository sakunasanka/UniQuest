<?php
class Student extends Controller
{
    private $model;

    private function prepareEditProfileData($post = [], $files = [])
    {
        $user = $this->model->getUserDetails($_SESSION['user_id']);
        return $data = [
            'userID' => $user['UserID'],
            'firstName' => ucfirst(trim($post['firstName'] ?? $user['FirstName'])),
            'lastName' => ucfirst(trim($post['lastName'] ?? $user['LastName'])),
            'contactNo' => trim($post['contactNo'] ?? $user['ContactNo']),
            'streetNo' => trim($post['streetNo'] ?? $user['StreetNo']),
            'addressLine1' => trim($post['addressLine1'] ?? $user['AddressLine1']),
            'addressLine2' => trim($post['addressLine2'] ?? $user['AddressLine2']),
            'city' => ucfirst(trim($post['city'] ?? $user['City'])),
            'profilePic' => $files['profilePic'] ?? $user['ProfilePic'],
            'profilePicName' => $files['profilePicName'] ?? $user['ProfilePic'],
            'cv' => $files['cv'] ?? $user['CV'],
            'cvName' => $files['cvName'] ?? $user['CV'],
            'role' => $_SESSION['user_role'],

            'firstName_err' => '',
            'lastName_err' => '',
            'contactNo_err' => '',
            'streetNo_err' => '',
            'addressLine1_err' => '',
            'addressLine2_err' => '',
            'city_err' => '',
            'profilePic_err' => '',
            'cv_err' => ''
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

    public function edit_profile()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST);

            //get data from post
            $data = $this->prepareEditProfileData($_POST, $_FILES);

            //validate input data
            $validateResponse = Validator::isValidEditProfileData($data);
            if (!$validateResponse['is_valid']) {
                $data = array_merge($data, $validateResponse['error']);
            }

            //validate files
            $fileValidationResponse = FileUploadHelper::validateFiles([
                'profilePic' => ['file' => $data['profilePic'], 'allowedExtensions' => FileUploadHelper::ALLOWED_IMAGE_EXTENSIONS],
                'cv' => ['file' => $data['cv'], 'allowedExtensions' => FileUploadHelper::ALLOWED_DOC_EXTENSIONS]
            ]);

            if (!$fileValidationResponse['is_valid']) {
                $data = array_merge($data, $fileValidationResponse['error']);
            }

            // Check if there are no errors
            if (empty($data['firstName_err']) && empty($data['lastName_err']) && empty($data['contactNo_err']) && empty($data['streetNo_err']) && empty($data['addressLine1_err']) && empty($data['city_err'])) {
                //upload files
                $uploadedFilesResponse = FileUploadHelper::uploadFiles([
                    'profilePic' => ['file' => $data['profilePic'], 'path' => PUBROOT . '/uploads/profile_pictures/student'],
                    'cv' => ['file' => $data['cv'], 'path' => PUBROOT . '/uploads/cvs']
                ]);

                //check if all files are uploaded successfully
                if ($uploadedFilesResponse['success']) {
                    //set file names to data array only the files that are uploaded
                    $data['profilePicName'] = $uploadedFilesResponse['file_name']['profilePicName'] ?? $data['profilePicName'];
                    $data['cvName'] = $uploadedFilesResponse['file_name']['cvName'] ?? $data['cvName'];
                } else {
                    //merge data with errors
                    $data = array_merge($data, $uploadedFilesResponse['error']);
                    // Load view with errors
                    $this->view('pages/student/edit_profile', $data);
                    return;
                }

                //edit student profile
                if ($this->model->updateProfile($data)) {
                    // Redirect to profile page
                    Redirect::to(URLROOT . '/user/profile');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('pages/student/edit_profile', $data);
            }
        } else {
            //init data array
            $data = $this->prepareEditProfileData();

            // Load view
            $this->view('pages/student/edit_profile', $data);
        }
    }
    
    public function delete_account()
    {
        $this->view('popups/student/deactivate_account');
    }
    public function rate_review_company()
    {
        $this->view('pages/student/rate_review_company');
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
        $posts = $this->model('M_jobpost')->getPosts();

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id']; // Get user ID from session

        // Get bookmarked jobs for the user
        $bookmarkedJobs = $this->model('jobModel')->getBookmarkedJobs($userId);
        $bookmarkedJobIds = array_column($bookmarkedJobs, 'JobID');
        } 
        else {
            $userId = null;
            $bookmarkedJobs = []; // No bookmarks if not logged in
        }

        $data =[
            'posts' => $posts,
            'bookmarkedJobs' => $bookmarkedJobs,
            'bookmarkedJobIds' => $bookmarkedJobIds
        ];

        $this->view('pages/student/jobs', $data);
        
    }
    public function notifications()
    {
        $this->view('pages/student/notification_alerts');
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

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id']; // Get user ID from session

          // Get bookmarked jobs for the user
        $posts = $this->model('jobModel')->getBookmarkedJobs($userId);
        $bookmarkedJobs = $this->model('jobModel')->getBookmarkedJobs($userId);
        $bookmarkedJobIds = array_column($bookmarkedJobs, 'JobID');
        } 
        else {
            $userId = null;
            $bookmarkedJobs = []; // No bookmarks if not logged in
        }

           $data =[
            'posts' => $posts,
            'bookmarkedJobs' => $bookmarkedJobs,
            'bookmarkedJobIds' => $bookmarkedJobIds
        ];

        $this->view('pages/student/saveJobs', $data);
    }

    public function saveCompanies()
    {
        $this->view('pages/student/saveCompanies');
    }

    public function make_complain()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'job_posting' => trim($_POST['job_posting']),
                'issue' => trim($_POST['issue']),
            ];
            $this->model('jobModel')->create_complain($data);
            
            Redirect::to('make_complain');
              
        }

        else {
            $data = [
                'job_posting' => '',
                'issue' => '',
            ];
            $this->view('pages/student/make_complain', $data);
        }
        
    }

    public function companyDescription()
    {
        $this->view('pages/student/companyDescription');
    }

    public function internshipDescription()
    {
        $this->view('pages/student/internshipDescription');
    }

    public function jobsApply()
    {
        $this->view('pages/student/jobsApply');
    }

    public function pending()
    {
        $this->view('pages/login/wait_to_verify_stu');
    }

    public function internships()
    {
        $this->view('pages/student/internships');
    }
  
    public function jobsDescription($id){
        
        $posts = $this->model('M_jobpost')->getpostbyid($id);
        $data =[
            'post' => $posts
        ];
        // echo json_encode($data);
        $this->view('pages/student/jobsDescription', $data);
    
    }

}
