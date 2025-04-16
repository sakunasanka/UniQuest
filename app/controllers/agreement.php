<?php
class Agreement extends Controller
{
    public function __construct()
    {
        // echo 'Pages loaded';
    }

    public function index()
    {
        $this->view('pages/userAgreement/userAgreement');
    }
}