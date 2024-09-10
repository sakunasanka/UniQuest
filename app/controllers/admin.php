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

    public function ptjobs_mng()
    {
        $this->view('pages/admin/ptjobs_mng');
    }

    public function intern_mng()
    {
        $this->view('pages/admin/intern_mng');
    }
}