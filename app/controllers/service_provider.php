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

    public function edit_profile()
    {
        $this->view('pages/service_provider/edit_profile');
    }
    public function view_profile()
    {
        $this->view('pages/service_provider/view_profile');
    }

}