<?php
class NotificationsController extends Controller {
    private $notificationModel;

    public function __construct() {
        $this->notificationModel = $this->model('NotificationModel');
    }

    // AJAX endpoint for dropdown
    public function getRecent() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false]);
            return;
        }

        $notifications = $this->notificationModel->getByUser($_SESSION['user_id']);
        $unreadCount = $this->notificationModel->getUnreadCount($_SESSION['user_id']);
        
        echo json_encode([
            'success' => true,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ]);
    }

    // AJAX endpoint for mark as read
    public function markRead($id) {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false]);
            return;
        }

        $success = $this->notificationModel->markAsRead($id);
        $unreadCount = $this->notificationModel->getUnreadCount($_SESSION['user_id']);
        
        echo json_encode([
            'success' => $success,
            'unreadCount' => $unreadCount
        ]);
    }

    // Mark all as read
    public function markAllRead() {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        $this->notificationModel->markAllAsRead($_SESSION['user_id']);
        redirect('student/notifications');
    }

    // Full notifications page
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        $notifications = $this->notificationModel->getByUser($_SESSION['user_id'], 20);
        $unreadCount = $this->notificationModel->getUnreadCount($_SESSION['user_id']);
        
        $data = [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ];

        $this->view('student/notifications/index', $data);
    }
}