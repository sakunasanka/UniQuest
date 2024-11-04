<?php 
class Login extends Controller {
    private $model;
    public function __construct() {
        // Load model
        $this->model = $this->model('userModel');
    }

    public function index() {
        self::login();
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

                if ($loggedInUser) {
                    // Create session
                    die('Logged in');//TODO: Handle this
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
}
?>