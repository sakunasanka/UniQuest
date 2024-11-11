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
        $this->view('pages/student/jobs');
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

    public function view_profile()
    {
        $this->view('pages/student/view_profile');
    }

    public function edit_profile()
    {
        $this->view('pages/student/edit_profile');
    }
    public function delete_account()
    {
        $this->view('popups/student/deactivate_account');
    }

    public function getReview()
    {
        $company_id = $_GET['company_id'] ?? 1; 
        $reviews = $this->rateAndReviewModel->getReviewsByCompanyId($company_id);

        $data = [
            'reviews' => $reviews
        ];

        $this->view('pages/student/rate_review_company', $data);
    }

    public function addReview()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Prepare data for the review
            $data = [
                'rating' => $_POST['rating'] ?? '',
                'comment' => trim($_POST['comment'] ?? ''),
                'company_id' => $_POST['company_id'] ?? '',
                'rating_err' => '',
                'comment_err' => ''
            ];

            // Validate rating and comment
            if (empty($data['rating'])) {
                $data['rating_err'] = 'Please provide a rating.';
            }
            if (empty($data['comment'])) {
                $data['comment_err'] = 'Please provide a comment.';
            }

            // Check for errors
            if (empty($data['rating_err']) && empty($data['comment_err'])) {
                if ($this->model('RateAndReviewModel')->addReview($data)) {
                    Redirect::to(URLROOT . '/student/rate_review_company');
                } else {
                    die('Something went wrong'); // Improved error handling suggested
                }
            } else {
                // Load view with errors
                $this->view('pages/student/rate_review_company', $data);
            }
        } else {
            $data = [
                'rating' => '',
                'comment' => '',
                'company_id' => '',
                'rating_err' => '',
                'comment_err' => ''
            ];

            $this->view('pages/student/rate_review_company', $data);
        }
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
        $this->view('pages/student/make_complain');
    }
  
    public function jobsDescription()
    {
        $this->view('pages/student/jobsDescription');
    }

    public function jobsApply()
    {
        $this->view('pages/student/jobsApply');
    }

}