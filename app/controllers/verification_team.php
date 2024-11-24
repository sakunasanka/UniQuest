<?php
class Verification_team extends Controller
{
    public function __construct()
    {
        // echo 'Pages loaded';
    }

    public function index()
    {
        echo 'verification_team/index';
    }

    public function user_ver_all()
    {
        $this->view('pages/verification_team/user_ver_all');
    }

    public function user_ver_pending()
    {
        $this->view('pages/verification_team/user_ver_pending');
    }

    public function user_ver_not()
    {
        $this->view('pages/verification_team/user_ver_not');
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

    public function notifications()
    {
        $this->view('pages/student/notification_alerts');
    }
}