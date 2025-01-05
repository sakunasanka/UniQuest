<?php

class M_applicationFields{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }


    // public function saveFields($jobId,$fields){

        
    //     $standardFields=['fullname','photo','email','contact','address','nic','nic_Copy','gender','dob','qualications','experience','skills','cv','linkedin'];
        
    //     foreach($standardFields as $field){
    //         if(isset($_POST['app_'.$field])){
    //            $this->addField($jobId,$field,'standard');
    //         }
    //     }

    //     //handle custom fields
    //     for($i=1;$i<=3;$i++){
    //         if(isset($_POST['app_other'.$i]) && !empty($_POST['app_other'.$i .'_name']))
    //         {
    //             $this->addField($jobId,$_POST['app_other'.$i.'_name'],'custom');
    //         }

    //     }
    // }
    public function saveFields($jobId, $fields) {
        print_r($fields);
        print_r($jobId);
        $standardFields = ['fullname','photo','email','contact','address','nic','nic_Copy','gender','dob','qualications','experience','skills','cv','linkedin'];
        
        foreach($standardFields as $field) {
            if(isset($fields['app_'.$field])) {
               
                $this->addField($jobId, $field, 'standard');
            }
        }
    
        for($i=1; $i<=3; $i++) {
            if(isset($fields['app_other'.$i]) && !empty($fields['app_other'.$i.'_name'])) {
                $this->addField($jobId, $fields['app_other'.$i.'_name'], 'custom');
            }
        }
    }
    

    // public function addField($jobId,$fieldName,$type){
    //     print_r('111111111111111111111111111111');
    //     print_r($fieldName);
    //     $this->db->query('INSERT INTO application_form_fields(job_id,field_name,field_type) 
    //                     VALUES(:job_id,:field_name,:field_type)');
    //     $this->db->bind(':job_id',$jobId);
    //     $this->db->bind(':field_name',$fieldName);
    //     $this->db->bind(':field_type',$type);
    //      $this->db->execute();
    //      if ($this->db->execute()) {
    //         print_r("Data successfully inserted.");
    //     } else {
    //         print_r("Error occurred while inserting data.");
    //     }
    

    // }


    private function addField($jobId, $fieldName, $type) {
        try {
            print_r("Debug: Inserting field: jobId = $jobId, fieldName = $fieldName, fieldType = $type");
            $this->db->query('INSERT INTO application_form_fields (job_id, field_name, field_type) 
                              VALUES (:job_id, :field_name, :field_type)');
            $this->db->bind(':job_id', $jobId);
            $this->db->bind(':field_name', $fieldName);
            $this->db->bind(':field_type', $type);
            if ($this->db->execute()) {
                print_r("Success: Field inserted for jobId = $jobId");
            } else {
                print_r("Error: Failed to insert field for jobId = $jobId");
            }
        } catch (PDOException $e) {
            print_r("Database Error: " . $e->getMessage());
        }
    }
    

    public function getFieldsByJobId($jobId) {
        $this->db->query('SELECT * FROM application_form_fields WHERE job_id = :job_id');
        $this->db->bind(':job_id', $jobId);
        return $this->db->resultSet();
    }

}

?>