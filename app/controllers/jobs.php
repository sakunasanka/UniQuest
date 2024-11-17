<?php
session_start();

class Jobs extends Controller
{
    private $model;

    public function __construct()
    {
        // Load model
        $this->model = $this->model('jobModel');

    }

    public function index()
    {   
      if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id']; // Get user ID from session
        } else {
            // Handle the case when user is not logged in
            $userId = null;
        }
        $data['posts'] = $this->model->getBookmarkedJobs($userId); 
        $this->view('pages/student/jobs', $data);
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
                if ($this->model->addUserPostBookmark($userId, $jobId)) {
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

    //remove bookmark
    public function removeBookmark(){
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
                if ($this->model->removeBookmark($userId, $jobId)) {
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

    //toggle bookmark
    public function toggleBookmark(){
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
                if ($this->model->isJobBookmarked($userId, $jobId)) {
                    // If bookmarked, remove the bookmark
                    if ($this->model->removeBookmark($userId, $jobId)) {
                        echo "Bookmark removed successfully!";
                    } else {
                        echo "Failed to remove bookmark. Please check the database.";
                    }
                } else {
                    // If not bookmarked, add the bookmark
                    if ($this->model->addUserPostBookmark($userId, $jobId)) {
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


    public function checkUserPostBookmark()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $jobId = $_POST['jobID'];
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $data = [
                    'jobId' => $jobId,
                    'studentId' => $user_id
                ];
                if ($this->model->checkUserPostBookmark($data)) {
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                echo 0;
            }
        }
    }

    // // public function removeBookmark()
    // public function removeBookmark()
    // {
    //     // Example user ID (should come from session or authentication system)
    //     $userId = 1; // For now, use a hardcoded user ID
    //     $jobId = $_POST['job_id']; // Get job ID from the POST request

    //     // Check if job ID is provided
    //     if (!empty($jobId)) {
    //         if ($this->model->removeBookmark($userId, $jobId)) {
    //             echo "Bookmark removed successfully";
    //         } else {
    //             echo "Failed to remove bookmark. Please check the database.";
    //         }
    //     } else {
    //         echo "Job not found!";
    //     }

    //   public function addBookmarkCompany($id) 
    //   {
    //       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    //         $companyId = $_POST['companyId'];
    //         if (isset($_SESSION['user_id'])) {
    //           $user_id = $_SESSION['user_id'];
    //           $data = [
    //             'companyId' => $companyId,
    //             'studentId' => $user_id
    //           ];
    //           if (!$this->model->checkUserPostBookmark($data)) {
    //             if ($status = $this->model->addUserPostBookmark($data)) {
    //               echo $status;
    //             }
    //           } else {
    //             // $this->model->deleteUserCompanyBookmark($data);
    //             echo 0;
    //           }
    //         } else {
    //           echo 0;
    //         }
    //       }
    //     }
}
?>