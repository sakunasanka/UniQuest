<?php

class Company extends Controller
{
    private $model;

    public function __construct()
    {
        // Check if user is logged in
        AuthMiddleware::requireAuth();
        // Check if user has the required role
        AuthMiddleware::requireRole('Student');
        
        // Load model
        $this->model = $this->model('companyModel');
    }

    public function index()
    {   
        $data = [];
        $this->view('pages/student/company', $data);
    }

    public function bookmarkCompany()
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

            // Get company ID from POST data
            $companyId = $_POST['company_id'] ?? null; // Use null coalescing operator to avoid undefined index

            // Check if company ID is provided
            if (!empty($companyId)) {
                // Attempt to bookmark the company
                if ($this->model->addUserPostBookmark($companyId)) {
                    echo "Bookmark added successfully!";
                } else {
                    echo "Failed to add bookmark. Please check the database.";
                }
            } else {
                echo "Company ID is missing!";
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

            // Get company ID from POST data
            $companyId = $_POST['company_id'] ?? null; // Use null coalescing operator to avoid undefined index

            // Check if company ID is provided
            if (!empty($companyId)) {
                // Attempt to remove the bookmark
                if ($this->model->removeBookmark($companyId)) {
                    echo "Bookmark removed successfully!";
                } else {
                    echo "Failed to remove bookmark. Please check the database.";
                }
            } else {
                echo "Company ID is missing!";
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

            // Get company ID from POST data
            $companyId = $_POST['company_id'] ?? null; // Use null coalescing operator to avoid undefined index

            // Check if company ID is provided
            if (!empty($companyId)) {
                // Check if the company is already bookmarked
                if ($this->model->isCompanyBookmarked($companyId)) {
                    // If bookmarked, remove the bookmark
                    if ($this->model->removeBookmark($companyId)) {
                        echo "Bookmark removed successfully!";
                    } else {
                        echo "Failed to remove bookmark. Please check the database.";
                    }
                } else {
                    // If not bookmarked, add the bookmark
                    if ($this->model->addUserPostBookmark($companyId)) {
                        echo "Bookmark added successfully!";
                    } else {
                        echo "Failed to add bookmark. Please check the database.";
                    }
                }
            } else {
                echo "Company ID is missing!";
            }
        } else {
            echo "Invalid request method.";
        }
    }
}
?>