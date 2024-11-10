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
            $this->db->query('INSERT INTO review (Rating, Comment, student_id, company_id) VALUES (:rating, :comment, :student_id, :company_id)');
            $this->db->bind(':rating', $data['rating']);
            $this->db->bind(':comment', $data['comment']);
            $this->db->bind(':student_id', $_SESSION['student_id']);
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
}
?>
