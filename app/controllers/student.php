<?php
class Student extends Controller
{
    public function __construct()
    {
        // echo 'Pages loaded';
    }

    public function index()
    {
        echo 'student/index';
    }

    public function students_mng()
    {
        $this->view('pages/student/students_mng');
    }

    public function make_complain()
    {
        $this->view('pages/student/make_complain');
    }

}
