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
                    // redirect('service_provider/ongoing_jobs');
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



                if ($this->model('M_jobpost')->deletePost($postId)) {
                    flash('post-msg', 'post is deleted');
                    redirect('service_provider/ongoing_jobs');
                } else {
                    die('Something went wrong');
                }
            }
        }
    }

    public function messages_stu($userID = null)
    {
        // Check if a user ID was submitted via POST
        if (isset($_POST['selectedUserID'])) {
            $userID = $_POST['selectedUserID'];
        }
        
        // Fetch all student messages
        $messages_stu = $this->model('ContactModel')->getMessagesStuCom();

        // Initialize data with the message list
        $data = [
            'messages_stu' => $messages_stu,
        ];
        
        // Check if we need to load chat data only if userID is valid AND form was submitted
        $loadChatData = !empty($userID) && isset($_POST['selectedUserID']);
        
        // If we should load chat data, add the additional info
        if ($loadChatData) {
            // Ensure session user ID exists before accessing
            if (!isset($_SESSION['user_id'])) {
                die("Unauthorized access. Please log in.");
            }
            // Fetch user details and chat messages
            $data['userID'] = $userID;
            $data['user'] = $this->model->getUserDetails($userID);
            $data['sender_id'] = $_SESSION['user_id'];
            $data['receiver_id'] = $userID;
            $data['messages'] = $this->model('chatModel')->getMessages($_SESSION['user_id'], $userID);
            $data['messageInput'] = '';
            $data['messageInput_err'] = '';
        }

        $this->view('pages/service_provider/messages_stu', $data);
    }

    public function messages_add($userID = null)
    { 
        // Check if a user ID was submitted via POST
        if (isset($_POST['selectedUserID'])) {
            $userID = $_POST['selectedUserID'];
        }
        
        // Fetch all student messages
        $messages_add = $this->model('ContactModel')->getMessagesAddCom();

        // Initialize data with the message list
        $data = [
            'messages_add' => $messages_add,
        ];
        
        // Check if we need to load chat data only if userID is valid AND form was submitted
        $loadChatData = !empty($userID) && isset($_POST['selectedUserID']);
        
        // If we should load chat data, add the additional info
        if ($loadChatData) {
            // Ensure session user ID exists before accessing
            if (!isset($_SESSION['user_id'])) {
                die("Unauthorized access. Please log in.");
            }
            // Fetch user details and chat messages
            $data['userID'] = $userID;
            $data['user'] = $this->model->getUserDetails($userID);
            $data['sender_id'] = $_SESSION['user_id'];
            $data['receiver_id'] = $userID;
            $data['messages'] = $this->model('chatModel')->getMessages($_SESSION['user_id'], $userID);
            $data['messageInput'] = '';
            $data['messageInput_err'] = '';
        }
        
        $this->view('pages/service_provider/messages_add', $data);
    }
    
    public function sendMessage($userID)
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Fetch previous messages to determine the last topic if not provided
            $previousMessage = $this->model('chatModel')->getLastMessageBetween($_SESSION['user_id'], $userID);
            $lastTopic = $previousMessage ? $previousMessage->topic : 'General Information';

            // Use the submitted topic if provided, otherwise use the last topic
            $submittedTopic = trim($_POST['topic'] ?? '');

            // Fetch email logic
            $email = null; // Default to null

            // 1. Check if the previous message has an email
            if ($previousMessage && !empty($previousMessage->user_email)) {
                $email = $previousMessage->user_email;
            }
            // 2. If previous message email is null, fetch email from the user table
            elseif ($this->model->getUserDetails($userID)) {
                $userDetails = $this->model->getUserDetails($userID);
                $email = $userDetails->email ?? null; // Use email if available, else null
            }

            $data = [
                'userID' => $userID,
                'email' => $email, 
                'user' => $this->model->getUserDetails($userID),
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => $userID,
                'messages' => $this->model('chatModel')->getMessages($_SESSION['user_id'], $userID),
                'messageInput' => trim($_POST['messageInput'] ?? ''),
                'topic' => !empty($submittedTopic) ? $submittedTopic : $lastTopic, // Ensure topic is never empty
                'messageInput_err' => '',
            ];

            // Validation
            if (empty($data['messageInput'])) {
                $data['messageInput_err'] = 'Message cannot be empty';
            }

            // Ensure no errors before proceeding
            if (empty($data['messageInput_err'])) {
                if ($this->model('chatModel')->sendMessage($data['email'], $data['sender_id'], $data['receiver_id'], $data['topic'], $data['messageInput'], $data['email'])) {
                    // flash('message_sent', 'Message sent successfully');
                    redirect('service_provider/messages_stu/' . $userID);
                } else {
                    die('Something went wrong while sending the message.');
                }
            } else {
                // Reload view with errors
                $this->loadUserDetailView($data);
            }
        } else {
            // Load initial view without POST request
            
            $data = [
                'userID' => $userID,
                'email' => '',
                'user' => $this->model->getUserDetails($userID),
                'sender_id' => $_SESSION['user_id'],
                'receiver_id' => $userID,
                'messages' => $this->model('chatModel')->getMessages($_SESSION['user_id'], $userID),
                'messageInput' => '',
                'messageInput_err' => '',
                'topic' => '', // Default to empty until a message is sent
            ];

            $this->loadUserDetailView($data);
        }
    }
    private function loadUserDetailView($data)
    {
        // Load the view with the provided data
        $this->view('pages/service_provider/messages_stu', $data);
        $this->view('pages/service_provider/messages_add', $data);
    }
}
