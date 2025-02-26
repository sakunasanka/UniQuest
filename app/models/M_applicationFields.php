<?php
class M_applicationFields extends Model{

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

    public function getApplicationCount() {
        $this->db->query('SELECT Count(*) as application_count FROM v_allapplications WHERE v_allapplications.CompanyID = :user_id');
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $row = $this->db->single();
        return $row->application_count;
    }
    
    public function getApplicationsByGender() {
        try {
            $this->db->query("
                SELECT 
                    CASE 
                        WHEN s.gender = 'Male' THEN 'Male'
                        WHEN s.gender = 'Female' THEN 'Female'
                    END AS gender,
                    COUNT(DISTINCT s.studentID) AS user_count
                FROM applications a
                INNER JOIN student s ON a.user_id = s.studentID
                INNER JOIN Jobs j ON a.job_id = j.jobID
                WHERE j.companyID = :company_id
                GROUP BY 
                    CASE 
                        WHEN s.gender = 'Male' THEN 'Male'
                        WHEN s.gender = 'Female' THEN 'Female'
                    END
                ORDER BY user_count DESC
            ");
    
            $this->db->bind(':company_id', $_SESSION['user_id']);
            
            $results = $this->db->resultSet();
            
            // Ensure all gender categories are represented
            $genderCounts = [
                'Male' => 0,
                'Female' => 0
            ];
    
            foreach ($results as $row) {
                $genderCounts[$row->gender] = (int)$row->user_count;
            }
    
            return $genderCounts;
    
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [
                'Male' => 0,
                'Female' => 0
            ];
        }
    }

    // public function getApplicationsByWeek() {
    //     $this->db->query("SELECT 
    //             WEEK(SubmissionDate) AS week, 
    //             COUNT(*) AS applications
    //         FROM v_allapplications
    //         WHERE CompanyID = :user_id
    //         GROUP BY WEEK(SubmissionDate)");
    //     $this->db->bind(':user_id', $_SESSION['user_id']);    
    //     return $this->db->resultSet();
    // }

    public function getApplicationsByWeek() {
        try {
            // Query to fetch application counts grouped by week, starting from Monday
            $this->db->query("
                WITH weeks AS (
                    SELECT 
                        DATE_SUB(DATE(CURRENT_DATE - INTERVAL WEEKDAY(CURRENT_DATE) DAY), INTERVAL seq WEEK) AS week_start,
                        CONCAT(
                            DATE_FORMAT(DATE_SUB(DATE(CURRENT_DATE - INTERVAL WEEKDAY(CURRENT_DATE) DAY), INTERVAL seq WEEK), '%Y-%m-%d'), 
                            ' to ', 
                            DATE_FORMAT(DATE_ADD(DATE_SUB(DATE(CURRENT_DATE - INTERVAL WEEKDAY(CURRENT_DATE) DAY), INTERVAL seq WEEK), INTERVAL 6 DAY), '%Y-%m-%d')
                        ) AS week_label
                    FROM (
                        SELECT 0 AS seq UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
                    ) AS seq_table
                )
                SELECT 
                    weeks.week_label AS week_label,
                    COALESCE(COUNT(a.id), 0) AS application_count
                FROM weeks
                LEFT JOIN applications a 
                    ON DATE(a.created_at) BETWEEN weeks.week_start AND DATE_ADD(weeks.week_start, INTERVAL 6 DAY)
                    AND a.job_id IN (
                        SELECT j.jobID 
                        FROM jobs j 
                        WHERE j.CompanyID = :user_id
                          AND j.verifiedBy IS NOT NULL
                    )
                GROUP BY weeks.week_start
                ORDER BY weeks.week_start DESC;
            ");
    
            // Bind the user ID
            $this->db->bind(':user_id', $_SESSION['user_id']);
    
            // Fetch and return the result set
            $result = $this->db->resultSet();
    
            // Extract week labels and application counts
            $weekLabels = array_column($result, 'week_label');
            $weekLabels = array_reverse($weekLabels);
            $applicationCounts = array_column($result, 'application_count');
            $applicationCounts = array_reverse($applicationCounts);
    
            return [
                'week_labels' => $weekLabels,
                'application_counts' => $applicationCounts
            ];
    
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [
                'week_labels' => [],
                'application_counts' => []
            ];
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