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
                    SELECT sender_id, MAX(created_at) AS latest_time
                    FROM messages_with_roles
                    WHERE sender_role = 'Student'
                    GROUP BY sender_id
                ) m2 ON m1.sender_id = m2.sender_id AND m1.created_at = m2.latest_time
                WHERE m1.sender_role = 'Student'
                ORDER BY m1.created_at DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getMessagesCom()
    {
        $sql = "SELECT m1.*
                FROM messages_with_roles m1
                INNER JOIN (
                    SELECT sender_id, MAX(created_at) AS latest_time
                    FROM messages_with_roles
                    WHERE sender_role = 'Company'
                    GROUP BY sender_id
                ) m2 ON m1.sender_id = m2.sender_id AND m1.created_at = m2.latest_time
                WHERE m1.sender_role = 'Company'
                ORDER BY m1.created_at DESC";

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getMessagesVer()
    {
        $sql = "SELECT m1.*
                FROM messages_with_roles m1
                INNER JOIN (
                    SELECT sender_id, MAX(created_at) AS latest_time
                    FROM messages_with_roles
                    WHERE sender_role = 'VT-Member'
                    GROUP BY sender_id
                ) m2 ON m1.sender_id = m2.sender_id AND m1.created_at = m2.latest_time
                WHERE m1.sender_role = 'VT-Member'
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

    // In MessageModel.php
    public function getMessageById($id) {
        $sql = "SELECT id, topic, email, name, created_at, message FROM messages WHERE id = :id LIMIT 1";
        $this->db->query($sql);
        $this->db->bind(':id', $id);

        return $this->db->single(); // Fetch single result
    }

}