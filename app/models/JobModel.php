<?php
class jobModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // public function checkUserPostBookmark($data)
    // {
    //     $this->db->query("SELECT * FROM bookmarkJobs WHERE studentId = :studentId AND jobID = :jobID");
    //     $this->db->bind(':studentId', $data['studentId']);
    //     $this->db->bind(':jobID', $data['jobID']);

    //     $this->db->single(); 

    //     return $this->db->rowCount() > 0;
    // }

    public function addUserPostBookmark($userId, $jobId)
    {
        try {
            // Prepare the query to insert the bookmark into the database
            $this->db->query("INSERT INTO BookmarkJobs (studentId, jobId) VALUES(:studentId, :jobId)");
            
            // Bind the parameters to the query
            $this->db->bind(':studentId', $userId);
            $this->db->bind(':jobId', $jobId);

            // Execute the query and check if the bookmark was successfully added
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Catch any database errors and print them
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // public function checkUserCompanyBookmark($data)
    // {
    //     $this->db->query("SELECT * FROM post_bookmarks WHERE studentId = :studentId AND companyId = :companyId");
    //     $this->db->bind(':studentId', $data['studentId']);
    //     $this->db->bind(':companyId', $data['companyId']);

    //     $this->db->single(); // Assuming you have a method like this to fetch a single row

    //     return $this->db->rowCount() > 0;
    // }

    // public function addUserCompanyBookmark($data)
    // {
    //     $this->db->query("INSERT INTO post_bookmarks (studentId, companyId) VALUES(:studentId, :companyId)");
    //     $this->db->bind(':studentId', $data['studentId']);
    //     $this->db->bind(':companyId', $data['companyId']);

    //     if ($this->db->execute()) {
    //         return true;
    //     }
    // }

}
?>