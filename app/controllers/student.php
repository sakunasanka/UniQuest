<?php
class Student extends Controller
{
    public function __construct()
    {
        // echo 'Pages loaded';
    }

    public function index()
    {
        echo 'student/index';
    }

    public function contact_sp()
    {
        $this->view('pages/student/contact_sp');
    }

    public function contact_admin()
    {
        $this->view('pages/student/contact_admin');
    }
    
     public function students_mng()
    {
        $this->view('pages/student/students_mng');
    }
  
    public function login()
    {
        $this->view('pages/student/login');
    }
    public function rate_review_company()
    {
        $this->view('pages/student/rate_review_company');
    }

    public function register()
    {
        $this->view('pages/student/register');
    }

    public function make_complain()
    {
        $this->view('pages/student/make_complain');
    }

    public function all_app()
    {
        $this->view('pages/student/all_applications');
    }

    public function accepted_app()
    {
        $this->view('pages/student/accepted_applications');
    }

    public function rejected_app()
    {
        $this->view('pages/student/rejected_applications');
    }
  
}

