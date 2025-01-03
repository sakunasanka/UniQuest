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
                        'CompanyName' => $data['companyName'] ?? null,
                        'StreetNo' => $data['streetNo'] ?? null,
                        'AddressLine1' => $data['addressLine1'] ?? null,
                        'AddressLine2' => $data['addressLine2'] ?? null,
                        'City' => $data['city'] ?? null,
                        'CompanyLogo' => $data['companyLogoName'] ?? null,
                        'Description' => $data['description'] ?? null,
                        'Website' => $data['website'] ?? null,
                        'Industry' => $data['industry'] ?? null
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
                ['Role', 'IN', ['Student', 'Company']],
                ['Status', '=', 'Pending']
            ];
            $users = $this->select('User', $conditions, 'UserID, Email, Role, RegisterDate, Status', 'AND', '', '', 0, true);
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
                ['Role', 'IN', ['Student', 'Company']],
                ['Status', '=', 'Not Approved']
            ];
            $users = $this->select('User', $conditions, 'UserID, Email, Role, RegisterDate, Status', 'AND', '', '', 0, true);
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
                'VerifiedDate' => date('Y-m-d H:i:s')
            ];
            $this->db->beginTransaction();

            if (!$this->update('User', $userData, ['UserID' => $userId])) {
                $this->db->rollBack();
                return false;
            } 

            $logData = [
                'EntityID' => $userId,
                'EntityType' => 'User',
                'Action' => 'Approve',
                'ActionBy' => $_SESSION['user_id'],
                'ActionDate' => date('Y-m-d H:i:s')
            ];

            if (!$this->insert('VerificationLogs', $logData)) {
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

    public function rejectUser($userId)
    {
        try {
            $userData = [
                'Status' => 'Not Approved',
                'VerifiedDate' => date('Y-m-d H:i:s')
            ];
            $this->db->beginTransaction();

            if (!$this->update('User', $userData, ['UserID' => $userId])) {
                $this->db->rollBack();
                return false;
            } 

            $logData = [
                'EntityID' => $userId,
                'EntityType' => 'User',
                'Action' => 'Reject',
                'ActionBy' => $_SESSION['user_id'],
                'ActionDate' => date('Y-m-d H:i:s')
            ];

            if (!$this->insert('VerificationLogs', $logData)) {
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
            // Conditions for the query
            $conditions = [
                ['Status', 'IN', ['Active', 'Deactive']], // Use IN clause for Status
                ['Role', '=', $role] // Use simple equality for Role
            ];

            // Fetch users using the select method
            $users = $this->select(
                'User', // Table name
                $conditions, // Conditions array
                'UserID, Email, ContactNo, RegisterDate, Status', // Columns to select
                'AND', // Logical operator (AND between conditions)
                '', // No GROUP BY
                '', // No ORDER BY
                0, // No LIMIT
                true // Fetch all results
            );

            return $users;
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
            $users = $this->select('User', [['Role', '=', $role]], 'COUNT(UserID) AS UserCount', 'AND', '', '', 0, true);
            return $users[0]->UserCount;
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
            $pendingUsers = $this->select('User', [['Status', '=', 'Pending']], 'COUNT(UserID) AS PendingUserCount', 'AND', '', '', 0, true);
            return $pendingUsers[0]->PendingUserCount;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return 0;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return 0;
        }
    }

    public function getVerifiedUsersByMe($userId)
    {
        try {
            // Get users verified by the current user
            $verifiedEntities = $this->select('v_verifiedUsers', [['ActionBy', '=', $userId]], '*', 'AND', '', '', 0, true);
            return $verifiedEntities;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return [];
        }
    }
}
