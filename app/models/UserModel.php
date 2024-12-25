<?php
class userModel extends Model
{
    public function findUserByEmail($email) 
    {
        try {
            $user = $this->select('user', [['Email', "=", $email]]);
            if ($user && $user->Status !== 'Deleted') {
                return $user;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function companyRegister(array $data)
    {
        try {
            $this->db->beginTransaction();

            // Insert into User table
            $userData = [
                'Password' => $data['password'],
                'Email' => $data['email'],
                'Role' => $data['role'],
                'RegisterDate' => $data['date'],
                'ContactNo' => $data['contactNo'],
                'Status' => $data['status']
            ];
            if (!$this->insert('user', $userData)) {
                $this->db->rollBack();
                return false;
            }

            // Get last inserted ID
            $userId = $this->db->lastInsertId();

            // Insert into Company table
            $companyData = [
                'CompanyID' => $userId,
                'CompanyName' => $data['companyName'],
                'Description' => $data['description'],
                'CompanyLogo' => $data['companyLogoName'],
                'StreetNo' => $data['streetNo'],
                'AddressLine1' => $data['addressLine1'],
                'AddressLine2' => $data['addressLine2'],
                'City' => $data['city'],
                'Industry' => $data['industry'],
                'Website' => $data['website']
            ];
            if (!$this->insert('company', $companyData)) {
                $this->db->rollBack();
                return false;
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function studentRegister(array $data)
    {
        try {
            $this->db->beginTransaction();

            // Insert into User table
            $userData = [
                'Password' => $data['password'],
                'Email' => $data['email'],
                'Role' => $data['role'],
                'RegisterDate' => $data['date'],
                'ContactNo' => $data['contactNo'],
                'Status' => $data['status']
            ];
            if (!$this->insert('user', $userData)) {
                $this->db->rollBack();
                return false;
            }

            // Get last inserted ID
            $userId = $this->db->lastInsertId();

            // Insert into Student table
            $studentData = [
                'StudentID' => $userId,
                'FirstName' => $data['firstName'],
                'LastName' => $data['lastName'],
                'ProfilePic' => $data['profilePicName'],
                'Gender' => $data['gender'],
                'DOB' => $data['dob'],
                'NIC_No' => $data['nicNo'],
                'NIC_Copy' => $data['nicCopyName'],
                'CV' => $data['cvName'],
                'StreetNo' => $data['streetNo'],
                'AddressLine1' => $data['addressLine1'],
                'AddressLine2' => $data['addressLine2'],
                'City' => $data['city'],
                'University' => $data['university'],
                'UniversityID' => $data['universityID'],
                'UniversityID_Copy' => $data['universityIDCopyName']
            ];
            if (!$this->insert('student', $studentData)) {
                $this->db->rollBack();
                return false;
            }

            // Commit transaction
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function addVTMember(array $data)
    {
        try {
            $this->db->beginTransaction();

            // Insert into User table
            $userData = [
                'Password' => $data['password'],
                'Email' => $data['email'],
                'Role' => $data['role'],
                'RegisterDate' => $data['date'],
                'ContactNo' => $data['contactNo'],
                'Status' => $data['status']
            ];
            if (!$this->insert('user', $userData)) {
                $this->db->rollBack();
                return false;
            }

            // Get last inserted ID
            $userId = $this->db->lastInsertId();

            // Insert into VerificationTeam table
            $vtData = [
                'VT_MemberID' => $userId,
                'FirstName' => $data['firstName'],
                'LastName' => $data['lastName'],
                'ProfilePic' => $data['profilePicName']
            ];
            if (!$this->insert('verificationteam', $vtData)) {
                $this->db->rollBack();
                return false;
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function login($email, $password)
    {
        try {
            $user = $this->findUserByEmail($email);
            if ($user) {
                if (password_verify($password, $user->Password)) {
                    return $user;
                }
            }
            return false;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getUserDetails($userId)
    {
        try {
            // Fetch user details
            $user = $this->select('User', [['UserID', '=', $userId]]);
            if (!$user) {
                return false; // User not found
            }

            // Determine the role and fetch additional details
            $roleTables = [
                'Student' => ['table' => 'Student', 'ID' => 'StudentID'],
                'Company' => ['table' => 'Company', 'ID' => 'CompanyID'],
                'VT-Member' => ['table' => 'VerificationTeam', 'ID' => 'VT_MemberID'],
                'Admin' => ['table' => 'Admin', 'ID' => 'AdminID']
            ];

            $role = $user->Role;
            if (array_key_exists($role, $roleTables)) {
                $roleTable = $roleTables[$role]['table'];
                $roleID = $roleTables[$role]['ID'];

                $additionalDetails = $this->select($roleTable, [[$roleID, '=', $userId]]);
                if ($additionalDetails) {
                    return array_merge((array)$user, (array)$additionalDetails);
                }
            }

            return (array)$user; // Return base user details if no additional table exists for the role
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function updateProfile($data)
    {
        try {
            $this->db->beginTransaction();

            // Update User table
            $userData = [
                'ContactNo' => $data['contactNo']
            ];
            if (!$this->update('user', $userData, ['UserID' => $data['userID']])) {
                $this->db->rollBack();
                return false;
            }

            if ($data['role'] === 'Student') {
                // Update Student table
                $studentData = [
                    'FirstName' => $data['firstName'],
                    'LastName' => $data['lastName'],
                    'StreetNo' => $data['streetNo'],
                    'AddressLine1' => $data['addressLine1'],
                    'AddressLine2' => $data['addressLine2'],
                    'City' => $data['city'],
                    'CV' => $data['cvName'],
                    'ProfilePic' => $data['profilePicName']
                ];
                if (!$this->update('student', $studentData, ['StudentID' => $data['userID']])) {
                    $this->db->rollBack();
                    return false;
                }
            } else if ($data['role'] === 'Company') {
                // Update Company table
                $companyData = [
                    'CompanyName' => $data['companyName'],
                    'StreetNo' => $data['streetNo'],
                    'AddressLine1' => $data['addressLine1'],
                    'AddressLine2' => $data['addressLine2'],
                    'City' => $data['city'],
                    'CompanyLogo' => $data['companyLogoName'],
                    'Description' => $data['description'],
                    'Website' => $data['website'],
                    'Industry' => $data['industry']
                ];
                if (!$this->update('company', $companyData, ['CompanyID' => $data['userID']])) {
                    $this->db->rollBack();
                    return false;
                }
            } else if ($data['role'] === 'VT-Member') {
                // Update VerificationTeam table
                $vtData = [
                    'FirstName' => $data['firstName'],
                    'LastName' => $data['lastName']
                ];
                if (!$this->update('verificationteam', $vtData, ['VT_MemberID' => $data['userID']])){
                    $this->db->rollBack();
                    return false;
                }
            } else if ($data['role'] === 'Admin') {
                // Update Admin table
                $adminData = [
                    'FirstName' => $data['firstName'],
                    'LastName' => $data['lastName']
                ];
                if (!$this->update('admin', $adminData, ['AdminID' => $data['userID']])){
                    $this->db->rollBack();
                    return false;
                }
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function deactivateAccount($userId)
    {
        try {
            $userData = [
                'Status' => 'Deactive'
            ];
            if ($this->update('user', $userData, ['UserID' => $userId])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getPendingStudentsAndCompanies()
    {
        try {
            // Use grouped conditions for more complex queries
            $conditions = [
                [['Role', '=', 'Student'], ['Role', '=', 'Company']],
                ['Status', '=', 'Pending']
            ];
            $users = $this->select('User', $conditions, 'UserID, Email, Role, RegisterDate, Status', 'AND', true);
            return $users;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getNotVerifiedStudentsAndCompanies()
    {
        try {
            $conditions = [
                [['Role', '=', 'Student'], ['Role', '=', 'Company']],
                ['Status', '=', 'Not Approved']
            ];
            $users = $this->select('User', $conditions, 'UserID, Email, Role, RegisterDate, Status', 'AND', true);
            return $users;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function approveUser($userId)
    {
        try {
            $userData = [
                'Status' => 'Active'
            ];
            if ($this->update('User', $userData, ['UserID' => $userId])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function rejectUser($userId)
    {
        try {
            $userData = [
                'Status' => 'Not Approved'
            ];
            if ($this->update('User', $userData, ['UserID' => $userId])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function activateAccount($userId)
    {
        try {
            $userData = [
                'Status' => 'Active'
            ];
            if ($this->update('User', $userData, ['UserID' => $userId])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getVerifiedUsersByRole($role)
    {
        try {
            $conditions = [
                [['Status', '=', 'Active'], ['Status', '=', 'Deactive']],
                ['Role', '=', $role]
            ];
            $users = $this->select('User', $conditions, 'UserID, Email, ContactNo, RegisterDate, Status', 'AND', true);
            return $users;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getVerifiedJobsByCategory($category)
    {
        try {
            $conditions = [
                [['Status', '=', 'Active'], ['Status', '=', 'Deactive']],
                ['Category', '=', $category]
            ];
            $users = $this->select('v_jobs', $conditions, 'JobID, CompanyID, Title, CompanyName, Email, jobs_create_at, Status, Category', 'AND', true);
            return $users;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getPendingJobs()
    {
        try {
            $conditions = [
                ['Status', '=', 'Pending']
            ];
            $users = $this->select('v_jobs', $conditions, 'JobID, CompanyID, Title, CompanyName, Email, jobs_create_at, Status, Category', 'AND', true);
            return $users;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getNotApprovedJobs()
    {
        try {
            $conditions = [
                ['Status', '=', 'Not Approved']
            ];
            $users = $this->select('v_jobs', $conditions, 'JobID, CompanyID, Title, CompanyName, Email, jobs_create_at, Status, Category', 'AND', true);
            return $users;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getJobDetails($jobId)
    {
        try {
            $conditions = [
                ['JobID', '=', $jobId]
            ];
            $job = $this->select('v_jobs', $conditions, '*', 'AND', false);
            return $job;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function approveJob($jobId)
    {
        try {
            $jobData = [
                'Status' => 'Active'
            ];
            if ($this->update('Jobs', $jobData, ['JobID' => $jobId])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function rejectJob($jobId)
    {
        try {
            $jobData = [
                'Status' => 'Not Approved'
            ];
            if ($this->update('Jobs', $jobData, ['JobID' => $jobId])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function activateJob($jobId)
    {
        try {
            $jobData = [
                'Status' => 'Active'
            ];
            if ($this->update('Jobs', $jobData, ['JobID' => $jobId])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function deactivateJob($jobId)
    {
        try {
            $jobData = [
                'Status' => 'Deactive'
            ];
            if ($this->update('Jobs', $jobData, ['JobID' => $jobId])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }
    
}

