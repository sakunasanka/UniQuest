<?php
class userModel extends Model
{
    // private $db;

    // public function __construct()
    // {
    //     $this->db = Database::getInstance();
    // }

    // public function findUserByEmail($email)
    // {
    //     try {
    //         if (!$this->db) {
    //             throw new Exception("Database connection is not established.");
    //         }
    //         $this->db->query('SELECT * FROM User WHERE Email = :email');
    //         $this->db->bind(':email', $email);
    //         $user = $this->db->single();
    //         if ($user && $user->Status !== 'Deleted') {
    //             return $user;
    //         } else {
    //             return false;
    //         }
    //     } catch (PDOException $e) { // Catch database-specific exceptions
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     } catch (Exception $e) {
    //         error_log("General Error: " . $e->getMessage());
    //         return false;
    //     }
    // }

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

    // public function companyRegister(array $data)
    // {
    //     try {
    //         // Start transaction
    //         $this->db->beginTransaction();

    //         //Insert into User table
    //         $this->db->query('INSERT INTO user (Password, Email, Role, RegisterDate, ContactNo, Status) VALUES ( :password, :email, :role, :registerDate, :contactNo, :status)');
    //         $this->db->bind(':password', $data['password']);
    //         $this->db->bind(':email', $data['email']);
    //         $this->db->bind(':role', $data['role']);
    //         $this->db->bind(':registerDate', $data['date']);
    //         $this->db->bind(':contactNo', $data['contactNo']);
    //         $this->db->bind(':status', $data['status']);

    //         //Execute query
    //         if (!$this->db->execute()) {
    //             error_log('Failed to insert into User table');
    //             $this->db->rollBack();
    //             return false;
    //         }

    //         //Get the last inserted user id
    //         $userId = $this->db->lastInsertId();

    //         //Insert into Company table
    //         $this->db->query('INSERT INTO Company (CompanyID, CompanyName, Description, CompanyLogo, StreetNo, AddressLine1, AddressLine2, City, Industry, Website) VALUES (:companyID, :companyName, :description, :companyLogo, :streetNo, :addressLine1, :addressLine2, :city, :industry, :website)');
    //         $this->db->bind(':companyID', $userId);
    //         $this->db->bind(':companyName', $data['companyName']);
    //         $this->db->bind(':description', $data['description']);
    //         $this->db->bind(':companyLogo', $data['companyLogoName']);
    //         $this->db->bind(':streetNo', $data['streetNo']);
    //         $this->db->bind(':addressLine1', $data['addressLine1']);
    //         $this->db->bind(':addressLine2', $data['addressLine2']);
    //         $this->db->bind(':city', $data['city']);
    //         $this->db->bind(':industry', $data['industry']);
    //         $this->db->bind(':website', $data['website']);

    //         //Execute query
    //         if (!$this->db->execute()) {
    //             error_log('Failed to insert into Company table');
    //             $this->db->rollBack();
    //             return false;
    //         }

    //         //Commit transaction
    //         $this->db->commit();
    //         return true;
    //     } catch (PDOException $e) {
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     } catch (Exception $e) {
    //         error_log("General Error: " . $e->getMessage());
    //         return false;
    //     }
    // }

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

    // public function studentRegister(array $data)
    // {
    //     try {
    //         // Start transaction
    //         $this->db->beginTransaction();

    //         //Insert into User table
    //         $this->db->query('INSERT INTO user (Password, Email, Role, RegisterDate, ContactNo, Status) VALUES ( :password, :email, :role, :registerDate, :contactNo, :status)');
    //         $this->db->bind(':password', $data['password']);
    //         $this->db->bind(':email', $data['email']);
    //         $this->db->bind(':role', $data['role']);
    //         $this->db->bind(':registerDate', $data['date']);
    //         $this->db->bind(':contactNo', $data['contactNo']);
    //         $this->db->bind(':status', $data['status']);

    //         //Execute query
    //         if (!$this->db->execute()) {
    //             error_log('Failed to insert into User table');
    //             $this->db->rollBack();
    //             return false;
    //         }

    //         //Get the last inserted user id
    //         $userId = $this->db->lastInsertId();

    //         //Insert into Student table
    //         $this->db->query('INSERT INTO Student (StudentID, FirstName, LastName, ProfilePic, Gender, DOB, NIC_No, NIC_Copy, CV, StreetNo, AddressLine1, AddressLine2, City, University, UniversityID, UniversityID_Copy) VALUES (:studentID, :firstName, :lastName, :profilePic, :gender, :dob, :nicNo, :nicCopy, :cv, :streetNo, :addressLine1, :addressLine2, :city, :university, :universityID, :universityIDCopy)');
    //         $this->db->bind(':studentID', $userId);
    //         $this->db->bind(':firstName', $data['firstName']);
    //         $this->db->bind(':lastName', $data['lastName']);
    //         $this->db->bind(':profilePic', $data['profilePicName']);
    //         $this->db->bind(':gender', $data['gender']);
    //         $this->db->bind(':dob', $data['dob']);
    //         $this->db->bind(':nicNo', $data['nicNo']);
    //         $this->db->bind(':nicCopy', $data['nicCopyName']);
    //         $this->db->bind(':cv', $data['cvName']);
    //         $this->db->bind(':streetNo', $data['streetNo']);
    //         $this->db->bind(':addressLine1', $data['addressLine1']);
    //         $this->db->bind(':addressLine2', $data['addressLine2']);
    //         $this->db->bind(':city', $data['city']);
    //         $this->db->bind(':university', $data['university']);
    //         $this->db->bind(':universityID', $data['universityID']);
    //         $this->db->bind(':universityIDCopy', $data['universityIDCopyName']);

    //         //Execute query
    //         if (!$this->db->execute()) {
    //             error_log('Failed to insert into Student table');
    //             $this->db->rollBack();
    //             return false;
    //         }

    //         //Commit transaction
    //         $this->db->commit();
    //         return true;
    //     } catch (PDOException $e) {
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     } catch (Exception $e) {
    //         error_log("General Error: " . $e->getMessage());
    //         return false;
    //     }
    // }

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

    // public function addVTMember(array $data)
    // {
    //     try {
    //         // Start transaction
    //         $this->db->beginTransaction();

    //         //Insert into User table
    //         $this->db->query('INSERT INTO user (Password, Email, Role, RegisterDate, ContactNo, Status) VALUES ( :password, :email, :role, :registerDate, :contactNo, :status)');
    //         $this->db->bind(':password', $data['password']);
    //         $this->db->bind(':email', $data['email']);
    //         $this->db->bind(':role', $data['role']);
    //         $this->db->bind(':registerDate', $data['date']);
    //         $this->db->bind(':contactNo', $data['contactNo']);
    //         $this->db->bind(':status', $data['status']);

    //         //Execute query
    //         if (!$this->db->execute()) {
    //             error_log('Failed to insert into User table');
    //             $this->db->rollBack();
    //             return false;
    //         }

    //         //Get the last inserted user id
    //         $userId = $this->db->lastInsertId();

    //         //Insert into verification team table
    //         $this->db->query('INSERT INTO VerificationTeam (VT_MemberID, FirstName, LastName, ProfilePic) VALUES (:vtMemberID, :firstName, :lastName, :profilePic)');
    //         $this->db->bind(':vtMemberID', $userId);
    //         $this->db->bind(':firstName', $data['firstName']);
    //         $this->db->bind(':lastName', $data['lastName']);
    //         $this->db->bind(':profilePic', $data['profilePicName']);

    //         //Execute query
    //         if (!$this->db->execute()) {
    //             error_log('Failed to insert into verification team table');
    //             $this->db->rollBack();
    //             return false;
    //         }

    //         //Commit transaction
    //         $this->db->commit();
    //         return true;
    //     } catch (PDOException $e) {
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     } catch (Exception $e) {
    //         error_log("General Error: " . $e->getMessage());
    //         return false;
    //     }
    // }

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

    // public function login($email, $password)
    // {
    //     try {
    //         // Find user by email
    //         $user = $this->findUserByEmail($email);
    //         if ($user) {
    //             $hashedPassword = $user->Password;
    //             if (password_verify($password, $hashedPassword)) {
    //                 return $user;
    //             }
    //         }
    //         return false;
    //     } catch (PDOException $e) {
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     } catch (Exception $e) {
    //         error_log("General Error: " . $e->getMessage());
    //         return false;
    //     }
    // }

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

    // public function getUserDetails($userId)
    // {
    //     try {
    //         $this->db->query('SELECT UserID, Email, Role, Status, ContactNo, RegisterDate FROM User WHERE UserID = :userId');
    //         $this->db->bind(':userId', $userId);
    //         $user = $this->db->single();
    //         if ($user->Role === 'Student') {
    //             $this->db->query('SELECT * FROM Student WHERE StudentID = :userId');
    //             $this->db->bind(':userId', $userId);
    //             $student = $this->db->single();
    //             return array_merge((array)$user, (array)$student);
    //         } else if ($user->Role === 'Company') {
    //             $this->db->query('SELECT * FROM Company WHERE CompanyID = :userId');
    //             $this->db->bind(':userId', $userId);
    //             $company = $this->db->single();
    //             return array_merge((array)$user, (array)$company);
    //         } else if ($user->Role === 'VT-Member') {
    //             $this->db->query('SELECT FirstName, LastName, ProfilePic FROM VerificationTeam WHERE VT_MemberID = :userId');
    //             $this->db->bind(':userId', $userId);
    //             $vtMember = $this->db->single();
    //             return array_merge((array)$user, (array)$vtMember);
    //         } else if ($user->Role === 'Admin') {
    //             $this->db->query('SELECT FirstName, LastName, ProfilePic FROM Admin WHERE AdminID = :userId');
    //             $this->db->bind(':userId', $userId);
    //             $admin = $this->db->single();
    //             return array_merge((array)$user, (array)$admin);
    //         } else {
    //             return false;
    //         }
    //     } catch (PDOException $e) { // Catch database-specific exceptions
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     } catch (Exception $e) {
    //         error_log("General Error: " . $e->getMessage());
    //         return false;
    //     }
    // }

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

    // public function updateProfile($data)
    // {
    //     try {
    //         // Start transaction
    //         $this->db->beginTransaction();

    //         //Update User table
    //         $this->db->query('UPDATE User SET ContactNo = :contactNo WHERE UserID = :userId');
    //         $this->db->bind(':contactNo', $data['contactNo']);
    //         $this->db->bind(':userId', $data['userID']);

    //         //Execute query
    //         if (!$this->db->execute()) {
    //             error_log('Failed to update User table');
    //             $this->db->rollBack();
    //             return false;
    //         }

    //         if ($data['role'] === 'Student') {
    //             //Update Student table
    //             $this->db->query('UPDATE Student SET FirstName = :firstName, LastName = :lastName, StreetNo = :streetNo, AddressLine1 = :addressLine1, AddressLine2 = :addressLine2, City = :city, CV = :cv, ProfilePic = :profilePic WHERE StudentID = :userId');
    //             $this->db->bind(':firstName', $data['firstName']);
    //             $this->db->bind(':lastName', $data['lastName']);
    //             $this->db->bind(':streetNo', $data['streetNo']);
    //             $this->db->bind(':addressLine1', $data['addressLine1']);
    //             $this->db->bind(':addressLine2', $data['addressLine2']);
    //             $this->db->bind(':city', $data['city']);
    //             $this->db->bind(':cv', $data['cvName']);
    //             $this->db->bind(':profilePic', $data['profilePicName']);
    //             $this->db->bind(':userId', $data['userID']);

    //             //Execute query
    //             if (!$this->db->execute()) {
    //                 error_log('Failed to update Student table');
    //                 $this->db->rollBack();
    //                 return false;
    //             }
    //         } else if ($data['role'] === 'Company') {
    //             //Update Company table
    //             $this->db->query('UPDATE Company SET CompanyName = :companyName, StreetNo = :streetNo, AddressLine1 = :addressLine1, AddressLine2 = :addressLine2, City = :city, CompanyLogo = :companyLogo, Description = :description, Website = :website, Industry = :industry WHERE CompanyID = :userId');
    //             $this->db->bind(':companyName', $data['companyName']);
    //             $this->db->bind(':streetNo', $data['streetNo']);
    //             $this->db->bind(':addressLine1', $data['addressLine1']);
    //             $this->db->bind(':addressLine2', $data['addressLine2']);
    //             $this->db->bind(':city', $data['city']);
    //             $this->db->bind(':companyLogo', $data['companyLogoName']);
    //             $this->db->bind(':description', $data['description']);
    //             $this->db->bind(':website', $data['website']);
    //             $this->db->bind(':industry', $data['industry']);
    //             $this->db->bind(':userId', $data['userID']);

    //             //Execute query
    //             if (!$this->db->execute()) {
    //                 error_log('Failed to update Company table');
    //                 $this->db->rollBack();
    //                 return false;
    //             }
    //         } else if ($data['role'] === 'VT-Member') {
    //             //Update VerificationTeam table
    //             $this->db->query('UPDATE VerificationTeam SET FirstName = :firstName, LastName = :lastName WHERE VT_MemberID = :userId');
    //             $this->db->bind(':firstName', $data['firstName']);
    //             $this->db->bind(':lastName', $data['lastName']);
    //             $this->db->bind(':userId', $data['userID']);

    //             //Execute query
    //             if (!$this->db->execute()) {
    //                 error_log('Failed to update VerificationTeam table');
    //                 $this->db->rollBack();
    //                 return false;
    //             }
    //         } else if ($data['role'] === 'Admin') {
    //             //Update Admin table
    //             $this->db->query('UPDATE Admin SET FirstName = :firstName, LastName = :lastName WHERE AdminID = :userId');
    //             $this->db->bind(':firstName', $data['firstName']);
    //             $this->db->bind(':lastName', $data['lastName']);
    //             $this->db->bind(':userId', $data['userID']);

    //             //Execute query
    //             if (!$this->db->execute()) {
    //                 error_log('Failed to update Admin table');
    //                 $this->db->rollBack();
    //                 return false;
    //             }
    //         }

    //         //Commit transaction
    //         $this->db->commit();
    //         return true;
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

    // public function deactivateAccount($userId)
    // {
    //     try {
    //         // Update User table with status and time of deactivation
    //         // $this->db->query('UPDATE User SET Status = "Deactive", DeactivationDate = NOW() WHERE UserID = :userId');
    //         $this->db->query('UPDATE User SET Status = "Deactive" WHERE UserID = :userId');
    //         $this->db->bind(':userId', $userId);
    //         if ($this->db->execute()) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     } catch (PDOException $e) {
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     } catch (Exception $e) {
    //         error_log("General Error: " . $e->getMessage());
    //         return false;
    //     }
    // }

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

    // public function getPendingStudentsAndCompanies()
    // {
    //     try {
    //         $this->db->query('SELECT UserID, Email, Role, RegisterDate, Status FROM User WHERE (Role = "Student" OR Role = "Company") AND Status = "Pending"');
    //         $users = $this->db->resultSet();
    //         return $users;
    //     } catch (PDOException $e) {
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     } catch (Exception $e) {
    //         error_log("General Error: " . $e->getMessage());
    //         return false;
    //     }
    // }

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
    
    // public function getNotVerifiedStudentsAndCompanies()
    // {
    //     try {
    //         $this->db->query('SELECT UserID, Email, Role, RegisterDate, Status FROM User WHERE (Role = "Student" OR Role = "Company") AND Status = "Not Approved"');
    //         $users = $this->db->resultSet();
    //         return $users;
    //     } catch (PDOException $e) {
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     } catch (Exception $e) {
    //         error_log("General Error: " . $e->getMessage());
    //         return false;
    //     }
    // }

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

    // public function approveUser($userId)
    // {
    //     try {
    //         $this->db->query('UPDATE User SET Status = "Active" WHERE UserID = :userId');
    //         $this->db->bind(':userId', $userId);
    //         if ($this->db->execute()) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     } catch (PDOException $e) {
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     } catch (Exception $e) {
    //         error_log("General Error: " . $e->getMessage());
    //         return false;
    //     }
    // }

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

    // public function rejectUser($userId)
    // {
    //     try {
    //         $this->db->query('UPDATE User SET Status = "Not Approved" WHERE UserID = :userId');
    //         $this->db->bind(':userId', $userId);
    //         if ($this->db->execute()) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     } catch (PDOException $e) {
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     } catch (Exception $e) {
    //         error_log("General Error: " . $e->getMessage());
    //         return false;
    //     }
    // }

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

    // public function activateAccount($userId)
    // {
    //     try {//todo: add logs
    //         $this->db->query('UPDATE User SET Status = "Active" WHERE UserID = :userId');
    //         $this->db->bind(':userId', $userId);
    //         if ($this->db->execute()) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     } catch (PDOException $e) {
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     } catch (Exception $e) {
    //         error_log("General Error: " . $e->getMessage());
    //         return false;
    //     }
    // }

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

    // public function getVTMembers()
    // {
    //     try {
    //         $this->db->query('SELECT UserID, Email, ContactNo, RegisterDate, Status FROM User WHERE Role = "VT-Member"');
    //         $users = $this->db->resultSet();
    //         return $users;
    //     } catch (PDOException $e) {
    //         error_log("Database Error: " . $e->getMessage());
    //         return false;
    //     } catch (Exception $e) {
    //         error_log("General Error: " . $e->getMessage());
    //         return false;
    //     }
    // }

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
    
}

