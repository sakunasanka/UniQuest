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

    public function jobs($queryParam = [])
    {
        // Get the requested data from query params
        $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
        $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 12;

        // Fetch part-time job posts
        $post_data = $this->model('M_jobpost')->getPartTimeJobs($page, $limit);
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
            'rowsPerPage' => $post_data['limit']
        ];

        // Load the view with the data
        $this->view('pages/student/jobs', $data);
    }

    public function internships($queryParam = [])
    {
        // Get the requested data from query params
        $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
        $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 12;
        // Retrieve internship jobs
        $post_data = $this->model('M_jobpost')->getInternshipJobs($page, $limit);
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
            'rowsPerPage' => $post_data['limit']
        ];

        $this->view('pages/student/jobs', $data); // Render internships view
    }


    public function companies($queryParam = [])
    {
        // Get the requested data from query params
        $page = isset($queryParam['page']) ? $queryParam['page'] : 1;
        $limit = isset($queryParam['limit']) ? $queryParam['limit'] : 12;
        $post_data = $this->model('userModel')->getcompany($page, $limit);
        $posts = $post_data['data'];
        $displayRatings = [];

        // Loop through each job post to get the display rating for the associated company
        foreach ($posts as $post) {
            $companyID = $post->CompanyID; // Assuming each job post has a CompanyID field
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
            'rowsPerPage' => $post_data['limit']
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

            $this->view('pages/student/jobsDescription', $data);
        }
    }

    public function companyDescription($id)
    {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id']; 

        $bookmarkedCompanies = $this->model('companyModel')->getBookmarkedCompanies($userId);
        $bookmarkedCompanyIds = array_column($bookmarkedCompanies, 'CompanyID');
        } 
        else {
            $userId = null;
            $bookmarkedCompanies = []; // No bookmarks if not logged in
            $bookmarkedCompanyIds = [];
        }
        $posts = $this->model('M_jobpost')->getpostbycompanyid($id);
        $reviews = $this->model('RateAndReviewModel')->getReviewsByCompanyId($posts->CompanyID);

        foreach ($reviews as $review) {
            $review->StudentName = $this->model('RateAndReviewModel')->getAnonymousName($review->StudentID);
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
        }
        else {
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
        $reviews = $this->model('RateAndReviewModel')-> getReviewsByCompanyId($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            $data =[
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
}
