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

    public function getVerifiedJobsByCategory($category, $pageNumber = 1, $rowsPerPage = 10, $sort = "JobID", $order = "ASC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['Status', 'IN', ['Active', 'Deactive', 'Admin-Deactive']],
                ['Category', '=', $category]
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', JobID, CompanyID, Title, CompanyName, Email, DATE_FORMAT(jobs_create_at, '%Y-%m-%d'), Status, Category)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }
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


    public function getPendingJobs($pageNumber = 1, $rowsPerPage = 10, $sort = "JobID", $order = "ASC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['Status', 'IN', ['Pending', 'Edited']]
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', JobID, CompanyID, Title, CompanyName, Email, DATE_FORMAT(jobs_create_at, '%Y-%m-%d'), Status, Category)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }
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

    public function getNotApprovedJobs($pageNumber = 1, $rowsPerPage = 10, $sort = "JobID", $order = "ASC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['Status', '=', 'Not Approved']
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', JobID, CompanyID, Title, CompanyName, Email, DATE_FORMAT(jobs_create_at, '%Y-%m-%d'), Status, Category)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }
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
                'Status' => 'Admin-Deactive'
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

    public function getVerifiedJobsByMe($userId, $pageNumber = 1, $rowsPerPage = 10, $sort = "JobID", $order = "ASC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['ActionBy', '=', $userId]
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', Title, Category, Email, DATE_FORMAT(ActionDate, '%Y-%m-%d'), Status)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }
            // Get users verified by the current user
            $verifiedEntities = $this->select('v_verifiedJobs', $conditions, '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
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

    public function viewcount($jobId){
        try{
            $this->db->query("SELECT COUNT(*) AS viewCount FROM is_viewed_job WHERE jodId = :jobId");
            $this->db->bind(':jobId', $jobId);
            $row = $this->db->single();
            return $row->viewCount;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
    public function addView($jobID, $companyID) {
        try {
            $this->db->query("INSERT  INTO is_viewed_job (CompanyID, UserID, JobID) VALUES (:CompanyID,:userID, :jobID)");
            $this->db->bind(':userID', $_SESSION['user_id'] ?? null);
            $this->db->bind(':jobID', $jobID);
            $this->db->bind(':CompanyID', $companyID);
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }

    }
    public function getApplicants($jobId)
    {
        try {
            $this->db->query("SELECT count(*) FROM applications WHERE job_id = :jobId");
            $this->db->bind(':jobId', $jobId);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function getViewIncreasedPercentage($companyID) {
        try {

            // Get views this month
            $thisMonthViews = $this->db->query("SELECT COUNT(*) AS thisMonthCount
                                FROM is_viewed_job
                                WHERE ViewedAt >= DATE_FORMAT(NOW(), '%Y-%m-01')
                                AND ViewedAt <  DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 MONTH), '%Y-%m-01') AND companyID = :companyID;");
            $this->db->bind(':companyID', $companyID);
            $thisMonthViews = $this->db->single();

            // Get views last month
            $lastMonthViews = $this->db->query("SELECT COUNT(*) AS lastMonthCount
                                FROM is_viewed_job
                                WHERE ViewedAt >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m-01')
                                AND ViewedAt < DATE_FORMAT(NOW(), '%Y-%m-01') AND companyID = :companyID");
            $this->db->bind(':companyID', $companyID);  
            $lastMonthViews = $this->db->single();
                                
            // Get percentage increase  
            $thisMonthCount = $thisMonthViews->thisMonthCount;
            $lastMonthCount = $lastMonthViews->lastMonthCount;
            if ($lastMonthCount == 0) {
                return 100; // Avoid division by zero
            }
            $percentageIncrease = (($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100;
            return round($percentageIncrease, 1);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function getViewDecreasedPercentage($companyID) {
        try {

            // Get views this month
            $thisMonthViews = $this->db->query("SELECT COUNT(*) AS thisMonthCount
                                FROM is_viewed_job
                                WHERE ViewedAt >= DATE_FORMAT(NOW(), '%Y-%m-01')
                                AND ViewedAt <  DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 MONTH), '%Y-%m-01') AND companyID = :companyID;");
            $this->db->bind(':companyID', $companyID);
            $thisMonthViews = $this->db->single();

            // Get views last month
            $lastMonthViews = $this->db->query("SELECT COUNT(*) AS lastMonthCount
                                FROM is_viewed_job
                                WHERE ViewedAt >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m-01')
                                AND ViewedAt < DATE_FORMAT(NOW(), '%Y-%m-01') AND companyID = :companyID;");  
            $this->db->bind(':companyID', $companyID);
            $lastMonthViews = $this->db->single();
                                
            // Get percentage increase  
            $thisMonthCount = $thisMonthViews->thisMonthCount;
            $lastMonthCount = $lastMonthViews->lastMonthCount;
            if ($lastMonthCount == 0) {
                return 100; // Avoid division by zero
            }
            $percentageDecrease = (($lastMonthCount - $thisMonthCount) / $lastMonthCount) * 100;
            return round($percentageDecrease, 1);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getRatingIncreasePercentage($companyID) {
        try {
            // Sum of ratings this month
            $thisMonthRatings = $this->db->query("SELECT SUM(Rating) AS thisMonthSum
                                FROM Review
                                WHERE created_at >= DATE_FORMAT(NOW(), '%Y-%m-01')
                                AND created_at < DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 MONTH), '%Y-%m-01') AND $companyID = :companyID;");
            $this->db->bind(':companyID', $companyID);
            $thisMonthRatings = $this->db->single();
    
            // Sum of ratings last month
            $lastMonthRatings = $this->db->query("SELECT SUM(Rating) AS lastMonthSum
                                FROM Review
                                WHERE created_at >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m-01')
                                AND created_at < DATE_FORMAT(NOW(), '%Y-%m-01') AND companyID = :companyID;");
            $this->db->bind(':companyID', $companyID);
            $lastMonthRatings = $this->db->single();
    
            $thisMonthSum = $thisMonthRatings->thisMonthSum ?? 0;
            $lastMonthSum = $lastMonthRatings->lastMonthSum ?? 0;
    
            // Avoid division by zero
            if ($lastMonthSum == 0) {
                return 100;
            }
    
            // Calculate percentage increase in sum of ratings
            $percentageIncrease = (($thisMonthSum - $lastMonthSum) / $lastMonthSum) * 100;
            return round($percentageIncrease, 1);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function getRatingDecreasePercentage($companyID) {
        try {
            // Sum of ratings this month
            $thisMonthRatings = $this->db->query("SELECT SUM(Rating) AS thisMonthSum
                                FROM Review
                                WHERE created_at >= DATE_FORMAT(NOW(), '%Y-%m-01')
                                AND created_at < DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 MONTH), '%Y-%m-01') AND $companyID = :companyID;");
            $this->db->bind(':companyID', $companyID);
            $thisMonthRatings = $this->db->single();
    
            // Sum of ratings last month
            $lastMonthRatings = $this->db->query("SELECT SUM(Rating) AS lastMonthSum
                                FROM Review
                                WHERE created_at >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m-01')
                                AND created_at < DATE_FORMAT(NOW(), '%Y-%m-01') AND companyID = :companyID;");
            $this->db->bind(':companyID', $companyID);
            $lastMonthRatings = $this->db->single();
    
            $thisMonthSum = $thisMonthRatings->thisMonthSum ?? 0;
            $lastMonthSum = $lastMonthRatings->lastMonthSum ?? 0;
    
            // Avoid division by zero
            if ($lastMonthSum == 0) {
                return 100;
            }
    
            // Calculate percentage increase in sum of ratings
            $percentageIncrease = (($lastMonthSum - $thisMonthSum) / $lastMonthSum) * 100;
            return round($percentageIncrease, 1);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function getReviewIncreasePercentage($companyID) {
        try {
            // Get review count for this month
            $thisMonthQuery = $this->db->query("SELECT COUNT(*) AS thisMonthCount
                FROM Review
                WHERE created_at >= DATE_FORMAT(NOW(), '%Y-%m-01')
                AND created_at < DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 MONTH), '%Y-%m-01') AND companyID = :companyID;");
            $this->db->bind(':companyID', $companyID);
            $thisMonthResult = $this->db->single();
            $thisMonthCount = $thisMonthResult->thisMonthCount;
    
            // Get review count for last month
            $lastMonthQuery = $this->db->query("SELECT COUNT(*) AS lastMonthCount
                FROM Review
                WHERE created_at >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m-01')
                AND created_at < DATE_FORMAT(NOW(), '%Y-%m-01') AND companyID = :companyID;");
            $this->db->bind(':companyID', $companyID);
            $lastMonthResult = $this->db->single();
            $lastMonthCount = $lastMonthResult->lastMonthCount;
    
            // Calculate percentage increase
            if ($lastMonthCount == 0) {
                return 100; // Avoid division by zero
            }
    
            $percentageIncrease = (($thisMonthCount - $lastMonthCount) / $lastMonthCount) * 100;
            return round($percentageIncrease, 1);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function getReviewDecreasePercentage($companyID) {
        try {
            // Get review count for this month
            $thisMonthQuery = $this->db->query("SELECT COUNT(*) AS thisMonthCount
                FROM Review
                WHERE created_at >= DATE_FORMAT(NOW(), '%Y-%m-01')
                AND created_at < DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 1 MONTH), '%Y-%m-01') AND companyID = :companyID;");
            $this->db->bind(':companyID', $companyID);
            $thisMonthResult = $this->db->single();
            $thisMonthCount = $thisMonthResult->thisMonthCount;
    
            // Get review count for last month
            $lastMonthQuery = $this->db->query("SELECT COUNT(*) AS lastMonthCount
                FROM Review
                WHERE created_at >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 MONTH), '%Y-%m-01')
                AND created_at < DATE_FORMAT(NOW(), '%Y-%m-01') AND companyID = :companyID;");
            $this->db->bind(':companyID', $companyID);
            $lastMonthResult = $this->db->single();
            $lastMonthCount = $lastMonthResult->lastMonthCount;
    
            // Calculate percentage increase
            if ($lastMonthCount == 0) {
                return 100; // Avoid division by zero
            }
    
            $percentageIncrease = (($lastMonthCount - $thisMonthCount) / $lastMonthCount) * 100;
            return round($percentageIncrease, 1);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
    
}