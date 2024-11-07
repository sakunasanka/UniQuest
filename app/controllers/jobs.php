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
        echo 'jobs/index';
    }

    public function addBookmarkJob($id) 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          $jobId = $_POST['jobId'];
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
            //   $this->model->deleteUserPostBookmark($data);
              echo 0;
            }
          } else {
            echo 0;
          }
        }
      }

      public function addBookmarkCompany($id) 
      {
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $companyId = $_POST['companyId'];
            if (isset($_SESSION['user_id'])) {
              $user_id = $_SESSION['user_id'];
              $data = [
                'companyId' => $companyId,
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
}
?>