<?php

class Jobs extends Controller
{
    private $model;

    public function __construct()
    {
        // Load model
        $this->model = $this->model('JobModel');
    }

    public function index()
    {
        $data = [];
        $this->view('pages/student/jobs', $data);
    }

    // New method to handle the bookmarking action
    public function bookmarkJob()
    {
        // Example user ID (should come from session or authentication system)
        $userId = 1; // For now, use a hardcoded user ID
        $jobId = $_POST['job_id']; // Get job ID from the POST request

        // Check if job ID is provided
        if (!empty($jobId)) {
            if ($this->model->addUserPostBookmark($userId, $jobId)) {
                echo "Bookmark added successfully";
            } else {
                echo "Failed to add bookmark. Please check the database.";
            }
        } else {
            echo "Job not found!";
        }
    }

    public function checkBookmark()
    {
        // Example user ID (should come from session or authentication system)
        $userId = 1; // For now, use a hardcoded user ID
        $jobId = $_POST['job_id']; // Get job ID from the POST request

        $this->model->isJobBookmarked($userId, $jobId);
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

      // public function addBookmarkCompany($id) 
      // {
      //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      //       $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      //       $companyId = $_POST['companyId'];
      //       if (isset($_SESSION['user_id'])) {
      //         $user_id = $_SESSION['user_id'];
      //         $data = [
      //           'companyId' => $companyId,
      //           'studentId' => $user_id
      //         ];
      //         if (!$this->model->checkUserPostBookmark($data)) {
      //           if ($status = $this->model->addUserPostBookmark($data)) {
      //             echo $status;
      //           }
      //         } else {
      //           // $this->model->deleteUserCompanyBookmark($data);
      //           echo 0;
      //         }
      //       } else {
      //         echo 0;
      //       }
      //     }
      //   }
}
?>