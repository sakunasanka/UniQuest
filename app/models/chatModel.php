<?php
class ChatModel extends Model {

    // Fetch chat messages between two users
    public function getMessagesForAdmin($sender_id, $receiver_id) {
        $sql = "SELECT * FROM messages_with_roles WHERE 
            (sender_id = :sender_id AND receiver_id = :receiver_id)
            OR 
            (sender_id = :receiver_id AND receiver_id = :sender_id)
            ORDER BY created_at ASC";
        $this->db->query($sql);
        $this->db->bind(':sender_id', $sender_id);
        $this->db->bind(':receiver_id', $receiver_id);
        return $this->db->resultSet();
    }

    // Save a new message
    public function sendMessage($email, $sender_id, $receiver_id, $topic, $message) {
        $sql = "INSERT INTO messages (user_email, sender_id, receiver_id, topic, message) 
                VALUES (:email, :sender_id, :receiver_id, :topic, :message)";
        $this->db->query($sql);
        $this->db->bind(':email', $email);
        $this->db->bind(':sender_id', $sender_id);
        $this->db->bind(':receiver_id', $receiver_id);
        $this->db->bind(':topic', $topic);
        $this->db->bind(':message', $message);
        return $this->db->execute();
    }

    public function getLastMessageBetween($sender_id, $receiver_id) {
        $sql = "SELECT topic, user_email FROM messages 
                WHERE (sender_id = :sender_id AND receiver_id = :receiver_id)
                OR (sender_id = :receiver_id AND receiver_id = :sender_id)
                ORDER BY created_at DESC LIMIT 1";
        $this->db->query($sql);
        $this->db->bind(':sender_id', $sender_id);
        $this->db->bind(':receiver_id', $receiver_id);
        return $this->db->single(); 
    }

    public function canEditMessage($messageId, $senderId) {
        $sql = "SELECT created_at FROM messages WHERE id = :messageId AND sender_id = :senderId";
        $this->db->query($sql);
        $this->db->bind(':messageId', $messageId);
        $this->db->bind(':senderId', $senderId);
        $message = $this->db->single();

        if ($message) {
            $createdAt = strtotime($message->created_at);
            $currentTime = time();
            $timeDifference = $currentTime - $createdAt;

            // Allow editing within 10 minutes (600 seconds)
            return $timeDifference <= 600;
        }

        return false;
    }

    public function canDeleteMessage($messageId, $senderId) {
        $sql = "SELECT created_at FROM messages WHERE id = :messageId AND sender_id = :senderId";
        $this->db->query($sql);
        $this->db->bind(':messageId', $messageId);
        $this->db->bind(':senderId', $senderId);
        $message = $this->db->single();

        if ($message) {
            $createdAt = strtotime($message->created_at);
            $currentTime = time();
            $timeDifference = $currentTime - $createdAt;

            // Allow deleting within 1 hour (3600 seconds)
            return $timeDifference <= 3600;
        }

        return false;
    }

    public function editMessage($messageId, $newMessage, $senderId) {
        $sql = "UPDATE messages SET message = :newMessage WHERE id = :messageId AND sender_id = :senderId";
        $this->db->query($sql);
        $this->db->bind(':newMessage', $newMessage);
        $this->db->bind(':messageId', $messageId);
        $this->db->bind(':senderId', $senderId);
        return $this->db->execute();
    }

    public function deleteMessage($messageId,$senderId) {
        $sql = "DELETE FROM messages WHERE id = :messageId AND sender_id = :senderId";
        $this->db->query($sql);
        $this->db->bind(':messageId', $messageId);
        $this->db->bind(':senderId', $senderId);
        return $this->db->execute();
    }
    
}
?>