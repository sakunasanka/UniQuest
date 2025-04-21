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

    protected function buildFilterConditions(array $filters = []): array
    {
        $conditions = [];

        if (empty($filters)) {
            return $conditions;
        }

        // District filter
        if (!empty($filters['district'])) {
            $conditions[] = ['District', '=', $filters['district']];
        }

        // City filter
        if (!empty($filters['city'])) {
            $conditions[] = ['City', '=', $filters['city']];
        }

        // Industry filter
        if (!empty($filters['industry'])) {
            $conditions[] = ['Industry', '=', $filters['industry']];
        }

        // Rating filter
        if (!empty($filters['rating'])) {
            $conditions[] = ['Rating', '>=', $filters['rating']];
        }

        return $conditions;
    }

    public function getcompany($pageNumber = 1, $rowsPerPage = 12, $sort = "UserID", $order = "DESC", $search = '', array $filters = [])
    {
        try {
            // Base conditions
            $conditions = [
                ['Status', '=', 'Active']
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', CompanyName, Address, Industry, Email)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }

            // Add filter conditions
            $filterConditions = $this->buildFilterConditions($filters);
            $conditions = array_merge($conditions, $filterConditions);

            $companies = $this->select('v_company', $conditions, '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $companies;
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
                'DistrictID' => $data['districtID'],
                'CityID' => $data['cityID'],
                'IndustryID' => $data['industryID'],
                'Website' => $data['website'],
                'LinkedIn' => $data['linkedin'],
                'Facebook' => $data['facebook'],
                'BRCertificate' => $data['brCertificateName']
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
                'Status' => $data['status'],
                'VerifiedDate' => $data['verifiedDate'],
                'VerifiedBy' => $data['verifiedBy']
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
                'Company' => ['table' => 'v_company', 'ID' => 'UserID'],
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

    // public function getUserDetailsView($role, $userId)
    // {
    //     try {
    //         // Define view and columns per role
    //         $roleMap = [
    //             'Student'    => ['view' => 'v_student',    'columns' => '*'],
    //             'Company'    => ['view' => 'v_company',    'columns' => '*'],
    //             'VT-Member'  => ['view' => 'v_vtmember',   'columns' => '*'],
    //             'Admin'      => ['view' => 'v_admin',      'columns' => '*'],
    //         ];

    //         // Check if role is valid
    //         if (!isset($roleMap[$role])) {
    //             throw new Exception("Invalid role specified: " . $role);
    //         }

    //         // Fetch user details
    //         $userDetails = $this->select($roleMap[$role]['view'], [['UserID', '=', $userId]], $roleMap[$role]['columns']);
    //         return $userDetails;
    //     } catch (PDOException $e) {
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     } catch (Exception $e) {
    //         error_log("General Error: " . $e->getMessage());
    //         return false;
    //     }
    // }

    public function updateProfile($data)
    {
        try {
            $this->db->beginTransaction();

            // Validate essential data
            if (empty($data['userID']) || empty($data['role'])) {
                throw new Exception("Invalid data: Missing userID or role.");
            }

            // Update User table
            $userData = ['ContactNo' => $data['contactNo'] ?? null];
            if (!$this->update('user', $userData, ['UserID' => $data['userID']])) {
                $this->db->rollBack();
                error_log("Failed to update 'user' table for UserID: " . $data['userID']);
                return false;
            }

            // Handle updates based on role
            switch ($data['role']) {
                case 'Student':
                    $studentData = [
                        'FirstName' => $data['firstName'] ?? null,
                        'LastName' => $data['lastName'] ?? null,
                        'StreetNo' => $data['streetNo'] ?? null,
                        'AddressLine1' => $data['addressLine1'] ?? null,
                        'AddressLine2' => $data['addressLine2'] ?? null,
                        'City' => $data['city'] ?? null,
                        'CV' => $data['cvName'] ?? null,
                        'ProfilePic' => $data['profilePicName'] ?? null
                    ];
                    if (!$this->update('student', $studentData, ['StudentID' => $data['userID']])) {
                        $this->db->rollBack();
                        error_log("Failed to update 'student' table for StudentID: " . $data['userID']);
                        return false;
                    }
                    break;

                case 'Company':
                    $companyData = [
                        'CompanyName' => $data['companyName'],
                        'Description' => $data['description'],
                        'CompanyLogo' => $data['companyLogoName'],
                        'StreetNo' => $data['streetNo'],
                        'AddressLine1' => $data['addressLine1'],
                        'AddressLine2' => $data['addressLine2'],
                        'DistrictID' => $data['districtID'],
                        'CityID' => $data['cityID'],
                        'IndustryID' => $data['industryID'],
                        'Website' => $data['website'],
                        'LinkedIn' => $data['linkedin'],
                        'Facebook' => $data['facebook']
                    ];
                    if (!$this->update('company', $companyData, ['CompanyID' => $data['userID']])) {
                        $this->db->rollBack();
                        error_log("Failed to update 'company' table for CompanyID: " . $data['userID']);
                        return false;
                    }
                    break;

                case 'VT-Member':
                    $vtData = [
                        'FirstName' => $data['firstName'] ?? null,
                        'LastName' => $data['lastName'] ?? null
                    ];
                    if (!$this->update('verificationteam', $vtData, ['VT_MemberID' => $data['userID']])) {
                        $this->db->rollBack();
                        error_log("Failed to update 'verificationteam' table for VT_MemberID: " . $data['userID']);
                        return false;
                    }
                    break;

                case 'Admin':
                    $adminData = [
                        'FirstName' => $data['firstName'] ?? null,
                        'LastName' => $data['lastName'] ?? null
                    ];
                    if (!$this->update('admin', $adminData, ['AdminID' => $data['userID']])) {
                        $this->db->rollBack();
                        error_log("Failed to update 'admin' table for AdminID: " . $data['userID']);
                        return false;
                    }
                    break;

                default:
                    $this->db->rollBack();
                    error_log("Invalid role specified: " . $data['role']);
                    return false;
            }

            // Commit the transaction
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function changePassword($userId, $newPassword)
    {
        try {
            $userData = [
                'Password' => $newPassword
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

    public function deactivateAccountByUser($userId)
    {
        try {
            $userData = [
                'Status' => 'Pending Deletion'
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

    public function getPendingStudentsAndCompanies($pageNumber = 1, $rowsPerPage = 10, $sort = "UserID", $order = "ASC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['Role', 'IN', ['Student', 'Company']],
                ['Status', '=', 'Pending']
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', UserID, Email, Role, DATE_FORMAT(RegisterDate, '%Y-%m-%d'), Status)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }
            $users = $this->select('User', $conditions, 'UserID, Email, Role, RegisterDate, Status', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $users;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getNotVerifiedStudentsAndCompanies($pageNumber = 1, $rowsPerPage = 10, $sort = "UserID", $order = "ASC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['Role', 'IN', ['Student', 'Company']],
                ['Status', '=', 'Not Approved']
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', UserID, Email, Role, DATE_FORMAT(RegisterDate, '%Y-%m-%d'), Status)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }

            $users = $this->select('User', $conditions, 'UserID, Email, Role, RegisterDate, Status', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
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
                'Status' => 'Active',
                'VerifiedDate' => date('Y-m-d H:i:s'),
                'VerifiedBy' => $_SESSION['user_id']
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
                'Status' => 'Not Approved',
                'VerifiedDate' => date('Y-m-d H:i:s'),
                'VerifiedBy' => $_SESSION['user_id']
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

    public function getVerifiedUsersByRole($role, $pageNumber = 1, $rowsPerPage = 10, $sort = "UserID", $order = "ASC", $search = '')
    {
        try {
            // Define view and columns per role
            $roleMap = [
                'Student'    => ['view' => 'v_student',    'columns' => 'UserID, FullName, Email, ContactNo, RegisterDate, Status, Role'],
                'Company'    => ['view' => 'v_company',    'columns' => 'UserID, CompanyName, Email, ContactNo, RegisterDate, Status, Role'],
                'VT-Member'  => ['view' => 'v_vtmember',   'columns' => 'UserID, FullName, Email, ContactNo, RegisterDate, Status, Role'],
                'Admin'      => ['view' => 'v_admin',      'columns' => 'UserID, FullName, Email, ContactNo, RegisterDate, Status, Role'],
            ];

            // Define base conditions
            $conditions = [
                ['Status', 'IN', ['Active', 'Deactive']],
                ['Role', '=', $role]
            ];

            // Check if role is valid
            if (!isset($roleMap[$role])) {
                throw new Exception("Invalid role specified: " . $role);
            }

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField = ($role === 'Company')
                    ? "CONCAT_WS(' ', CompanyName, Email, ContactNo, DATE_FORMAT(RegisterDate, '%Y-%m-%d'), Status, Role)"
                    : "CONCAT_WS(' ', FullName, Email, ContactNo, Status, DATE_FORMAT(RegisterDate, '%Y-%m-%d'), Role)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }

            // Perform select
            return $this->select(
                $roleMap[$role]['view'],
                $conditions,
                $roleMap[$role]['columns'],
                'AND',
                '',
                "$sort $order",
                $rowsPerPage,
                $pageNumber,
                true
            );
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }


    public function getCountRegisteredUsers($role)
    {
        try {
            // Get users by role
            $users = $this->select('User', [['Role', '=', $role], ['Status', '=', 'Active']], 'COUNT(UserID) AS UserCount', 'AND', '', '', 0, true);

            // Check if the result is an object and access the property correctly
            if (is_object($users)) {
                return $users->UserCount;
            } elseif (is_array($users) && !empty($users)) {
                return $users[0]->UserCount;
            } else {
                return 0; // No users found
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return 0;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return 0;
        }
    }

    public function getCountPendingUsers()
    {
        try {
            // Get pending students and companies
            $pendingUsers = $this->select('User', [['Status', '=', 'Pending'],], 'COUNT(UserID) AS PendingUserCount', 'AND', '', '', 0, 1, true);
            return $pendingUsers['data'][0]->PendingUserCount;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return 0;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return 0;
        }
    }

    public function getVerifiedUsersByMe($userId, $pageNumber = 1, $rowsPerPage = 10, $sort = "UserID", $order = "DESC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['ActionBy', '=', $userId]
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', Name, Email, DATE_FORMAT(ActionDate, '%Y-%m-%d'), Status, Role)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }

            // Get users verified by the current user
            $verifiedEntities = $this->select('v_verifiedUsers', $conditions, '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $verifiedEntities;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return [];
        }
    }

    public function storeToken($email, $token, $expiration)
    {
        try {
            // Save token to the database
            $tokenData = [
                'Email' => $email,
                'Token' => $token,
                'Expiration' => $expiration
            ];

            if ($this->insert('token', $tokenData)) {
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

    public function getTokenDetails($token)
    {
        try {
            // Get the token details from the database
            $tokenData = $this->select('token', [['Token', '=', $token]], 'Email, Expiration', 'AND', '', '', 0, 1, false);
            if ($tokenData) {
                return $tokenData;
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

    public function deleteToken($token)
    {
        try {
            // Delete the token from the database
            if ($this->delete('token', ['Token' => $token])) {
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

    public function verifyEmail($email)
    {
        try {
            $emailData = [
                'Email' => $email,
                'VerifiedDate' => date('Y-m-d H:i:s'),
                'isVerified' => 'Y'
            ];

            if ($this->insert('email_verification', $emailData)) {
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

    public function isEmailVerified($email)
    {
        try {
            $emailData = $this->select('email_verification', [['Email', '=', $email]], 'isVerified', 'AND', '', '', 0, 1, false);
            if ($emailData->isVerified === 'Y') {
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

    public function getUserLoginsByGender()
    {
        $this->db->query("SELECT 
                gender, 
                COUNT(*) AS logins
            FROM user
            GROUP BY gender");
        return $this->db->resultSet();
    }
    
    public function getUserRoleByID($userId)
    {
        $this->db->query("SELECT Role FROM user WHERE UserID = :userId");
        $this->db->bind(':userId', $userId);
        return $this->db->single();
    }

    public function getAdminIds() 
    {
        $this->db->query("SELECT AdminID FROM Admin");
        $admins = $this->db->resultSet();
    }

    public function getAllUserIds() 
    {
        $this->db->query("SELECT UserID FROM User");
        $users = $this->db->resultSet();
        return array_map(function($user) {
            return $user->UserID;
        }, $users);
    }
}
