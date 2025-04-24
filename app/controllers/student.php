<?php
class Student extends Controller
{
    private $model;

    public function __construct()
    {
        // Check if user is logged in
        AuthMiddleware::requireAuth();
        // Check if user has the required role
        AuthMiddleware::requireRole('Student');

        // Load model
        $this->model = $this->model('userModel');
    }

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

    public function index()
    {
        // $this->jobs();
    }

    public function contact_sp()
    {
        $this->view('pages/student/contact_sp');
    }

    public function contact_admin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Data for the contact form
            $data = [
                'email' => trim($_POST['email'] ?? ''),
                'topic' => trim($_POST['topic'] ?? ''),
                'message' => trim($_POST['message'] ?? ''),

                'email_err' => '',
                'topic_err' => '',
                'message_err' => ''
            ];

            // Validation checks
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter your email';
            }


            if (empty($data['topic'])) {
                $data['topic_err'] = 'Please select a topic';
            }

            if (empty($data['message'])) {
                $data['message_err'] = 'Please enter your message';
            }

            // Ensure no errors before submitting
            if (empty($data['email_err'])  && empty($data['topic_err']) && empty($data['message_err'])) {
                if ($this->model('ContactModel')->sendMessage($data)) {

                    //send notification for each admin
                    $admins = $this->model->getAdminIds();
                    foreach ($admins as $admin) {
                        notifyMessageToAdminFromStudent($admin->AdminID, $data['message'], $_SESSION['user_id'], $_SESSION['user_name']);
                    }
                    $_SESSION['show_contact_us_success'] = true;
                    
                    redirect('student/contact_admin');
                } else {
                    $_SESSION['show_contact_us_error'] = true;
                    die('Something went wrong. Please try again.');
                }
            } else {
                $this->view('pages/student/contact_admin', $data);
            }
        } else {
            // Initialize default data for the view on GET request
            $data = [
                'email' => isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '',
                'topic' => '',
                'message' => '',
                'email_err' => '',
                'topic_err' => '',
                'message_err' => '',
            ];
            
            $this->view('pages/student/contact_admin', $data);
        }
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

    public function addReview($id = null)
    {
        $reviews = $this->model('RateAndReviewModel')->getReviewsByCompanyId($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Prepare data for the review
            $data = [
                'reviews' => $reviews,
                'rating' => trim($_POST['rating'] ?? ''),
                'comment' => trim($_POST['comment'] ?? ''),
                'user_id' => trim($_POST['user_id'] ?? ''),
                'company_id' => trim($_POST['company_id'] ?? ''),
                'existingReview' => $_POST['existingReview'] ?? 'false',
                'rating_err' => '',
                'comment_err' => ''
            ];

            // Check if this is an existing review update
            if ($data['existingReview'] === 'true') {
                // Get the review ID from the model
                $existingReview = $this->model('RateAndReviewModel')->getReviewByStudentAndCompany(
                    $data['user_id'],
                    $data['company_id']
                );

                if ($existingReview) {
                    $data['review_id'] = $existingReview->ReviewID;
                } else {
                    $data['existingReview'] = 'false';
                }
            }

            // Validate rating and comment
            if (empty($data['rating'])) {
                $data['rating_err'] = 'Please provide a rating.';
            }
            if (empty($data['comment'])) {
                $data['comment_err'] = 'Please provide a comment.';
            }

            // Check for errors
            if (empty($data['rating_err']) && empty($data['comment_err'])) {

                // Check if the user has already reviewed this company
                if ($data['existingReview'] == 'true') {
                    if ($this->model('RateAndReviewModel')->updateReview($data)) {
                        Redirect::to(URLROOT . '/student/myreviews');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    if ($this->model('RateAndReviewModel')->addReview($data)) {
                        Redirect::to(URLROOT . '/student/myreviews');
                    } else {
                        die('Something went wrong');
                    }
                }
            } else {
                // Load view with errors
                $this->view('pages/student/rate_review_company', $data);
            }
        } else {
            $data = [
                'reviews' => $reviews,
                'rating' => '',
                'comment' => '',
                'user_id' => '',
                'company_id' => $id,
                'existingReview' => 'false',
                'rating_err' => '',
                'comment_err' => ''
            ];

            $this->view('pages/student/rate_review_company', $data);
        }
    }

    public function updateReview($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'review_id' => $id,
                'rating' => $_POST['rating'] ?? '',
                'comment' => trim($_POST['comment'] ?? ''),
                'rating_err' => '',
                'comment_err' => ''
            ];

            if (empty($data['rating'])) {
                $data['rating_err'] = 'Please provide a rating.';
            }
            if (empty($data['comment'])) {
                $data['comment_err'] = 'Please provide a comment.';
            }

            if (empty($data['rating_err']) && empty($data['comment_err'])) {
                if ($this->model('RateAndReviewModel')->updateReview($data)) {
                    Redirect::to(URLROOT . '/student/myreviews');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('pages/student/edit_review', $data);
            }
        } else {

            $review = $this->model('RateAndReviewModel')->getReviewById($id);

            // if (!$review) {
            // Redirect::to(URLROOT . '/student/rate_review_company');
            // return;
            // }

            // Ensure the review belongs to the logged-in student
            // if ($review->StudentID !== $_SESSION['user_id']) {
            //     Redirect::to(URLROOT . '/student/editReview');
            // return;
            // }

            $data = [
                'review_id' => $id,
                'review' => $review,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'rating_err' => '',
                'comment_err' => ''
            ];

            $this->view('pages/student/edit_review', $data);
        }
    }

    public function deleteReview($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Check if the review exists
            // $review = $this->model('RateAndReviewModel')->getReviewById($id);

            // if (!$review) {
            //     Redirect::to(URLROOT . '/student/rate_review_company');
            //     return;
            // }

            // Ensure the review belongs to the logged-in student


            // Attempt to delete the review
            if ($this->model('RateAndReviewModel')->deleteReviewById($id)) {
                Redirect::to(URLROOT . '/student/myreviews');
            } else {
                die('Something went wrong while deleting the review.');
            }
        } else {
            Redirect::to(URLROOT . '/student/rate_review_company');
        }
    }


    public function rate_review_company()
    {
        $reviews = $this->model('RateAndReviewModel')->getReviewsByStuId();

        $data = [
            'reviews' => $reviews,
            'rating' => '',
            'comment' => '',
            'user_id' => $_SESSION['user_id'],
            'company_id' => '',
            'existingReview' => 'false',
            'rating_err' => '',
            'comment_err' => ''
        ];

        $this->view('pages/student/rate_review_company', $data);
    }

    public function all_app($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'SubmissionDate';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            $applications = $this->model('M_applicationFields')->getAllApplications($_SESSION['user_id'], $page, $limit, $sort, $order, $search);
            $data = [
                'applications' => $applications['data'],
                'currentPage' => $applications['currentPage'],
                'rowsPerPage' => $applications['limit'],
                'totalRows' => $applications['totalRows'],
                'totalPages' => $applications['totalPages'],
                'isLastPage' => $applications['isLastPage'] ? 'yes' : 'no',
            ];
            $this->view('pages/student/all_applications', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function accepted_app($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'SubmissionDate';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';

            $users = $this->model->getPendingStudentsAndCompanies($page, $limit, $sort, $order);
            $data = [
                'users' => $users['data'],
                'currentPage' => $users['currentPage'],
                'rowsPerPage' => $users['limit'],
                'totalRows' => $users['totalRows'],
                'totalPages' => $users['totalPages'],
                'isLastPage' => $users['isLastPage'] ? 'yes' : 'no',
            ];
            $this->view('pages/student/accepted_applications', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function rejected_app($queryParam = [])
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'SubmissionDate';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';

            $users = $this->model->getPendingStudentsAndCompanies($page, $limit, $sort, $order);
            $data = [
                'users' => $users['data'],
                'currentPage' => $users['currentPage'],
                'rowsPerPage' => $users['limit'],
                'totalRows' => $users['totalRows'],
                'totalPages' => $users['totalPages'],
                'isLastPage' => $users['isLastPage'] ? 'yes' : 'no',
            ];
            $this->view('pages/student/rejected_applications', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function notifications()
    {
        $this->view('pages/student/notification_alerts');
    }

    public function saveJobs($queryParam = [])
    {

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id']; // Get user ID from session

            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 12;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'JobID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            // get filter data from query params
            $filters = [
                'district' => isset($queryParam['district']) ? $queryParam['district'] : null,
                'city' => isset($queryParam['city']) ? $queryParam['city'] : null,
                'industry' => isset($queryParam['industry']) ? $queryParam['industry'] : null,
                'rating' => isset($queryParam['rating']) ? $queryParam['rating'] : null,
                'minSalary' => isset($queryParam['minSalary']) ? $queryParam['minSalary'] : null,
                'maxSalary' => isset($queryParam['maxSalary']) ? $queryParam['maxSalary'] : null,
                'salaryType' => isset($queryParam['salaryType']) ? $queryParam['salaryType'] : null
            ];

            // Get bookmarked jobs for the user
            $post_data = $this->model('M_jobpost')->getSaveJobs($userId, $page, $limit, $sort, $order, $search, $filters);
            $posts = $post_data['data'];
            $displayRatings = [];

            // Loop through each job post to get the display rating for the associated company
            foreach ($posts as $post) {
                $companyID = $post->CompanyID; // Assuming each job post has a CompanyID field
                $displayRatings[$companyID] = $this->model('RateAndReviewModel')->getDisplayRating($companyID);
            }
            $bookmarkedJobs = $this->model('jobModel')->getBookmarkedJobs($userId);
            $bookmarkedJobIds = array_column($bookmarkedJobs, 'JobID');
        } else {
            $userId = null;
            $bookmarkedJobs = []; // No bookmarks if not logged in
        }

        $data = [
            'posts' => $posts,
            'bookmarkedJobs' => $bookmarkedJobs,
            'bookmarkedJobIds' => $bookmarkedJobIds,
            'displayRatings' => $displayRatings,
            'totalRows' => $post_data['totalRows'],
            'rowsPerPage' => $post_data['limit'],
            'districts' => $this->model('AdminModel')->getDistricts()['data'], // Get districts for filtering
            'cities' => [], //Initially empty, will be populated based on selected district
            'industries' => $this->model('AdminModel')->getIndustries()['data'], // Get industries for filtering
        ];

        $this->view('pages/student/saveJobs', $data);
    }

    public function saveInternships($queryParam = [])
    {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id']; // Get user ID from session

            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 12;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'JobID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            // get filter data from query params
            $filters = [
                'district' => isset($queryParam['district']) ? $queryParam['district'] : null,
                'city' => isset($queryParam['city']) ? $queryParam['city'] : null,
                'industry' => isset($queryParam['industry']) ? $queryParam['industry'] : null,
                'rating' => isset($queryParam['rating']) ? $queryParam['rating'] : null,
                'minSalary' => isset($queryParam['minSalary']) ? $queryParam['minSalary'] : null,
                'maxSalary' => isset($queryParam['maxSalary']) ? $queryParam['maxSalary'] : null,
                'salaryType' => isset($queryParam['salaryType']) ? $queryParam['salaryType'] : null
            ];

            // Get bookmarked jobs for the user
            $post_data = $this->model('M_jobpost')->getSaveInternships($userId, $page, $limit, $sort, $order, $search, $filters);
            $posts = $post_data['data'];
            $displayRatings = [];

            // Loop through each job post to get the display rating for the associated company
            foreach ($posts as $post) {
                $companyID = $post->CompanyID; // Assuming each job post has a CompanyID field
                $displayRatings[$companyID] = $this->model('RateAndReviewModel')->getDisplayRating($companyID);
            }

        $bookmarkedJobs = $this->model('jobModel')->getBookmarkedInternships($userId);
        $bookmarkedJobIds = array_column($bookmarkedJobs, 'JobID');
        } 
        else {
            $userId = null;
            $bookmarkedJobs = []; // No bookmarks if not logged in
        }

        $data = [
            'posts' => $posts,
            'bookmarkedJobs' => $bookmarkedJobs,
            'bookmarkedJobIds' => $bookmarkedJobIds,
            'displayRatings' => $displayRatings,
            'totalRows' => $post_data['totalRows'],
            'rowsPerPage' => $post_data['limit'],
            'districts' => $this->model('AdminModel')->getDistricts()['data'], // Get districts for filtering
            'cities' => [], //Initially empty, will be populated based on selected district
            'industries' => $this->model('AdminModel')->getIndustries()['data'], // Get industries for filtering
        ];

        $this->view('pages/student/saveInternships', $data);
    }

    public function saveCompanies($queryParam = [])
    {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id']; // Get user ID from session

            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 12;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'CompanyID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';
            $search = isset($queryParam['search']) ? $queryParam['search'] : '';

            // get filter data from query params
            $filters = [
                'district' => isset($queryParam['district']) ? $queryParam['district'] : null,
                'city' => isset($queryParam['city']) ? $queryParam['city'] : null,
                'industry' => isset($queryParam['industry']) ? $queryParam['industry'] : null,
                'rating' => isset($queryParam['rating']) ? $queryParam['rating'] : null,
                'minSalary' => isset($queryParam['minSalary']) ? $queryParam['minSalary'] : null,
                'maxSalary' => isset($queryParam['maxSalary']) ? $queryParam['maxSalary'] : null,
                'salaryType' => isset($queryParam['salaryType']) ? $queryParam['salaryType'] : null
            ];

            // Retrieve companies
            $post_data = $this->model('M_jobpost')->getSaveCompanies($userId, $page, $limit, $sort, $order, $search, $filters);
            $posts = $post_data['data'];
            $displayRatings = [];

            // Loop through each job post to get the display rating for the associated company
            foreach ($posts as $post) {
                $companyID = $post->CompanyID; // Assuming each job post has a CompanyID field
                $displayRatings[$companyID] = $this->model('RateAndReviewModel')->getDisplayRating($companyID);
            }

            $bookmarkedCompanies = $this->model('companyModel')->getBookmarkedCompanies($userId);
            $bookmarkedCompanyIds = array_column($bookmarkedCompanies, 'CompanyID');
        } else {
            $userId = null;
            $bookmarkedCompanies = []; // No bookmarks if not logged in
        }

        $data = [
            'posts' => $posts,
            'bookmarkedCompanies' => $bookmarkedCompanies,
            'bookmarkedCompanyIds' => $bookmarkedCompanyIds,
            'displayRatings' => $displayRatings,
            'totalRows' => $post_data['totalRows'],
            'rowsPerPage' => $post_data['limit'],
            'districts' => $this->model('AdminModel')->getDistricts()['data'], // Get districts for filtering
            'cities' => [], //Initially empty, will be populated based on selected district
            'industries' => $this->model('AdminModel')->getIndustries()['data'], // Get industries for filtering
        ];

        $this->view('pages/student/saveCompanies', $data);
    }

    public function make_complain($jobID)
    {
        $existingComplaint = $this->model('ComplaintModel')->getExistingComplaint($_SESSION['user_id'], $jobID);
        if ($existingComplaint) {
            $_SESSION['existing_complaint'] = true;
            $previousURL = $_SERVER['HTTP_REFERER'] ?? URLROOT . '/jobs';
            Redirect::to($previousURL);
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data = [
                'jobID' => $jobID,
                'title' => $_POST['title'] ?? '',
                'complaint' => trim($_POST['complaint'] ?? ''),
                'proof' => $_FILES['proof'] ?? '',
                'studentID' => $_SESSION['user_id'],
                'complaint_err' => '',
                'proof_err' => ''
            ];

            // Validate complaint and proof
            if (empty($data['complaint'])) {
                $data['complaint_err'] = 'Please provide a complaint.';
            }

            // Validate proof file
            if (empty($data['proof']['name'])) {
                $data['proof_err'] = 'Please upload a proof file.';
            } 
            
            // Check for errors
            if (empty($data['complaint_err']) && empty($data['proof_err'])) {
                // Handle file upload for proof
                $proofResponse = FileUploadHelper::uploadFile($data['proof'], PUBROOT . '/uploads/proofs');
                if ($proofResponse['success']) {
                    $data['proofName'] = $proofResponse['file_name'];
                } else {
                    $data['proof_err'] = $proofResponse['error'];
                    $this->view('pages/student/make_complain', $data);
                    return;
                }
                if ($this->model('ComplaintModel')->createComplaint($data)) {
                    $admins = $this->model->getAdminIds();
                    $job = $this->model('M_jobpost')->getpostbyid($jobID);
                    foreach ($admins as $admin) {
                        notifyComplaintToAdmin($admin->AdminID, $job->Title, $_SESSION['user_name']);
                    }
                    $_SESSION['complaint_submit_success'] = true;                 
                    Redirect::to(URLROOT . '/jobs'); // Adjust the redirect URL as needed
                } else {
                    $_SESSION['complaint_submit_error'] = true;   
                    die('Something went wrong'); // Improved error handling suggested
                }
            } else {
                // Load view with errors
                $this->view('pages/student/make_complain', $data);
            }
        } else {
            $post = $this->model('M_jobpost')->getpostbyid($jobID);
            $data = [
                'jobID' => $jobID,
                'title' => $post->Title,
                'complaint' => '',
                'proof' => '',
                'complaint_err' => '',
                'proof_err' => ''
            ];
            $this->view('pages/student/make_complain', $data);
        }
    }

    public function companyDescription($id)
    {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            $bookmarkedCompanies = $this->model('companyModel')->getBookmarkedCompanies($userId);
            $bookmarkedCompanyIds = array_column($bookmarkedCompanies, 'CompanyID');
            $posts = $this->model('M_jobpost')->getpostbycompanyid($id);
            $reviews = $this->model('RateAndReviewModel')->getReviewsByCompanyId($id);
        } else {
            $userId = null;
            $bookmarkedCompanies = []; // No bookmarks if not logged in
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Prepare data for the review
            $data = [
                'post' => $posts,
                'bookmarkedCompanies' => $bookmarkedCompanies,
                'bookmarkedCompanyIds' => $bookmarkedCompanyIds,
                'reviews' => $reviews,
                'rating' => $_POST['rating'] ?? '',
                'comment' => trim($_POST['comment'] ?? ''),
                'user_id' => $_POST['user_id'] ?? '',
                'company_id' => $_POST['company_id'] ?? '',
                'rating_err' => '',
                'comment_err' => ''
            ];

            // Validate rating and comment
            if (empty($data['rating'])) {
                $data['rating_err'] = 'Please provide a rating.';
            }
            if (empty($data['comment'])) {
                $data['comment_err'] = 'Please provide a comment.';
            }

            // Check for errors
            if (empty($data['rating_err']) && empty($data['comment_err'])) {
                if ($this->model('RateAndReviewModel')->addReview($data)) {
                    Redirect::to(URLROOT . '/student/addReview/' . $data['company_id']); //To be corrected
                } else {
                    die('Something went wrong'); // Improved error handling suggested
                }
            } else {
                // Load view with errors
                $this->view('pages/student/rate_review_company', $data);
            }
        } else {
            $data = [
                'post' => $posts,
                'bookmarkedCompanies' => $bookmarkedCompanies,
                'bookmarkedCompanyIds' => $bookmarkedCompanyIds,
                'reviews' => $reviews,
                'rating' => '',
                'comment' => '',
                'user_id' => '',
                'company_id' => $id,
                'rating_err' => '',
                'comment_err' => ''
            ];

            $this->view('pages/student/companyDescription', $data);
        }
    }

    public function internshipDescription($id)
    {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        } else {
            $userId = null;
            $bookmarkedJobs = []; // No bookmarks if not logged in
            $posts = [];
            $posts_com_id = [];
            $reviews = [];
        }

        // Get bookmarked jobs for the user
        $bookmarkedJobs = $this->model('jobModel')->getBookmarkedJobs($userId);
        $bookmarkedJobIds = array_column($bookmarkedJobs, 'JobID');
        $posts = $this->model('M_jobpost')->getpostbyid($id);
        $posts_com_id = $this->model('M_jobpost')->getpostbycompanyid($id);
        $reviews = $this->model('RateAndReviewModel')->getReviewsByCompanyId($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'post' => $posts,
                'post_com' => $posts_com_id,
                'bookmarkedJobs' => $bookmarkedJobs,
                'bookmarkedJobIds' => $bookmarkedJobIds,
                'reviews' => $reviews,
                'rating' => $_POST['rating'] ?? '',
                'comment' => trim($_POST['comment'] ?? ''),
                'user_id' => $_POST['user_id'] ?? '',
                'company_id' => $_POST['company_id'] ?? '',
                'rating_err' => '',
                'comment_err' => ''
            ];

            if (empty($data['rating'])) {
                $data['rating_err'] = 'Please provide a rating.';
            }
            if (empty($data['comment'])) {
                $data['comment_err'] = 'Please provide a comment.';
            }

            // Check for errors
            if (empty($data['rating_err']) && empty($data['comment_err'])) {
                if ($this->model('RateAndReviewModel')->addReview($data)) {
                    Redirect::to(URLROOT . '/student/addReview/' . $data['company_id']);  //To be corrected
                } else {
                    die('Something went wrong'); // Improved error handling suggested
                }
            } else {
                // Load view with errors
                $this->view('pages/student/rate_review_company', $data);
            }
        } else {
            $data = [
                'post' => $posts,
                'post_com' => $posts_com_id,
                'bookmarkedJobs' => $bookmarkedJobs,
                'bookmarkedJobIds' => $bookmarkedJobIds,
                'reviews' => $reviews,
                'rating' => '',
                'comment' => '',
                'user_id' => '',
                'company_id' => $_POST['company_id'] ?? '',
                'rating_err' => '',
                'comment_err' => ''
            ];

            $this->view('pages/student/internshipDescription', $data);
        }
    }

    public function jobsApplyform($jobId)
    {

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        } else {
            $userId = null;
            $bookmarkedJobs = [];
            $posts = [];
            $posts_com_id = [];
            $reviews = [];
        }

        // Load model and get application fields
        $applicationFields = $this->model('M_applicationFields')->getFieldsByJobId($jobId);

        // Fetch job details3
        $job = $this->model('M_jobpost')->getpostbyid($jobId);

        $posts = $this->model('M_jobpost')->getpostbyid($jobId);
        $displayRating = $this->model('RateAndReviewModel')->getDisplayRating($posts->CompanyID);
        $isApplied = $this->model('jobModel')->isApplied($jobId);

        if ($posts->Category == 'Internship') {
            $bookmarkedJobs = $this->model('jobModel')->getBookmarkedInternships($userId);
        } else {
            $bookmarkedJobs = $this->model('jobModel')->getBookmarkedJobs($userId);
        }
        $bookmarkedJobIds = array_column($bookmarkedJobs, 'JobID');
        $userdetails = $this->model('UserModel')->getUserDetails($_SESSION['user_id']);
        $userdetails = array_change_key_case($userdetails, CASE_LOWER);
        // die(var_dump($userdetails));

        $data = [
            'fields' => $applicationFields,
            'job' => $job,
            'post' => $posts,
            'bookmarkedJobs' => $bookmarkedJobs,
            'bookmarkedJobIds' => $bookmarkedJobIds,
            'displayRating' => $displayRating,
            'userdetails' => $userdetails,
        ];
        // Check if the user has already applied for this job
        if ($isApplied) {
            if ($data['job']->Category == 'Part-time') {
                $_SESSION['show_job_apply_error'] = true;
                $previousURL = $_SERVER['HTTP_REFERER'] ?? URLROOT . '/jobs';
                Redirect::to($previousURL);
            } else {
                $_SESSION['show_internship_apply_error'] = true;
                $previousURL = $_SERVER['HTTP_REFERER'] ?? URLROOT . '/jobs';
                Redirect::to($previousURL);
            }
        } else {
            $this->view('pages/student/jobsApply', $data);
        }
    }
    public function jobsApply($jobId)
    {
        $posts = $this->model('M_jobpost')->getpostbyid($jobId);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $applicationFields = $this->model('M_applicationFields')->getFieldsByJobId($jobId);

            // Initialize data array and validation
            $data = [
                'job_id' => $jobId,
                'fields' => [],
                'errors' => []
            ];

            // Process each field based on its type
            foreach ($applicationFields as $fieldName => $fieldConfig) {
                switch ($fieldConfig['type']) {
                    case 'file':
                        if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
                            $uploadResult = $this->handleFileUpload($_FILES[$fieldName], $fieldName);
                            if ($uploadResult['success']) {
                                $data['fields'][$fieldName] = $uploadResult['path'];
                            } else {
                                $data['errors'][$fieldName] = $uploadResult['error'];
                            }

                        } elseif (isset($fieldConfig['required']) && $fieldConfig['required']) {
                            $data['errors'][$fieldName] = 'File upload is required';
                        }
                        break;

                    default:
                        $value = trim($_POST[$fieldName] ?? '');

                        if (empty($value) && isset($fieldConfig['required']) && $fieldConfig['required']) {
                            $data['errors'][$fieldName] = 'This field is required';
                        } else {
                            $data['fields'][$fieldName] = $value;
                        }
                        break;
                }
            }

            // If no errors, save application
            if (empty($data['errors'])) {
                $applicationModel = $this->model('M_applicationFields');
            
            $applicationCount = $this->model('M_applicationFields')->getApplicationCountForJob($jobId); 
            $sub_plan = $this->model('companyModel')->getSubscriptionPlanByJobID($jobId); 
            
                if ($applicationCount >= 20 && $sub_plan == 'free' || $applicationCount >= 50 && $sub_plan == 'professional') {
                    $_SESSION['show_job_apply_count_error'];
                    $previousURL = $_SERVER['HTTP_REFERER'] ?? URLROOT . '/jobs';
                    Redirect::to($previousURL);
                }
                elseif ($sub_plan == 'enterprise') {    
                    $applicationModel->createApplication($data['fields'], $jobId, $_SESSION['user_id']);
                    
                    if ($applicationModel->createApplication($data['fields'], $jobId, $_SESSION['user_id'])) {
                        // Notify the user about the successful application
                        $_SESSION['application_success'] = true;

                        notifyJobsApply(
                            $posts->CompanyID,
                            $posts->Title,
                            $jobId
                            
                        );
                        redirect('student/all_app');
                    } else {
                        // Return to form with errors
                        $_SESSION['application_error'] = true;
                        $this->view('pages/student/jobsApply', $data);
                    }
                }    
            } else {
                // GET request - show the application form
                $jobModel = $this->model('M_jobpost');
                $job = $jobModel->getJobById($jobId);

                if (!$job) {
                    redirect('pages/error');
                }

                $data = [
                    'job' => $job,
                    'fields' => $this->model('M_applicationFields')->getFieldsByJobId($jobId)
                ];

                $this->view('pages/student/jobsApply', $data);
            }
        }
    }
    
    private function handleFileUpload($file, $fieldName)
    {
        $result = [
            'success' => false,
            'path' => '',
            'error' => ''
        ];

        // Define allowed file types based on field
        $allowedTypes = [
            'cvs' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            'photo' => ['image/jpeg', 'image/png'],
            'nic_copy' => ['application/pdf', 'image/jpeg', 'image/png'],
            'other1' => ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'],
            'other2' => ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'],
            'other3' => ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'],
        ];

        // Validate file type
        if (!in_array($file['type'], $allowedTypes[$fieldName] ?? [])) {
            $result['error'] = 'Invalid file type';
            return $result;
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;

        // Set upload directory based on field type
        $uploadDir = PUBROOT . '/uploads/' . $fieldName . '/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $result['success'] = true;
            $result['path'] = 'uploads/' . $fieldName . '/' . $filename;
        } else {
            $result['error'] = 'Failed to upload file';
        }

        return $result;
    }

    // public function jobsApply()
    // {
    //     $this->view('pages/student/jobsApply');
    // }

    public function pending()
    {
        $this->view('pages/login/wait_to_verify_stu');
    }

    public function deactive()
    {
        $this->view('pages/login/deactivate_stu');
    }

    public function view_application($applicationID)
    {
        // Fetch application details
        $application = $this->model('M_applicationFields')->getApplicationByID($applicationID);

        if (!$application) {
            // Handle the case where the application is not found
            redirect('error/not_found');
        }

        // Access the first element of the $application array
        $application = $application[0];

        // Prepare the application data
        $applicationData = [
            'jobID' => $application->JobID ?? null,
            'photo' => $application->StudentProfileImage ?? null,
            'fullname' => $application->StudentName ?? null,
            'id' => $application->ApplicationID ?? null,
            'created_at' => $application->SubmissionDate ?? null,
            'status' => $application->ApplicationStatus ?? null,
            'email' => $application->StudentEmail ?? null,
            'contact' => $application->StudentContact ?? null,
            'address' => $application->address ?? null,
            'nic' => $application->nic ?? null,
            'gender' => $application->gender ?? null,
            'dob' => $application->dob ?? null,
            'qualifications' => $application->Qualifications ?? null,
            'experience' => $application->Experience ?? null,
            'skills' => $application->Skills ?? null,
            'cv' => $application->cv ?? null,
            'nic_copy' => $application->nic_copy ?? null,
            'linkedin' => $application->linkedin ?? null,
            'other1' => $application->other1 ?? null,
            'other2' => $application->other2 ?? null,
            'other3' => $application->other3 ?? null,
            'other1_type' => $application->other1_type ?? null,
            'other2_type' => $application->other2_type ?? null,
            'other3_type' => $application->other3_type ?? null,
        ];

        $data = [
            'application' => $applicationData,
        ];
        $fields = $this->model('M_applicationFields')->getFieldsByJobId($data['application']['jobID']);

        $data['fields'] = $fields;

        // Load the view
        $this->view('pages/service_provider/view_application', $data);
    }

    public function myreviews($queryParam = [])
    {
        // Get the requested data from query params
        $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
        $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 10;
        $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'ReviewID';
        $order = isset($queryParam['order']) ? $queryParam['order'] : 'DESC';

        // Get user ID from session
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        } else {
            $userId = null;
        }

        $reviewsData = $this->model('RateAndReviewModel')->getReviewsByStuId($_SESSION['user_id'], $page, $limit, $sort, $order);
        $reviews = $reviewsData['data'];

        foreach ($reviews as $review) {
            $review->LikeCount = $this->model('RateAndReviewModel')->getLikesByReviewID($review->ReviewID);
            $review->DislikeCount = $this->model('RateAndReviewModel')->getDislikesByReviewID($review->ReviewID);
            $review->is_liked = $this->model('RateAndReviewModel')->checkIfLiked($review->ReviewID, $userId);
            $review->is_disliked = $this->model('RateAndReviewModel')->checkIfDisliked($review->ReviewID, $userId);
        }

        $data = [
            'reviews' => $reviews,
            'rating' => '',
            'comment' => '',
            'company_id' => '',
            'currentPage' => $reviewsData['currentPage'],
            'rowsPerPage' => $reviewsData['limit'],
            'totalRows' => $reviewsData['totalRows'],
            'totalPages' => $reviewsData['totalPages'],
            'isLastPage' => $reviewsData['isLastPage'] ? 'yes' : 'no',
        ];

        $this->view('pages/student/myreviews', $data);
    }

    public function markAllRead() {

        $this->model('NotificationModel')->markAllAsRead($_SESSION['user_id']);
        $previousURL = $_SERVER['HTTP_REFERER'] ?? URLROOT . '/student/notifications';
        Redirect::to($previousURL);
    }

    public function markAsRead($notificationId) {
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

    public function getRecentNotifications() {
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

    public function getAllNotifications() {

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