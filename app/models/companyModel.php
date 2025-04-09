<?php
class companyModel extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
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
    
public function updateSubscription($user_id, $plan, $start_date, $end_date, $status)
{
    try {
        $this->db->query('UPDATE company 
                         SET subscription_plan = :plan, 
                             subscription_start_date = :start_date, 
                             subscription_end_date = :end_date, 
                             subscription_status = :status 
                         WHERE user_id = :user_id');
        
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':plan', $plan);
        $this->db->bind(':start_date', $start_date);
        $this->db->bind(':end_date', $end_date);
        $this->db->bind(':status', $status);
        
        return $this->db->execute();
    } catch (Exception $e) {
        error_log("Database error: " . $e->getMessage());
        return false;
    }

}
}
