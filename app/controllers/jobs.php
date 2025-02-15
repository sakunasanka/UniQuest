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

    public function jobs()
    {
        // Fetch part-time job posts
        $posts = $this->model('M_jobpost')->getPartTimeJobs();
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
            'displayRatings' => $displayRatings // Add display ratings to the data array
        ];

        // Load the view with the data
        $this->view('pages/student/jobs', $data);
    }

    public function internships()
    { {
            // Retrieve internship jobs
            $posts = $this->model('M_jobpost')->getInternshipJobs();
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
            }

            $data = [
                'posts' => $posts,
                'bookmarkedJobs' => $bookmarkedJobs,
                'bookmarkedJobIds' => $bookmarkedJobIds,
                'displayRatings' => $displayRatings // Add display ratings to the data array
            ];

            $this->view('pages/student/jobs', $data); // Render internships view
        }
    }

    public function companies()
    { {
            $posts = $this->model('userModel')->getcompany();
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
            }

            $data = [
                'posts' => $posts,
                'bookmarkedCompanies' => $bookmarkedCompanies,
                'bookmarkedCompanyIds' => $bookmarkedCompanyIds,
                'displayRatings' => $displayRatings
            ];

            $this->view('pages/student/company', $data);
        }
    }
}
