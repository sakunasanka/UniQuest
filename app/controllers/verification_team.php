<?php
class Verification_team extends Controller
{
    private $model;

    public function __construct()
    {
        // Check if user is logged in
        AuthMiddleware::requireAuth();
        // Check if user has the required role
        AuthMiddleware::requireRole('VT-Member');

        // Load model
        $this->model = $this->model('userModel');
    }

    public function index()
    {
        $this->user_ver_pending();
    }

    public function user_verified()
    {
        $this->view('pages/verification_team/user_verified');
    }

    public function job_verified()
    {
        $this->view('pages/verification_team/job_verified');
    }

    public function user_ver_pending()
    {
        try {
            $users = $this->model->getPendingStudentsAndCompanies();
            $data = [
                'users' => $users
            ];
            $this->view('pages/verification_team/user_ver_pending', $data);
        } catch (Exception $e) {
            die($e->getMessage());//TODO: Handle this
        }
    }

    public function user_ver_not()
    {
        try {
            $users = $this->model->getNotVerifiedStudentsAndCompanies();
            $data = [
                'users' => $users
            ];
            $this->view('pages/verification_team/user_ver_not', $data);
        } catch (Exception $e) {
            die($e->getMessage());//TODO: Handle this
        }
    }

    public function user_ver_detail($userID)
    {
        try {
            $user = $this->model->getUserDetails($userID);
            $data = [
                'user' => $user
            ];
            if ($user['Role'] == 'Student') {
                $this->view('pages/verification_team/stu_ver_detail', $data);
            } else if ($user['Role'] == 'Company') {
                $this->view('pages/verification_team/com_ver_detail', $data);
            }
        } catch (Exception $e) {
            die($e->getMessage());//TODO: Handle this
        }
    }

    public function stu_detail() {
        $this->view('pages/verification_team/stu_detail');
    }

    public function com_detail() {
        $this->view('pages/verification_team/com_detail');
    }

    public function user_ver_approve($userID)
    {
        try {
            $this->model->approveUser($userID);
            Redirect::to(URLROOT . '/verification_team/user_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage());//TODO: Handle this
        }
    }

    public function user_ver_reject($userID)
    {
        try {
            $this->model->rejectUser($userID);
            Redirect::to(URLROOT . '/verification_team/user_ver_pending');
        } catch (Exception $e) {
            die($e->getMessage());//TODO: Handle this
        }
    }

    public function job_ver_pending()
    {
        $this->view('pages/verification_team/job_ver_pending');
    }

    public function ptjob_ver_detail()
    {
        $this->view('pages/verification_team/ptjob_ver_detail');
    }

    public function job_ver_not()
    {
        $this->view('pages/verification_team/job_ver_not');
    }

    public function notifications()
    {
        $this->view('pages/verification_team/notification_alerts');
    }

    public function contact_admin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Data for the contact form
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'topic' => trim($_POST['topic'] ?? ''),
                'message' => trim($_POST['message'] ?? ''),

                'name_err' => '',
                'email_err' => '',
                'topic_err' => '',
                'message_err' => ''
            ];

            // Validation checks
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter your name';
            }

            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter your email address';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Please enter a valid email address';
            }

            if (empty($data['topic'])) {
                $data['topic_err'] = 'Please select a topic';
            }

            if (empty($data['message'])) {
                $data['message_err'] = 'Please enter your message';
            }

            // Ensure no errors before submitting
            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['topic_err']) && empty($data['message_err'])) {
                if($this->model('ContactModel')->sendMessage($data)){
                    flash('contact-msg', 'Your message has been sent successfully.');
                    redirect('verification_team/contact_admin');
                } else {
                    die('Something went wrong. Please try again.');
                }
            } else {
                $this->view('pages/verification_team/contact_admin', $data);
            }
        } else {
            // Initialize default data for the view on GET request
            $data = [
                'name' => '',
                'email' => '',
                'topic' => '',
                'message' => '',
                'name_err' => '',
                'email_err' => '',
                'topic_err' => '',
                'message_err' => ''
            ];

        $this->view('pages/verification_team/contact_admin', $data);
        }
    }
}