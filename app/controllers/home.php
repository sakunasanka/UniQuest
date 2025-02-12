<?php
class Home extends Controller
{
    public function __construct()
    {
        // echo 'Pages loaded';
    }

    public function index()
    {
        $this->view('pages/home/homepage');
    }

    public function unauth()
    {
        $this->view('pages/403_forbidden/403_forbidden');
    }
}