<?php
class jobModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function checkUserPostBookmark($data)
    {
        $this->db->query("SELECT * FROM bookmarkJobs WHERE studentId = :studentId AND jobID = :jobID");
        $this->db->bind(':studentId', $data['studentId']);
        $this->db->bind(':jobID', $data['jobID']);

        $this->db->single(); 

        return $this->db->rowCount() > 0;
    }

    public function addUserPostBookmark($data)
    {
        $this->db->query("INSERT INTO post_bookmarks (studentId, jobID) VALUES(:studentId, :jobID)");
        $this->db->bind(':studentId', $data['studentId']);
        $this->db->bind(':jobID', $data['jobID']);

        if ($this->db->execute()) {
            return true;
        }
    }

    public function checkUserCompanyBookmark($data)
    {
        $this->db->query("SELECT * FROM post_bookmarks WHERE studentId = :studentId AND companyId = :companyId");
        $this->db->bind(':studentId', $data['studentId']);
        $this->db->bind(':companyId', $data['companyId']);

        $this->db->single(); // Assuming you have a method like this to fetch a single row

        return $this->db->rowCount() > 0;
    }

    public function addUserCompanyBookmark($data)
    {
        $this->db->query("INSERT INTO post_bookmarks (studentId, companyId) VALUES(:studentId, :companyId)");
        $this->db->bind(':studentId', $data['studentId']);
        $this->db->bind(':companyId', $data['companyId']);

        if ($this->db->execute()) {
            return true;
        }
    }

}
?>