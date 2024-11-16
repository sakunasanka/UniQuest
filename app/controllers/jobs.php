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

    public function addBookmarkJob($id) 
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
              if (!$this->model->checkUserPostBookmark($data)) {
                if ($status = $this->model->addUserPostBookmark($data)) {
                  echo $status;
                }
              } else {
                // $this->model->deleteUserCompanyBookmark($data);
                echo 0;
              }
            } else {
              echo 0;
            }
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