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
    public function jobPostform()
    {
        $this->view('pages/admin/jobPost');
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

    public function edit_job($postId)
    {   if($_SERVER['REQUEST_METHOD']=='POST'){
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data=[
            'job_name' => trim($_POST['jobName'] ),
            'job_benifits' => trim($_POST['jobBenefits'] ),
            'job_location' => trim($_POST['jobLocation'] ),
            'job_category' => trim($_POST['jobType'] ),
            'adress' => trim($_POST['address']),
            'job_id' => $postId,
            'required_skills' => trim($_POST['qualifications']),
            'salary_range' => trim($_POST['salaryRange'] ),
            'Description' => trim($_POST['jobDescription']),

            'job_name_err' => '',
            'job_benifits_err' => '',
            'job_location_err' => '',
            'job_category_err' => '',
            'adress_err' => '',
            'required_skills_err' => '',
            'salary_range_err' => '',
            'Description_err' => ''
        ];

        //validation
        $post=$this->model('M_jobpost')->getpostbyid($postId);
        // $oldImage= PUBROOT.'/img/postsimg/'.$post->image;

        //photouploaded

        //user havent change the existing  photo
    //     if($_POST['intentionally_removed']=='removed'){
    //         deleteImage($oldImage);
    //         $data['image_name'] = '';       
    //     }
    //     else{
    //     if($_FILES['image']['size']==''){
    //         $data['image_name'] = $post->image;
           
    //     }
    //     else{
    //        updateImage($oldImage , $data['image']['tmp_name'] , $data['image_name'] , '/img/postsimg/');
            
    //    }   
    // }
        


    if (empty($data['job_name'])) {
        $data['job_name_err'] = 'Please enter job name';
    }
    if (empty($data['job_benifits'])) {
        $data['job_benifits_err'] = 'Please enter job benefits';
    }
    if (empty($data['job_location'])) {
        $data['job_location_err'] = 'Please enter job location';
    }
    if (empty($data['job_category'])) {
        $data['job_category_err'] = 'Please enter job category';
    }
    if (empty($data['adress'])) {
        $data['adress_err'] = 'Please enter address';
    }
    if (empty($data['required_skills'])) {
        $data['required_skills_err'] = 'Please enter required skills';
    }
    if (empty($data['salary_range'])) {
        $data['salary_range_err'] = 'Please enter salary range';
    }
    if (empty($data['Description'])) {
        $data['Description_err'] = 'Please enter description';
    }

        if(
            empty($data['job_name_err']) &&
            empty($data['job_benifits_err']) &&
            empty($data['job_location_err']) &&
            empty($data['job_category_err']) &&
            empty($data['adress_err']) &&
            empty($data['required_skills_err']) &&
            empty($data['salary_range_err']) &&
            empty($data['Description_err'])
        ){
            if($this->model('M_jobpost')->edit($data)){
                flash('post-msg','post is updated');
                redirect('service_provider/edit_job');

            }
            else{
                die('something went wrong');
            }

        }
        else{
            //loading view with errors
            $this->view('pages/service_provider/edit_job', $data);
        }
    }
    else{
        $post=$this->model('M_jobpost')->getpostbyid($postId);

        //check the owner
        if($post->companyID != $_SESSION['user_id']){
            redirect('student/jobs');
        }
        $data = [
            'job_name' => '',
            'job_id' => '',
            'job_benifits' => '',
            'job_location' => '',
            'job_category' => '',
            'adress' => '',
            'required_skills' => '',
            'salary_range' => '',
            'Description' => '',

            'job_name_err' => '',
            'job_benifits_err' => '',
            'job_location_err' => '',
            'job_category_err' => '',
            'adress_err' => '',
            'required_skills_err' => '',
            'salary_range_err' => '',
            'Description_err' => ''
        ];
        $this->view('pages/service_provider/edit_job', $data);
        }
            
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

    public function pending()
    {
        $this->view('pages/login/wait_to_verify_ser');
    }
    public function jobPost()
    {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data = [
            'job_name' => trim($_POST['jobName'] ?? ''),
            'job_benifits' => trim($_POST['jobBenefits'] ?? ''),
            'job_location' => trim($_POST['jobLocation'] ?? ''),
            'job_category' => trim($_POST['jobType'] ?? ''),
            'adress' => trim($_POST['address']),
            'required_skills' => trim($_POST['qualifications'] ?? ''),
            'salary_range' => trim($_POST['salaryRange'] ?? ''),
            'Description' => trim($_POST['jobDescription'] ?? ''),

            'job_name_err' => '',
            'job_benifits_err' => '',
            'job_location_err' => '',
            'job_category_err' => '',
            'adress_err' => '',
            'required_skills_err' => '',
            'salary_range_err' => '',
            'Description_err' => ''
        ];

        // Validation
        if (empty($data['job_name'])) {
            $data['job_name_err'] = 'Please enter job name';
        }
        if (empty($data['job_benifits'])) {
            $data['job_benifits_err'] = 'Please enter job benefits';
        }
        if (empty($data['job_location'])) {
            $data['job_location_err'] = 'Please enter job location';
        }
        if (empty($data['job_category'])) {
            $data['job_category_err'] = 'Please enter job category';
        }
        if (empty($data['adress'])) {
            $data['adress_err'] = 'Please enter address';
        }
        if (empty($data['required_skills'])) {
            $data['required_skills_err'] = 'Please enter required skills';
        }
        if (empty($data['salary_range'])) {
            $data['salary_range_err'] = 'Please enter salary range';
        }
        if (empty($data['Description'])) {
            $data['Description_err'] = 'Please enter description';
        }

        // Make sure no errors
        if (
            empty($data['job_name_err']) &&
            empty($data['job_benifits_err']) &&
            empty($data['job_location_err']) &&
            empty($data['job_category_err']) &&
            empty($data['adress_err']) &&
            empty($data['required_skills_err']) &&
            empty($data['salary_range_err']) &&
            empty($data['Description_err'])
        ) {
            if ($this->model('M_jobpost')->create($data)) {
                flash('post-msg', 'Post is published');

                redirect('student/jobs');
                return; // Exit after redirect
            } else {
                die('Something went wrong');
            }
        } else {
            // Load view with errors
            $this->view('pages/admin/jobPost', $data);
        }
    } else {
        $data = [
            'job_name' => '',
            'job_benifits' => '',
            'job_location' => '',
            'job_category' => '',
            'adress' => '',
            'required_skills' => '',
            'salary_range' => '',
            'Description' => '',

            'job_name_err' => '',
            'job_benifits_err' => '',
            'job_location_err' => '',
            'job_category_err' => '',
            'adress_err' => '',
            'required_skills_err' => '',
            'salary_range_err' => '',
            'Description_err' => ''
        ];
        $this->view('pages/admin/jobPost', $data);
    }
}

  



    public function delete($postId){
            
        $post= $this->model('M_jobpost')->getpostbyid($postId);

        //check owner
        if($post->companyID != $_SESSION['company_id']){
            redirect('service_provider/jobs');
        }
        else{
        
        

        if($this->model('M_jobpost')->delete($postId)){
            flash('post-msg','post is deleted');
            redirect('service_provider/jobs');

        }
        else{
            die('Something went wrong');
        }
        } 
}

}
