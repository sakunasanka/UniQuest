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
                'email' => trim($_POST['email'] ?? ''),
                'topic' => trim($_POST['topic'] ?? ''),
                'message' => trim($_POST['message'] ?? ''),

                'email_err' => '',
                'topic_err' => '',
                'message_err' => ''
            ];

            // Validation checks
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter your email';
            }

            if (empty($data['topic'])) {
                $data['topic_err'] = 'Please select a topic';
            }

            if (empty($data['message'])) {
                $data['message_err'] = 'Please enter your message';
            }

            // Ensure no errors before submitting
            if (empty($data['email_err'])  && empty($data['topic_err']) && empty($data['message_err'])) {
                if($this->model('ContactModel')->sendMessage($data)){
                    flash('contact-msg', 'Your message has been sent successfully.');
                    Redirect::to(URLROOT . '/service_provider/contact_admin');
                } else {
                    die('Something went wrong. Please try again.');
                }
            } else {
                $this->view('pages/service_provider/contact_admin', $data);
            }
        } else {
            // Initialize default data for the view on GET request
            $data = [
                'email' => '',
                'topic' => '',
                'message' => '',
                'email_err' => '',
                'topic_err' => '',
                'message_err' => ''
            ];
    
     $this->view('pages/service_provider/contact_admin', $data);
    }
}

    public function dashboard()
    {
        $companyInfo = $this->model('companyModel')->getCompanyInfo();

        $data = [
            'companyInfo' => $companyInfo
        ];

        $this->view('pages/service_provider/ser_dashboard', $data);
    }
    public function jobPostform()
    {
        $this->view('pages/service_provider/jobPost');
    }
    

    public function report()
    {
        if ($_SESSION['user_role'] == 'Company') {
            $companyInfo = $this->model('companyModel')->getCompanyInfo();
        } else {
            $companyInfo = null; 
        }

        $data = [
            
        ];

        if (($companyInfo->subscription_plan == 'professional' || $companyInfo->subscription_plan == 'enterprise') && $companyInfo->subscription_status == 'active' && $_SESSION['user_role'] == 'Company') {
            $this->view('pages/service_provider/job_report', $data);
        }
        else {
            $_SESSION['show_report_error'] = true;
            $previousURL = $_SERVER['HTTP_REFERER'] ?? URLROOT . '/service_provider/dashboard';
            Redirect::to($previousURL);
        }
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

    public function offered_applications($jobID)
    {
        // Fetch applications for the given job ID
        $applications = $this->model('M_applicationFields')->getOfferedApplicationsByJobID($jobID);

        // Pass data to the view
        $data = [
            'applications' => $applications,
            'jobID' => $jobID,
            'post' => $this->model('M_jobpost')->getpostbyid($jobID),
        ];
        $data['posted'] = date('M d, Y', strtotime($data['post']->jobs_create_at));

        // Load the view
        $this->view('pages/service_provider/offered_applications', $data);
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
        $applications = $this->model('M_applicationFields')->getPendnigApplicationsByJobID($jobID);

        // Pass data to the view
        $data = [
            'applications' => $applications,
            'jobID' => $jobID,
            'post' => $this->model('M_jobpost')->getpostbyid($jobID),
        ];
        $data['posted'] = date('M d, Y', strtotime($data['post']->jobs_create_at));

        // Load the view
        $this->view('pages/service_provider/new_applications', $data);
    }
    public function view_application($applicationID)
    {
    // Fetch application details
    $application = $this->model('M_applicationFields')->getApplicationsByID($applicationID);

    if (!$application) {
        // Handle the case where the application is not found
        redirect('error/not_found');
    }

    // Access the first element of the $application array
    $application = $application[0];
    
    // Prepare the application data
    $applicationData = [
        'jobID' => $application->JobID ?? null,
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
        'other3' => $application->other3 ?? null,
        'other1_type' => $application->other1_type ?? null,
        'other2_type' => $application->other2_type ?? null,
        'other3_type' => $application->other3_type ?? null,
    ];

    $data = [
        'application' => $applicationData,
    ];
    $fields = $this->model('M_applicationFields')->getFieldsByJobId($data['application']['jobID']);

    $data['fields'] = $fields;

    // Load the view
    $this->view('pages/service_provider/view_application', $data);
    }

    public function rejected_applications($jobID)
    {
        // Fetch applications for the given job ID
        $applications = $this->model('M_applicationFields')->getRejectedApplicationsByJobID($jobID);

        // Pass data to the view
        $data = [
            'applications' => $applications,
            'jobID' => $jobID,
            'post' => $this->model('M_jobpost')->getpostbyid($jobID),
        ];
        $data['posted'] = date('M d, Y', strtotime($data['post']->jobs_create_at));

        // Load the view
        $this->view('pages/service_provider/rejected_applications', $data);
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
        $companyInfo = $this->model('companyModel')->getCompanyInfo();

        $data = [
            'companyInfo' => $companyInfo
        ];

        $this->view('pages/service_provider/premiumFeatures', $data);
    }
    public function payhereprocess() {
        // Get user data from session
        $user_id = $_SESSION['user_id'] ?? 0;
        
        // Get plan from query parameter
        $plan = $_GET['plan'] ?? 'professional';
        
        // Plan details
        $amount = ($plan === 'enterprise') ? 5000 : 3000;
        
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
        
        // Store pending payment in database
        $this->model('companyModel')->storePendingPayment($user_id, $order_id, $plan, $amount);
        
        // Store in session as fallback
        $_SESSION['pending_order_id'] = $order_id;
        $_SESSION['pending_plan'] = $plan;
        
        // Create response
        $response = [
            'merchant_id' => $merchant_id,
            'order_id' => $order_id,
            'amount' => $amount,
            'currency' => $currency,
            'hash' => $hash
        ];
        
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    public function payment_return() {
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Log all incoming data
        error_log("Payment Return - GET: " . print_r($_GET, true));
        error_log("Payment Return - POST: " . print_r($_POST, true));
        error_log("Payment Return - SESSION: " . print_r($_SESSION, true));
        
        // Get order_id from URL first, then session
        $order_id = $_GET['order_id'] ?? ($_SESSION['pending_order_id'] ?? null);
        
        if (!$order_id) {
            $_SESSION['payment_message'] = 'Payment error: Missing order information';
            
            return;
        }
        
        // Get payment details from database
        $payment = $this->model('companyModel')->getPendingPayment($order_id);
        
        if (!$payment) {
            $_SESSION['payment_message'] = 'Payment error: Order not found';
            Redirect::to(URLROOT . '/service_provider/premium');
            return;
        }
        
        // Check if already processed
        if ($this->model('companyModel')->getPaymentByOrderId($order_id)) {
            $_SESSION['payment_message'] = 'Payment already processed';
            Redirect::to(URLROOT . '/service_provider/premium');
            return;
        }
        
        // Calculate dates
        $start_date = date('Y-m-d H:i:s');
        $end_date = date('Y-m-d H:i:s', strtotime('+30 days'));
        
        // Update subscription
        $result = $this->model('companyModel')->updateSubscription(
            $payment->user_id, 
            $payment->plan, 
            $start_date, 
            $end_date, 
            'active'
        );
        
        if ($result) {
            // Store payment (use temporary payment_id for return_url flow)
            $payment_id = 'RET_' . time();
            $this->model('companyModel')->storePaymentSuccess(
                $payment->user_id,
                $order_id,
                $payment_id,
                $payment->plan,
                $payment->amount
            );
            
            $_SESSION['payment_message'] = 'Payment successful! Your subscription has been activated.';
            unset($_SESSION['pending_order_id']);
            unset($_SESSION['pending_plan']);
        } else {
            $_SESSION['payment_message'] = 'Payment was processed but there was an issue updating your account. Please contact support.';
        }
        
        Redirect::to(URLROOT . '/service_provider/premium');
    }

    public function premium_pro() {
        // Log the full request
        file_put_contents('payhere_notify.log', date('Y-m-d H:i:s') . " - " . print_r($_POST, true) . "\n", FILE_APPEND);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $merchant_id = $_POST['merchant_id'];
            $order_id = $_POST['order_id'];
            $payment_id = $_POST['payment_id'];
            $amount = $_POST['payhere_amount'];
            $status_code = $_POST['status_code'];
            $md5sig = $_POST['md5sig'];
            
            // Verify signature
            $merchant_secret = "NDEyMTM4MDkxMzEwNDM3Njc5NTYzNzA0OTE1MDEzNzYwNDM2OTgw";
            $local_md5sig = strtoupper(
                md5(
                    $merchant_id . 
                    $order_id . 
                    $amount . 
                    $_POST['payhere_currency'] . 
                    $status_code . 
                    strtoupper(md5($merchant_secret))
                )
            );
            
            if ($local_md5sig === $md5sig && $status_code == 2) {
                // Payment verified - process it
                
                // Get pending payment
                $payment = $this->model('companyModel')->getPendingPayment($order_id);
                
                if ($payment) {
                    // Update subscription
                    $start_date = date('Y-m-d H:i:s');
                    $end_date = date('Y-m-d H:i:s', strtotime('+30 days'));
                    
                    $this->model('companyModel')->updateSubscription(
                        $payment->user_id,
                        $payment->plan,
                        $start_date,
                        $end_date,
                        'active'
                    );
                    
                    // Store payment success
                    $this->model('companyModel')->storePaymentSuccess(
                        $payment->user_id,
                        $order_id,
                        $payment_id,
                        $payment->plan,
                        $amount
                    );
                    
                    // Clean up pending payment
                    $this->model('companyModel')->clearPendingPayment($order_id);
                }
            }
        }
        
        http_response_code(200);
        exit;
    }

    public function process_payment_ajax() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
            exit;
        }
        
        $order_id = $_POST['order_id'] ?? null;
        $plan = $_POST['plan'] ?? null;
        
        if (!$order_id || !$plan) {
            echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
            exit;
        }
        
        // Extract user_id from order_id (ORDER_timestamp_userid)
        $parts = explode('_', $order_id);
        $user_id = end($parts);
        
        // Calculate dates
        $start_date = date('Y-m-d H:i:s');
        $end_date = date('Y-m-d H:i:s', strtotime('+30 days'));
        
        // Update subscription
        $result = $this->model('companyModel')->updateSubscription(
            $user_id,
            $plan,
            $start_date,
            $end_date,
            'active'
        );
        
        if ($result) {
            // Store payment
            $payment_id = 'AJAX_' . time();
            $amount = ($plan === 'enterprise') ? 5000 : 3000;
            
            $this->model('companyModel')->storePaymentSuccess(
                $user_id,
                $order_id,
                $payment_id,
                $plan,
                $amount
            );
            
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database update failed']);
        }
        
        exit;
    }
    
    
    public function analytics()
    {
        $jobCount = $this->model('M_jobpost')->getJobCountByCompany();
        $activeJobCount = $this->model('M_jobpost')->getActiveJobCountByCompany();
        $applicationCount = $this->model('M_applicationFields')->getApplicationCount();
        $applicationsByGender = $this->model('M_applicationFields')->getApplicationsByGender();
        $applicationsByWeek = $this->model('M_applicationFields')->getApplicationsByWeek();
        $topPerforming = $this->model('M_applicationFields')->getTopPerformingJobs();
        $companyInfo = $this->model('companyModel')->getCompanyInfo();

        // Fetch data for charts
        $registrationsData = $this->model('M_jobpost')->getJobPostingsByMonth();
        $applicationData = $this->model('M_applicationFields')->getApplicationsByWeek();

        $Jobspermonth = [];
        $Internshipspermonth = [];

            // Loop through each job post to get the display rating for the associated company
            foreach ($registrationsData['data'] as $registration) {
                $job_count = $registration->part_time_jobs; 
                $Jobspermonth[] = $job_count;
            }
            $Jobspermonth = array_reverse($Jobspermonth);

            // Loop through each job post to get the display rating for the associated company
            foreach ($registrationsData['data'] as $registration) {
                $internship_count = $registration->internships; 
                $Internshipspermonth[] = $internship_count;
            }
            $Internshipspermonth = array_reverse($Internshipspermonth);

        // $userLoginsData = $this->model('M_user')->getUserLoginsByGender();
        
        $data = [
            'job_count' => $jobCount,
            'activeJobCount' => $activeJobCount,
            'applicationCount' => $applicationCount,
            'registrationsData' => $registrationsData,
            'applicationData' => $applicationData,
            'Jobspermonth' => $Jobspermonth,
            'Internshipspermonth' => $Internshipspermonth,
            'month_names' => $registrationsData['month_names'],
            'applicationsByGender' => $applicationsByGender,
            'applicationsByWeek' => $applicationsByWeek,
            'topPerforming' => $topPerforming,
            // 'userLoginsData' => $userLoginsData,
        ];

        if (($companyInfo->subscription_plan == 'professional' || $companyInfo->subscription_plan == 'enterprise') && $companyInfo->subscription_status == 'active' && $_SESSION['user_role'] == 'Company') {
            $this->view('pages/service_provider/ser_analytics', $data);
        }
        else {
            $_SESSION['show_premium_error'] = true;
            $previousURL = $_SERVER['HTTP_REFERER'] ?? URLROOT . '/service_provider/dashboard';
            Redirect::to($previousURL);
        }
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

            $publishDate = date('Y-m-d', strtotime('+2 days'));

            $data = [
                'job_name' => trim($_POST['jobName'] ?? ''),
                'job_benifits' => trim($_POST['jobBenefits'] ?? ''),
                'job_location' => trim($_POST['jobLocation'] ?? ''),
                'job_category' => trim($_POST['jobType'] ?? ''),
                'publish_date' => !empty($_POST['jobPostDate']) ? trim($_POST['publishDate']) : $publishDate,
                'required_skills' => trim($_POST['qualifications'] ?? ''),
                'salary_range' => trim($_POST['salaryRange'] ?? ''),
                'salary_type' => trim($_POST['salaryType'] ?? ''),
                'Description' => trim($_POST['jobDescription'] ?? ''),
                'status' => 'Pending',

                'job_name_err' => '',
                'job_benifits_err' => '',
                'job_location_err' => '',
                'job_category_err' => '',
                'required_skills_err' => '',
                'salary_range_err' => '',
                'salary_type_err' => '',
                'Description_err' => '',
                'publish_date_err' => ''
            ];

            // Validate date - not in the past and not more than 7 days in the future
            if (!empty($_POST['jobPostDate'])) {
                $selectedDate = strtotime($data['publish_date']);
                $today = strtotime($publishDate);
                $maxDate = strtotime('+30 days', $today);

                if ($selectedDate < $today) {
                    $data['publish_date_err'] = 'Date cannot be earlier than 2 days from today (For verification purposes)';
                } elseif ($selectedDate > $maxDate) {
                    $data['publish_date_err'] = 'Date cannot be more than 30 days in the future';
                }
            }

            // validation for other fields
            if (empty($data['job_name'])) {
                $data['job_name_err'] = 'Please enter job name';
            }
            if (empty($data['job_location'])) {
                $data['job_location_err'] = 'Please enter job location';
            }
            if (empty($data['job_category'])) {
                $data['job_category_err'] = 'Please enter job category';
            }

            if (
                empty($data['job_name_err']) &&
                empty($data['job_benifits_err']) &&
                empty($data['job_location_err']) &&
                empty($data['job_category_err']) &&
                empty($data['required_skills_err']) &&
                empty($data['salary_range_err']) &&
                empty($data['salary_type_err']) &&
                empty($data['Description_err']) &&
                empty($data['publish_date_err'])
            ) {
                if ($this->model('M_jobpost')->create($data)) {
                    $jobId = $this->model('M_jobpost')->getLatestJobId();
                    $this->model('M_applicationFields')->saveFields($jobId, $_POST);
                    redirect('service_provider/ongoing_jobs');
                } else {
                    die('something went wrong');
                }
            } else {
                $this->view('pages/service_provider/jobPost', $data);
            }
        } else {
            // Default values for GET request
            $publishDate = date('Y-m-d', strtotime('+2 days'));

            $data = [
                'job_name' => '',
                'job_benifits' => '',
                'job_location' => '',
                'job_category' => '',
                'adress' => '',
                'required_skills' => '',
                'salary_range' => '',
                'salary_type' => '',
                'Description' => '',
                'publish_date' => $publishDate,

                'job_name_err' => '',
                'job_benifits_err' => '',
                'job_location_err' => '',
                'job_category_err' => '',
                'adress_err' => '',
                'required_skills_err' => '',
                'salary_range_err' => '',
                'salary_type_err' => '',
                'Description_err' => '',
                'publish_date_err' => ''
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



                if ($this->model('M_jobpost')->deletePost($postId)) {
                    flash('post-msg', 'post is deleted');
                    redirect('service_provider/ongoing_jobs');
                } else {
                    die('Something went wrong');
                }
            }
        }
    }
}