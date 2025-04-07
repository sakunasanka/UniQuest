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
                'other3' => false,
                'other1_type' => null,
                'other2_type' => null,
                'other3_type' => null
            ];

            // Initialize all required fields as false
            $requiredValues = [
                'job_id' => $jobId,
                'fullname_req' => false,
                'photo_req' => false,
                'email_req' => false,
                'contact_req' => false,
                'address_req' => false,
                'nic_req' => false,
                'nic_copy_req' => false,
                'gender_req' => false,
                'dob_req' => false,
                'qualifications_req' => false,
                'experience_req' => false,
                'skills_req' => false,
                'cv_req' => false,
                'linkedin_req' => false,
                'other1_req' => false,
                'other2_req' => false,
                'other3_req' => false
            ];

            // Set true for selected standard fields
            $standardFields = [
                'fullname', 'photo', 'email', 'contact', 'address', 
                'nic', 'nic_copy', 'gender', 'dob', 'qualifications', 
                'experience', 'skills', 'cv', 'linkedin'
            ];

            foreach ($standardFields as $field) {
                $fieldKey = 'app_' . $field;
                $reqKey = 'app_' . $field . '_req';
                
                if (isset($fields[$fieldKey])) {
                    $fieldValues[strtolower($field)] = true;
                    
                    if (isset($fields[$reqKey]) && $fields[$reqKey] === 'yes') {
                        $requiredValues[strtolower($field) . '_req'] = true;
                    }
                }
            }

            // Handle custom fields (other1, other2, other3)
            for ($i = 1; $i <= 3; $i++) {
                $fieldKey = 'app_other' . $i;
                $reqKey = 'app_other' . $i . '_req';
                $typeKey = 'app_other' . $i . '_type';
                
                if (isset($fields[$fieldKey]) && !empty($fields[$fieldKey . '_name'])) {
                    $fieldValues['other' . $i] = $fields[$fieldKey . '_name'];
                    
                    // Save the custom field type
                    if (isset($fields[$typeKey])) {
                        $fieldValues['other' . $i . '_type'] = $fields[$typeKey];
                    }
                    
                    if (isset($fields[$reqKey]) && $fields[$reqKey] === 'yes') {
                        $requiredValues['other' . $i . '_req'] = true;
                    }
                }
            }

            // Insert into application_fields table (now with type columns)
            $sql = "INSERT INTO application_fields (
                job_id, fullname, photo, email, contact, address, 
                nic, nic_copy, gender, dob, qualifications, 
                experience, skills, cv, linkedin, 
                other1, other2, other3,
                other1_type, other2_type, other3_type
            ) VALUES (
                :job_id, :fullname, :photo, :email, :contact, :address,
                :nic, :nic_copy, :gender, :dob, :qualifications,
                :experience, :skills, :cv, :linkedin,
                :other1, :other2, :other3,
                :other1_type, :other2_type, :other3_type
            )";

            $this->db->query($sql);
            foreach ($fieldValues as $field => $value) {
                $this->db->bind(':' . $field, $value);
            }

            // Bind custom field types if they exist
            if (isset($fields['app_other1_type'])) {
                $this->db->bind(':other1_type', $fields['app_other1_type']);
            }
            if (isset($fields['app_other2_type'])) {
                $this->db->bind(':other2_type', $fields['app_other2_type']);
            }
            if (isset($fields['app_other3_type'])) {
                $this->db->bind(':other3_type', $fields['app_other3_type']);
            }
            
            $this->db->execute();

            // Insert into application_fields_req table
            $sqlReq = "INSERT INTO application_fields_req (
                job_id, fullname_req, photo_req, email_req, contact_req, address_req, 
                nic_req, nic_copy_req, gender_req, dob_req, qualifications_req, 
                experience_req, skills_req, cv_req, linkedin_req, 
                other1_req, other2_req, other3_req
            ) VALUES (
                :job_id, :fullname_req, :photo_req, :email_req, :contact_req, :address_req,
                :nic_req, :nic_copy_req, :gender_req, :dob_req, :qualifications_req,
                :experience_req, :skills_req, :cv_req, :linkedin_req,
                :other1_req, :other2_req, :other3_req
            )";

            $this->db->query($sqlReq);
            foreach ($requiredValues as $field => $value) {
                $this->db->bind(':' . $field, $value);
            }

            $this->db->execute();

            $this->db->commit();
            return true;

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