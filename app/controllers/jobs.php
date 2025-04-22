<?php

class Jobs extends Controller
{
    private $model;

    public function __construct()
    {
        // // Check if user is logged in
        // AuthMiddleware::requireAuth();
        // // Check if user has the required role
        // AuthMiddleware::requireRole('Student');

        // Load model
        $this->model = $this->model('jobModel');
    }

    public function auth($method)
    {
        $protectedMethods = ['bookmarkJob', 'removeBookmark', 'toggleBookmark'];
        if (in_array($method, $protectedMethods)) {
            AuthMiddleware::requireAuth();
            AuthMiddleware::requireRole('Student');
        }
    }

    public function index()
    {
        $this->jobs();
    }

    public function bookmarkJob()
    {
        // Ensure the request is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Validate session user ID
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id']; // Get user ID from session
            } else {
                http_response_code(403); // Return 403 forbidden status
                echo "User not logged in!";
                return;
            }

            // Get job ID from POST data
            $jobId = $_POST['job_id'] ?? null; // Use null coalescing operator to avoid undefined index

            // Check if job ID is provided
            if (!empty($jobId)) {
                // Attempt to bookmark the job
                if ($this->model->addUserPostBookmark($jobId)) {
                    echo "Bookmark added successfully!";
                } else {
                    echo "Failed to add bookmark. Please check the database.";
                }
            } else {
                echo "Job ID is missing!";
            }
        } else {
            echo "Invalid request method.";
        }
    }

    // Remove bookmark
    public function removeBookmark()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate session user ID
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id']; // Get user ID from session
            } else {
                http_response_code(403); // Return 403 forbidden status
                echo "User not logged in!";
                return;
            }

            // Get job ID from POST data
            $jobId = $_POST['job_id'] ?? null; // Use null coalescing operator to avoid undefined index

            // Check if job ID is provided
            if (!empty($jobId)) {
                // Attempt to remove the bookmark
                if ($this->model->removeBookmark($jobId)) {
                    echo "Bookmark removed successfully!";
                } else {
                    echo "Failed to remove bookmark. Please check the database.";
                }
            } else {
                echo "Job ID is missing!";
            }
        } else {
            echo "Invalid request method.";
        }
    }

    // Toggle bookmark
    public function toggleBookmark()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate session user ID
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id']; // Get user ID from session
            } else {
                http_response_code(403); // Return 403 forbidden status
                echo "User not logged in!";
                return;
            }

            // Get job ID from POST data
            $jobId = $_POST['job_id'] ?? null; // Use null coalescing operator to avoid undefined index

            // Check if job ID is provided
            if (!empty($jobId)) {
                // Check if the job is already bookmarked
                if ($this->model->isJobBookmarked($jobId)) {
                    // If bookmarked, remove the bookmark
                    if ($this->model->removeBookmark($jobId)) {
                        echo "Bookmark removed successfully!";
                    } else {
                        echo "Failed to remove bookmark. Please check the database.";
                    }
                } else {
                    // If not bookmarked, add the bookmark
                    if ($this->model->addUserPostBookmark($jobId)) {
                        echo "Bookmark added successfully!";
                    } else {
                        echo "Failed to add bookmark. Please check the database.";
                    }
                }
            } else {
                echo "Job ID is missing!";
            }
        } else {
            echo "Invalid request method.";
        }
    }

    // Add like/dislike status methods to the Jobs controller
    public function updateLikeStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate session user ID
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id']; // Get user ID from session
            } else {
                http_response_code(403); // Return 403 forbidden status
                echo "User not logged in!";
                return;
            }

            // Get review ID and like status from POST data
            $reviewId = $_POST['review_id'] ?? null;
            $isLiked = $_POST['is_liked'] ?? false;
            $isLiked = filter_var($isLiked, FILTER_VALIDATE_BOOLEAN);
            // Check if review ID is provided
            if (!empty($reviewId)) {
                if ($isLiked) {
                    // Add like to review
                    if ($this->model('RateAndReviewModel')->addLike($reviewId, $userId)) {
                        echo "Like added successfully!";                  
                        
                    } else {
                        echo "Failed to add like.";
                    }
                } else {
                    // Remove like from review
                    if ($this->model('RateAndReviewModel')->removeLike($reviewId, $userId)) {
                        echo "Like removed successfully!";
                    } else {
                        echo "Failed to remove like.";
                    }
                }
            } else {
                echo "Review ID is missing!";
            }
        } else {
            echo "Invalid request method.";
        }
    }

    public function updateDislikeStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate session user ID
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id']; // Get user ID from session
            } else {
                http_response_code(403); // Return 403 forbidden status
                echo "User not logged in!";
                return;
            }

            // Get review ID and dislike status from POST data
            $reviewId = $_POST['review_id'] ?? null;
            $isDisliked = $_POST['is_disliked'] ?? false;
            $isDisliked = filter_var($isDisliked, FILTER_VALIDATE_BOOLEAN);

            // Check if review ID is provided
            if (!empty($reviewId)) {
                if ($isDisliked) {
                    // Add dislike to review
                    if ($this->model('RateAndReviewModel')->addDislike($reviewId, $userId)) {
                        echo "Dislike added successfully!";
                    } else {
                        echo "Failed to add dislike.";
                    }
                } else {
                    // Remove dislike from review
                    if ($this->model('RateAndReviewModel')->removeDislike($reviewId, $userId)) {
                        echo "Dislike removed successfully!";
                    } else {
                        echo "Failed to remove dislike.";
                    }
                }
            } else {
                echo "Review ID is missing!";
            }
        } else {
            echo "Invalid request method.";
        }
    }

    // In your controller
    public function getCitiesByDistrict() {
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

    public function jobs($queryParam = [])
    {
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

        // Fetch part-time job posts
        $post_data = $this->model('M_jobpost')->getPartTimeJobs($page, $limit, $sort, $order, $search, $filters);
        $posts = $post_data['data'];
        $displayRatings = [];

        // Loop through each job post to get the display rating for the associated company
        foreach ($posts as $post) {
            $companyID = $post->CompanyID; // Assuming each job post has a CompanyID field
            $displayRatings[$companyID] = $this->model('RateAndReviewModel')->getDisplayRating($companyID);
        }

        // Check if the user is logged in
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id']; // Get user ID from session

            // Get bookmarked jobs for the user
            $bookmarkedJobs = $this->model('jobModel')->getBookmarkedJobs($userId);
            $bookmarkedJobIds = array_column($bookmarkedJobs, 'JobID');
        } else {
            $userId = null;
            $bookmarkedJobs = []; // No bookmarks if not logged in
            $bookmarkedJobIds = [];
        }

        // Prepare data to pass to the view
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

        // Load the view with the data
        $this->view('pages/student/jobs', $data);
    }

    public function internships($queryParam = [])
    {
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

        // Retrieve internship jobs
        $post_data = $this->model('M_jobpost')->getInternshipJobs($page, $limit, $sort, $order, $search, $filters);
        $posts = $post_data['data'];
        $displayRatings = [];

        // Loop through each job post to get the display rating for the associated company
        foreach ($posts as $post) {
            $companyID = $post->CompanyID; // Assuming each job post has a CompanyID field
            $displayRatings[$companyID] = $this->model('RateAndReviewModel')->getDisplayRating($companyID);
        }

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id']; // Get user ID from session

            // Get bookmarked jobs for the user
            $bookmarkedJobs = $this->model('jobModel')->getBookmarkedInternships($userId);
            $bookmarkedJobIds = array_column($bookmarkedJobs, 'JobID');
        } else {
            $userId = null;
            $bookmarkedJobs = []; // No bookmarks if not logged in
            $bookmarkedJobIds = [];
        }

        $data = [
            'posts' => $posts,
            'bookmarkedJobs' => $bookmarkedJobs,
            'bookmarkedJobIds' => $bookmarkedJobIds,
            'displayRatings' => $displayRatings, // Add display ratings to the data array
            'totalRows' => $post_data['totalRows'],
            'rowsPerPage' => $post_data['limit'],
            'districts' => $this->model('AdminModel')->getDistricts()['data'], // Get districts for filtering
            'cities' => [], //Initially empty, will be populated based on selected district
            'industries' => $this->model('AdminModel')->getIndustries()['data'], // Get industries for filtering
        ];

        $this->view('pages/student/jobs', $data); // Render internships view
    }


    public function companies($queryParam = [])
    {
        // Get the requested data from query params
        $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
        $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 12;
        $sort = isset($queryParam['sort']) ? $queryParam['sort'] : 'UserID';
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
        $post_data = $this->model('userModel')->getcompany($page, $limit, $sort, $order, $search, $filters);
        $posts = $post_data['data'];
        $displayRatings = [];

        // Loop through each job post to get the display rating for the associated company
        foreach ($posts as $post) {
            $companyID = $post->UserID; // Assuming each job post has a CompanyID field
            $displayRatings[$companyID] = $this->model('RateAndReviewModel')->getDisplayRating($companyID);
        }

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id']; // Get user ID from session

            // Get bookmarked companies for the user
            $bookmarkedCompanies = $this->model('jobModel')->getBookmarkedCompanies($userId);
            $bookmarkedCompanyIds = array_column($bookmarkedCompanies, 'CompanyID');
        } else {
            $userId = null;
            $bookmarkedCompanies = []; // No bookmarks if not logged in
            $bookmarkedCompanyIds = [];
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

        $this->view('pages/student/company', $data);
    }

    public function jobsDescription($id)
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

        // Get bookmarked jobs for the user
        $posts = $this->model('M_jobpost')->getpostbyid($id);
        $reviews = $this->model('RateAndReviewModel')->getReviewsByCompanyId($posts->CompanyID);
        $displayRating = $this->model('RateAndReviewModel')->getDisplayRating($posts->CompanyID);

        if ($posts->Category == 'Internship') {
            $bookmarkedJobs = $this->model('jobModel')->getBookmarkedInternships($userId);
        } else {
            $bookmarkedJobs = $this->model('jobModel')->getBookmarkedJobs($userId);
        }
        $bookmarkedJobIds = array_column($bookmarkedJobs, 'JobID');
        $posts_com_id = $this->model('M_jobpost')->getpostbycompanyid($id);

        // Replace reviewer names with anonymous names
        foreach ($reviews as $review) {
            $review->StudentName = $this->model('RateAndReviewModel')->getAnonymousName($review->StudentID);
            $review->LikeCount = $this->model('RateAndReviewModel')->getLikesByReviewID($review->ReviewID);
            $review->DislikeCount = $this->model('RateAndReviewModel')->getDislikesByReviewID($review->ReviewID);
            $review->is_liked = $this->model('RateAndReviewModel')->checkIfLiked($review->ReviewID, $userId);
            $review->is_disliked = $this->model('RateAndReviewModel')->checkIfDisliked($review->ReviewID, $userId);
        }

        // Check if the user has already reviewed the company
        $existingReview = $this->model('RateAndReviewModel')->getReviewByStudentAndCompany($userId, $posts->CompanyID);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'post' => $posts,
                'post_com' => $posts_com_id,
                'bookmarkedJobs' => $bookmarkedJobs,
                'bookmarkedJobIds' => $bookmarkedJobIds,
                'displayRating' => $displayRating,
                'reviews' => $reviews,
                'rating' => $_POST['rating'] ?? '',
                'comment' => trim($_POST['comment'] ?? ''),
                'user_id' => $_POST['user_id'] ?? '',
                'company_id' => $_POST['company_id'] ?? '',
                'rating_err' => '',
                'comment_err' => '',
                'existingReview' => $existingReview
            ];

            if (empty($data['rating'])) {
                $data['rating_err'] = 'Please provide a rating.';
            }
            if (empty($data['comment'])) {
                $data['comment_err'] = 'Please provide a comment.';
            }

            // Check for errors
            if (empty($data['rating_err']) && empty($data['comment_err'])) {
                if ($existingReview) {
                    // Update existing review
                    $data['review_id'] = $existingReview->ReviewID;
                    if ($this->model('RateAndReviewModel')->updateReview($data)) {
                        Redirect::to(URLROOT . '/student/myreviews');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    // Add new review
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
                'post' => $posts,
                'user' => $this->model('userModel')->getUserDetails($posts->CompanyID),
                'receiver_id' => $posts->CompanyID,
                'messageInput' => '',
                'messageInput_err' => '',
                'post_com' => $posts_com_id,
                'bookmarkedJobs' => $bookmarkedJobs,
                'bookmarkedJobIds' => $bookmarkedJobIds,
                'displayRating' => $displayRating,
                'reviews' => $reviews,
                'rating' => $existingReview ? $existingReview->Rating : '',
                'comment' => $existingReview ? $existingReview->Comment : '',
                'user_id' => $userId,
                'company_id' => $posts->CompanyID,
                'rating_err' => '',
                'comment_err' => '',
                'existingReview' => $existingReview
            ];

            if (isset($_SESSION['user_id'])) {
                $data['sender_id'] = $_SESSION['user_id'];
                $data['messages'] = $this->model('chatModel')->getMessages($_SESSION['user_id'], $posts->CompanyID);

            }

            $this->view('pages/student/jobsDescription', $data);
        }
    }

    public function sendMessage($id)
    {

        $posts = $this->model('M_jobpost')->getpostbyid($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $previousMessage = $this->model('chatModel')->getLastMessageBetween($_SESSION['user_id'], $posts->CompanyID);
            $lastTopic = $previousMessage ? $previousMessage->topic : 'General Information';
            $submittedTopic = trim($_POST['topic'] ?? '');

            // Fetch email
            $email = null;
            if ($previousMessage && !empty($previousMessage->user_email)) {
                $email = $previousMessage->user_email;
            } elseif ($this->model('userModel')->getUserDetails($posts->CompanyID)) {
                $userDetails = $this->model('userModel')->getUserDetails($posts->CompanyID);
                $email = $userDetails->email ?? null;
            }
            $data = [
                'email' => $email,
                'post' => $posts,
                'user' => $this->model('userModel')->getUserDetails($posts->CompanyID),
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => $posts->CompanyID,
                'messages' => $this->model('chatModel')->getMessages($_SESSION['user_id'], $posts->CompanyID),
                'messageInput' => trim($_POST['messageInput'] ?? ''),
                'topic' => !empty($submittedTopic) ? $submittedTopic : $lastTopic,
                'messageInput_err' => ''
            ];

            if (empty($data['messageInput'])) {
                $data['messageInput_err'] = 'Message cannot be empty';
            }

            // Ensure no errors before proceeding
            if (empty($data['messageInput_err'])) {
                if ($this->model('chatModel')->sendMessage($data['email'], $data['sender_id'], $data['receiver_id'], $data['topic'], $data['messageInput'], $data['email'])) {
                    notifyMessageToCompanyFromStudent($data['receiver_id'], $data['messageInput'], $data['sender_id'], $_SESSION['user_name']);
                    $_SESSION['show_contact_us_success'] = true;
                    Redirect::to(URLROOT . '/jobs/jobsdescription/' . $id);
                } else {
                    $_SESSION['show_contact_us_error'] = true;
                    die('Something went wrong while sending the message.');
                }
            } else {
                // Reload view with errors
                $this->view('pages/student/jobsDescription', $data);
            }
        } else {
            $data = [
                'email' => '',
                'post' => $posts,
                'user' => $this->model('userModel')->getUserDetails($posts->CompanyID),
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => $posts->CompanyID,
                'messages' => $this->model('chatModel')->getMessages($_SESSION['user_id'], $posts->CompanyID),
                'messageInput' => '',
                'messageInput_err' => '',
                'topic' => '',
            ];

            $this->view('pages/student/jobsDescription', $data);
        }
    }

    public function companyDescription($id)
    {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            $bookmarkedCompanies = $this->model('companyModel')->getBookmarkedCompanies($userId);
            $bookmarkedCompanyIds = array_column($bookmarkedCompanies, 'CompanyID');
        } else {
            $userId = null;
            $bookmarkedCompanies = []; // No bookmarks if not logged in
            $bookmarkedCompanyIds = [];
        }
        $posts = $this->model('M_jobpost')->getpostbycompanyid($id);
        $jobs = $this->model('M_jobpost')->getJobsByCompanyId($id);
        $reviews = $this->model('RateAndReviewModel')->getReviewsByCompanyId($posts->UserID);

        foreach ($reviews as $review) {
            $review->StudentName = $this->model('RateAndReviewModel')->getAnonymousName($review->StudentID);
            $review->LikeCount = $this->model('RateAndReviewModel')->getLikesByReviewID($review->ReviewID);
            $review->DislikeCount = $this->model('RateAndReviewModel')->getDislikesByReviewID($review->ReviewID);
            $review->is_liked = $this->model('RateAndReviewModel')->checkIfLiked($review->ReviewID, $userId);
            $review->is_disliked = $this->model('RateAndReviewModel')->checkIfDisliked($review->ReviewID, $userId);
        }

        $existingReview = $this->model('RateAndReviewModel')->getReviewByStudentAndCompany($userId, $posts->UserID);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Prepare data for the review
            $data = [
                'post' => $posts,
                'jobs' => $jobs,
                'bookmarkedCompanies' => $bookmarkedCompanies,
                'bookmarkedCompanyIds' => $bookmarkedCompanyIds,
                'reviews' => $reviews,
                'rating' => $_POST['rating'] ?? '',
                'comment' => trim($_POST['comment'] ?? ''),
                'user_id' => $_POST['user_id'] ?? '',
                'company_id' => $_POST['company_id'] ?? '',
                'rating_err' => '',
                'comment_err' => '',
                'existingReview' => $existingReview
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
                if ($existingReview) {
                    // Update existing review
                    $data['review_id'] = $existingReview->ReviewID;
                    if ($this->model('RateAndReviewModel')->updateReview($data)) {
                        Redirect::to(URLROOT . '/student/myreviews');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    // Add new review
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
                'post' => $posts,
                'user' => $this->model('userModel')->getUserDetails($posts->UserID),
                'receiver_id' => $posts->UserID,
                'messageInput' => '',
                'messageInput_err' => '',
                'jobs' => $jobs,
                'bookmarkedCompanies' => $bookmarkedCompanies,
                'bookmarkedCompanyIds' => $bookmarkedCompanyIds,
                'reviews' => $reviews,
                'rating' => $existingReview ? $existingReview->Rating : '',
                'comment' => $existingReview ? $existingReview->Comment : '',
                'user_id' => '',
                'company_id' => $id,
                'rating_err' => '',
                'comment_err' => '',
                'existingReview' => $existingReview
            ];

            if (isset($_SESSION['user_id'])) {
                $data['sender_id'] = $_SESSION['user_id'];
                $data['messages'] = $this->model('chatModel')->getMessages($_SESSION['user_id'], $posts->UserID);

            }

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
                    Redirect::to(URLROOT . '/student/myreviews');
                } else {
                    die('Something went wrong');
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

    public function trendyCompany()
    {
        $trendy_companies = $this->model('RateAndReviewModel')->getTrendyCompanies();

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id']; // Get user ID from session

            // Get bookmarked companies for the user
            $bookmarkedCompanies = $this->model('jobModel')->getBookmarkedCompanies($userId);
            $bookmarkedCompanyIds = array_column($bookmarkedCompanies, 'CompanyID');
        } else {
            $userId = null;
            $bookmarkedCompanies = []; // No bookmarks if not logged in
        }

        $data = [
            'trendy_companies' => $trendy_companies,
            'bookmarkedCompanies' => $bookmarkedCompanies,
            'bookmarkedCompanyIds' => $bookmarkedCompanyIds
        ];

        if (isset($_SESSION['user_role'])) {
            $this->view('pages/student/trendyCompany', $data);
        } else {
            Redirect::to(URLROOT . '/login');
        }
    }
}