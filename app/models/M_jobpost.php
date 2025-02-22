<?php

class M_jobpost extends Model {
    // private $db;

    // public function __construct() {
    //     // Assuming Database class uses a singleton pattern with getInstance()
    //     $this->db = Database::getInstance();
    // }

    public function getLatestJobId() {
        $this->db->query('SELECT * FROM jobs ORDER BY create_at DESC LIMIT 1');
        
        $row = $this->db->single();
        
        if($row) {
            return $row->JobID;
        }
        
        return false;
    }

    public function getpostbyid($jobpostId){
        $this->db->query('SELECT * FROM v_jobs WHERE v_jobs.JobID = :id');
        $this->db->bind(':id', $jobpostId);
        $row = $this->db->single();
        return $row;
    }

    public function getpostbycompanyid($companyId){
        $this->db->query('SELECT * FROM v_companies WHERE v_companies.CompanyID = :id');
        $this->db->bind(':id', $companyId);
        $row = $this->db->single();
        return $row;
    }

    public function getJobCountByCompany() {
        $this->db->query('SELECT COUNT(*) as job_count FROM v_jobs WHERE CompanyID = :user_id');
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $row = $this->db->single(); 
        return $row->job_count;
    }

    public function getActiveJobCountByCompany() {
        $this->db->query('SELECT COUNT(*) as job_count FROM v_jobs WHERE CompanyID = :user_id AND Status = :status');
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $this->db->bind(':status', 'Active'); 
        $row = $this->db->single(); 
        return $row->job_count;
    }

    public function getPost(){
        $this->db->query('SELECT * FROM v_jobs WHERE v_jobs.CompanyID = :id');
        $this->db->bind(':id', $_SESSION['user_id']);
        $results = $this->db->resultSet();
        return $results;
    }
    
    public function getPosts(){
        $this->db->query('SELECT * FROM v_jobs');
        $results = $this->db->resultSet();
        return $results;
    }



    public function create($data) {
        $this->db->query('
            INSERT INTO jobs 
            (Title, Description, Location, Category, JobBenefits, RequiredQualifications, SalaryRange, CompanyID, Status) 
            VALUES 
            (:job_name, :Description, :job_location, :job_category, :job_benifits, :required_skills, :salary_range, :company_id, :status)
        ');

        // Bind the values from $data array
        $this->db->bind(':job_name', $data['job_name']);
        $this->db->bind(':Description', $data['Description']);
        $this->db->bind(':job_location', $data['job_location']);
        $this->db->bind(':job_category', $data['job_category']);
        $this->db->bind(':job_benifits', $data['job_benifits']);
        $this->db->bind(':required_skills', $data['required_skills']);
        $this->db->bind(':salary_range', $data['salary_range']);
        $this->db->bind(':company_id', $_SESSION['user_id']);
        $this->db->bind(':status', $data['status']);

        // Execute and return the result
        return $this->db->execute();
        if ($this->db->execute()) {
            return $this->db->lastInsertId(); // Return the last inserted ID
        } else {
            return false;
        }
    }


    public function edit($data) {
        $this->db->query('
            UPDATE jobs 
            SET 
                Title = :job_name, 
                Description = :job_description, 
                Location = :job_location, 
                JobBenefits = :job_benifits, 
                RequiredQualifications = :required_skills, 
                SalaryRange = :salary_range 
            WHERE 
               JobID = :job_id 
        ');
    
        // Bind the values from $data array
        $this->db->bind(':job_name', $data['job_name']);
        $this->db->bind(':job_description', $data['job_description']);
        $this->db->bind(':job_location', $data['job_location']);
        $this->db->bind(':job_benifits', $data['job_benifits']);
        $this->db->bind(':required_skills', $data['required_skills']);
        $this->db->bind(':salary_range', $data['salary_range']);
        $this->db->bind(':job_id', $data['job_id']);
        
        // Execute and return the result
        return $this->db->execute();
    }

    public function deletePost($postId){
        $this->db->query('DELETE FROM jobs WHERE JobID=:id');
        $this->db->bind(':id',$postId );
        

        //execute
        if($this->db->execute()){
            return true;
        }else{               
            return false;
        }
    }

    public function getPartTimeJobs($pageNumber = 1, $rowsPerPage = 12)
    {
        try{
            $conditions = [
                ['Status', '=', 'Active'],
                ['Category', '=', 'Part-time']
            ];

            $jobs = $this->select('v_jobs', $conditions, '*', 'AND', '', '', $rowsPerPage, $pageNumber, true);
            return $jobs;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getInternshipJobs($pageNumber = 1, $rowsPerPage = 12)
    {
        try{
            $conditions = [
                ['Status', '=', 'Active'],
                ['Category', '=', 'Internship']
            ];

            $interns = $this->select('v_jobs', $conditions, '*', 'AND', '', '', $rowsPerPage, $pageNumber, true);
            return $interns;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getJobPostingsByMonth() {
        // Get the current date and calculate the start date for the last 5 months
        $currentDate = date('Y-m-d');
    
        // Query to fetch job postings for the last 5 months
        $this->db->query("
            WITH months AS (
                SELECT DATE_FORMAT(DATE_SUB(:current_date, INTERVAL seq MONTH), '%Y-%m-01') AS month_start
                FROM (
                    SELECT 0 AS seq UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
                ) AS seq_table
            )
            SELECT 
                DATE_FORMAT(months.month_start, '%M') AS month_name,
                COALESCE(SUM(CASE WHEN j.Category = 'Part-time' THEN 1 ELSE 0 END), 0) AS part_time_jobs,
                COALESCE(SUM(CASE WHEN j.Category = 'Internship' THEN 1 ELSE 0 END), 0) AS internships
            FROM months
            LEFT JOIN jobs j 
                ON DATE_FORMAT(j.create_at, '%Y-%m') = DATE_FORMAT(months.month_start, '%Y-%m')
                AND j.CompanyID = :user_id
            GROUP BY months.month_start
            ORDER BY months.month_start DESC;
        ");
    
        // Bind parameters
        $this->db->bind(':current_date', $currentDate);
        $this->db->bind(':user_id', $_SESSION['user_id']);
    
        $result = $this->db->resultSet();

        // Extract month names from the result
        //month names sort by ascending order
        $monthNames = array_column($result, 'month_name');
        $monthNames = array_reverse($monthNames);

        return [
            'month_names' => $monthNames,
            'data' => $result
        ];
    }

    public function getJobCountsLast5Months()
    {
        // Query to get job counts for the last 5 months
        $this->db->query("
            WITH months AS (
                SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL seq MONTH), '%Y-%m-01') AS month_start
                FROM (
                    SELECT 0 AS seq UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
                ) AS seq_table
            )
            SELECT 
                DATE_FORMAT(months.month_start, '%M') AS month_name,
                COALESCE(SUM(CASE WHEN j.Category = 'Part-time' THEN 1 ELSE 0 END), 0) AS job_count
            FROM months
            LEFT JOIN jobs j 
                ON DATE_FORMAT(j.create_at, '%Y-%m') = DATE_FORMAT(months.month_start, '%Y-%m')
                AND j.CompanyID = :user_id
            GROUP BY months.month_start
            ORDER BY months.month_start DESC;
        ");

        // Bind the user ID
        $this->db->bind(':user_id', $_SESSION['user_id']);

        // Fetch and return the result set
        return $this->db->resultSet();
    }

    // Function to get internship counts for the last 5 months
    public function getInternshipCountsLast5Months()
    {
        // Query to get internship counts for the last 5 months
        $this->db->query("
            WITH months AS (
                SELECT DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL seq MONTH), '%Y-%m-01') AS month_start
                FROM (
                    SELECT 0 AS seq UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4
                ) AS seq_table
            )
            SELECT 
                DATE_FORMAT(months.month_start, '%M') AS month_name,
                COALESCE(SUM(CASE WHEN j.Category = 'Internship' THEN 1 ELSE 0 END), 0) AS internship_count
            FROM months
            LEFT JOIN jobs j 
                ON DATE_FORMAT(j.create_at, '%Y-%m') = DATE_FORMAT(months.month_start, '%Y-%m')
                AND j.CompanyID = :user_id
            GROUP BY months.month_start
            ORDER BY months.month_start DESC;
        ");

        // Bind the user ID
        $this->db->bind(':user_id', $_SESSION['user_id']);

        // Fetch and return the result set
        return $this->db->resultSet();
    }
    
}
?>