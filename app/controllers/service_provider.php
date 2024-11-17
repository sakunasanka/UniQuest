<?php
class Service_provider extends Controller
{
    private $model;

    private function prepareEditProfileData($post = [], $files = [])
    {
        $user = $this->model->getUserDetails($_SESSION['user_id']);
        return $data = [
            'userID' => $user['UserID'],
            'companyName' => ucfirst(trim($post['companyName'] ?? $user['CompanyName'])),
            'contactNo' => trim($post['contactNo'] ?? $user['ContactNo']),
            'streetNo' => trim($post['streetNo'] ?? $user['StreetNo']),
            'addressLine1' => trim($post['addressLine1'] ?? $user['AddressLine1']),
            'addressLine2' => trim($post['addressLine2'] ?? $user['AddressLine2']),
            'city' => ucfirst(trim($post['city'] ?? $user['City'])),
            'companyLogo' => $files['companyLogo'] ?? $user['CompanyLogo'],
            'companyLogoName' => $files['companyLogoName'] ?? $user['CompanyLogo'],
            'description' => trim($post['description'] ?? $user['Description']),
            'industry' => trim($post['industry'] ?? $user['Industry']),
            'website' => trim($post['website'] ?? $user['Website']),
            'role' => $_SESSION['user_role'],

            'companyName_err' => '',
            'contactNo_err' => '',
            'streetNo_err' => '',
            'addressLine1_err' => '',
            'addressLine2_err' => '',
            'city_err' => '',
            'companyLogo_err' => '',
            'description_err' => '',
            'industry_err' => '',
            'website_err' => ''
        ];
    }

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
    {   $posts = $this->model('M_jobpost')->getPosts();
        $data =[
            'posts' => $posts
        ];

         $this->view('pages/service_provider/ongoing_jobs', $data);
        
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
            'job_name' => trim($_POST['jobName'] ?? ''),
            'job_benifits' => trim($_POST['jobBenefits'] ?? ''),
            'job_location' => trim($_POST['jobLocation'] ?? ''),
            'required_skills' => trim($_POST['qualifications'] ?? ''),
            'salary_range' => trim($_POST['salaryRange'] ?? ''),
            'Description' => trim($_POST['jobDescription'] ?? ''),
            'job_id' => $postId,


            'job_name_err' => '',
            'job_benifits_err' => '',
            'job_location_err' => '',
            'required_skills_err' => '',
            'salary_range_err' => '',
            'Description_err' => ''
        ];

      
        


    if (empty($data['job_name'])) {
        $data['job_name_err'] = 'Please enter job name';
    }
    if (empty($data['job_benifits'])) {
        $data['job_benifits_err'] = 'Please enter job benefits';
    }
    if (empty($data['job_location'])) {
        $data['job_location_err'] = 'Please enter job location';
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
            empty($data['required_skills_err']) &&
            empty($data['salary_range_err']) &&
            empty($data['Description_err'])
        ){
            if($this->model('M_jobpost')->edit($data)){
                flash('post-msg','post is updated');
                redirect('service_provider/ongoing_jobs');

            }
            else{
                die('something went wrong');
            }

        }
        else{
            // echo json_encode($data);
            //loading view with errors
            $this->view('pages/service_provider/edit_job', $data);
        }
    }
    else{
        $post=$this->model('M_jobpost')->getpostbyid($postId);

        //check the owner
        if($post->CompanyID != $_SESSION['user_id']){
            redirect('student/jobs');
        }
        $data = [
            'job_name' => $post->Title,
            'job_id' => $postId, 
            'job_benifits' => $post->JobBenefits,
            'job_location' => $post->Location,
            'required_skills' => $post->RequiredQualifications,
            'salary_range' => $post->SalaryRange,
            'Description' => $post->Description,

            'job_name_err' => '',
            'job_benifits_err' => '',
            'job_location_err' => '',
            'required_skills_err' => '',
            'salary_range_err' => '',
            'Description_err' => ''
        ];
        // echo json_encode($data);
        $this->view('pages/service_provider/edit_job', $data);
        }
            
    }
  
    public function view_job($id)
    {
        $posts = $this->model('M_jobpost')->getpostbyid($id);
        $data =[
            'post' => $posts
        ];
        // echo json_encode($data);
        $this->view('pages/student/jobsDescription', $data);
    }
  
    public function edit_profile()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //sanitize post data
            $_POST = filter_input_array(INPUT_POST);

            //get data from post
            $data = $this->prepareEditProfileData($_POST, $_FILES);

            //validate data
            $validateResponse = Validator::isValidEditProfileData($data);
            if (!$validateResponse['is_valid']) {
                $data = array_merge($data, $validateResponse['error']);
            }

            //validate files
            $logoValidationResponse = FileUploadHelper::validateFile($data['companyLogo'], FileUploadHelper::ALLOWED_IMAGE_EXTENSIONS);
            if (!$logoValidationResponse['is_valid']) {
                $data['companyLogo_err'] = $logoValidationResponse['error'];
            }

            //if no errors
            if (empty($data['companyName_err']) && empty($data['contactNo_err']) && empty($data['streetNo_err']) && empty($data['addressLine1_err']) && empty($data['addressLine2_err']) && empty($data['city_err']) && empty($data['companyLogo_err']) && empty($data['description_err']) && empty($data['industry_err']) && empty($data['website_err'])) {
                //upload logo
                $logoUploadResponse = FileUploadHelper::uploadFile($data['companyLogo'], PUBROOT . '/uploads/profile_pictures/company');
                if ($logoUploadResponse['success']) {
                    //set logo name
                    $data['companyLogoName'] = $logoUploadResponse['file_name'] ?? $data['companyLogoName'];
                } else {
                    //set error
                    $data['companyLogo_err'] = $logoUploadResponse['error'];
                    //load view with errors
                    $this->view('pages/service_provider/edit_profile', $data);
                    return;
                }

                //edit company profile
                if ($this->model->updateProfile($data)) {
                    //redirect to view profile
                    // header('location: ' . URLROOT . '/service_provider/view_profile');
                    Redirect::to(URLROOT . '/user/profile');
                } else {
                    die('Something went wrong');
                }
            } else {
                //load view with errors
                $this->view('pages/service_provider/edit_profile', $data);
            }
        } else {
            //init data
            $data = $this->prepareEditProfileData();

            //load view
            $this->view('pages/service_provider/edit_profile', $data);
        }
    }

    public function pending()
    {
        $this->view('pages/login/wait_to_verify_ser');
    }
    public function jobPost()
    {

        if($_SERVER['REQUEST_METHOD']=='POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data=[
                
                'job_name' => trim($_POST['jobName'] ?? ''),
                'job_benifits' => trim($_POST['jobBenefits'] ?? ''),
                'job_location' => trim($_POST['jobLocation'] ?? ''),
                'job_category' => trim($_POST['jobType'] ?? ''),
                'adress' => trim($_POST['address']),
                'required_skills' => trim($_POST['qualifications'] ?? ''),
                'salary_range' => trim($_POST['salaryRange'] ?? ''),
                'Description' => trim($_POST['jobDescription'] ?? ''),

                'job_name_err'=>'',
                'job_benifits_err'=>'',
                'job_location_err'=>'',
                'job_category_err'=>'',
                'adress_err'=>'',
                'required_skills_err'=>'',
                'salary_range_err'=>'',
                'Description_err' => ''
            ];

            //validation
            
            if(empty($data['job_name'])){
                $data['job_name_err'] = 'Please enter job name';

            }
            if(empty($data['job_benifits'])){
                $data['job_benifits_err'] = 'Please enter job benifits';

            }
            if(empty($data['job_location'])){
                $data['job_location_err'] = 'Please enter job location';

            }
            if(empty($data['job_category'])){
                $data['job_category_err'] = 'Please enter job category';

            }
            if(empty($data['adress'])){
                $data['adress_err'] = 'Please enter adress';

            }
            if(empty($data['required_skills'])){
                $data['required_skills_err'] = 'Please enter required skills';

            }
            if(empty($data['salary_range'])){
                $data['salary_range_err'] = 'Please enter salary range';

            }

            if(empty($data['Description'])){
                $data['Description_err'] = 'Please enter Description';  

            }

            //make sure no errors
            if(empty($data['job_name_err']) && empty($data['job_benifits_err']) && empty($data['job_location_err']) && empty($data['job_category_err']) && empty($data['adress_err']) && empty($data['required_skills_err']) && empty($data['salary_range_err']) && empty($data['Description_err'])){
                if($this->model('M_jobpost')->create($data)){
                    flash('post-msg','post is published');
                    redirect('service_provider/ongoing_jobs');
                }
                else{
                    die('something went wrong');
                    
                }
            } else {
                //loading view with errors
                $this->view('pages/admin/jobPost', $data);
            }
        }
            else{
                $data =[
                    'job_name'=>'',
                    'job_benifits'=>'',
                    'job_location'=>'',
                    'job_category'=>'',
                    'adress'=>'',
                    'required_skills'=>'',
                    'salary_range'=>'',
                    'Description' => '',

                    'job_name_err'=>'',
                    'job_benifits_err'=>'',
                    'job_location_err'=>'',
                    'job_category_err'=>'',
                    'adress_err'=>'',
                    'required_skills_err'=>'',
                    'salary_range_err'=>'',
                    'Description_err' => ''
                ];
                $this->view('pages/admin/jobPost', $data);
            }
       
    }



    public function delete($postId){
            
        $post= $this->model('M_jobpost')->getpostbyid($postId);

        //check owner
        if($post->CompanyID != $_SESSION['user_id']){
            redirect('student/jobs');
        }
        else{
        
        

        if($this->model('M_jobpost')->delete($postId)){
            flash('post-msg','post is deleted');
            redirect('service_provider/ongoing_jobs');

        }
        else{
            die('Something went wrong');
        }
        } 
}

}
