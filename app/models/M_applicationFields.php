<?php
class M_applicationFields extends Model
{

    public function saveFields($jobId, $fields)
    {
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
                'fullname',
                'photo',
                'email',
                'contact',
                'address',
                'nic',
                'nic_copy',
                'gender',
                'dob',
                'qualifications',
                'experience',
                'skills',
                'cv',
                'linkedin'
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


    public function getFieldsByJobId($jobId)
    {
        try {
            // Get the fields configuration
            $this->db->query('SELECT * FROM application_fields WHERE job_id = :job_id');
            $this->db->bind(':job_id', $jobId);
            $fields = $this->db->single();

            // Get required fields configuration
            $this->db->query('SELECT * FROM application_fields_req WHERE job_id = :job_id');
            $this->db->bind(':job_id', $jobId);
            $requiredFields = $this->db->single();

            // Convert database results into a structured array
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
                        // Add required flag if the field is required
                        $reqField = $field . '_req';
                        if ($requiredFields && ($requiredFields->$reqField === true || $requiredFields->$reqField === 1)) {
                            $config['required'] = true;
                        }
                        $formFields[$field] = $config;
                    }
                }

                // Add custom fields if they exist
                for ($i = 1; $i <= 3; $i++) {
                    $otherField = 'other' . $i;
                    if (!empty($fields->$otherField)) {
                        $config = [
                            'type' => $fields->{'other' . $i . '_type'} ?? 'text',
                            'label' => $fields->$otherField,
                            'accept' => $fields->{'other' . $i . '_type'} === 'file' ? '.pdf,.jpg,.jpeg,.png' : null
                        ];
                        // Add required flag if the custom field is required
                        $reqField = 'other' . $i . '_req';
                        if ($requiredFields && ($requiredFields->$reqField === true || $requiredFields->$reqField === 1)) {
                            $config['required'] = true;
                        }
                        $formFields[$otherField] = $config;
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

    public function getApplicationCount()
    {
        $this->db->query('SELECT Count(*) as application_count FROM v_allapplications WHERE v_allapplications.CompanyID = :user_id');
        $this->db->bind(':user_id', $_SESSION['user_id']);
        $row = $this->db->single();
        return $row->application_count;
    }

    public function getApplicationsByGender()
    {
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

    public function getApplicationsByWeek()
    {
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

    public function getTopPerformingJobs($limit = 4)
    {
        try {
            $this->db->query("
                SELECT 
                    j.title AS job_title,
                    COUNT(a.id) AS application_count
                FROM jobs j
                LEFT JOIN applications a ON j.jobID = a.job_id
                WHERE j.CompanyID = :company_id
                GROUP BY j.jobID, j.title
                ORDER BY application_count DESC
                LIMIT :limit
            ");

            $this->db->bind(':company_id', $_SESSION['user_id']);
            $this->db->bind(':limit', $limit, PDO::PARAM_INT);

            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }

    public function createApplication($fields, $jobId, $userId)
    {
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
                'fullname',
                'photo',
                'email',
                'contact',
                'address',
                'nic',
                'nic_copy',
                'gender',
                'dob',
                'qualifications',
                'experience',
                'skills',
                'cv',
                'linkedin',
                'other1',
                'other2',
                'other3'
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
                // // Log the exact SQL error if available
                // $errorInfo = $this->db->errorInfo();
                // error_log("SQL Error: " . print_r($errorInfo, true));
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
    // public function debugViewStructure() {
    //     $this->db->query("DESCRIBE v_allapplications");
    //     $columns = $this->db->resultSet();
    //     echo "View columns:<br>";
    //     print_r($columns);

    //     // Check if there's any data in the view at all
    //     $this->db->query("SELECT COUNT(*) as total FROM v_allapplications");
    //     $total = $this->db->single();
    //     echo "<br>Total records in view: " . $total->total;

    //     // Check a sample record
    //     $this->db->query("SELECT * FROM v_allapplications LIMIT 1");
    //     $sample = $this->db->single();
    //     echo "<br>Sample record:<br>";
    //     print_r($sample);
    // }

    // Model: M_applicationFields.php
    public function getAllApplications($userId, $pageNumber = 1, $rowsPerPage = 10, $sort = "SubmissionDate", $order = "DESC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['StudentID', '=', $userId]
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', JobTitle, CompanyName, JobLocation, DATE_FORMAT(SubmissionDate, '%Y/%m/%d'), Status)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }

            $results = $this->select('v_allapplications', $conditions, 'ApplicationID, JobTitle, CompanyName, JobLocation, SubmissionDate, Status', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $results;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            return [];
        }
    }
    public function getApplicationResponses($applicationId)
    {
        // Using the exact field name from your view structure
        $query = "SELECT * FROM v_allapplications WHERE ApplicationID = :application_id";

        try {
            $this->db->query($query);
            $this->db->bind(':application_id', $applicationId);

            // Debug information

            $results = $this->db->resultSet();

            // Add error checking
            if ($this->db->rowCount() > 0) {
                return $results;
            } else {
                // Debug: Check if the user exists
                $this->db->query("SELECT StudentName FROM v_allapplications WHERE ApplicationID = :application_id LIMIT 1");
                $this->db->bind(':user_id', $applicationId);
                $user = $this->db->single();

                if ($user) {
                    echo "User exists but no applications found";
                } else {
                    echo "No user found with ID: " . $applicationId;
                }
                return [];
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            return [];
        }
    }
    public function getAllApplicationsByCompanyId($companyId, $pageNumber = 1, $rowsPerPage = 10, $sort = "SubmissionDate", $order = "DESC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['CompanyID', '=', $companyId]
            ];

            // Add search condition if a search term is provided
            // if (!empty($search)) {
            //     $searchTerm = '%' . $search . '%';
            //     $searchField =  "CONCAT_WS(' ', StudentName, StudentEmail, StudentContact, DATE_FORMAT(SubmissionDate, '%Y/%m/%d'), Status)";

            //     $conditions[] = [$searchField, 'LIKE', $searchTerm];
            // }

            // Get users verified by the current user
            $verifiedEntities = $this->select('v_allapplications', $conditions, '*', 'AND', '', $sort . ' ' . $order, 0, 1, true);
            return $verifiedEntities;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return [];
        }
    }

    public function getApplicationsByJobID($jobID)
    {
        // try {
        // Prepare the SQL query
        $query = 'SELECT * FROM v_allapplications WHERE jobID = :jobID';
        $this->db->query($query);
        // Bind the job ID parameter
        $this->db->bind(':jobID', $jobID);

        // Execute the query and return the results
        return $this->db->resultSet();

        // } catch (PDOException $e) {
        //     error_log("Database Error: " . $e->getMessage());
        //     return [];
        // }

    }
    public function getApplicationByID($applicationID)
    {
        // try {
        // Prepare the SQL query
        $query = 'SELECT * FROM v_allapplications WHERE applicationID = :applicationID';
        $this->db->query($query);
        // Bind the job ID parameter
        $this->db->bind(':applicationID', $applicationID);

        // Execute the query and return the results
        return $this->db->resultSet();

        // } catch (PDOException $e) {
        //     error_log("Database Error: " . $e->getMessage());
        //     return [];
        // }

    }

    public function getPendnigApplicationsByJobID($jobID, $pageNumber = 1, $rowsPerPage = 10, $sort = "SubmissionDate", $order = "DESC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['jobID', '=', $jobID],
                ['Status', '=', 'Pending']
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', StudentName, StudentEmail, StudentContact, DATE_FORMAT(SubmissionDate, '%Y/%m/%d'), Status)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }

            // Get users verified by the current user
            $verifiedEntities = $this->select('v_allapplications', $conditions, '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $verifiedEntities;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return [];
        }
    }

    public function getOfferedApplicationsByJobID($jobID, $pageNumber = 1, $rowsPerPage = 10, $sort = "SubmissionDate", $order = "DESC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['jobID', '=', $jobID],
                ['Status', '=', 'Accepted']
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "(' ', StudentName, StudentEmail, StudentContact, DATE_FORMAT(SubmissionDate, '%Y/%m/%d'), Status)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }

            // Get users verified by the current user
            $verifiedEntities = $this->select('v_allapplications', $conditions, '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $verifiedEntities;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return [];
        }
    }

    public function getRejectedApplicationsByJobID($jobID, $pageNumber = 1, $rowsPerPage = 10, $sort = "SubmissionDate", $order = "DESC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['jobID', '=', $jobID],
                ['Status', '=', 'Rejected']
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', StudentName, StudentEmail, StudentContact, DATE_FORMAT(SubmissionDate, '%Y/%m/%d'), Status)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }

            // Get users verified by the current user
            $verifiedEntities = $this->select('v_allapplications', $conditions, '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $verifiedEntities;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return [];
        }
    }

    public function approveApplication($applicationID)
    {
        try {
            $this->db->query("UPDATE applications SET status = 'Accepted' WHERE id = :applicationID");
            $this->db->bind(':applicationID', $applicationID);
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function rejectApplication($applicationID)
    {
        try {
            $this->db->query("UPDATE applications SET status = 'Rejected' WHERE id = :applicationID");
            $this->db->bind(':applicationID', $applicationID);
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function getApplicationCountForJob($jobID) {
        try {
            $this->db->query("SELECT ApplicationCount FROM v_jobs WHERE v_jobs.JobID = :jobID");
            $this->db->bind(':jobID', $jobID);
            $row = $this->db->single();
            return $row->ApplicationCount;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
}
