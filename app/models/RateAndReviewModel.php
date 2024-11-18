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
            $this->db->bind(':company_id', 10040); 

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

    public function getReviewsByCompanyId($company_id)
    {
        $this->db->query('SELECT * FROM review WHERE company_id = :company_id ORDER BY created_at DESC');
        $this->db->bind(':company_id', $company_id);
        return $this->db->resultSet();
    }
    
    public function updateReview($data)
    {
        try {
            $this->db->query('UPDATE review SET Rating = :rating, Comment = :comment WHERE id = :id AND user_id = :user_id');
            $this->db->bind(':rating', $data['rating']);
            $this->db->bind(':comment', $data['comment']);
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':user_id', $_SESSION['user_id']);
            
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

    public function getReviewById($id)
    {
        $this->db->query('SELECT * FROM review WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function deleteReviewById($id)
    {
        try {
            $this->db->query('DELETE FROM review WHERE id = :id AND user_id = :user_id');
            $this->db->bind(':id', $id);
            $this->db->bind(':user_id', $_SESSION['user_id']); // Ensure only the review's owner can delete it

            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

}
?>
