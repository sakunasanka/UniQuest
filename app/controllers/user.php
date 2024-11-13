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
                $this->view('pages/service_provider/view_profile', $data);//TODO: Create company profile view
            } else if ($user['Role'] === 'Admin') {
                $this->view('pages/admin/profile', $data); //TODO: Create admin profile view
            } else if ($user['Role'] === 'VT-Member') {
                $this->view('pages/vt-member/profile', $data);//TODO: Create VT-Member profile view
            } else {
                // Redirect to login page
                Redirect::to(URLROOT . '/login');
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}
?>