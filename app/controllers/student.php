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

    public function searchJob()
    {
        $this->view('pages/student/searchJob');
    }

    public function searchCompany()
    {
        $this->view('pages/student/searchCompany');
    }

    public function noMatch()
    {
        $this->view('pages/student/noMatch');
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
  
    public function jobs()
    {
        $this->view('pages/student/jobs');
    }

    public function company()
    {
        $this->view('pages/student/company');
    }

    public function trendyCompany()
    {
        $this->view('pages/student/trendyCompany');
    }

    public function saveJobs()
    {
        $this->view('pages/student/saveJobs');
    }
  
    public function jobsDescription()
    {
        $this->view('pages/student/jobsDescription');
      
    public function jobsApply()
    {
        $this->view('pages/student/jobsApply');
    }
}

