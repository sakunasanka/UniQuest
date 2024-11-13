<?php
class Student extends Controller
{
    private $model;

    public function __construct()
    {
        // Load model
        $this->model = $this->model('userModel');
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

    public function edit_profile()
    {
        $this->view('pages/student/edit_profile');
    }
    public function delete_account()
    {
        $this->view('popups/student/deactivate_account');
    }
    public function rate_review_company()
    {
        $this->view('pages/student/rate_review_company');
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

    public function saveCompanies()
    {
        $this->view('pages/student/saveCompanies');
    }

    public function make_complain()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'job_posting' => trim($_POST['job_posting']),
                'issue' => trim($_POST['issue']),
            ];
            $this->model('jobModel')->create_complain($data);
            
            Redirect::to('make_complain');
            DisplayPopup::openPopup(APPROOT . 'views/popups/admin/activateAcc');  //Not working yet  
              
        }

        else {
            $data = [
                'job_posting' => '',
                'issue' => '',
            ];
            $this->view('pages/student/make_complain', $data);
        }
        
    }
  
    public function jobsDescription()
    {
        $this->view('pages/student/jobsDescription');
    }

    public function companyDescription()
    {
        $this->view('pages/student/companyDescription');
    }

    public function internshipDescription()
    {
        $this->view('pages/student/internshipDescription');
    }

    public function jobsApply()
    {
        $this->view('pages/student/jobsApply');
    }

    public function pending()
    {
        $this->view('pages/login/wait_to_verify_stu');
    }

    public function internships()
    {
        $this->view('pages/student/internships');
    }

}