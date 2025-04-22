<?php
class ReportModel extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getJobPerformanceData($jobId)
    {
        try {
            // Get basic job information
            $job = $this->getJobDetails($jobId);
            
            if (!$job) {
                return null;
            }

            // Get total applications count
            $totalApplicants = $this->getTotalApplicants($jobId);
            
            // Calculate application rate (assuming you have views data)
            $views = $this->getJobViews($jobId);
            $applicationRate = $views > 0 ? ($totalApplicants / $views) * 100 : 0;

            // Get demographic data
            $demographics = [
                'gender' => $this->getGenderDistribution($jobId),
                'age' => $this->getAgeDistribution($jobId),
                'location' => $this->getLocationDistribution($jobId)
            ];

            return [
                'job' => $job,
                'totalApplicants' => $totalApplicants,
                'applicationRate' => round($applicationRate, 1),
                'demographics' => $demographics
            ];
            
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }

    private function getJobDetails($jobId)
    {
        $this->db->query("SELECT * FROM v_jobs WHERE JobID = :jobId");
        $this->db->bind(':jobId', $jobId);
        return $this->db->single();
    }

    private function getTotalApplicants($jobId)
    {
        $this->db->query("SELECT COUNT(*) as count FROM applications WHERE job_id = :jobId");
        $this->db->bind(':jobId', $jobId);
        $result = $this->db->single();
        return $result->count;
    }
//**************************************view count *********************** *
    private function getJobViews($jobId)
    {
        $this->db->query("SELECT views FROM job_views WHERE job_id = :jobId");
        $this->db->bind(':jobId', $jobId);
        $result = $this->db->single();
        return $result ? $result->views : 0;
    }
    private function getGenderDistribution($jobId)
{
    $this->db->query("
        SELECT 
            COALESCE(
                CASE 
                    WHEN s.gender = 'M' THEN 'Male'
                    WHEN s.gender = 'F' THEN 'Female'
                    WHEN s.gender IS NULL OR s.gender = '' THEN 'Unknown'
                    ELSE s.gender 
                END, 
                'Unknown'
            ) as gender,
            COUNT(*) as count 
        FROM applications a
        JOIN student s ON a.user_id = s.StudentID
        WHERE a.job_id = :jobId
        GROUP BY gender
    ");
    $this->db->bind(':jobId', $jobId);
    $results = $this->db->resultSet();

    $distribution = ['Male' => 0, 'Female' => 0, 'Unknown' => 0];
    
    if (!empty($results)) {
        $total = array_sum(array_column($results, 'count'));
        foreach ($results as $row) {
            $gender = ucfirst(strtolower($row->gender));
            $distribution[$gender] = $total > 0 ? round(($row->count / $total) * 100, 1) : 0;
        }
    }
    
    return $distribution;
}

private function getAgeDistribution($jobId) 
{
    $this->db->query("
        SELECT 
            TIMESTAMPDIFF(YEAR, s.DOB, CURDATE()) as age,
            COUNT(*) as count
        FROM applications a
        JOIN student s ON a.user_id = s.StudentID
        WHERE a.job_id = :jobId
        AND s.DOB IS NOT NULL
        AND s.DOB != '0000-00-00'
        GROUP BY age
    ");
    $this->db->bind(':jobId', $jobId);
    $results = $this->db->resultSet();
    
    // Initialize with your exact desired age categories
    $distribution = [
        '18-21' => 0,
        '22-25' => 0, 
        '26-30' => 0,
        '31-35' => 0,
        '36+' => 0
    ];
    
    if (!empty($results)) {
        $total = array_sum(array_column($results, 'count'));
        
        foreach ($results as $row) {
            $age = $row->age;
            $percent = $total > 0 ? round(($row->count / $total) * 100, 1) : 0;
            
            if ($age >= 18 && $age <= 21) {
                $distribution['18-21'] += $percent;
            } 
            elseif ($age >= 22 && $age <= 25) {
                $distribution['22-25'] += $percent;
            }
            elseif ($age >= 26 && $age <= 30) {
                $distribution['26-30'] += $percent;
            }
            elseif ($age >= 31 && $age <= 35) {
                $distribution['31-35'] += $percent;
            }
            else {
                $distribution['36+'] += $percent;
            }
        }
    }
    
    // Remove empty categories
    return array_filter($distribution);
}

private function getLocationDistribution($jobId)
{
    $this->db->query("
        SELECT 
            s.City,
            COUNT(*) as count 
        FROM applications a
        JOIN student s ON a.user_id = s.StudentID
        WHERE a.job_id = :jobId
        GROUP BY s.City
    ");
    $this->db->bind(':jobId', $jobId);
    $results = $this->db->resultSet();
    
    // Initialize with your desired cities
    $distribution = [
        'Colombo' => 0,
        'Kandy' => 0,
        'Galle' => 0,
        'Other' => 0
    ];
    
    if (!empty($results)) {
        $total = array_sum(array_column($results, 'count'));
        
        foreach ($results as $row) {
            $city = ucfirst(strtolower($row->City));
            $percent = $total > 0 ? round(($row->count / $total) * 100, 1) : 0;
            
            if (array_key_exists($city, $distribution)) {
                $distribution[$city] += $percent;
            } else {
                $distribution['Other'] += $percent;
            }
        }
    }
    
    // Remove empty categories
    return array_filter($distribution);
}
}