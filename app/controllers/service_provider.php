<?php
class Service_Provider extends Controller
{
    public function __construct()
    {
        // echo 'Pages loaded';
    }

    public function index()
    {
        echo 'service_provider/index';
    }

    public function login()
    {
        $this->view('pages/service_provider/login');
    }

}