<?php

class ContactModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Validate form input and insert it into the database
    public function sendMessage($data)
    {
        // Validation
        if (empty($data['email']) || empty($data['topic']) || empty($data['message'])) {
            return false;
        }

        if (!isset($_SESSION['user_email'])) {
            return false; // Return false if the email session is not set
        }

        // Fetch all admin IDs from the Admin table
        $this->db->query("SELECT AdminID FROM Admin");
        $admins = $this->db->resultSet();

        // Check if there are admins
        if (empty($admins)) {
            return false; // No admins found
        }

        // Insert a message for each admin
        foreach ($admins as $admin) {
            $this->db->query("INSERT INTO messages (user_email, topic, message, sender_id, receiver_id) 
                            VALUES (:email, :topic, :message, :sender_id, :receiver_id)");

            // Bind parameters
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':topic', $data['topic']);
            $this->db->bind(':message', $data['message']);
            $this->db->bind(':sender_id', $_SESSION['user_id']);
            $this->db->bind(':receiver_id', $admin->AdminID); // Set receiver_id as admin's ID

            // Execute query
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getMessagesAll()
    {
        $sql = "SELECT m1.*
                FROM messages_with_roles m1
                INNER JOIN (
                    SELECT sender_id, MAX(created_at) AS latest_time
                    FROM messages_with_roles
                    WHERE sender_role != 'Admin'
                    GROUP BY sender_id
                ) m2 ON m1.sender_id = m2.sender_id AND m1.created_at = m2.latest_time
                WHERE m1.sender_role != 'Admin'
                ORDER BY m1.created_at DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getMessagesStu()
    {
        $sql = "SELECT m1.*
                FROM messages_with_roles m1
                INNER JOIN (
                    SELECT 
                        CASE 
                            WHEN sender_role = 'Student' THEN sender_id
                            WHEN receiver_role = 'Student' THEN receiver_id
                        END AS student_id,
                        MAX(created_at) AS latest_time
                    FROM messages_with_roles
                    WHERE (sender_role = 'Student' AND receiver_role = 'Admin') 
                    OR (sender_role = 'Admin' AND receiver_role = 'Student')
                    GROUP BY 
                        CASE 
                            WHEN sender_role = 'Student' THEN sender_id
                            WHEN receiver_role = 'Student' THEN receiver_id
                        END
                ) m2 
                ON (m1.sender_id = m2.student_id OR m1.receiver_id = m2.student_id) 
                AND m1.created_at = m2.latest_time
                WHERE m1.sender_role = 'Student' OR m1.receiver_role = 'Student'
                ORDER BY m1.created_at DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getMessagesCom()
    {
        $sql = "SELECT m1.*
                FROM messages_with_roles m1
                INNER JOIN (
                    SELECT 
                        CASE 
                            WHEN sender_role = 'Company' THEN sender_id
                            WHEN receiver_role = 'Company' THEN receiver_id
                        END AS company_id,
                        MAX(created_at) AS latest_time
                    FROM messages_with_roles
                    WHERE (sender_role = 'Company' AND receiver_role = 'Admin') 
                    OR (sender_role = 'Admin' AND receiver_role = 'Company')
                    GROUP BY 
                        CASE 
                            WHEN sender_role = 'Company' THEN sender_id
                            WHEN receiver_role = 'Company' THEN receiver_id
                        END
                ) m2 
                ON (m1.sender_id = m2.company_id OR m1.receiver_id = m2.company_id) 
                AND m1.created_at = m2.latest_time
                WHERE m1.sender_role = 'Company' OR m1.receiver_role = 'Company'
                ORDER BY m1.created_at DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getMessagesVer()
    {
        $sql = "SELECT m1.*
                FROM messages_with_roles m1
                INNER JOIN (
                    SELECT 
                        CASE 
                            WHEN sender_role = 'VT-Member' THEN sender_id
                            WHEN receiver_role = 'VT-Member' THEN receiver_id
                        END AS vt_member_id,
                        MAX(created_at) AS latest_time
                    FROM messages_with_roles
                    WHERE (sender_role = 'VT-Member' AND receiver_role = 'Admin') 
                    OR (sender_role = 'Admin' AND receiver_role = 'VT-Member')
                    GROUP BY 
                        CASE 
                            WHEN sender_role = 'VT-Member' THEN sender_id
                            WHEN receiver_role = 'VT-Member' THEN receiver_id
                        END
                ) m2 
                ON (m1.sender_id = m2.vt_member_id OR m1.receiver_id = m2.vt_member_id) 
                AND m1.created_at = m2.latest_time
                WHERE m1.sender_role = 'VT-Member' OR m1.receiver_role = 'VT-Member'
                ORDER BY m1.created_at DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getMessagesAdmin()
    {
        $sql = "SELECT m1.*
                FROM messages_with_roles m1
                INNER JOIN (
                    SELECT 
                        CASE 
                            WHEN sender_role = 'Admin' THEN sender_id
                            WHEN receiver_role = 'Admin' THEN receiver_id
                        END AS admin_id,
                        MAX(created_at) AS latest_time
                    FROM messages_with_roles
                    WHERE (sender_role = 'Admin' AND receiver_role = 'VT-Member') 
                    OR (sender_role = 'VT-Member' AND receiver_role = 'Admin')
                    GROUP BY 
                        CASE 
                            WHEN sender_role = 'Admin' THEN sender_id
                            WHEN receiver_role = 'Admin' THEN receiver_id
                        END
                ) m2 
                ON (m1.sender_id = m2.admin_id OR m1.receiver_id = m2.admin_id) 
                AND m1.created_at = m2.latest_time
                WHERE m1.sender_role = 'Admin' OR m1.receiver_role = 'Admin'
                ORDER BY m1.created_at DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function updateReadStatus($id)
    {
        $this->db->query("UPDATE contact_messages SET read_status = 1 WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getMessagesStuCom()
    {
        $sql = "SELECT m1.*
                FROM messages_with_roles m1
                INNER JOIN (
                    SELECT 
                        CASE 
                            WHEN sender_role = 'Student' THEN sender_id
                            WHEN receiver_role = 'Student' THEN receiver_id
                        END AS student_id,
                        MAX(created_at) AS latest_time
                    FROM messages_with_roles
                    WHERE (sender_role = 'Student' AND receiver_role = 'Company') 
                    OR (sender_role = 'Company' AND receiver_role = 'Student')
                    GROUP BY 
                        CASE 
                            WHEN sender_role = 'Student' THEN sender_id
                            WHEN receiver_role = 'Student' THEN receiver_id
                        END
                ) m2 
                ON (m1.sender_id = m2.student_id OR m1.receiver_id = m2.student_id) 
                AND m1.created_at = m2.latest_time
                WHERE m1.sender_role = 'Student' OR m1.receiver_role = 'Student'
                ORDER BY m1.created_at DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getMessagesAddCom()
    {
        $sql = "SELECT m1.*
                FROM messages_with_roles m1
                INNER JOIN (
                    SELECT 
                        CASE 
                            WHEN sender_role = 'Admin' THEN sender_id
                            WHEN receiver_role = 'Admin' THEN receiver_id
                        END AS company_id,
                        MAX(created_at) AS latest_time
                    FROM messages_with_roles
                    WHERE (sender_role = 'Admin' AND receiver_role = 'Company') 
                    OR (sender_role = 'Company' AND receiver_role = 'Admin')
                    GROUP BY 
                        CASE 
                            WHEN sender_role = 'Admin' THEN sender_id
                            WHEN receiver_role = 'Admin' THEN receiver_id
                        END
                ) m2 
                ON (m1.sender_id = m2.company_id OR m1.receiver_id = m2.company_id) 
                AND m1.created_at = m2.latest_time
                WHERE m1.sender_role = 'Admin' OR m1.receiver_role = 'Admin'
                ORDER BY m1.created_at DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getMessagesVerAdm()
    {
        $sql = "SELECT m1.*
                FROM messages_with_roles m1
                INNER JOIN (
                    SELECT 
                        CASE 
                            WHEN sender_role = 'VT-Member' THEN sender_id
                            WHEN receiver_role = 'VT-Member' THEN receiver_id
                        END AS admin_id,
                        MAX(created_at) AS latest_time
                    FROM messages_with_roles
                    WHERE (sender_role = 'VT-Member' AND receiver_role = 'Admin') 
                    OR (sender_role = 'Admin' AND receiver_role = 'VT-Member')
                    GROUP BY 
                        CASE 
                            WHEN sender_role = 'VT-Member' THEN sender_id
                            WHEN receiver_role = 'VT-Member' THEN receiver_id
                        END
                ) m2 
                ON (m1.sender_id = m2.admin_id OR m1.receiver_id = m2.admin_id) 
                AND m1.created_at = m2.latest_time
                WHERE m1.sender_role = 'VT-Member' OR m1.receiver_role = 'VT-Member'
                ORDER BY m1.created_at DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

}