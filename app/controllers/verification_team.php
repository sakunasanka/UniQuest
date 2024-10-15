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

    public function jp_registration()
    {
        $this->view('pages/verification_team/jp_registration');
    }
    public function post()
    {
        $this->view('pages/verification_team/post');
    }
    public function checking_details()
    {
        $this->view('pages/verification_team/checking_details');
    }

}