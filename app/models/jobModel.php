<?php
class jobModel extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function submitComplain() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
        }
        else {
            $data = [
                'company' => '',
                'job_posting' => '',
                'issue' => '',

                'company_err' => '',
                'job_posting_err' => '',
                'issue_err' => ''
            ];
            $this->view('pages/student/make_complain', $data);
        }
    }

    public function getComplains() {
        $this->db->query('SELECT * FROM StudentCompanyComplaints');
        $results = $this->db->resultSet();
        return $results;
    }

}
?>