<?php
class jobModel extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function addUserPostBookmark($jobId)
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
    public function isJobBookmarked($jobId)
    {
        $this->db->query("SELECT COUNT(*) AS count FROM bookmarkJobs WHERE studentId = :studentId AND jobId = :jobId");
        $this->db->bind(':studentId', $_SESSION['user_id']);
        $this->db->bind(':jobId', $jobId);
        $row = $this->db->single();
        return $row->count > 0;
    }

    //Method to get bookmarked jobs
    public function getBookmarkedJobs($studentId)
    {
        // Fetch only the IDs of bookmarked jobs for the user
        $this->db->query("SELECT * FROM v_bookmarkedJobs WHERE studentId = :studentId AND Category = 'Part-time'");
        $this->db->bind(':studentId', $studentId);
        return $this->db->resultSet();
    }

    public function getBookmarkedInternships($studentId)
    {
        // Fetch only the IDs of bookmarked jobs for the user
        $this->db->query("SELECT * FROM v_bookmarkedJobs WHERE studentId = :studentId AND Category = 'Internship'");
        $this->db->bind(':studentId', $studentId);
        return $this->db->resultSet();
    }

    public function getBookmarkedCompanies($studentId)
    {
        // Fetch only the IDs of bookmarked jobs for the user
        $this->db->query("SELECT * FROM v_bookmarkedCompanies WHERE studentId = :studentId");
        $this->db->bind(':studentId', $studentId);
        return $this->db->resultSet();
    }

    //Method to remove a bookmark from the database
    public function removeBookmark($jobId)
    {
        $this->db->query("DELETE FROM bookmarkJobs WHERE studentId = :studentId AND jobId = :jobId");
        $this->db->bind(':studentId', $_SESSION['user_id']);
        $this->db->bind(':jobId', $jobId);
        return $this->db->execute();
    }

    // public function create_complaint($data)
    // {
    //     try {
    //         $this->db->query('INSERT INTO complaint_jobs (studentId, jobID, description) VALUES (:studentId, :jobID, :description)');
    //         $this->db->bind(':studentId', $_SESSION['user_id']);
    //         $this->db->bind(':jobID', $data['posts']->JobID);
    //         $this->db->bind(':description', $data['complaint']);
    //         return $this->db->execute();
    //     } catch (PDOException $e) {
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     }
    // }

    public function getVerifiedJobsByCategory($category, $pageNumber = 1, $rowsPerPage = 10, $sort = "JobID", $order = "ASC", $search = '', $searchBy = 'JobID')
    {
        try {
            $conditions = [
                ['Status', 'IN', ['Active', 'Deactive']],
                ['Category', '=', $category],
                [$searchBy, 'LIKE', $search . '%']
            ];
            $users = $this->select(
                'v_jobs', 
                $conditions, 
                'JobID, CompanyID, Title, CompanyName, Email, jobs_create_at, Status, Category', 
                'AND', 
                '', // GROUP BY
                $sort . ' ' . $order,// ORDER BY
                $rowsPerPage, // LIMIT
                $pageNumber, // page number
                true // fetch all
            );
            return $users;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }


    public function getPendingJobs($pageNumber = 1, $rowsPerPage = 10, $sort = "JobID", $order = "ASC", $search = '', $searchBy = 'JobID')
    {
        try {
            $conditions = [
                ['Status', '=', 'Pending'],
                [$searchBy, 'LIKE', $search . '%']
            ];
            $users = $this->select('v_jobs', $conditions, 'JobID, CompanyID, Title, CompanyName, Email, jobs_create_at, Status, Category', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $users;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getNotApprovedJobs($pageNumber = 1, $rowsPerPage = 10, $sort = "JobID", $order = "ASC", $search = '', $searchBy = 'JobID')
    {
        try {
            $conditions = [
                ['Status', '=', 'Not Approved'],
                [$searchBy, 'LIKE', $search . '%']
            ];
            $users = $this->select('v_jobs', $conditions, 'JobID, CompanyID, Title, CompanyName, Email, jobs_create_at, Status, Category', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $users;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getJobDetails($jobId)
    {
        try {
            $conditions = [
                ['JobID', '=', $jobId]
            ];
            $job = $this->select('v_jobs', $conditions, '*', 'AND', '', '', 0, false);
            return $job;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function approveJob($jobId)
    {
        try {
            $jobData = [
                'Status' => 'Active',
                'VerifiedDate' => date('Y-m-d H:i:s'),
                'VerifiedBy' => $_SESSION['user_id']
            ];
            if ($this->update('Jobs', $jobData, ['JobID' => $jobId])) {
                $this->db->rollBack();
                return true;
            } else {
                return false;
            }

            // $logData = [
            //     'EntityID' => $jobId,
            //     'EntityType' => 'Job',
            //     'Action' => 'Approve',
            //     'ActionBy' => $_SESSION['user_id'],
            //     'ActionDate' => date('Y-m-d H:i:s')
            // ];

            // if (!$this->insert('VerificationLogs', $logData)) {
            //     $this->db->rollBack();
            //     return false;
            // }

            // $this->db->commit();
            // return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function rejectJob($jobId)
    {
        try {
            $jobData = [
                'Status' => 'Not Approved',
                'VerifiedDate' => date('Y-m-d H:i:s'),
                'VerifiedBy' => $_SESSION['user_id']
            ];
            // $this->db->beginTransaction();

            if ($this->update('Jobs', $jobData, ['JobID' => $jobId])) {
                $this->db->rollBack();
                return true;
            } else {
                return false;
            } 

            // $logData = [
            //     'EntityID' => $jobId,
            //     'EntityType' => 'Job',
            //     'Action' => 'Reject',
            //     'ActionBy' => $_SESSION['user_id'],
            //     'ActionDate' => date('Y-m-d H:i:s')
            // ];

            // if (!$this->insert('VerificationLogs', $logData)) {
            //     $this->db->rollBack();
            //     return false;
            // }

            // $this->db->commit();
            // return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function activateJob($jobId)
    {
        try {
            $jobData = [
                'Status' => 'Active'
            ];
            if ($this->update('Jobs', $jobData, ['JobID' => $jobId])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function deactivateJob($jobId)
    {
        try {
            $jobData = [
                'Status' => 'Deactive'
            ];
            if ($this->update('Jobs', $jobData, ['JobID' => $jobId])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getCountPendingJobs()
    {
        try {
            // Get pending jobs
            $pendingJobs = $this->select('Jobs', [['Status', '=', 'Pending']], 'COUNT(JobID) AS PendingJobCount', '', '', '', 0, false);
            return $pendingJobs->PendingJobCount;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return 0;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return 0;
        }
    }

    public function getCountActiveJobs()
    {
        try {
            $activeJobs = $this->select('Jobs', [['Status', '=', 'Active']], 'COUNT(JobID) AS ActiveJobCount', '', '', '', 0, false);
            return $activeJobs->ActiveJobCount;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return 0;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return 0;
        }
    }

    public function getVerifiedJobsByMe($userId, $pageNumber = 1, $rowsPerPage = 10, $sort = "JobID", $order = "ASC", $search = '', $searchBy = 'JobID')
    {
        try {
            // Get users verified by the current user
            $verifiedEntities = $this->select('v_verifiedJobs', [['ActionBy', '=', $userId], [$searchBy, 'LIKE', $search . '%']], '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $verifiedEntities;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return [];
        }
    }

    public function isApplied($jobId)
    {
        try {
            $this->db->query("SELECT 1 FROM applications WHERE user_id = :studentId AND job_id = :jobId LIMIT 1");
            $this->db->bind(':studentId', $_SESSION['user_id']);
            $this->db->bind(':jobId', $jobId);
            
            // Returns true if a row exists, false otherwise
            return $this->db->single() !== false;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

}
