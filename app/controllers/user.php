<?php
class User extends Controller
{
    private $model;
    private $universityEmailValidator;

    public function __construct()
    {
        // Load model
        $this->model = $this->model('userModel');

        // Load UniversityEmailValidator
        $this->universityEmailValidator = new UniversityEmailValidator();
    }

    private function validateEmail(&$data)
    {
        if (Validator::isEmpty($data['email'])) {
            $data['email_err'] = 'Please enter your email address';
        } elseif (!Validator::isValidEmail($data['email'])) {
            $data['email_err'] = 'Please enter a valid email address';
        } elseif (!$this->model->findUserByEmail($data['email'])) {
            $data['email_err'] = 'No user found with that email address';
        }
    }

    public function auth($method)
    {
        $protectedMethods = ['profile', 'deactivate'];
        if (in_array($method, $protectedMethods)) {
            AuthMiddleware::requireAuth();
        }
    }

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            // Validate email
            $data['email_err'] = Validator::isEmpty($data['email']) ? 'Please enter email' : (!Validator::isValidEmail($data['email']) ? 'Please enter a valid email' : (!$this->model->findUserByEmail($data['email']) ? 'No user found' : ''));

            // Validate password
            $data['password_err'] = Validator::isEmpty($data['password']) ? 'Please enter password' : '';

            // Check if there are no errors
            if (empty($data['email_err']) && empty($data['password_err'])) {
                // check is email is verified
                if ($this->model('AdminModel')->isEmailVerified($data['email'])) {
                    // Check for user
                    $loggedInUser = $this->model->login($data['email'], $data['password']);

                    if ($loggedInUser && $loggedInUser->Status === 'Active') {
                        // Create session
                        $this->createSession($loggedInUser->UserID);
                    } else if ($loggedInUser && $loggedInUser->Status === 'Pending Deletion') {
                        // Redirect to reactivate account page
                        $_SESSION['logged_user_id'] = $loggedInUser->UserID;
                        $_SESSION['logged_user_email'] = $loggedInUser->Email;
                        $_SESSION['logged_user_name'] = $loggedInUser->FirstName . ' ' . $loggedInUser->LastName;
                        Redirect::to(URLROOT . '/user/reactivate_acc');
                        exit;
                    } else if ($loggedInUser && $loggedInUser->Status === 'Deactive') {
                        if ($loggedInUser->Role === 'Student') {
                            $this->view('pages/login/deactivate_stu');
                        } else if ($loggedInUser->Role === 'Company') {
                            $this->view('pages/login/deactivate_ser');
                        }
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
                    } else {
                        $data['password_err'] = 'Password incorrect';
                        $this->view('pages/login/login', $data);
                    }
                } else {
                    //redirect to send verification email page
                    $this->view('pages/login/email_not_verified', $data);
                }
            } else {
                // Load view with errors
                $this->view('pages/login/login', $data);
            }
        } else {
            $data = [
                'email' => $_SESSION['verified_email'] ?? '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            // Load view
            $this->view('pages/login/login', $data);
        }
    }

    //send verification email to company
    public function sendStuVeriEmail()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST);

            // Init data
            $data = [
                'email' => strtolower(trim($_POST['email'])),
                'email_err' => ''
            ];

            // Validate email
            $this->validateEmail($data);

            //validate university email
            if (!$this->universityEmailValidator->isUniversityEmail($data['email'])) {
                $data['email_err'] = 'Please enter a valid university email address';
            }

            // Check if there are no errors
            if (empty($data['email_err'])) {
                //Generate the token
                $token = TokenHelper::generateToken();
                LogHelper::logDebug('Token generated: ' . $token);
                //Generate the expiry date
                $expiryDate = TokenHelper::generateExpiryDate();

                // Save token to database
                if ($this->model('AdminModel')->storeToken($data['email'], $token, $expiryDate)) {
                    LogHelper::logDebug('Token saved to database');
                    // Send token to email
                    MailHelper::sendEmailWithTokenStudent($data['email'], $token, 'user');
                    // Redirect to verify email page
                    $this->view('pages/login/veri_email_sent');
                } else {
                    LogHelper::logError('Token not saved to database');
                }
            } else {
                // Load view with errors
                $this->view('pages/login/email_not_verified', $data);
            }
        } else {
            // Init data
            $data = [
                'email' => '',
                'email_err' => ''
            ];
            // Load view
            $this->view('pages/login/email_not_verified', $data);
        }
    }

    //verify email using token
    public function verifyStuEmail($queryparams = [])
    {
        //check if token is set
        if (isset($queryparams['token'])) {
            //get token from query params
            $token = $queryparams['token'];

            //get token details
            $tokenDetails = $this->model('AdminModel')->getTokenDetails($token);

            //check if token is valid
            if ($tokenDetails) {
                //check if token is expired
                if (TokenHelper::validateToken($tokenDetails->Expiration)) {
                    //delete token
                    $this->model('AdminModel')->deleteToken($token);

                    //store email as verified
                    $this->model('AdminModel')->updateVerifyEmail($tokenDetails->Email);

                    //store verified email in session
                    $_SESSION['verified_email'] = $tokenDetails->Email;

                    // Redirect to register page
                    Redirect::to(URLROOT . '/login');
                } else {
                    //error message for expired token
                    die('Token expired');
                }
            } else {
                //error message for invalid token
                die('Invalid token');
            }
        } else {
            //TODO: Handle this
            die('Token not found');
        }
    }

    public function reactivate_acc()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['logged_user_id'])) {
                Redirect::to(URLROOT . '/login');
                exit;
            }
            $userID = $_SESSION['logged_user_id'];
            unset($_SESSION['logged_user_id']);

            // Check if user wants to reactivate account
            if (isset($_POST['yes'])) {
                $this->model->activateAccount($userID);
                //send email to notify user that their account has been reactivated
                MailHelper::sendEmailAccountReactivated($_SESSION['logged_user_email'], $_SESSION['logged_user_name']);
                //add user account log
                $this->model('AdminModel')->addUserAccountLog($userID, 'Reactivate', 15);
                unset($_SESSION['logged_user_email']);
                unset($_SESSION['logged_user_name']);
                // Create session
                $this->createSession($userID);
            } else if (isset($_POST['no'])) {
                // Redirect to home page
                Redirect::to(URLROOT);
            }
        } else {
            // Load view
            $this->view('pages/login/reactivate_acc');
        }
    }

    public function createSession($userID)
    {
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
                Redirect::to(URLROOT . '/jobs');
            } else if ($user['Role'] === 'Company') {
                Redirect::to(URLROOT . '/service_provider/dashboard');
            } else if ($user['Role'] === 'Admin') {
                Redirect::to(URLROOT . '/admin/dashboard');
            } else if ($user['Role'] === 'VT-Member') {
                Redirect::to(URLROOT . '/verification_team/user_ver_pending');
            }
            //print user details
            // print_r($_SESSION);
            // print($_SESSION['user_id']);
        } else {
            // Handle case where session details were not found
            die('User not found or unable to create session'); //TODO: Handle this
        }
    }

    public function logout()
    {
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
                $this->view('pages/admin/view_profile', $data); //TODO: Create admin profile view
            } else if ($user['Role'] === 'VT-Member') {
                $this->view('pages/verification_team/view_profile', $data); //TODO: Create VT-Member profile view
            } else {
                // Redirect to login page
                Redirect::to(URLROOT . '/login');
            }
        } catch (Exception $e) {
            die($e->getMessage()); //TODO: Handle this
        }
    }

    // Change password function
    public function change_password()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Set response type to JSON
            header('Content-Type: application/json');
            error_reporting(0); // Hide warnings (useful in production)

            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $data = [
                'current_password' => trim($_POST['current_password'] ?? ''),
                'new_password' => trim($_POST['new_password'] ?? ''),
                'confirm_password' => trim($_POST['confirm_password'] ?? ''),
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate current password
            if (Validator::isEmpty($data['current_password'])) {
                $data['current_password_err'] = 'Please enter current password';
            }

            // Validate new password
            if (Validator::isEmpty($data['new_password'])) {
                $data['new_password_err'] = 'Please enter new password';
            } elseif (!Validator::isValidPassword($data['new_password'])) {
                $data['new_password_err'] = 'Password must be at least 8 characters long and contain at least one number, one uppercase letter, one lowercase letter, and one special character';
            }

            // Validate confirm password
            if (Validator::isEmpty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm new password';
            } elseif ($data['new_password'] !== $data['confirm_password']) {
                $data['confirm_password_err'] = 'Passwords do not match';
            }

            // Check if there are no validation errors
            if (empty($data['current_password_err']) && empty($data['new_password_err']) && empty($data['confirm_password_err'])) {
                $user = $this->model->getUserDetails($_SESSION['user_id']);

                // Check if current password is correct
                if ($user && password_verify($data['current_password'], $user['Password'])) {
                    // Hash new password
                    $hashed_password = password_hash($data['new_password'], PASSWORD_DEFAULT);
                    $this->model->changePassword($_SESSION['user_id'], $hashed_password);
                    // Log password change
                    LogHelper::logDebug('Password changed for user ID: ' . $_SESSION['user_id']);
                    // Send email to notify user that their password has been changed
                    // MailHelper::sendEmailPasswordChanged($user['Email'], $user['FirstName'] . ' ' . $user['LastName']);
                    // Add user account log
                    $this->model('AdminModel')->addUserAccountLog($_SESSION['user_id'], 'ChangePass', 14);

                    // Unset session variables
                    session_unset();

                    // Destroy session
                    session_destroy();

                    // Return success response
                    echo json_encode(['status' => 'success', 'message' => 'Password changed successfully!']);

                    // Stop script execution
                    exit;
                } else {
                    // Return error if current password is incorrect
                    echo json_encode([
                        'status' => 'error',
                        'errors' => ['current_password' => 'Current password is incorrect']
                    ]);
                    exit;
                }
            }

            // Return validation errors
            echo json_encode([
                'status' => 'error',
                'errors' => array_filter([
                    'current_password' => $data['current_password_err'],
                    'new_password' => $data['new_password_err'],
                    'confirm_password' => $data['confirm_password_err']
                ])
            ]);
            exit;
        }
    }

    public function forgot_password()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $data = [
                'email' => trim($_POST['email'] ?? ''),
                'email_err' => ''
            ];

            // Validate email
            $this->validateEmail($data);

            // Check if there are no validation errors
            if (empty($data['email_err'])) {
                try {
                    //Generate the token
                    $token = TokenHelper::generateToken();
                    LogHelper::logDebug('Token generated: ' . $token);
                    //Generate the expiry date
                    $expiryDate = TokenHelper::generateExpiryDate('5 minutes');

                    //log the token
                    LogHelper::logDebug('Password reset token generated for ' . $data['email']);

                    // Save token to database
                    if ($this->model('AdminModel')->storeToken($data['email'], $token, $expiryDate)) {
                        LogHelper::logDebug('Token saved to database');
                        // Send token to email
                        MailHelper::sendEmailWithTokenResetPassword($data['email'], $token);
                        // Redirect to verify email page
                        $this->view('pages/login/email_sent', $data);
                    } else {
                        LogHelper::logError('Token not saved to database');
                    }
                } catch (Exception $e) {
                    // Log exception and return error response
                    error_log('Exception while sending password reset email: ' . $e->getMessage());
                    $data['email_err'] = 'An error occurred. Please try again later';
                    $this->view('pages/login/forgot_password', $data);
                }
            } else {
                // Load view with errors
                $this->view('pages/login/forgot_password', $data);
            }
        } else {
            $data = [
                'email' => '',
                'email_err' => ''
            ];

            // Load view
            $this->view('pages/login/forgot_password', $data);
        }
    }

    public function reset_password($queryParams = [])
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $data = [
                'password' => trim($_POST['password'] ?? ''),
                'confirm_password' => trim($_POST['confirm_password'] ?? ''),
                'password_err' => '',
                'confirm_password_err' => '',
                'error' => ''
            ];
            //check if token is set
            if (isset($queryParams['token'])) {
                //get token from query params
                $token = $queryParams['token'];
                //get token details
                $tokenDetails = $this->model('AdminModel')->getTokenDetails($token);
                // Check if token is valid
                if (!$tokenDetails || empty($tokenDetails->Email)) {
                    //log the error
                    LogHelper::logError('Invalid token');
                    // Return error response
                    $data['error'] = 'Invalid token';
                    $this->view('pages/login/reset_password', $data);
                    return;
                }
                // Validate token expiration
                if (TokenHelper::validateToken($tokenDetails->Expiration)) {
                    //get user details by email
                    $userDetails = $this->model->findUserByEmail($tokenDetails->Email);
                    // Reset password
                    if ($this->resetPassword($data, $userDetails->UserID)) {
                        // Delete token
                        $this->model('AdminModel')->deleteToken($token);
                        // Redirect to login page
                        Redirect::to(URLROOT . '/login');
                        exit;
                    } else {
                        // Return error response
                        $data['error'] = 'An error occurred. Please try again later';
                        $this->view('pages/login/reset_password', $data);
                    }
                } else {
                    //log the error
                    LogHelper::logError('Token has expired');
                    // Return error response
                    $data['error'] = 'Token has expired';
                    $this->view('pages/login/reset_password', $data);
                }
            } else {
                //log the error
                LogHelper::logError('Token not found');
                // Return error response
                $data['error'] = 'Token not found';
                $this->view('pages/login/reset_password', $data);
            }
        } else {
            $data = [
                'password' => '',
                'confirm_password' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'error' => ''
            ];
            // Load view
            $this->view('pages/login/reset_password', $data);
        }
    }

    private function resetPassword($data, $userID)
    {
        // Validate password
        if (Validator::isEmpty($data['password'])) {
            $data['password_err'] = 'Please enter password';
        } elseif (!Validator::isValidPassword($data['password'])) {
            $data['password_err'] = 'Password must be at least 8 characters long and contain at least one number, one uppercase letter, one lowercase letter, and one special character';
        }

        // Validate confirm password
        if (Validator::isEmpty($data['confirm_password'])) {
            $data['confirm_password_err'] = 'Please confirm password';
        } elseif (!Validator::isValidConfirmPassword($data['password'], $data['confirm_password'])) {
            $data['confirm_password_err'] = 'Passwords do not match';
        }

        // Check if there are no validation errors
        if (!empty($data['password_err']) || !empty($data['confirm_password_err'])) {
            $this->view('pages/login/reset_password', $data);
            return false;
        }
        try {
            // Hash password
            $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
            // Update password
            $this->model->changePassword($userID, $hashed_password);
            //log the password change
            LogHelper::logDebug('Password reset for user ID: ' . $userID);
            // send email to notify user that their password has been reset
            // MailHelper::sendEmailPasswordReset($data['email'], $data['name']);
            //add user account log
            $this->model('AdminModel')->addUserAccountLog($userID, 'ResetPass', 13);

            return true;
        } catch (Exception $e) {
            // Log exception and return error response
            LogHelper::logError('Exception while resetting password: ' . $e->getMessage());
            return false;
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
                $this->model->deactivateAccountByUser($_SESSION['user_id']);
                //send email to notify user that their account
                MailHelper::sendEmailAccountDeactivated($_SESSION['user_email'], $_SESSION['user_name']);
                //add user account log
                $this->model('AdminModel')->addUserAccountLog($_SESSION['user_id'], 'PendingDelete', 11);
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

    public function errorPage()
    {
        $this->view('pages/404_not_found/page_not_found');
    }

    public function contact_admin()
    {
        $this->view('pages/student/contact_admin');
    }
}
