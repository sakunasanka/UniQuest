<?php
class jobModel extends Controller
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create_complain($data) {
        $this-> db->query('INSERT INTO complaint (job_posting, issue) VALUES (:job_posting, :issue)');
        $this->db->bind(':job_posting', $data['job_posting']);
        $this->db->bind(':issue', $data['issue']);

        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

}
?>