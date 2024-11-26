<?php
class User extends Controller
{
    private $model;

    public function __construct()
    {
        // Load model
        $this->model = $this->model('userModel');
    }

    public function index()
    {
        echo 'user/index';
    }

    public function login() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            // Validate email
            $data['email_err'] = Validator::isEmpty($data['email']) ? 'Please enter email' : 
                (!Validator::isValidEmail($data['email']) ? 'Please enter a valid email' : 
                (!$this->model->findUserByEmail($data['email']) ? 'No user found' : ''));

            // Validate password
            $data['password_err'] = Validator::isEmpty($data['password']) ? 'Please enter password' : '';

            // Check if there are no errors
            if (empty($data['email_err']) && empty($data['password_err'])) {
                // Check for user
                $loggedInUser = $this->model->login($data['email'], $data['password']);

                if ($loggedInUser && $loggedInUser->Status === 'Active') {
                    // Create session
                    $this->createSession($loggedInUser->UserID);
                } else if ($loggedInUser && $loggedInUser->Status === 'Deactive') {
                    die('Deactive');//TODO: Handle this

                } else if ($loggedInUser && $loggedInUser->Status === 'Pending') {
                    if ($loggedInUser->Role === 'Student') {
                        $this->view('pages/login/wait_to_verify_stu');
                    } else if ($loggedInUser->Role === 'Company') {
                        $this->view('pages/login/wait_to_verify_ser');
                    }
                } else if ($loggedInUser && $loggedInUser->Status === 'Not Approved') {
                    if ($loggedInUser->Role === 'Student') {
                        $this->view('pages/login/deactivate_stu');
                    } else if ($loggedInUser->Role === 'Company') {
                        $this->view('pages/login/deactivate_ser');
                    }
                    if(isset($_SESSION['user_id'])){
                        session_unset();
                        session_destroy();
                    }
                    
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('pages/login/login', $data);
                }

            } else {
                // Load view with errors
                $this->view('pages/login/login', $data);
            }

        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            // Load view
            $this->view('pages/login/login', $data);
        }
    }

    public function createSession($userID) {
        // Start session
        session_start();
    
        // Get session details
        $user = $this->model->getUserDetails($userID);
    
        if ($user) {
            // Store session variables
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['user_email'] = $user['Email'];
            $_SESSION['user_role'] = $user['Role'];
            $_SESSION['user_status'] = $user['Status'];
    
            if ($user['Role'] === 'Student' || $user['Role'] === 'Admin' || $user['Role'] === 'VT-Member') {
                $_SESSION['user_name'] = $user['FirstName'] . ' ' . $user['LastName'];
                $_SESSION['user_profile_pic'] = $user['ProfilePic'];
            } else if ($user['Role'] === 'Company') {
                $_SESSION['user_name'] = $user['CompanyName'];
                $_SESSION['user_profile_pic'] = $user['CompanyLogo'];
            }
    
            // TODO: Redirect to dashboard or handle the next step
            if ($user['Role'] === 'Student') {
                Redirect::to(URLROOT . '/user/profile');
            } else if ($user['Role'] === 'Company') {
                Redirect::to(URLROOT . '/service_provider/dashboard');
            } else if ($user['Role'] === 'Admin') {
                Redirect::to(URLROOT . '/admin/dashboard');
            } else if ($user['Role'] === 'VT-Member') {
                Redirect::to(URLROOT . '/verification_team/user_ver_all');
            }
            //print user details
            // print_r($_SESSION);
            // print($_SESSION['user_id']);
        } else {
            // Handle case where session details were not found
            die('User not found or unable to create session');//TODO: Handle this
        }
    }

    public function logout() {
        // Unset session variables
        session_unset();
    
        // Destroy session
        session_destroy();
    
        // Redirect to login page
        Redirect::to(URLROOT . '/home');
    }

    public function profile()
    {
        try {
            $user = $this->model->getUserDetails($_SESSION['user_id']);
            $data = [
                'user' => $user
            ];
            if ($user['Role'] === 'Student') {
                $this->view('pages/student/view_profile', $data);
            } else if ($user['Role'] === 'Company') {
                $this->view('pages/service_provider/view_profile', $data);
            } else if ($user['Role'] === 'Admin') {
                $this->view('pages/admin/profile', $data); //TODO: Create admin profile view
            } else if ($user['Role'] === 'VT-Member') {
                $this->view('pages/vt-member/profile', $data);//TODO: Create VT-Member profile view
            } else {
                // Redirect to login page
                Redirect::to(URLROOT . '/login');
            }
        } catch (Exception $e) {
            die($e->getMessage());//TODO: Handle this
        }
    }

    public function deactivate()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST);

            $data = [
                'confirm' => isset($_POST['confirm']) ? trim($_POST['confirm']) : '',
                'confirm_err' => ''
            ];
    
            // Validate confirm
            if (empty($data['confirm']) || $data['confirm'] !== 'yes') {
                $data['confirm_err'] = 'Please confirm account deactivation';
            }

            // Check if there are no errors
            if (empty($data['confirm_err'])) {
                // Deactivate account
                $this->model->deactivateAccount($_SESSION['user_id']);
                // Logout
                $this->logout();
            } else {
                // Load view with errors
                $this->view('popups/student/deactivate_account', $data);
            }
        } else {
            $data = [
                'confirm' => '',
                'confirm_err' => ''
            ];

            // Load view
            $this->view('popups/student/deactivate_account', $data);
        }
    }

    public function errorPage() {
        $this->view('pages/404_not_found/page_not_found');
    }

    public function contact_admin()
    {
        $this->view('pages/student/contact_admin');
    }
}
?>