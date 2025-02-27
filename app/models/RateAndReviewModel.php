<?php
class RateAndReviewModel
{
    private $db;
    private $anonymousNames;

    public function __construct()
    {
        $this->db = Database::getInstance();
        // Load anonymous names from the JSON file
        $anonymousNamesPath = 'anonymousNames.json'; 
        if (!file_exists($anonymousNamesPath)) {
            throw new Exception("Anonymous names file not found.");
        }
        $this->anonymousNames = json_decode(file_get_contents($anonymousNamesPath), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Failed to decode anonymous names JSON.");
        }
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

    public function getReviewsByCompanyId($id)
    {
        $this->db->query('SELECT * FROM companyreviews WHERE CompanyID = :company_id ORDER BY created_at DESC');
        $this->db->bind(':company_id', $id);       
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

    public function getDisplayRating($companyID)
    {
        // Fetch the latest review for each student per company, regardless of time
        $this->db->query('
            SELECT StudentID, MAX(created_at) as latest_review_date
            FROM companyreviews
            WHERE CompanyID = :companyID
            GROUP BY StudentID
        ');
        $this->db->bind(':companyID', $companyID);
        $displayReviews = $this->db->resultSet();

        // Extract ratings for the latest reviews for each student in this company
        $displayRatings = [];
        foreach ($displayReviews as $displayReview) {
            $this->db->query('
                SELECT Rating
                FROM companyreviews
                WHERE CompanyID = :companyID AND StudentID = :studentID AND created_at = :latestReviewDate
            ');
            $this->db->bind(':companyID', $companyID);
            $this->db->bind(':studentID', $displayReview->StudentID);
            $this->db->bind(':latestReviewDate', $displayReview->latest_review_date);
            $rating = $this->db->single();
            $displayRatings[] = $rating->Rating;
        }

        // Calculate the display rating for the company (average of the latest reviews)
        $displayRating = count($displayRatings) > 0 ? array_sum($displayRatings) / count($displayRatings) : 0;

        // Round off display_rating to 2 decimal places
        $displayRating = round($displayRating, 2);

        return $displayRating;
    }

    public function getTrendyCompanies()
    {
        // Calculate the date one week ago from today
        $oneWeekAgo = date('Y-m-d H:i:s', strtotime('-1 week'));

        // Step 1: Get the latest review from each student for each company with a rating >= 4
        $this->db->query('
            SELECT CompanyID, StudentID, MAX(created_at) as latest_review_date
            FROM companyreviews
            WHERE Rating >= 4 AND created_at >= :oneWeekAgo
            GROUP BY CompanyID, StudentID
        ');
        $this->db->bind(':oneWeekAgo', $oneWeekAgo);
        $latestReviews = $this->db->resultSet();

        // Step 2: Extract the latest reviews for each company
        $companyReviews = [];
        foreach ($latestReviews as $review) {
            $companyID = $review->CompanyID;
            $studentID = $review->StudentID;
            $latestReviewDate = $review->latest_review_date;

            // Fetch the latest review details for this student and company
            $this->db->query('
                SELECT Rating
                FROM companyreviews
                WHERE CompanyID = :companyID AND StudentID = :studentID AND created_at = :latestReviewDate
            ');
            $this->db->bind(':companyID', $companyID);
            $this->db->bind(':studentID', $studentID);
            $this->db->bind(':latestReviewDate', $latestReviewDate);
            $reviewDetails = $this->db->single();

            // Add the rating to the company's review list
            if (!isset($companyReviews[$companyID])) {
                $companyReviews[$companyID] = [];
            }
            $companyReviews[$companyID][] = $reviewDetails->Rating;
        }

        // Step 3: Calculate the average rating for companies with more than 0 reviews
        $trendyCompanies = [];
        foreach ($companyReviews as $companyID => $ratings) {
            if (count($ratings) >= 1) {
                $averageRating = array_sum($ratings) / count($ratings);

                // Fetch additional company details (CompanyLogo and City) from the companies table
                $this->db->query('
                    SELECT CompanyLogo, CompanyName, City
                    FROM companyreviews
                    WHERE CompanyID = :companyID
                ');
                $this->db->bind(':companyID', $companyID);
                $companyDetails = $this->db->single();

                // Step 4: Get the display rating of companies using the new function
                $displayRating = $this->getDisplayRating($companyID);

                // Round off avg_rating to 2 decimal places
                $averageRating = round($averageRating, 2);

                // Add company details to the trendyCompanies array
                $trendyCompanies[] = [
                    'CompanyID' => $companyID,
                    'avg_rating' => $averageRating,
                    'total_reviews' => count($ratings),
                    'CompanyLogo' => $companyDetails->CompanyLogo,
                    'CompanyName' => $companyDetails->CompanyName,
                    'City' => $companyDetails->City,
                    'display_rating' => $displayRating
                ];
            }
        }

        // Step 5: Sort companies by average rating in descending order and limit to top 20 companies
        usort($trendyCompanies, function ($a, $b) {
            return $b['avg_rating'] <=> $a['avg_rating'];
        });
        $trendyCompanies = array_slice($trendyCompanies, 0, 20);

        return $trendyCompanies;
    }

    public function getAnonymousName($reviewerId)
    {
        if (!isset($reviewerId)) {
            throw new InvalidArgumentException('Reviewer ID cannot be null.');
        }

        if (empty($this->anonymousNames)) {
            throw new RuntimeException('Anonymous names array is empty.');
        }

        $hash = crc32((string) $reviewerId);
        $index = abs($hash) % count($this->anonymousNames);

        return $this->anonymousNames[$index];
    }

}
?>