<?php
class Service_provider extends Controller
{
    private $model;

    public function __construct()
    {
        // Load model
        $this->model = $this->model('userModel');
    }

    public function index()
    {
        echo 'service_provider/index';
    }

    public function contact_admin()
    {
        $this->view('pages/service_provider/contact_admin');
    }   

    public function dashboard()
    {
        $this->view('pages/service_provider/ser_dashboard');
    }

    public function report()
    {
        $this->view('pages/service_provider/job_report');
    }

    public function ongoing_jobs()
    {
        $this->view('pages/service_provider/ongoing_jobs');
    }

    public function offered_jobs()
    {
        $this->view('pages/service_provider/offered_jobs');
    }

    public function offered_applications()
    {
        $this->view('pages/service_provider/offered_applications');
    }

    public function new_applications()
    {
        $this->view('pages/service_provider/new_applications');
    }

    public function rejected_applications()
    {
        $this->view('pages/service_provider/rejected_applications');
    }
  
    public function premium()
    {
        $this->view('pages/service_provider/premiumFeatures');
    }

    public function analytics()
    {
        $this->view('pages/service_provider/ser_analytics');
    }

    public function edit_job()
    {
        $this->view('pages/service_provider/edit_job');
    }
  
    public function view_job()
    {
        $this->view('pages/service_provider/view_job');
    }
  
    public function edit_profile()
    {
        $this->view('pages/service_provider/edit_profile');
    }
  
    public function view_profile()
    {
        $this->view('pages/service_provider/view_profile');
    }
  
