<?php
class RateAndReviewModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function addReview(array $data)
    {
        try {
            // Start transaction
            $this->db->beginTransaction();

            // Insert review into the Review table
            $this->db->query('INSERT INTO Review (Rating, Comment, StudentID, CompanyID) VALUES (:rating, :comment, :user_id, :company_id)');
            $this->db->bind(':rating', $data['rating']);
            $this->db->bind(':comment', $data['comment']);
            $this->db->bind(':user_id', $_SESSION['user_id']);
            $this->db->bind(':company_id', $data['company_id']); 

            // Execute query
            if (!$this->db->execute()) {
                error_log('Failed to insert into Review table');
                $this->db->rollBack();
                return false;
            }

            // Commit transaction
            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            $this->db->rollBack(); // Rollback on exception
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            $this->db->rollBack(); // Rollback on exception
            return false;
        }
    }

    public function getReviewsByCompanyId()
    {
        $this->db->query('SELECT * FROM companyreviews WHERE CompanyID = :company_id ORDER BY created_at DESC');
        $this->db->bind(':company_id', $_SESSION['user_id']);
        return $this->db->resultSet();
    }

    public function getReviewsByStuId()
    {
        $this->db->query('SELECT * FROM companyreviews WHERE StudentID = :student_id ORDER BY created_at DESC');
        $this->db->bind(':student_id', $_SESSION['user_id']);
        return $this->db->resultSet();
    }

    public function getReviewById($reviewID){
        $this->db->query('SELECT * FROM review WHERE ReviewID = :review_id');
        $this->db->bind(':review_id', $reviewID);
        return $this->db->single();
    }
    
    public function updateReview($data)
    {
        try {
            $this->db->query('UPDATE review SET Rating = :rating, Comment = :comment WHERE ReviewID = :id');
            $this->db->bind(':rating', $data['rating']);
            $this->db->bind(':comment', $data['comment']);
            $this->db->bind(':id', $data['review_id']);
            // $this->db->bind(':user_id', $_SESSION['user_id']);
            
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteReviewById($id)
    {
        try {
            $this->db->query('DELETE FROM review WHERE ReviewID = :id');
            $this->db->bind(':id', $id);
            // $this->db->bind(':user_id', $_SESSION['user_id']); // Ensure only the review's owner can delete it

            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

}
?>