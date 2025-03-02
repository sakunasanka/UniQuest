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

    // private function saveCustomFieldName($jobId, $fieldNumber, $fieldName) {
    //     try {
    //         $sql = "INSERT INTO custom_field_names (job_id, field_number, field_name) 
    //                VALUES (:job_id, :field_number, :field_name)";
            
    //         $this->db->query($sql);
    //         $this->db->bind(':job_id', $jobId);
    //         $this->db->bind(':field_number', $fieldNumber);
    //         $this->db->bind(':field_name', $fieldName);
            
    //         return $this->db->execute();
    //     } catch (PDOException $e) {
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     }
    // }
    public function getFieldsByJobId($jobId) {
        try {
            $this->db->query('SELECT * FROM application_fields WHERE job_id = :job_id');
            $this->db->bind(':job_id', $jobId);
            
            $fields = $this->db->single();
            
            // Convert database results into a structured array for easier form generation
            if ($fields) {
                $formFields = [];
                
                // Standard fields mapping
                $fieldMapping = [
                    'fullname' => ['type' => 'text', 'label' => 'Full Name'],
                    'photo' => ['type' => 'file', 'label' => 'Photo', 'accept' => 'image/*'],
                    'email' => ['type' => 'email', 'label' => 'Email Address'],
                    'contact' => ['type' => 'text', 'label' => 'Contact Number'],
                    'address' => ['type' => 'text', 'label' => 'Address'],
                    'nic' => ['type' => 'text', 'label' => 'NIC Number'],
                    'nic_copy' => ['type' => 'file', 'label' => 'NIC Copy', 'accept' => '.pdf,.jpg,.jpeg,.png'],
                    'gender' => ['type' => 'select', 'label' => 'Gender', 'options' => ['Male', 'Female', 'Other']],
                    'dob' => ['type' => 'date', 'label' => 'Date of Birth'],
                    'qualifications' => ['type' => 'textarea', 'label' => 'Educational Qualifications'],
                    'experience' => ['type' => 'textarea', 'label' => 'Work Experience'],
                    'skills' => ['type' => 'textarea', 'label' => 'Skills'],
                    'cv' => ['type' => 'file', 'label' => 'CV/Resume', 'accept' => '.pdf,.doc,.docx'],
                    'linkedin' => ['type' => 'url', 'label' => 'LinkedIn Profile']
                ];

                // Add only the fields that are set to true
                foreach ($fieldMapping as $field => $config) {
                    if ($fields->$field === true || $fields->$field === 1) {
                        $formFields[$field] = $config;
                    }
                }

                // Add custom fields if they exist
                for ($i = 1; $i <= 3; $i++) {
                    $otherField = 'other' . $i;
                    if (!empty($fields->$otherField)) {
                        $formFields[$otherField] = [
                            'type' => 'text',
                            'label' => $fields->$otherField
                        ];
                    }
                }

                return $formFields;
            }
            
            return null;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
}
    // public function getFieldsByJobId($jobId) {
    //     $this->db->query('SELECT * FROM application_fields WHERE job_id = :job_id');
    //     $this->db->bind(':job_id', $jobId);
        
    //     $fields = $this->db->single();
        
    //     // Get custom field names if they exist
    //     if ($fields) {
    //         $this->db->query('SELECT * FROM custom_field_names WHERE job_id = :job_id');
    //         $this->db->bind(':job_id', $jobId);
    //         $customFields = $this->db->resultSet();
            
    //         $fields->custom_fields = $customFields;
    //     }
        
    //     return $fields;
    // }

?>