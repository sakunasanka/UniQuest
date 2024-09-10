<?php
class Admin extends Controller
{
    public function __construct()
    {
        // echo 'Pages loaded';
    }

    public function index()
    {
        echo 'admin/index';
    }

    public function students_mng()
    {
        $this->view('pages/admin/students_mng');
    }

    public function admin_dash()
    {
        $this->view('pages/admin/adminDash');
    }

}