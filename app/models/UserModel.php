<?php
class userModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findUserByEmail($email) 
    {
        try {
            if (!$this->db) {
                throw new Exception("Database connection is not established.");
            }
            $this->db->query('SELECT * FROM User WHERE Email = :email');
            $this->db->bind(':email', $email);
            $user = $this->db->single();
            if ($user) {
                return $user;
            } else {
                return false;
            }
        } catch (PDOException $e) { // Catch database-specific exceptions
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function companyRegister(array $data)
    {
        try{
            // Start transaction
            $this->db->beginTransaction();

            //Insert into User table
            $this->db->query('INSERT INTO user (Password, Email, Role, RegisterDate, ContactNo, Status) VALUES ( :password, :email, :role, :registerDate, :contactNo, :status)');
            $this->db->bind(':password', $data['password']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':role', $data['role']);
            $this->db->bind(':registerDate', $data['date']);
            $this->db->bind(':contactNo', $data['contactNo']);
            $this->db->bind(':status', $data['status']);

            //Execute query
            if (!$this->db->execute()) {
                error_log('Failed to insert into User table');
                $this->db->rollBack();
                return false;
            }

            //Get the last inserted user id
            $userId = $this->db->lastInsertId();

            //Insert into Company table
            $this->db->query('INSERT INTO Company (CompanyID, CompanyName, Description, CompanyLogo, StreetNo, AddressLine1, AddressLine2, City) VALUES (:companyID, :companyName, :description, :companyLogo, :streetNo, :addressLine1, :addressLine2, :city)');
            $this->db->bind(':companyID', $userId);
            $this->db->bind(':companyName', $data['companyName']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':companyLogo', $data['companyLogoName']);
            $this->db->bind(':streetNo', $data['streetNo']);
            $this->db->bind(':addressLine1', $data['addressLine1']);
            $this->db->bind(':addressLine2', $data['addressLine2']);
            $this->db->bind(':city', $data['city']);

            //Execute query
            if (!$this->db->execute()) {
                error_log('Failed to insert into Company table');
                $this->db->rollBack();
                return false;
            }

            //Commit transaction
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
        try{
            // Start transaction
            $this->db->beginTransaction();

            //Insert into User table
            $this->db->query('INSERT INTO user (Password, Email, Role, RegisterDate, ContactNo, Status) VALUES ( :password, :email, :role, :registerDate, :contactNo, :status)');
            $this->db->bind(':password', $data['password']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':role', $data['role']);
            $this->db->bind(':registerDate', $data['date']);
            $this->db->bind(':contactNo', $data['contactNo']);
            $this->db->bind(':status', $data['status']);

            //Execute query
            if (!$this->db->execute()) {
                error_log('Failed to insert into User table');
                $this->db->rollBack();
                return false;
            }

            //Get the last inserted user id
            $userId = $this->db->lastInsertId();

            //Insert into Student table
            $this->db->query('INSERT INTO Student (StudentID, FirstName, LastName, ProfilePic, Gender, DOB, NIC_No, NIC_Copy, CV, StreetNo, AddressLine1, AddressLine2, City, University, UniversityID, UniversityID_Copy) VALUES (:studentID, :firstName, :lastName, :profilePic, :gender, :dob, :nicNo, :nicCopy, :cv, :streetNo, :addressLine1, :addressLine2, :city, :university, :universityID, :universityIDCopy)');
            $this->db->bind(':studentID', $userId);
            $this->db->bind(':firstName', $data['firstName']);
            $this->db->bind(':lastName', $data['lastName']);
            $this->db->bind(':profilePic', $data['profilePicName']);
            $this->db->bind(':gender', $data['gender']);
            $this->db->bind(':dob', $data['dob']);
            $this->db->bind(':nicNo', $data['nicNo']);
            $this->db->bind(':nicCopy', $data['nicCopyName']);
            $this->db->bind(':cv', $data['cvName']);
            $this->db->bind(':streetNo', $data['streetNo']);
            $this->db->bind(':addressLine1', $data['addressLine1']);
            $this->db->bind(':addressLine2', $data['addressLine2']);
            $this->db->bind(':city', $data['city']);
            $this->db->bind(':university', $data['university']);
            $this->db->bind(':universityID', $data['universityID']);
            $this->db->bind(':universityIDCopy', $data['universityIDCopyName']);

            //Execute query
            if (!$this->db->execute()) {
                error_log('Failed to insert into Student table');
                $this->db->rollBack();
                return false;
            }

            //Commit transaction
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

    public function vtMemberRegister(array $data)
    {
        try{
            // Start transaction
            $this->db->beginTransaction();

            //Insert into User table
            $this->db->query('INSERT INTO user (Password, Email, Role, RegisterDate, ContactNo, Status) VALUES ( :password, :email, :role, :registerDate, :contactNo, :status)');
            $this->db->bind(':password', $data['password']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':role', $data['role']);
            $this->db->bind(':registerDate', $data['date']);
            $this->db->bind(':contactNo', $data['contactNo']);
            $this->db->bind(':status', $data['status']);

            //Execute query
            if (!$this->db->execute()) {
                error_log('Failed to insert into User table');
                $this->db->rollBack();
                return false;
            }

            //Get the last inserted user id
            $userId = $this->db->lastInsertId();

            //Insert into verification team table
            $this->db->query('INSERT INTO VerificationTeam (VT_MemberID, FirstName, LastName, ProfilePic) VALUES (:vtMemberID, :firstName, :lastName, :profilePic)');
            $this->db->bind(':vtMemberID', $userId);
            $this->db->bind(':firstName', $data['firstName']);
            $this->db->bind(':lastName', $data['lastName']);
            $this->db->bind(':profilePic', $data['profilePicName']);
            
            //Execute query
            if (!$this->db->execute()) {
                error_log('Failed to insert into verification team table');
                $this->db->rollBack();
                return false;
            }

            //Commit transaction
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
            // Find user by email
            $user = $this->findUserByEmail($email);
            if ($user) {
                $hashedPassword = $user->Password;
                if (password_verify($password, $hashedPassword)) {
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

    public function getSessionDetails($userId)
    {
        try {
            $this->db->query('SELECT UserID, Email, Role, Status FROM User WHERE UserID = :userId');
            $this->db->bind(':userId', $userId);
            $user = $this->db->single();
            if ($user-> Role === 'Student') {
                $this->db->query('SELECT FirstName, LastName, ProfilePic FROM Student WHERE StudentID = :userId');
                $this->db->bind(':userId', $userId);
                $student = $this->db->single();
                return array_merge((array)$user, (array)$student);
            } else if ($user-> Role === 'Company') {
                $this->db->query('SELECT CompanyName, CompanyLogo FROM Company WHERE CompanyID = :userId');
                $this->db->bind(':userId', $userId);
                $company = $this->db->single();
                return array_merge((array)$user, (array)$company);
            } else if ($user-> Role === 'VT-Member') {
                $this->db->query('SELECT FirstName, LastName, ProfilePic FROM VerificationTeam WHERE VT_MemberID = :userId');
                $this->db->bind(':userId', $userId);
                $vtMember = $this->db->single();
                return array_merge((array)$user, (array)$vtMember);
            } else if ($user-> Role === 'Admin') {
                $this->db->query('SELECT FirstName, LastName, ProfilePic FROM Admin WHERE AdminID = :userId');
                $this->db->bind(':userId', $userId);
                $admin = $this->db->single();
                return array_merge((array)$user, (array)$admin);
            } else {
                return false;
            }
        } catch (PDOException $e) { // Catch database-specific exceptions
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }
}
?>