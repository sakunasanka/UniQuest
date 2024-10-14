<?php
class verification_team extends Controller
{
    public function __construct()
    {
        // echo 'Pages loaded';
    }

    public function index()
    {
        echo 'verification_team/index';
    }


    public function stu_registration()
    {
        $this->view('pages/verification_team/stu_registration');
    }

   

}