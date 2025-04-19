<?php

class M_jobpost extends Model
{
    // private $db;

    // public function __construct() {
    //     // Assuming Database class uses a singleton pattern with getInstance()
    //     $this->db = Database::getInstance();
    // }

    public function getLatestJobId()
    {
        $this->db->query('SELECT * FROM jobs ORDER BY create_at DESC LIMIT 1');

        $row = $this->db->single();

        if ($row) {
            return $row->JobID;
        }

        return false;
    }

    public function getJobsByCompanyId($id)
    {
        $this->db->query('SELECT * FROM v_jobs WHERE CompanyID = :company_id ORDER BY jobs_create_at DESC');
        $this->db->bind(':company_id', $id);
        return $this->db->resultSet();
    }

    public function getpostbyid($jobpostId)
    {
        $this->db->query('SELECT * FROM v_jobs WHERE v_jobs.JobID = :id');
        $this->db->bind(':id', $jobpostId);
        $row = $this->db->single();
        return $row;
    }

    public function getpostbycompanyid($companyId)
    {
        $this->db->query('SELECT * FROM v_company WHERE v_company.UserID = :id');
        $this->db->bind(':id', $companyId);
        $row = $this->db->single();
        return $row;
    }

    public function getJobCountByCompany()
    {
        $this->db->query('SELECT COUNT(*) as job_count FROM v_jobs WHERE CompanyID = :user_id');
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $row = $this->db->single();
        return $row->job_count;
    }

    public function getActiveJobCountByCompany()
    {
        $this->db->query('SELECT COUNT(*) as job_count FROM v_jobs WHERE CompanyID = :user_id AND Status = :status');
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $this->db->bind(':status', 'Active');
        $row = $this->db->single();
        return $row->job_count;
    }

    // public function getPost(){
    //     $this->db->query('SELECT * FROM v_jobs WHERE v_jobs.CompanyID = :id');
    //     $this->db->bind(':id', $_SESSION['user_id']);
    //     $results = $this->db->resultSet();
    //     return $results;
    // }

    public function getPendingPost($pageNumber = 1, $rowsPerPage = 10, $sort = "JobID", $order = "DESC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['CompanyID', '=', $_SESSION['user_id']],
                ['Status', '=', 'Pending']
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', Title, CompanyName, Email, Industry, DATE_FORMAT(PublishDate, '%Y-%m-%d'), Status, Category, City)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }

            $posts = $this->select('v_jobs', $conditions, '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $posts;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getActivePost($pageNumber = 1, $rowsPerPage = 10, $sort = "JobID", $order = "DESC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['CompanyID', '=', $_SESSION['user_id']],
                ['Status', '=', 'Active']
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', Title, CompanyName, Email, Industry, DATE_FORMAT(PublishDate, '%Y-%m-%d'), Status, Category, City)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }

            $posts = $this->select('v_jobs', $conditions, '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $posts;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getDeactivePost($pageNumber = 1, $rowsPerPage = 10, $sort = "JobID", $order = "DESC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['CompanyID', '=', $_SESSION['user_id']],
                ['Status', '=', 'Deactive']
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', Title, CompanyName, Email, Industry, DATE_FORMAT(PublishDate, '%Y-%m-%d'), Status, Category, City)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }

            $posts = $this->select('v_jobs', $conditions, '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $posts;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getPosts()
    {
        $this->db->query('SELECT * FROM v_jobs');
        $results = $this->db->resultSet();
        return $results;
    }



    public function create($data)
    {
        $this->db->query('
            INSERT INTO jobs 
            (Title, Description, DistrictID, CityID, Category, JobBenefits, RequiredQualifications, SalaryRange, SalaryType, CompanyID, PublishDate, Status) 
            VALUES 
            (:job_name, :Description, :job_district, :job_city, :job_category, :job_benifits, :required_skills, :salary_range, :salary_type, :company_id, :publish_date, :status)
        ');

        // Bind the values from $data array
        $this->db->bind(':job_name', $data['job_name']);
        $this->db->bind(':Description', $data['Description']);
        $this->db->bind(':job_district', $data['job_district']);
        $this->db->bind(':job_city', $data['job_city']);
        $this->db->bind(':job_category', $data['job_category']);
        $this->db->bind(':job_benifits', $data['job_benifits']);
        $this->db->bind(':required_skills', $data['required_skills']);
        $this->db->bind(':salary_range', $data['salary_range']);
        $this->db->bind(':salary_type', $data['salary_type']);
        $this->db->bind(':company_id', $_SESSION['user_id']);
        $this->db->bind(':publish_date', $data['publish_date']);
        $this->db->bind(':status', $data['status']);

        // Execute and return the result
        return $this->db->execute();
        if ($this->db->execute()) {
            return $this->db->lastInsertId(); // Return the last inserted ID
        } else {
            return false;
        }
    }


    public function edit($data)
    {
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
        $this->db->query('UPDATE jobs SET Status="Deleted" WHERE JobID=:id');
        $this->db->bind(':id',$postId );
        

        //execute
        if($this->db->execute()){
            return true;
        }else{               
            return false;
        }
    }

    public function deactivatePost($postId){
        $this->db->query('UPDATE jobs SET Status="Deactive" WHERE JobID=:id');
        $this->db->bind(':id',$postId );

        //execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    protected function buildFilterConditions(array $filters = []): array
    {
        $conditions = [];

        if (empty($filters)) {
            return $conditions;
        }

        // District filter
        if (!empty($filters['district'])) {
            $conditions[] = ['District', '=', $filters['district']];
        }

        // City filter
        if (!empty($filters['city'])) {
            $conditions[] = ['City', '=', $filters['city']];
        }

        // Industry filter
        if (!empty($filters['industry'])) {
            $conditions[] = ['Industry', '=', $filters['industry']];
        }

        // Rating filter
        if (!empty($filters['rating'])) {
            $conditions[] = ['Rating', '>=', $filters['rating']];
        }

        // Salary range filter
        if (!empty($filters['minSalary']) || !empty($filters['maxSalary'])) {
            $salaryField = 'SalaryRange';

            if (!empty($filters['minSalary']) && !empty($filters['maxSalary'])) {
                $conditions[] = [$salaryField, 'BETWEEN', [$filters['minSalary'], $filters['maxSalary']]];
            } elseif (!empty($filters['minSalary'])) {
                $conditions[] = [$salaryField, '>=', $filters['minSalary']];
            } elseif (!empty($filters['maxSalary'])) {
                $conditions[] = [$salaryField, '<=', $filters['maxSalary']];
            }
        }

        // Salary type filter
        if (!empty($filters['salaryType'])) {
            $conditions[] = ['SalaryType', '=', $filters['salaryType']];
        }

        return $conditions;
    }

    public function getPartTimeJobs($pageNumber = 1, $rowsPerPage = 12, $sort = "JobID", $order = "DESC", $search = '', array $filters = [])
    {
        try {
            // Base conditions
            $conditions = [
                ['Status', '=', 'Active'],
                ['Category', '=', 'Part-time']
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', Title, CompanyName, Email, Industry, DATE_FORMAT(PublishDate, '%Y-%m-%d'), SalaryRange, SalaryType, Status, Category, City)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }

            // Add filter conditions
            $filterConditions = $this->buildFilterConditions($filters);
            $conditions = array_merge($conditions, $filterConditions);

            // Get the jobs with applied filters
            $jobs = $this->select('v_jobs', $conditions, '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);

            return $jobs;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getInternshipJobs($pageNumber = 1, $rowsPerPage = 12, $sort = "JobID", $order = "DESC", $search = '', array $filters = [])
    {
        try {
            $conditions = [
                ['Status', '=', 'Active'],
                ['Category', '=', 'Internship']
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', Title, CompanyName, Email, Industry, DATE_FORMAT(PublishDate, '%Y-%m-%d'), SalaryRange, SalaryType, Status, Category, City)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }

            // Add filter conditions
            $filterConditions = $this->buildFilterConditions($filters);
            $conditions = array_merge($conditions, $filterConditions);

            $interns = $this->select('v_jobs', $conditions, '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $interns;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getSaveJobs($studentId, $pageNumber = 1, $rowsPerPage = 12, $sort = "JobID", $order = "DESC", $search = '', $searchBy = 'Title', array $filters = [])
    {
        try {
            // Base conditions
            $conditions = [
                ['Status', '=', 'Active'],
                ['Category', '=', 'Part-time'],
                ['StudentID', '=', $studentId]
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', Title, CompanyName, Email, Status, Category, Location)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }

            // Add filter conditions
            $filterConditions = $this->buildFilterConditions($filters);
            $conditions = array_merge($conditions, $filterConditions);

            // Get the jobs with applied filters
            $jobs = $this->select('v_bookmarkedJobs', $conditions, '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);

            return $jobs;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getSaveInternships($studentId, $pageNumber = 1, $rowsPerPage = 12, $sort = "JobID", $order = "DESC", $search = '', array $filters = [])
    {
        try {
            // Base conditions
            $conditions = [
                ['Status', '=', 'Active'],
                ['Category', '=', 'Internship'],
                ['StudentID', '=', $studentId]
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', Title, CompanyName, Email, Status, Category, Location)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }

            // Add filter conditions
            $filterConditions = $this->buildFilterConditions($filters);
            $conditions = array_merge($conditions, $filterConditions);

            // Get the jobs with applied filters
            $jobs = $this->select('v_bookmarkedJobs', $conditions, '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);

            return $jobs;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getSaveCompanies($studentId, $pageNumber = 1, $rowsPerPage = 12, $sort = "JobID", $order = "DESC", $search = '', $searchBy = 'Title', array $filters = [])
    {
        try {
            // Base conditions
            $conditions = [
                ['Status', '=', 'Active'],
                ['StudentID', '=', $studentId]
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', CompanyName, Industry, City)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }

            // Add filter conditions
            $filterConditions = $this->buildFilterConditions($filters);
            $conditions = array_merge($conditions, $filterConditions);

            // Get the jobs with applied filters
            $jobs = $this->select('v_bookmarkedCompanies', $conditions, '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);

            return $jobs;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getJobPostingsByMonth()
    {
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
                AND j.verifiedBy IS NOT NULL
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
}
