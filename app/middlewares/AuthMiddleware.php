<?php
class AuthMiddleware {
    public static function requireAuth() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login page
            Redirect::to(URLROOT . '/user/login');
            exit;
        }
    }

    public static function requireRole($role) {
        // Check if user is logged in
        self::requireAuth();

        // Check if user has the required role
        if ($_SESSION['user_role'] !== $role) {
            // Redirect to error page
            // Redirect::to('/');//todo: redirect to error page
            die('Unauthorized access');
            exit;
        }
    }
}

?>