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
        if (empty($data['name']) || empty($data['email']) || empty($data['topic']) || empty($data['message'])) {
            return false;
        }

        $this->db->query("INSERT INTO contact_messages (name, email, topic, message) 
                          VALUES (:name, :email, :topic, :message)");

        // Bind parameters
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':topic', $data['topic']);
        $this->db->bind(':message', $data['message']);

        // Execute query
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getMessages()
    {
        $this->db->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
        $results = $this->db->resultSet();
        return $results;
    }

    public function updateReadStatus($id)
    {
        $this->db->query("UPDATE contact_messages SET read_status = 1 WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

}
