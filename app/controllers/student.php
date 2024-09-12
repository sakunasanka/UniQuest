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

}
