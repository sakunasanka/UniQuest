<?php
class NotificationModel extends Model {

    public function create($userId, $type, $title, $message, $relatedUrl = null) {
        $this->db->query('INSERT INTO notifications (UserID, type, title, message, related_url) 
                        VALUES (:user_id, :type, :title, :message, :related_url)');
        
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':type', $type);
        $this->db->bind(':title', $title);
        $this->db->bind(':message', $message);
        $this->db->bind(':related_url', $relatedUrl);
        
        return $this->db->execute();
    }

    public function getAllNotifications($userId) {
        $this->db->query('SELECT * FROM notifications 
                         WHERE UserID = :user_id 
                         ORDER BY created_at DESC');
        
        $this->db->bind(':user_id', $userId);
        
        return $this->db->resultSet();
    }

    public function getUnreadCount($userId) {
        $this->db->query('SELECT COUNT(*) as count FROM notifications 
                         WHERE UserID = :user_id AND is_read = 0 AND created_at <= NOW()');
        $this->db->bind(':user_id', $userId);
        $result = $this->db->single();
        return $result->count;
    }

    public function markAsRead($notificationId) {
        $this->db->query('UPDATE notifications SET is_read = 1 
                         WHERE id = :id');
        $this->db->bind(':id', $notificationId);
        return $this->db->execute();
    }

    public function markAllAsRead($userId) {
        $this->db->query('UPDATE notifications SET is_read = 1 
                         WHERE UserID = :user_id AND is_read = 0 AND created_at <= NOW()');
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }

    public function getRecentNotifications($userId, $limit = 5) {
        $this->db->query('SELECT * FROM notifications 
                         WHERE UserID = :user_id AND created_at <= NOW()
                         ORDER BY created_at DESC 
                         LIMIT :limit');
        
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        
        return $this->db->resultSet();
    }
    
}