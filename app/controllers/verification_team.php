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

    public function user_ver_all()
    {
        try {
            $users = $this->model->getAllStudentsAndCompanies();
            $data = [
                'users' => $users
            ];
            $this->view('pages/verification_team/user_ver_all', $data);
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
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

    public function job_ver_all()
    {
        $this->view('pages/verification_team/job_ver_all');
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
