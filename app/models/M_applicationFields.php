<?php
class M_applicationFields {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function saveFields($jobId, $fields) {
        try {
            // Start a transaction
            $this->db->beginTransaction();

            // Initialize all fields as false
            $fieldValues = [
                'job_id' => $jobId,
                'fullname' => false,
                'photo' => false,
                'email' => false,
                'contact' => false,
                'address' => false,
                'nic' => false,
                'nic_copy' => false,
                'gender' => false,
                'dob' => false,
                'qualifications' => false,
                'experience' => false,
                'skills' => false,
                'cv' => false,
                'linkedin' => false,
                'other1' => false,
                'other2' => false,
                'other3' => false
            ];

            // Set true for selected standard fields
            $standardFields = [
                'fullname', 'photo', 'email', 'contact', 'address', 
                'nic', 'nic_copy', 'gender', 'dob', 'qualifications', 
                'experience', 'skills', 'cv', 'linkedin'
            ];

            foreach ($standardFields as $field) {
                if (isset($fields['app_' . strtolower($field)])) {
                    $fieldValues[strtolower($field)] = true;
                }
            }

            // Handle custom fields (other1, other2, other3)
            for ($i = 1; $i <= 3; $i++) {
                if (isset($fields['app_other' . $i]) && !empty($fields['app_other' . $i . '_name'])) {
                    $fieldValues['other' . $i] = $fields['app_other' . $i . '_name'];
                    // Store the custom field name in a separate table if needed
                    // $this->saveCustomFieldName($jobId, $i, $fields['app_other' . $i . '_name']);
                }
            }

            // Insert into application_fields table
            $sql = "INSERT INTO application_fields (
                job_id, fullname, photo, email, contact, address, 
                nic, nic_copy, gender, dob, qualifications, 
                experience, skills, cv, linkedin, 
                other1, other2, other3
            ) VALUES (
                :job_id, :fullname, :photo, :email, :contact, :address,
                :nic, :nic_copy, :gender, :dob, :qualifications,
                :experience, :skills, :cv, :linkedin,
                :other1, :other2, :other3
            )";

            $this->db->query($sql);

            // Bind all parameters
            foreach ($fieldValues as $field => $value) {
                $this->db->bind(':' . $field, $value);
            }

            // Execute the query
            if ($this->db->execute()) {
                $this->db->commit();
                return true;
            } else {
                $this->db->rollBack();
                return false;
            }

        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    private function saveCustomFieldName($jobId, $fieldNumber, $fieldName) {
        try {
            $sql = "INSERT INTO custom_field_names (job_id, field_number, field_name) 
                   VALUES (:job_id, :field_number, :field_name)";
            
            $this->db->query($sql);
            $this->db->bind(':job_id', $jobId);
            $this->db->bind(':field_number', $fieldNumber);
            $this->db->bind(':field_name', $fieldName);
            
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function getFieldsByJobId($jobId) {
        $this->db->query('SELECT * FROM application_fields WHERE job_id = :job_id');
        $this->db->bind(':job_id', $jobId);
        
        $fields = $this->db->single();
        
        // Get custom field names if they exist
        if ($fields) {
            $this->db->query('SELECT * FROM custom_field_names WHERE job_id = :job_id');
            $this->db->bind(':job_id', $jobId);
            $customFields = $this->db->resultSet();
            
            $fields->custom_fields = $customFields;
        }
        
        return $fields;
    }
}
?>