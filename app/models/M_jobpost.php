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

    public function getJobsByCompanyId($id){
        $this->db->query('SELECT * FROM v_jobs WHERE CompanyID = :company_id ORDER BY jobs_create_at DESC');
        $this->db->bind(':company_id', $id);       
        return $this->db->resultSet();
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
            (Title, Description, Location, Category, JobBenefits, RequiredQualifications, SalaryRange, SalaryType, CompanyID, PublishDate, Status) 
            VALUES 
            (:job_name, :Description, :job_location, :job_category, :job_benifits, :required_skills, :salary_range, :salary_type, :company_id, :publish_date, :status)
        ');

        // Bind the values from $data array
        $this->db->bind(':job_name', $data['job_name']);
        $this->db->bind(':Description', $data['Description']);
        $this->db->bind(':job_location', $data['job_location']);
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
}
?>