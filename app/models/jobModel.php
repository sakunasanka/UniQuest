<?php
class jobModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function addUserPostBookmark($userId, $jobId)
{
    try {

        // Prepare the query to insert the bookmark into the database
        $this->db->query("INSERT IGNORE INTO BookmarkJobs (studentId, jobId) VALUES(:studentId, :jobId)");

        // Bind the parameters to the query
        $this->db->bind(':studentId', $_SESSION['user_id']);
        $this->db->bind(':jobId', $jobId);
        // Execute the query and check if the bookmark was successfully added
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // Catch any database errors and log them
        error_log("Database Error: " . $e->getMessage());
        return false;
    } catch (Exception $e) {
        // Catch any general errors and log them
        error_log("Error: " . $e->getMessage());
        return false;
    }
}

    // Method to check if a job is bookmarked by the user
    public function isJobBookmarked($studentId, $jobId) {
        $this->db->query("SELECT COUNT(*) AS count FROM bookmarkJobs WHERE studentId = :studentId AND jobId = :jobId");
        $this->db->bind(':studentId', $_SESSION['user_id']);
        $this->db->bind(':jobId', $jobId);
        $row = $this->db->single();
        return $row->count > 0;
    }

    //Method to get bookmarked jobs
    public function getBookmarkedJobs($studentId) {
        // Fetch only the IDs of bookmarked jobs for the user
        $this->db->query("SELECT * FROM v_bookmarkedJobs WHERE studentId = :studentId");
        $this->db->bind(':studentId', $studentId);
        return $this->db->resultSet();
    }

    //Method to remove a bookmark from the database
    public function removeBookmark($studentId, $jobId) {
        $this->db->query("DELETE FROM bookmarkJobs WHERE studentId = :studentId AND jobId = :jobId");
        $this->db->bind(':studentId', $_SESSION['user_id']);
        $this->db->bind(':jobId', $jobId);
        return $this->db->execute();
    }

    public function getComplains() {
        $this->db->query('SELECT * FROM StudentCompanyComplaints');
        $results = $this->db->resultSet();
        return $results;
    }

    public function create_complaint($data) {
        try {
            $this->db->query('INSERT INTO complaint_jobs (studentId, jobID, description) VALUES (:studentId, :jobID, :description)');
            $this->db->bind(':studentId', $_SESSION['user_id']);
            $this->db->bind(':jobID', $data['posts']->JobID);
            $this->db->bind(':description', $data['complaint']);
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
}    
?>