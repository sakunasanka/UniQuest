<?php
class Service_provider extends Controller
{
    public function __construct()
    {
        // echo 'Pages loaded';
    }

    public function index()
    {
        echo 'service_provider/index';
    }

    public function contact_admin()
    {
        $this->view('pages/service_provider/contact_admin');
    }

    public function register()
    {
        $this->view('pages/service_provider/register');
    }    

    public function dashboard()
    {
        $this->view('pages/service_provider/ser_dashboard');
    }

    public function report()
    {
        $this->view('pages/service_provider/job_report');
    }
  
    public function login()
    {
        $this->view('pages/service_provider/login');
    }

    public function ongoing_jobs()
    {
        $this->view('pages/service_provider/ongoing_jobs');
    }

    public function offered_jobs()
    {
        $this->view('pages/service_provider/offered_jobs');
    }

}