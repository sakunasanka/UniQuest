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
            $posts = $this->model('M_jobpost')->getPosts();

            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id']; // Get user ID from session
    
              // Get bookmarked jobs for the user
            $bookmarkedJobs = $this->model('jobModel')->getBookmarkedJobs($userId);
            $bookmarkedJobIds = array_column($bookmarkedJobs, 'JobID');
            } 
            else {
                $userId = null;
                $bookmarkedJobs = []; // No bookmarks if not logged in
            }

            $allJobs = $this->model('jobModel')->getAllJobs();

            $data =[
                'posts' => $posts,
                'allPosts' => $allJobs,
                'bookmarkedJobs' => $bookmarkedJobs,
                'bookmarkedJobIds' => $bookmarkedJobIds
            ];

             $this->view('pages/student/jobs', $data);
        
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
        $this->view('pages/student/make_complain');
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
    public function jobsDescription($id){
        
        $posts = $this->model('M_jobpost')->getpostbyid($id);
        $data =[
            'post' => $posts
        ];
        // echo json_encode($data);
        $this->view('pages/student/jobsDescription', $data);
    
    }



}