<?php
class Service_provider extends Controller
{
    public function __construct()
    {
        // echo 'Pages loaded';
    }

    public function index()
    {
        echo 'service_provider/index';
    }

    public function contact_admin()
    {
        $this->view('pages/service_provider/contact_admin');
    }

    public function dashboard()
    {
        $this->view('pages/service_provider/ser_dashboard');
    }

}