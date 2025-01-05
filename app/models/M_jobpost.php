<?php

class M_jobpost {
    private $db;

    public function __construct() {
        // Assuming Database class uses a singleton pattern with getInstance()
        $this->db = Database::getInstance();
    }

    public function getpostbyid($jobpostId){
        $this->db->query('SELECT * FROM v_jobs WHERE v_jobs.JobID = :id');
        $this->db->bind(':id', $jobpostId);
        $row = $this->db->single();
        return $row;
    }

    public function getpostbycompanyid($jobpostId){
        $this->db->query('SELECT * FROM v_jobs WHERE v_jobs.CompanyID = :id');
        $this->db->bind(':id', $jobpostId);
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
            // Return the last inserted JobID
            return $this->db->lastInsertId();
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

    public function delete($postId){
        $this->db->query('DELETE FROM jobs WHERE JobID=:id');
        $this->db->bind(':id',$postId );
        

        //execute
        if($this->db->execute()){
            return true;
        }else{               
            return false;
        }
    }
    

}
?>