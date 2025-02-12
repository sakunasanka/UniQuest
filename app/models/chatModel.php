<?php

class chatModel
{
    private $db;

    public function __construct() {
        $this->db = new Database::getInstance();
    }

    // Fetch chat messages between two users
    public function getMessages($sender_id, $receiver_id) {
        $sql = "SELECT * FROM chats WHERE 
                (sender_id = :sender_id AND receiver_id = :receiver_id)
                OR (sender_id = :receiver_id AND receiver_id = :sender_id)
                ORDER BY sent_at ASC";
        $this->db->query($sql);
        $this->db->bind(':sender_id', $sender_id);
        $this->db->bind(':receiver_id', $receiver_id);
        return $this->db->resultSet();
    }

    // Save a new message
    public function sendMessage($sender_role, $sender_id, $receiver_id, $message) {
        $sql = "INSERT INTO chats (sender_role, sender_id, receiver_id, message) 
                VALUES (:sender_role, :sender_id, :receiver_id, :message)";
        $this->db->query($sql);
        $this->db->bind(':sender_role', $sender_role);
        $this->db->bind(':sender_id', $sender_id);
        $this->db->bind(':receiver_id', $receiver_id);
        $this->db->bind(':message', $message);
        return $this->db->execute();
    }
}
