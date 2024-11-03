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
            $this->db->query('INSERT INTO Company (CompanyID, CompanyName, Description, ProfilePic, StreetNo, AddressLine1, AddressLine2, City) VALUES (:companyID, :companyName, :description, :profilePic, :streetNo, :addressLine1, :addressLine2, :city)');
            $this->db->bind(':companyID', $userId);
            $this->db->bind(':companyName', $data['companyName']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':profilePic', $data['profilePic']);
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


}
?>