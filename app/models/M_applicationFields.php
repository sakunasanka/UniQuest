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

// Model: M_jobApplication.php


public function createApplication($fields, $jobId, $userId) {
    try {
        $this->db->beginTransaction();
        
        // Debug logging
        error_log("Creating application for JobID: $jobId, UserID: $userId");
        error_log("Fields: " . print_r($fields, true));
        
        // Check if user has already applied
        $this->db->query('SELECT id FROM applications WHERE job_id = :job_id AND user_id = :user_id');
        $this->db->bind(':job_id', $jobId);
        $this->db->bind(':user_id', $userId);
        
        if ($this->db->single()) {
            throw new Exception('You have already applied for this job');
        }
        
        // Define all possible fields
        $possibleFields = [
            'fullname', 'photo', 'email', 'contact', 'address', 'nic', 'nic_copy',
            'gender', 'dob', 'qualifications', 'experience', 'skills', 'cv', 'linkedin'
        ];
        
        // Build SQL query dynamically based on provided fields
        $sqlFields = ['job_id', 'user_id', 'status'];
        $sqlValues = [':job_id', ':user_id', '"Pending"'];
        $params = [
            ':job_id' => $jobId,
            ':user_id' => $userId
        ];
        
        // Add fields that exist in the input
        foreach ($possibleFields as $field) {
            $sqlFields[] = $field;
            $sqlValues[] = ':' . $field;
            $params[':' . $field] = isset($fields[$field]) && $fields[$field] !== '' ? $fields[$field] : null;
        }
        
        // Create the SQL query
        $fieldsStr = implode(', ', $sqlFields);
        $valuesStr = implode(', ', $sqlValues);
        $sql = "INSERT INTO applications ($fieldsStr) VALUES ($valuesStr)";
        
        // Prepare and execute query
        $this->db->query($sql);
        
        // Log parameters for debugging
        error_log("SQL Query: $sql");
        error_log("Parameters: " . print_r($params, true));
        
        // Bind all parameters
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }
        
        $result = $this->db->execute();
        error_log("Insert result: " . ($result ? 'true' : 'false'));
        
        if (!$result) {
            // Log the exact SQL error if available
            $errorInfo = $this->db->errorInfo();
            error_log("SQL Error: " . print_r($errorInfo, true));
            throw new Exception('Failed to save application: ' . ($errorInfo[2] ?? 'Unknown error'));
        }
        
        $this->db->commit();
        error_log("Application created successfully");
        return true;
        
    } catch (Exception $e) {
        $this->db->rollBack();
        error_log("Application Error: " . $e->getMessage());
        return [
            'status' => false,
            'message' => $e->getMessage()
        ];
    }
}
// Add this to your model to debug the database structure
// First, let's verify the view structure
public function debugViewStructure() {
    $this->db->query("DESCRIBE v_allapplications");
    $columns = $this->db->resultSet();
    echo "View columns:<br>";
    print_r($columns);
    
    // Check if there's any data in the view at all
    $this->db->query("SELECT COUNT(*) as total FROM v_allapplications");
    $total = $this->db->single();
    echo "<br>Total records in view: " . $total->total;
    
    // Check a sample record
    $this->db->query("SELECT * FROM v_allapplications LIMIT 1");
    $sample = $this->db->single();
    echo "<br>Sample record:<br>";
    print_r($sample);
}

// Model: M_applicationFields.php
public function getAllApplications($userId) {
    // Using the exact field name from your view structure
    $query = "SELECT * FROM v_allapplications WHERE StudentID = :user_id";
    
    try {
        $this->db->query($query);
        $this->db->bind(':user_id', $userId);
        
        // Debug information
      
        $results = $this->db->resultSet();
        
        // Add error checking
        if ($this->db->rowCount() > 0) {
            return $results;
        } else {
            // Debug: Check if the user exists
            $this->db->query("SELECT StudentName FROM v_allapplications WHERE StudentID = :user_id LIMIT 1");
            $this->db->bind(':user_id', $userId);
            $user = $this->db->single();
            
            if ($user) {
                echo "User exists but no applications found";
            } else {
                echo "No user found with ID: " . $userId;
            }
            return [];
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        return [];
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
}
?>