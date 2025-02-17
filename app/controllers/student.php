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
                'name' => trim($_POST['name'] ?? ''),
                'topic' => trim($_POST['topic'] ?? ''),
                'message' => trim($_POST['message'] ?? ''),

                'name_err' => '',
                'topic_err' => '',
                'message_err' => ''
            ];

            // Validation checks
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter your name';
            }


            if (empty($data['topic'])) {
                $data['topic_err'] = 'Please select a topic';
            }

            if (empty($data['message'])) {
                $data['message_err'] = 'Please enter your message';
            }

            // Ensure no errors before submitting
            if (empty($data['name_err'])  && empty($data['topic_err']) && empty($data['message_err'])) {
                if($this->model('ContactModel')->sendMessage($data)){
                    flash('contact-msg', 'Your message has been sent successfully.');
                    redirect('student/contact_admin');
                } else {
                    die('Something went wrong. Please try again.');
                }
            } else {
                $this->view('pages/student/contact_admin', $data);
            }
        } else {
            // Initialize default data for the view on GET request
            $data = [
                'name' => '',
                'topic' => '',
                'message' => '',
                'name_err' => '',
                'topic_err' => '',
                'message_err' => ''
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
        $reviews = $this->model('RateAndReviewModel')-> getReviewsByCompanyId($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Prepare data for the review
            $data = [
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
                    Redirect::to(URLROOT . '/student/addReview/'.$data['company_id']);
                } else {
                    die('Something went wrong'); // Improved error handling suggested
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
                'rating' => $_POST['Rating'] ?? '',
                'comment' => trim($_POST['Comment'] ?? ''),
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
            'rating' => $review->Rating,
            'comment' => $review->Comment,
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
        $this->view('pages/student/rate_review_company');
    }

    public function all_app()
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 2;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'UserID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';

            $users = $this->model->getPendingStudentsAndCompanies($page, $limit, $sort, $order);
            $data = [
                'users' => $users['data'],
                'currentPage' => $users['currentPage'],
                'rowsPerPage' => $users['limit'],
                'totalRows' => $users['totalRows'],
                'totalPages' => $users['totalPages'],
                'isLastPage' => $users['isLastPage'] ? 'yes' : 'no',
            ];
            $this->view('pages/student/all_applications', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    public function accepted_app()
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 2;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'UserID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';

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

    public function rejected_app()
    {
        try {
            // Get the requested data from query params
            $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
            $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 2;
            $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'UserID';
            $order = isset($queryParam['order']) ? $queryParam['order'] : 'ASC';

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

    public function trendyCompany()
    {
        $trendy_companies = $this->model('RateAndReviewModel')->getTrendyCompanies();

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id']; // Get user ID from session

            // Get bookmarked companies for the user
            $bookmarkedCompanies = $this->model('jobModel')->getBookmarkedCompanies($userId);
            $bookmarkedCompanyIds = array_column($bookmarkedCompanies, 'CompanyID');
        } 
        else {
            $userId = null;
            $bookmarkedCompanies = []; // No bookmarks if not logged in
        }

        $data =[
            'trendy_companies' => $trendy_companies,
            'bookmarkedCompanies' => $bookmarkedCompanies,
            'bookmarkedCompanyIds' => $bookmarkedCompanyIds
        ];

        $this->view('pages/student/trendyCompany', $data);
    }

    public function saveJobs()
    {   

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id']; // Get user ID from session

          // Get bookmarked jobs for the user
        $posts = $this->model('jobModel')->getBookmarkedJobs($userId);
        $displayRatings = [];

            // Loop through each job post to get the display rating for the associated company
            foreach ($posts as $post) {
                $companyID = $post->CompanyID; // Assuming each job post has a CompanyID field
                $displayRatings[$companyID] = $this->model('RateAndReviewModel')->getDisplayRating($companyID);
            }
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
            'bookmarkedJobIds' => $bookmarkedJobIds,
            'displayRatings' => $displayRatings
        ];

        $this->view('pages/student/saveJobs', $data);
    }

    public function saveInternships()
    {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id']; // Get user ID from session

          // Get bookmarked jobs for the user
        $posts = $this->model('jobModel')->getBookmarkedInternships($userId);
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

           $data =[
            'posts' => $posts,
            'bookmarkedJobs' => $bookmarkedJobs,
            'bookmarkedJobIds' => $bookmarkedJobIds,
            'displayRatings' => $displayRatings
        ];

        $this->view('pages/student/saveInternships', $data);
    }

    public function saveCompanies()
    {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id']; // Get user ID from session

          // Get bookmarked jobs for the user
        $posts = $this->model('companyModel')->getBookmarkedCompanies($userId);
        $displayRatings = [];

            // Loop through each job post to get the display rating for the associated company
            foreach ($posts as $post) {
                $companyID = $post->CompanyID; // Assuming each job post has a CompanyID field
                $displayRatings[$companyID] = $this->model('RateAndReviewModel')->getDisplayRating($companyID);
            }

        $bookmarkedCompanies = $this->model('companyModel')->getBookmarkedCompanies($userId);
        $bookmarkedCompanyIds = array_column($bookmarkedCompanies, 'CompanyID');
        } 
        else {
            $userId = null;
            $bookmarkedCompanies = []; // No bookmarks if not logged in
        }

           $data =[
            'posts' => $posts,
            'bookmarkedCompanies' => $bookmarkedCompanies,
            'bookmarkedCompanyIds' => $bookmarkedCompanyIds,
            'displayRatings' => $displayRatings
        ];

        $this->view('pages/student/saveCompanies', $data);
    }

    public function make_complain($id = null)
    {
        $posts = $this->model('M_jobpost')->getpostbyid($id);

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'complaint' => trim($_POST['complaint']),
                'posts' => $posts
            ];
            $this->model('ComplaintModel')->createComplaint($data);
            
            Redirect::to(URLROOT . '/student/make_complain/'.$id);
              
        }

        else {
            $data = [
                'complaint' => '',
                'posts' => $posts
            ];
            $this->view('pages/student/make_complain', $data);
        }
        
    }

    // public function companyDescription($id)
    // {
    //     if (isset($_SESSION['user_id'])) {
    //         $userId = $_SESSION['user_id']; 

    //     $bookmarkedCompanies = $this->model('companyModel')->getBookmarkedCompanies($userId);
    //     $bookmarkedCompanyIds = array_column($bookmarkedCompanies, 'CompanyID');
    //     $posts = $this->model('M_jobpost')->getpostbycompanyid($id);
    //     $reviews = $this->model('RateAndReviewModel')-> getReviewsByCompanyId($id);
    //     } 
    //     else {
    //         $userId = null;
    //         $bookmarkedCompanies = []; // No bookmarks if not logged in
    //     }
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    //         // Prepare data for the review
    //         $data = [
    //             'post' => $posts,
    //             'bookmarkedCompanies' => $bookmarkedCompanies,
    //             'bookmarkedCompanyIds' => $bookmarkedCompanyIds,
    //             'reviews' => $reviews,
    //             'rating' => $_POST['rating'] ?? '',
    //             'comment' => trim($_POST['comment'] ?? ''),
    //             'user_id' => $_POST['user_id'] ?? '',
    //             'company_id' => $_POST['company_id'] ?? '',
    //             'rating_err' => '',
    //             'comment_err' => ''
    //         ];

    //         // Validate rating and comment
    //         if (empty($data['rating'])) {
    //             $data['rating_err'] = 'Please provide a rating.';
    //         }
    //         if (empty($data['comment'])) {
    //             $data['comment_err'] = 'Please provide a comment.';
    //         }

    //         // Check for errors
    //         if (empty($data['rating_err']) && empty($data['comment_err'])) {
    //             if ($this->model('RateAndReviewModel')->addReview($data)) {
    //                 Redirect::to(URLROOT . '/student/addReview/'.$data['company_id']); //To be corrected
    //             } else {
    //                 die('Something went wrong'); // Improved error handling suggested
    //             }
    //         } else {
    //             // Load view with errors
    //             $this->view('pages/student/rate_review_company', $data);
    //         }
    //     } else {
    //         $data = [
    //             'post' => $posts,
    //             'bookmarkedCompanies' => $bookmarkedCompanies,
    //             'bookmarkedCompanyIds' => $bookmarkedCompanyIds,
    //             'reviews' => $reviews,
    //             'rating' => '',
    //             'comment' => '',
    //             'user_id' => '',
    //             'company_id' => $id,
    //             'rating_err' => '',
    //             'comment_err' => ''
    //         ];

    //         $this->view('pages/student/companyDescription', $data);
    //     }
    // }
 
    // public function internshipDescription($id)
    // {
    //     if (isset($_SESSION['user_id'])) {
    //         $userId = $_SESSION['user_id']; 
    //     }
    //     else {
    //         $userId = null;
    //         $bookmarkedJobs = []; // No bookmarks if not logged in
    //         $posts = [];
    //         $posts_com_id = [];
    //         $reviews = [];
    //     }    
    
    //     // Get bookmarked jobs for the user
    //     $bookmarkedJobs = $this->model('jobModel')->getBookmarkedJobs($userId);
    //     $bookmarkedJobIds = array_column($bookmarkedJobs, 'JobID');
    //     $posts = $this->model('M_jobpost')->getpostbyid($id);
    //     $posts_com_id = $this->model('M_jobpost')->getpostbycompanyid($id);
    //     $reviews = $this->model('RateAndReviewModel')-> getReviewsByCompanyId($id);

    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
    //         $data =[
    //             'post' => $posts,
    //             'post_com' => $posts_com_id,
    //             'bookmarkedJobs' => $bookmarkedJobs,
    //             'bookmarkedJobIds' => $bookmarkedJobIds,
    //             'reviews' => $reviews,
    //             'rating' => $_POST['rating'] ?? '',
    //             'comment' => trim($_POST['comment'] ?? ''),
    //             'user_id' => $_POST['user_id'] ?? '',
    //             'company_id' => $_POST['company_id'] ?? '',
    //             'rating_err' => '',
    //             'comment_err' => ''
    //         ];
        
    //         if (empty($data['rating'])) {
    //             $data['rating_err'] = 'Please provide a rating.';
    //         }
    //         if (empty($data['comment'])) {
    //             $data['comment_err'] = 'Please provide a comment.';
    //         }

    //         // Check for errors
    //         if (empty($data['rating_err']) && empty($data['comment_err'])) {
    //             if ($this->model('RateAndReviewModel')->addReview($data)) {
    //                 Redirect::to(URLROOT . '/student/addReview/'.$data['company_id']);  //To be corrected
    //             } else {
    //                 die('Something went wrong'); // Improved error handling suggested
    //             }
    //         } else {
    //             // Load view with errors
    //             $this->view('pages/student/rate_review_company', $data);
    //         }
    //     } else {
    //         $data = [
    //             'post' => $posts,
    //             'post_com' => $posts_com_id,
    //             'bookmarkedJobs' => $bookmarkedJobs,
    //             'bookmarkedJobIds' => $bookmarkedJobIds,
    //             'reviews' => $reviews,
    //             'rating' => '',
    //             'comment' => '',
    //             'user_id' => '',
    //             'company_id' => $_POST['company_id'] ?? '',
    //             'rating_err' => '',
    //             'comment_err' => ''
    //         ];

    //         $this->view('pages/student/internshipDescription', $data);
    //     }    
    // }


    public function jobsApply($jobId) {
        // Load model and get application fields
        $applicationFields = $this->model('M_applicationFields')->getFieldsByJobId($jobId);
    
        // Fetch job details
        $job = $this->model('M_jobpost')->getpostbyid($jobId);
    
        $data = [
            'fields' => $applicationFields,
            'job' => $job, // Pass job data to the view
        ];
    
        $this->view('pages/student/jobsApply', $data); 
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
  
    // public function jobsDescription($id){
        
    //     if (isset($_SESSION['user_id'])) {
    //         $userId = $_SESSION['user_id']; 
    //     }
    //     else {
    //         $userId = null;
    //         $bookmarkedJobs = []; // No bookmarks if not logged in
    //         $posts = [];
    //         $posts_com_id = [];
    //         $reviews = [];
    //     }    
    
    //     // Get bookmarked jobs for the user
    //     $posts = $this->model('M_jobpost')->getpostbyid($id);
        
    //     if ($posts->Category == 'Internship') {
    //         $bookmarkedJobs = $this->model('jobModel')->getBookmarkedInternships($userId);         
    //     } 
    //     else {
    //         $bookmarkedJobs = $this->model('jobModel')->getBookmarkedJobs($userId);
    //     }    
    //     $bookmarkedJobIds = array_column($bookmarkedJobs, 'JobID');
    //     $posts_com_id = $this->model('M_jobpost')->getpostbycompanyid($id);
    //     $reviews = $this->model('RateAndReviewModel')-> getReviewsByCompanyId($id);
         
        

    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
    //         $data =[
    //             'post' => $posts,
    //             'post_com' => $posts_com_id,
    //             'bookmarkedJobs' => $bookmarkedJobs,
    //             'bookmarkedJobIds' => $bookmarkedJobIds,
    //             'reviews' => $reviews,
    //             'rating' => $_POST['rating'] ?? '',
    //             'comment' => trim($_POST['comment'] ?? ''),
    //             'user_id' => $_POST['user_id'] ?? '',
    //             'company_id' => $_POST['company_id'] ?? '',
    //             'rating_err' => '',
    //             'comment_err' => ''
    //         ];
    //         if (empty($data['rating'])) {
    //             $data['rating_err'] = 'Please provide a rating.';
    //         }
    //         if (empty($data['comment'])) {
    //             $data['comment_err'] = 'Please provide a comment.';
    //         }

    //         // Check for errors
    //         if (empty($data['rating_err']) && empty($data['comment_err'])) {
    //             if ($this->model('RateAndReviewModel')->addReview($data)) {
    //                 Redirect::to(URLROOT . '/student/addReview/'.$data['company_id']); //To be corrected
    //             } else {
    //                 die('Something went wrong'); // Improved error handling suggested
    //             }
    //         } else {
    //             // Load view with errors
    //             $this->view('pages/student/rate_review_company', $data);
    //         }
    //     } else {
    //         $data = [
    //             'post' => $posts,
    //             'post_com' => $posts_com_id,
    //             'bookmarkedJobs' => $bookmarkedJobs,
    //             'bookmarkedJobIds' => $bookmarkedJobIds,
    //             'reviews' => $reviews,
    //             'rating' => '',
    //             'comment' => '',
    //             'user_id' => '',
    //             'company_id' => $posts->CompanyID,
    //             'rating_err' => '',
    //             'comment_err' => ''
    //         ];

    //         $this->view('pages/student/jobsDescription', $data);
    //     }    
    
    // }

    public function myreviews()
    {
        $reviews = $this->model('RateAndReviewModel')->getReviewsByStuId($_SESSION['user_id']);

        $data = [
            'reviews' => $reviews
        ];

        $this->view('pages/student/myreviews', $data);

    }

}
