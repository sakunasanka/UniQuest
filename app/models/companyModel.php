<?php
class companyModel extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getCompanyInfo() 
    {
        $this->db->query("SELECT * FROM company WHERE CompanyID = :companyId");

        $this->db->bind(':companyId', $_SESSION['user_id']);
        return $this->db->single();
    }
    
    public function addUserPostBookmark($companyId)
    {
        try {

            // Prepare the query to insert the bookmark into the database
            $this->db->query("INSERT IGNORE INTO BookmarkCompanies (studentId, companyId) VALUES(:studentId, :companyId)");

            // Bind the parameters to the query
            $this->db->bind(':studentId', $_SESSION['user_id']);
            $this->db->bind(':companyId', $companyId);
            // Execute the query and check if the bookmark was successfully added
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Catch any database errors and log them
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            // Catch any general errors and log them
            error_log("Error: " . $e->getMessage());
            return false;
        }
    }

    // Method to check if a company is bookmarked by the user
    public function isCompanyBookmarked($companyId)
    {
        $this->db->query("SELECT COUNT(*) AS count FROM BookmarkCompanies WHERE studentId = :studentId AND companyId = :companyId");
        $this->db->bind(':studentId', $_SESSION['user_id']);
        $this->db->bind(':companyId', $companyId);
        $row = $this->db->single();
        return $row->count > 0;
    }

    //Method to get bookmarked companies
    public function getBookmarkedCompanies($studentId)
    {
        // Fetch only the IDs of bookmarked companies for the user
        $this->db->query("SELECT * FROM v_bookmarkedCompanies WHERE studentId = :studentId");
        $this->db->bind(':studentId', $studentId);
        return $this->db->resultSet();
    }

    //Method to remove a bookmark from the database
    public function removeBookmark($companyId)
    {
        $this->db->query("DELETE FROM bookmarkCompanies WHERE studentId = :studentId AND companyId = :companyId");
        $this->db->bind(':studentId', $_SESSION['user_id']);
        $this->db->bind(':companyId', $companyId);
        return $this->db->execute();
    }
    
    public function storePendingPayment($user_id, $order_id, $plan, $amount) {
        try {
            $this->db->query('INSERT INTO pending_payments 
                             (user_id, order_id, plan, amount, created_at)
                             VALUES (:user_id, :order_id, :plan, :amount, NOW())');
            
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':order_id', $order_id);
            $this->db->bind(':plan', $plan);
            $this->db->bind(':amount', $amount);
            
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Database error in storePendingPayment: " . $e->getMessage());
            return false;
        }
    }

    public function getPendingPayment($order_id) {
        try {
            $this->db->query('SELECT * FROM pending_payments WHERE order_id = :order_id LIMIT 1');
            $this->db->bind(':order_id', $order_id);
            return $this->db->single();
        } catch (Exception $e) {
            error_log("Database error in getPendingPayment: " . $e->getMessage());
            return false;
        }
    }

    public function clearPendingPayment($order_id) {
        try {
            $this->db->query('DELETE FROM pending_payments WHERE order_id = :order_id');
            $this->db->bind(':order_id', $order_id);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Database error in clearPendingPayment: " . $e->getMessage());
            return false;
        }
    }

    public function updateSubscription($user_id, $plan, $start_date, $end_date, $status) {
        try {
            $this->db->beginTransaction();
            
            // Update subscription
            $this->db->query('UPDATE company 
                             SET subscription_plan = :plan,
                                 subscription_start_date = :start_date,
                                 subscription_end_date = :end_date,
                                 subscription_status = :status
                             WHERE CompanyID = :user_id');
            
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':plan', $plan);
            $this->db->bind(':start_date', $start_date);
            $this->db->bind(':end_date', $end_date);
            $this->db->bind(':status', $status);
            
            if (!$this->db->execute()) {
                throw new Exception("Failed to update subscription");
            }
            
            // Add notifications
            $this->addSubscriptionNotification(
                $user_id,
                'Subscription Expiry Warning',
                'Your subscription plan will expire in 2 days.',
                date('Y-m-d H:i:s', strtotime($end_date . ' -2 days'))
            );
            
            $this->addSubscriptionNotification(
                $user_id,
                'Subscription Expiry Warning',
                'Your subscription plan will expire in 1 day.',
                date('Y-m-d H:i:s', strtotime($end_date . ' -1 day'))
            );
            
            $this->addSubscriptionNotification(
                $user_id,
                'Subscription Expiry Warning',
                'Your subscription plan has expired.',
                $end_date
            );
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Database error in updateSubscription: " . $e->getMessage());
            return false;
        }
    }
    
    private function addSubscriptionNotification($user_id, $title, $message, $date) {
        $this->db->query('INSERT INTO notifications (UserID, type, title, message, created_at) 
              VALUES (:user_id, "Warning", :title, :message, :date)');
        
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':title', $title);
        $this->db->bind(':message', $message);
        $this->db->bind(':date', $date);
        
        if (!$this->db->execute()) {
            throw new Exception("Failed to create notification");
        }
    }

    public function storePaymentSuccess($user_id, $order_id, $payment_id, $plan, $amount) {
        try {
            $this->db->query('INSERT INTO payments 
                             (user_id, order_id, payment_id, plan, amount, currency, payment_date, status)
                             VALUES (:user_id, :order_id, :payment_id, :plan, :amount, "LKR", NOW(), "completed")');
            
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':order_id', $order_id);
            $this->db->bind(':payment_id', $payment_id);
            $this->db->bind(':plan', $plan);
            $this->db->bind(':amount', $amount);
            
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Database error in storePaymentSuccess: " . $e->getMessage());
            return false;
        }
    }

    public function getPaymentByOrderId($order_id) {
        try {
            $this->db->query('SELECT * FROM payments WHERE order_id = :order_id LIMIT 1');
            $this->db->bind(':order_id', $order_id);
            return $this->db->single();
        } catch (Exception $e) {
            error_log("Database error in getPaymentByOrderId: " . $e->getMessage());
            return false;
        }
    }

    public function getSubscriptionPlan($user_id) {
        try {
            $this->db->query('SELECT subscription_plan FROM company WHERE CompanyID = :user_id LIMIT 1');
            $this->db->bind(':user_id', $user_id);
            $result = $this->db->single();
            return $result ? $result->subscription_plan : null;
        } catch (Exception $e) {
            error_log("Database error in getSubscriptionPlan: " . $e->getMessage());
            return false;
        }
    }
}
