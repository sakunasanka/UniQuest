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

    public function getReview()
    {
        $company_id = $_GET['company_id'] ?? 1; 
        $reviews =$this->model('RateAndReviewModel')->getReviewsByCompanyId($company_id);

        $data = [
            'reviews' => $reviews
        ];

        $this->view('pages/student/rate_review_company', $data);
    }

    public function addReview($id = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Prepare data for the review
            $data = [
                'rating' => $_POST['rating'] ?? '',
                'comment' => trim($_POST['comment'] ?? ''),
                'user_id' => $_POST['user_id'] ?? '',
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
                'user_id' => '',
                'company_id' => $id,
                'rating_err' => '',
                'comment_err' => ''
            ];

            $this->view('pages/student/rate_review_company', $data);
        }
    }

    public function editReview($id)
    {
        $review = $this->model('RateAndReviewModel')->getReviewById($id);

        if (!$review) {
            Redirect::to(URLROOT . '/student/rate_review_company');
            return;
        }

        $data = [
            'review' => $review,
            'rating_err' => '',
            'comment_err' => ''
        ];

        $this->view('pages/student/edit_review', $data);
    }

    public function updateReview($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'review_id' => $id,
                'rating' => $_POST['rating'] ?? '',
                'comment' => trim($_POST['comment'] ?? ''),
                'rating_err' => '',
                'comment_err' => ''
            ];

            if (empty($data['rating'])) {
                $data['rating_err'] = 'Please provide a rating.';
            }
            if (empty($data['comment'])) {
                $data['comment_err'] = 'Please provide a comment.';
            }

            if (empty($data['rating_err']) && empty($data['comment_err'])) {
                if ($this->model('RateAndReviewModel')->updateReview($data)) {
                    Redirect::to(URLROOT . '/student/rate_review_company');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('pages/student/edit_review', $data);
            }
        } else {
            Redirect::to(URLROOT . '/student/rate_review_company');
        }
    }

    public function deleteReview($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Check if the review exists
            $review = $this->model('RateAndReviewModel')->getReviewById($id);

            if (!$review) {
                Redirect::to(URLROOT . '/student/rate_review_company');
                return;
            }

            // Ensure the review belongs to the logged-in student
            if ($review->student_id != $_SESSION['user_id']) {
                Redirect::to(URLROOT . '/student/rate_review_company');
                return;
            }

            // Attempt to delete the review
            if ($this->model('RateAndReviewModel')->deleteReviewById($id)) {
                Redirect::to(URLROOT . '/student/rate_review_company');
            } else {
                die('Something went wrong while deleting the review.');
            }
        } else {
            Redirect::to(URLROOT . '/student/rate_review_company');
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
            $posts = $this->model('M_jobpost')->getPosts();
            $data =[
                'posts' => $posts
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