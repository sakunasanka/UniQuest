<?php
class Admin extends Controller
{
    public function __construct()
    {
        // echo 'Pages loaded';
    }

    public function index()
    {
        echo 'admin/index';
    }

    public function students_mng()
    {
        $this->view('pages/admin/students_mng');
    }

    public function company_mng()
    {
        $this->view('pages/admin/company_mng');
    }

    public function verTeam_mng()
    {
        $this->view('pages/admin/verTeam_mng');
    }

    public function job_complaint()
    {
        $this->view('pages/admin/job_complaint');
    }

    public function company_complaint()
    {
        $this->view('pages/admin/company_complaint');
    }
    public function ptjobs_mng()
    {
        $this->view('pages/admin/ptjobs_mng');
    }

    public function intern_mng()
    {
        $this->view('pages/admin/intern_mng');
    }
  
    public function user_ver_all()
    {
        $this->view('pages/admin/user_ver_all');
    }

    public function user_ver_pending()
    {
        $this->view('pages/admin/user_ver_pending');
    }

    public function user_ver_not()
    {
        $this->view('pages/admin/user_ver_not');
    }

    public function job_ver_all()
    {
        $this->view('pages/admin/job_ver_all');
    }

    public function job_ver_pending()
    {
        $this->view('pages/admin/job_ver_pending');
    }

    public function job_ver_not()
    {
        $this->view('pages/admin/job_ver_not');
    }

    public function dashboard()
    {
        $this->view('pages/admin/adminDash');
    }

    public function analytics()
    {
        $this->view('pages/admin/analytics');
    }

}