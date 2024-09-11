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
}