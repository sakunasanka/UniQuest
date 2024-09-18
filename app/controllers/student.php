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

    public function contact_sp()
    {
        $this->view('pages/student/contact_sp');
    }

    public function contact_admin()
    {
        $this->view('pages/student/contact_admin');
    }
    
     public function students_mng()
    {
        $this->view('pages/student/students_mng');
    }

    public function searchJob()
    {
        $this->view('pages/student/searchJob');
    }

    public function searchCompany()
    {
        $this->view('pages/student/searchCompany');
    }

    public function noMatch()
    {
        $this->view('pages/student/noMatch');
    }
}

