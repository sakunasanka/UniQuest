<?php
class Service_provider extends Controller
{
    private $model;

    public function __construct()
    {
        // Check if user is logged in
        AuthMiddleware::requireAuth();
        // Check if user has the required role
        AuthMiddleware::requireRole('Company');
        
        // Load model
        $this->model = $this->model('userModel');
    }

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

    public function index()
    {
        $this->dashboard();
    }

    public function contact_admin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Data for the contact form
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'topic' => trim($_POST['topic'] ?? ''),
                'message' => trim($_POST['message'] ?? ''),

                'name_err' => '',
                'topic_err' => '',
                'message_err' => ''
            ];

            // Validation checks
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter your name';
            }

            if (empty($data['topic'])) {
                $data['topic_err'] = 'Please select a topic';
            }

            if (empty($data['message'])) {
                $data['message_err'] = 'Please enter your message';
            }

            // Ensure no errors before submitting
            if (empty($data['name_err'])  && empty($data['topic_err']) && empty($data['message_err'])) {
                if($this->model('ContactModel')->sendMessage($data)){
                    flash('contact-msg', 'Your message has been sent successfully.');
                    redirect('service_provider/contact_admin');
                } else {
                    die('Something went wrong. Please try again.');
                }
            } else {
                $this->view('pages/service_provider/contact_admin', $data);
            }
        } else {
            // Initialize default data for the view on GET request
            $data = [
                'name' => '',
                'topic' => '',
                'message' => '',
                'name_err' => '',
                'topic_err' => '',
                'message_err' => ''
            ];
    
     $this->view('pages/service_provider/contact_admin', $data);
    }
}

    public function dashboard()
    {
        $this->view('pages/service_provider/ser_dashboard');
    }
    public function jobPostform()
    {
        $this->view('pages/service_provider/jobPost');
    }
    

    public function report()
    {
        $this->view('pages/service_provider/job_report');
    }

    public function ongoing_jobs()
    {
        //$id = $_SESSION['user_id'];
        $posts = $this->model('M_jobpost')->getPost();
        $data = [
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

    // public function new_applications($id)
    // {
        
    //         // Get user ID from session
    //         $userId = $_SESSION['user_id'] ?? null;
            
    //         if (!$userId) {
    //             redirect('users/login');
    //         }
            
    //         // Load models
    //         $applicationModel = $this->model('M_applications');
    //         $fieldModel = $this->model('M_applicationFields');
    //         $jobModel = $this->model('M_jobpost');
            
    //         // Get all applications for this student
    //         $applications = $applicationModel->getApplicationsByStudentId($userId);
            
    //         // Prepare data for each application with job-specific fields
    //         $applicationsData = [];
            
    //         foreach ($applications as $app) {
    //             // Get job details
    //             $job = $jobModel->getpostbyid($app->job_id);
                
    //             // Get application fields for this job
    //             $fields = $fieldModel->getFieldsByJobId($app->job_id);
                
    //             // Get application responses for this application
    //             $responses = $applicationModel->getApplicationResponses($app->id);
                
    //             $applicationsData[] = [
    //                 'application' => $app,
    //                 'job' => $job,
    //                 'fields' => $fields,
    //                 'responses' => $responses
    //             ];
    //         }
            
    //         $data = [
    //             'applications' => $applicationsData
    //         ];
            
            
    //     $this->view('pages/service_provider/new_applications', $data);
    // }
    public function new_applications($jobID)
    {
        // Fetch applications for the given job ID
        $applications = $this->model('M_applicationFields')->getApplicationsByJobID($jobID);

        // Pass data to the view
        $data = [
            'applications' => $applications,
            'jobID' => $jobID
        ];

        // Load the view
        $this->view('pages/service_provider/new_applications', $data);
    }
    public function view_application($applicationID)
{
    // Fetch application details
    $application = $this->model('M_applicationFields')->getApplicationsByuserID($applicationID);

    if (!$application) {
        // Handle the case where the application is not found
        redirect('error/not_found');
    }

    // Access the first element of the $application array
    $application = $application[0];
    
    // Prepare the application data
    $applicationData = [
        'photo' => $application->StudentProfileImage ?? null,
        'fullname' => $application->StudentName ?? null,
        'id' => $application->ApplicationID ?? null,
        'created_at' => $application->SubmissionDate ?? null,
        'status' => $application->ApplicationStatus ?? null,
        'email' => $application->StudentEmail ?? null,
        'contact' => $application->StudentContact ?? null,
        'address' => $application->address ?? null,
        'nic' => $application->nic ?? null,
        'gender' => $application->gender ?? null,
        'dob' => $application->dob ?? null,
        'qualifications' => $application->Qualifications ?? null,
        'experience' => $application->Experience ?? null,
        'skills' => $application->Skills ?? null,
        'cv' => $application->cv ?? null,
        'nic_copy' => $application->nic_copy ?? null,
        'linkedin' => $application->linkedin ?? null,
        'other1' => $application->other1 ?? null,
        'other2' => $application->other2 ?? null,
        'other3' => $application->other3 ?? null
    ];

    $data = [
        'application' => $applicationData,
    ];

    // Load the view
    $this->view('pages/service_provider/view_application', $data);
}

    public function rejected_applications()
    {
        $this->view('pages/service_provider/rejected_applications');
    }
    public function application_dashboard()
    {
        // Get the company ID from the session (assuming the company is logged in)
        $companyId = $_SESSION['user_id'];

        // Fetch all applications for the company's jobs
        $applications = $this->model('M_applicationFields')->getAllApplicationsByCompanyId($companyId);

        // Process the data to calculate stats for each job
        $jobs = [];
        foreach ($applications as $application) {
            $jobId = $application->JobID;

            // Initialize job stats if not already done
            if (!isset($jobs[$jobId])) {
                $jobs[$jobId] = [
                    'title' => $application->JobTitle,
                    'jobID' => $jobId,
                    'location' => $application->JobLocation,
                    'posted' => date('M d, Y', strtotime($application->JobCreatedAt)),
                    'stats' => [
                        'total' => 0,
                        'accepted' => 0,
                        'rejected' => 0,
                        'pending' => 0
                    ]
                ];
            }

            // Update stats based on application status
            $jobs[$jobId]['stats']['total']++;
            switch ($application->ApplicationStatus) {
                case 'Accepted':
                    $jobs[$jobId]['stats']['accepted']++;
                    break;
                case 'Rejected':
                    $jobs[$jobId]['stats']['rejected']++;
                    break;
                case 'Pending':
                    $jobs[$jobId]['stats']['pending']++;
                    break;
            }
        }

        // Convert associative array to indexed array for the view
        $jobs = array_values($jobs);

        // Pass data to the view
        $data = [
            'jobs' => $jobs
        ];

        $this->view('pages/service_provider/application_dashboard', $data);
    

        
    }
    public function premium() 
    {
        
        
        // Load view with subscription data
        $this->view('pages/service_provider/premiumFeatures');
            
    }
    public function subscription() 
    {
    // Check if user is logged in
    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    // Get user ID from session
    $user_id = $_SESSION['user_id'];
    
    // Get subscription details
    $subscription = $this->model('companyModel')->getCompanySubscription($user_id);
    $is_active = $this->model('companyModel')->isSubscriptionActive($user_id);
    
    // Load view with subscription data
    $this->view('service_provider/subscription', [
        'subscription' => $subscription,
        'is_active' => $is_active
    ]);
    }

/**
 * Check subscription status
 * Used for AJAX requests to validate if user can access premium features
 */
    public function check_subscription() 
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            exit;
        }
        
        // Get user ID from session
        $user_id = $_SESSION['user_id'];
        
        // Check if subscription is active
        $is_active = $this->model('companyModel')->isSubscriptionActive($user_id);
        $subscription = $this->model('companyModel')->getCompanySubscription($user_id);
        
        // Return subscription status
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'is_active' => $is_active,
            'plan' => $subscription->subscription_plan ?? 'free',
            'status' => $subscription->subscription_status ?? null,
            'expiry' => $subscription->subscription_end_date ?? null
        ]);
        exit;
    }
    // public function premium()
    // {
        
        
    //     $this->view('pages/service_provider/premiumFeatures');
    // }
    public function premium_pro()
    {
        // This is the notify_url endpoint that PayHere will call after payment
        
        // Check if it's a POST request from PayHere
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verify the payment using PayHere's notification
            $merchant_id = $_POST['merchant_id'];
            $order_id = $_POST['order_id'];
            $payment_id = $_POST['payment_id'];
            $payhere_amount = $_POST['payhere_amount'];
            $payhere_currency = $_POST['payhere_currency'];
            $status_code = $_POST['status_code'];
            $md5sig = $_POST['md5sig'];
            
            // Your PayHere merchant secret
            $merchant_secret = "NDEyMTM4MDkxMzEwNDM3Njc5NTYzNzA0OTE1MDEzNzYwNDM2OTgw";
            
            // Generate the hash to validate the notification
            $local_md5sig = strtoupper(
                md5(
                    $merchant_id . 
                    $order_id . 
                    $payhere_amount . 
                    $payhere_currency . 
                    $status_code . 
                    strtoupper(md5($merchant_secret))
                )
            );
            
            // Verify the signature and status code
            if (($local_md5sig === $md5sig) && ($status_code == 2)) {
                // Payment successful
                
                // Extract user_id from the order_id
                // Format: ORDER_timestamp_user_id
                $parts = explode('_', $order_id);
                $user_id = $parts[2]; // Get the user_id part
                
                // Determine subscription plan based on amount
                $plan = '';
                $duration = 30; // 30 days for monthly subscription
                
                if ($payhere_amount == 3000) {
                    $plan = 'professional';
                } elseif ($payhere_amount == 5000) {
                    $plan = 'enterprise';
                } else {
                    // Unknown plan
                    error_log("Unknown plan amount: " . $payhere_amount);
                    http_response_code(400);
                    exit;
                }
                
                // Calculate subscription dates
                $start_date = date('Y-m-d H:i:s');
                $end_date = date('Y-m-d H:i:s', strtotime("+{$duration} days"));
                
                // Update the company table
                $result = $this->model('companyModel')->updateSubscription($user_id, $plan, $start_date, $end_date, 'active');
                
                if ($result) {
                    // Store payment success info in the database for this user
                    // This will be checked when the user returns to the application
                    $this->model('companyModel')->storePaymentSuccess($user_id, $order_id, $payment_id);
                    
                    // Log successful subscription update
                    error_log("Subscription updated for user: " . $user_id . " to plan: " . $plan);
                    
                    // Return success response to PayHere
                    http_response_code(200);
                    exit;
                } else {
                    // Log error
                    error_log("Failed to update subscription for user: " . $user_id);
                    http_response_code(500);
                    exit;
                }
            } else {
                // Invalid notification or payment failed
                error_log("Invalid notification or payment failed. Status code: " . $status_code);
                http_response_code(400);
                exit;
            }
        } else {
            // If it's a GET request, redirect to the premium features page
            redirect('pages/serviceprovider/premiumFeatures');
        }
    }
    
    public function payhereprocess()
{
    // Get user data from session
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    
    // Get plan from query parameter
    $plan = isset($_GET['plan']) ? $_GET['plan'] : 'professional';
    
    // Plan details
    $amount = 3000; // Default to Professional plan price
    if ($plan === 'enterprise') {
        $amount = 5000;
    }
    
    $merchant_id = '1230028';
    $order_id = 'ORDER_' . time() . '_' . $user_id;
    $merchant_secret = "NDEyMTM4MDkxMzEwNDM3Njc5NTYzNzA0OTE1MDEzNzYwNDM2OTgw";
    $currency = 'LKR';
    
    // Generate hash
    $hash = strtoupper(
        md5(
            $merchant_id . 
            $order_id .
            number_format($amount, 2, '.', '') .
            $currency .
            strtoupper(md5($merchant_secret))
        )
    );
    
    // Create response array
    $array = [
        'merchant_id' => $merchant_id,
        'order_id' => $order_id,
        'amount' => $amount,
        'currency' => $currency,
        'hash' => $hash,
        'plan' => $plan
    ];
    
    // Store order_id in session for verification later
    $_SESSION['pending_order_id'] = $order_id;
    $_SESSION['pending_plan'] = $plan;
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($array);
    exit;
}
    
    
    public function analytics()
    {
        $this->view('pages/service_provider/ser_analytics');
    }

    public function notifications()
    {
        $this->view('pages/student/notification_alerts');
    }

    public function edit_job($postId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
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

            if (
                empty($data['job_name_err']) &&
                empty($data['job_benifits_err']) &&
                empty($data['job_location_err']) &&
                empty($data['required_skills_err']) &&
                empty($data['salary_range_err']) &&
                empty($data['Description_err'])
            ) {
                if ($this->model('M_jobpost')->edit($data)) {
                    flash('post-msg', 'post is updated');
                    redirect('service_provider/ongoing_jobs');
                } else {
                    die('something went wrong');
                }
            } else {
                // echo json_encode($data);
                //loading view with errors
                $this->view('pages/service_provider/edit_job', $data);
            }
        } else {
            $post = $this->model('M_jobpost')->getpostbyid($postId);

            //check the owner
            if ($post->CompanyID != $_SESSION['user_id']) {
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
        $data = [
            'post' => $posts
        ];
        // echo json_encode($data);
        $this->view('pages/service_provider/view_job', $data);
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

    public function deactive()
    {
        $this->view('pages/login/deactivate_ser');
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
                'required_skills' => trim($_POST['qualifications'] ?? ''),
                'salary_range' => trim($_POST['salaryRange'] ?? ''),
                'Description' => trim($_POST['jobDescription'] ?? ''),
                'status' => 'Active',

                'job_name_err' => '',
                'job_benifits_err' => '',
                'job_location_err' => '',
                'job_category_err' => '',
                'required_skills_err' => '',
                'salary_range_err' => '',
                'Description_err' => ''
            ];

            //validation

            if (empty($data['job_name'])) {
                $data['job_name_err'] = 'Please enter job name';
            }
            if (empty($data['job_benifits'])) {
                $data['job_benifits_err'] = 'Please enter job benifits';
            }
            if (empty($data['job_location'])) {
                $data['job_location_err'] = 'Please enter job location';
            }
            if (empty($data['job_category'])) {
                $data['job_category_err'] = 'Please enter job category';
            }
            if (empty($data['required_skills'])) {
                $data['required_skills_err'] = 'Please enter required skills';
            }
            if (empty($data['salary_range'])) {
                $data['salary_range_err'] = 'Please enter salary range';
            }

            if (empty($data['Description'])) {
                $data['Description_err'] = 'Please enter Description';
            }

            //make sure no errors
            if (empty($data['job_name_err']) && empty($data['job_benifits_err']) && empty($data['job_location_err']) && empty($data['job_category_err'])  && empty($data['required_skills_err']) && empty($data['salary_range_err']) && empty($data['Description_err'])) {
                if ($this->model('M_jobpost')->create($data)) {
                    
                    $jobId = $this->model('M_jobpost')->getLatestJobId();

                    $this->model('M_applicationFields')->saveFields($jobId, $_POST);
                    redirect('service_provider/ongoing_jobs');
                } else {
                    die('something went wrong');
                }
            } else {
                //loading view with errors
                $this->view('pages/service_provider/jobPost', $data);
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
            $this->view('pages/service_provider/jobPost', $data);
        }
    }



    public function delete($postId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = $this->model('M_jobpost')->getpostbyid($postId);

            //check owner
            if ($post->CompanyID != $_SESSION['user_id']) {
                redirect('student/jobs');
            } else {



                if ($this->model('M_jobpost')->delete($postId)) {
                    flash('post-msg', 'post is deleted');
                    redirect('service_provider/ongoing_jobs');
                } else {
                    die('Something went wrong');
                }
            }
        }
    }
}
