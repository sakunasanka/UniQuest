<?php
    class M_jobpost{
        private  $db;

        public function __construct(){
            $this->db = new Database();
        }
        public function create($data){
            $this->db->query('INSERT INTO jobs (Title, Description, Location, Category, JobBenefits, Address, RequiredQualifications, SalaryRange, CompanyID) VALUES (:job_name, :Description, :job_location, :job_category, :job_benifits, :adress, :required_skills, :salary_range, :company_id)');
            
            $this->db->bind(':job_name', $data['job_name']);
            $this->db->bind(':Description', $data['Description']);
            $this->db->bind(':job_location', $data['job_location']);
            $this->db->bind(':job_category', $data['job_category']);
            $this->db->bind(':job_benifits', $data['job_benifits']);
            $this->db->bind(':adress', $data['adress']);
            $this->db->bind(':required_skills', $data['required_skills']);
            $this->db->bind(':salary_range', $data['salary_range']);
            $this->db->bind(':company_id', $_SESSION['company_id']);
            

            return $this->db->execute();
            //execute
            // if($this->db->execute()){
            //     return true;
            // }else{               
            //     return false;
            // }
        }

    }

?>
