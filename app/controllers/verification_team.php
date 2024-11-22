<?php
class Verification_team extends Controller
{
    private $model;

    public function __construct()
    {
        // Load model
        $this->model = $this->model('userModel');
    }

    public function index()
    {
        echo 'verification_team/index';
    }

    public function user_verified()
    {
        $this->view('pages/verification_team/user_verified');
    }

    public function job_verified()
    {
        $this->view('pages/verification_team/job_verified');
    }

    public function user_ver_pending()
    {
        try {
            $users = $this->model->getPendingStudentsAndCompanies();
            $data = [
                'users' => $users
            ];
            $this->view('pages/verification_team/user_ver_pending', $data);
        } catch (Exception $e) {
            die($e->getMessage());//TODO: Handle this
        }
    }

    public function user_ver_not()
    {
        try {
            $users = $this->model->getNotVerifiedStudentsAndCompanies();
            $data = [
                'users' => $users
            ];
            $this->view('pages/verification_team/user_ver_not', $data);
        } catch (Exception $e) {
            die($e->getMessage());//TODO: Handle this
        }
    }

    public function user_ver_detail($userID)
    {
        try {
            $user = $this->model->getUserDetails($userID);
            $data = [
                'user' => $user
            ];
            if ($user['Role'] == 'Student') {
                $this->view('pages/verification_team/stu_ver_detail', $data);
            } else if ($user['Role'] == 'Company') {
                $this->view('pages/verification_team/com_ver_detail', $data);
            }
        } catch (Exception $e) {
            die($e->getMessage());//TODO: Handle this
        }
    }

    public function stu_detail() {
        $this->view('pages/verification_team/stu_detail');
    }

    public function com_detail() {
        $this->view('pages/verification_team/com_detail');
    }

    public function user_ver_approve($userID)
    {
        try {
            $this->model->approveUser($userID);
            Redirect::to(URLROOT . '/verification_team/user_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage());//TODO: Handle this
        }
    }

    public function user_ver_reject($userID)
    {
        try {
            $this->model->rejectUser($userID);
            Redirect::to(URLROOT . '/verification_team/user_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage());//TODO: Handle this
        }
    }

    public function job_ver_pending()
    {
        $this->view('pages/verification_team/job_ver_pending');
    }

    public function job_ver_not()
    {
        $this->view('pages/verification_team/job_ver_not');
    }
}
