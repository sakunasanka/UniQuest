<?php
class ReportModel extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getJobPerformanceDataComp($jobId)
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

            $data = [
                'job' => $job,
                'totalApplicants' => $totalApplicants,
                'applicationRate' => round($applicationRate, 1),
                'demographics' => $demographics
            ];
            return $data;
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
        try {
            $this->db->query("SELECT COUNT(*) AS viewCount FROM is_viewed_job WHERE JobID = :jobId");
            $this->db->bind(':jobId', $jobId);
            $row = $this->db->single();
            return $row->viewCount;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }
    private function getGenderDistribution($jobId)
    {
        $this->db->query("
        SELECT 
            COALESCE(
                CASE 
                    WHEN s.Gender = 'Male' THEN 'Male'
                    WHEN s.Gender = 'Female' THEN 'Female'
                    WHEN s.Gender IS NULL OR s.Gender = '' THEN 'Unknown'
                    ELSE s.Gender 
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
                $gender = $row->gender;
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
                } elseif ($age >= 22 && $age <= 25) {
                    $distribution['22-25'] += $percent;
                } elseif ($age >= 26 && $age <= 30) {
                    $distribution['26-30'] += $percent;
                } elseif ($age >= 31 && $age <= 35) {
                    $distribution['31-35'] += $percent;
                } else {
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

    public function getSystemHealthData()
    {
        try {
            $query = "
            SELECT 
                (SELECT COUNT(*) FROM user) AS total_users,
                (SELECT COUNT(*) FROM user WHERE Status = 'Active') AS active_users,
                (SELECT COUNT(*) FROM jobs WHERE Status = 'Active') AS active_jobs,
                (SELECT COUNT(*) FROM complaint_jobs WHERE Status = 'Pending') AS pending_complaints,
                (SELECT COUNT(DISTINCT CompanyID) FROM jobs) AS companies_with_jobs,
                (SELECT COUNT(*) FROM applications WHERE status = 'Hired') AS total_hires,
                (SELECT COUNT(*) FROM verificationlogs WHERE Action = 'Reject' 
                 AND ActionDate > NOW() - INTERVAL 7 DAY) AS recent_rejections,
                (SELECT COUNT(*) FROM user_login_activity 
                 WHERE LoginTime > NOW() - INTERVAL 24 HOUR) AS daily_logins
        ";
            $this->db->query($query);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log("Database Error in getSystemHealthData: " . $e->getMessage());
            return null;
        }
    }

    public function getUserGrowthData($startDate = null, $endDate = null)
    {
        try {
            $query = "
        SELECT 
            DATE_FORMAT(u.RegisterDate, '%Y-%m') AS month,
            u.Role,
            COUNT(*) AS new_users,
            COUNT(CASE WHEN u.VerifiedBy IS NOT NULL THEN 1 END) AS verified_users,
            COUNT(CASE WHEN u.Status = 'Active' THEN 1 END) AS active_users,
            COUNT(CASE WHEN u.Status = 'Pending' THEN 1 END) AS pending_users
        FROM user u
        WHERE 1=1
        ";

            // Add date filtering if provided
            if ($startDate) {
                $query .= " AND u.RegisterDate >= :startDate";
            }
            if ($endDate) {
                $query .= " AND u.RegisterDate <= :endDate";
            }

            $query .= "
        GROUP BY DATE_FORMAT(u.RegisterDate, '%Y-%m'), u.Role
        ORDER BY month DESC, u.Role
        ";

            $this->db->query($query);

            // Bind parameters if dates are provided
            if ($startDate) {
                $this->db->bind(':startDate', $startDate);
            }
            if ($endDate) {
                $this->db->bind(':endDate', $endDate);
            }

            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log("Database Error in getUserGrowthData: " . $e->getMessage());
            return null;
        }
    }

    public function getJobPerformanceData($startDate = null, $endDate = null)
    {
        try {
            $query = "
        SELECT 
            j.Category,
            c.CompanyName,
            COUNT(j.JobID) AS total_jobs,
            COUNT(a.id) AS total_applications,
            COUNT(CASE WHEN a.status = 'Hired' THEN 1 END) AS hires,
            ROUND(COUNT(CASE WHEN a.status = 'Hired' THEN 1 END)*100.0/NULLIF(COUNT(a.id), 0), 2) AS hire_rate,
            AVG(TIMESTAMPDIFF(HOUR, j.create_at, a.created_at)) AS avg_time_to_apply
        FROM jobs j
        LEFT JOIN applications a ON j.JobID = a.job_id
        LEFT JOIN company c ON j.CompanyID = c.CompanyID
        WHERE 1=1
        ";

            // Add date filters if provided
            if ($startDate) {
                $query .= " AND j.create_at >= :startDate";
            }
            if ($endDate) {
                $query .= " AND j.create_at <= :endDate";
            }

            $query .= "
        GROUP BY j.Category, c.CompanyName
        ORDER BY total_applications DESC
        ";

            $this->db->query($query);

            // Bind parameters if dates are provided
            if ($startDate) {
                $this->db->bind(':startDate', $startDate);
            }
            if ($endDate) {
                $this->db->bind(':endDate', $endDate);
            }

            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log("Database Error in getJobPerformanceData: " . $e->getMessage());
            return null;
        }
    }

    public function getRevenueData($startDate = null, $endDate = null)
    {
        try {
            $query = "
        SELECT 
            c.subscription_plan,
            COUNT(DISTINCT c.CompanyID) AS company_count,
            SUM(CASE WHEN j.Status = 'Active' THEN 1 ELSE 0 END) AS active_jobs,
            AVG(TIMESTAMPDIFF(
                DAY, 
                c.subscription_start_date, 
                COALESCE(c.subscription_end_date, NOW())
            )) AS avg_subscription_days,
            COUNT(DISTINCT j.JobID) AS jobs_per_company,
            SUM(CASE 
                WHEN c.subscription_plan = 'basic' THEN 29.99
                WHEN c.subscription_plan = 'professional' THEN 99.99
                WHEN c.subscription_plan = 'enterprise' THEN 299.99
                ELSE 0
            END) AS estimated_revenue
        FROM company c
        LEFT JOIN jobs j ON c.CompanyID = j.CompanyID
        WHERE 1=1
        ";

            // Add date filters if provided
            if ($startDate) {
                $query .= " AND c.subscription_start_date >= :startDate";
            }
            if ($endDate) {
                $query .= " AND (c.subscription_end_date <= :endDate OR c.subscription_end_date IS NULL)";
            }

            $query .= "
        GROUP BY c.subscription_plan
        ORDER BY company_count DESC
        ";

            $this->db->query($query);

            // Bind parameters if dates are provided
            if ($startDate) {
                $this->db->bind(':startDate', $startDate);
            }
            if ($endDate) {
                $this->db->bind(':endDate', $endDate);
            }

            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log("Database Error in getRevenueData: " . $e->getMessage());
            return null;
        }
    }


    public function getComplaintData()
    {
        try {
            $query = "
            SELECT 
                c.CompanyName,
                COUNT(cj.ComplaintID) AS total_complaints,
                COUNT(CASE WHEN cj.Status = 'Resolved' THEN 1 END) AS resolved,
                COUNT(CASE WHEN cj.Status = 'Pending' THEN 1 END) AS pending,
                AVG(TIMESTAMPDIFF(HOUR, cj.ComplainedDate, cl.Timestamp)) AS avg_resolution_hours,
                GROUP_CONCAT(DISTINCT j.Title) AS complained_jobs
            FROM complaint_jobs cj
            JOIN jobs j ON cj.JobID = j.JobID
            JOIN company c ON j.CompanyID = c.CompanyID
            LEFT JOIN complaint_logs cl ON cj.ComplaintID = cl.ComplaintID AND cl.StatusAfter = 'Resolved'
            GROUP BY c.CompanyName
            ORDER BY total_complaints DESC
        ";
            $this->db->query($query);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log("Database Error in getComplaintData: " . $e->getMessage());
            return null;
        }
    }

    public function getVerificationPerformanceData()
    {
        try {
            $query = "
            SELECT 
                CONCAT(vt.FirstName, ' ', vt.LastName) AS verifier,
                u.Role AS verifier_role,
                COUNT(vl.LogID) AS total_actions,
                COUNT(CASE WHEN vl.Action = 'Approve' THEN 1 END) AS approvals,
                COUNT(CASE WHEN vl.Action = 'Reject' THEN 1 END) AS rejections,
                AVG(TIMESTAMPDIFF(MINUTE, 
                    CASE WHEN vl.EntityType = 'User' THEN u.RegisterDate 
                         WHEN vl.EntityType = 'Job' THEN j.create_at END,
                    vl.ActionDate)) AS avg_review_time_minutes
            FROM verificationlogs vl
            LEFT JOIN verificationteam vt ON vl.ActionBy = vt.VT_MemberID
            LEFT JOIN user u ON vl.EntityType = 'User' AND vl.EntityID = u.UserID
            LEFT JOIN jobs j ON vl.EntityType = 'Job' AND vl.EntityID = j.JobID
            GROUP BY vl.ActionBy, vt.FirstName, vt.LastName, u.Role
            ORDER BY total_actions DESC
        ";
            $this->db->query($query);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log("Database Error in getVerificationPerformanceData: " . $e->getMessage());
            return null;
        }
    }

    public function getStudentPlacementData()
    {
        try {
            $query = "
            SELECT 
                s.University,
                COUNT(DISTINCT s.StudentID) AS total_students,
                COUNT(DISTINCT CASE WHEN a.status = 'Hired' THEN s.StudentID END) AS placed_students,
                COUNT(DISTINCT a.job_id) AS distinct_jobs,
                GROUP_CONCAT(DISTINCT c.CompanyName) AS hiring_companies,
                ROUND(COUNT(DISTINCT CASE WHEN a.status = 'Hired' THEN s.StudentID END)*100.0/
                      COUNT(DISTINCT s.StudentID),2) AS placement_rate
            FROM student s
            LEFT JOIN applications a ON s.StudentID = a.user_id
            LEFT JOIN jobs j ON a.job_id = j.JobID
            LEFT JOIN company c ON j.CompanyID = c.CompanyID
            GROUP BY s.University
            ORDER BY placement_rate DESC
        ";
            $this->db->query($query);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log("Database Error in getStudentPlacementData: " . $e->getMessage());
            return null;
        }
    }

    public function getBookmarkAnalysisData()
    {
        try {
            $query = "
            SELECT 
                u.Role AS user_role,
                COUNT(DISTINCT bj.StudentID) AS students_bookmarking,
                COUNT(DISTINCT bj.JobID) AS bookmarked_jobs,
                COUNT(DISTINCT bc.CompanyID) AS bookmarked_companies,
                AVG(TIMESTAMPDIFF(DAY, j.create_at, bj.bookmark_create_at)) AS avg_days_to_bookmark_job,
                (SELECT COUNT(*) FROM BookmarkJobs WHERE StudentID = s.StudentID) AS avg_bookmarks_per_student
            FROM user u
            LEFT JOIN student s ON u.UserID = s.StudentID
            LEFT JOIN BookmarkJobs bj ON s.StudentID = bj.StudentID
            LEFT JOIN BookmarkCompanies bc ON s.StudentID = bc.StudentID
            LEFT JOIN jobs j ON bj.JobID = j.JobID
            GROUP BY u.Role
        ";
            $this->db->query($query);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log("Database Error in getBookmarkAnalysisData: " . $e->getMessage());
            return null;
        }
    }

    public function getExecutiveSummaryData()
    {
        try {
            $query = "
            SELECT 
                (SELECT COUNT(*) FROM user) AS total_users,
                (SELECT COUNT(*) FROM jobs) AS total_jobs,
                (SELECT COUNT(*) FROM applications WHERE status = 'Hired') AS successful_hires,
                (SELECT COUNT(*) FROM company 
                WHERE COALESCE(subscription_end_date, NOW()) >= NOW()) AS paying_companies,
                (SELECT COUNT(*) FROM complaint_jobs WHERE Status = 'Resolved' 
                AND ComplainedDate > NOW() - INTERVAL 30 DAY) AS complaints_resolved_30d,
                (SELECT COUNT(DISTINCT user_id) FROM applications 
                WHERE status = 'Hired') AS students_placed,
                (
                    SELECT AVG(TIMESTAMPDIFF(HOUR, j.create_at, v.ActionDate))
                    FROM jobs j
                    INNER JOIN verificationlogs v 
                        ON v.EntityID = j.JobID AND v.EntityType = 'Job'
                ) AS avg_job_approval_time_hours
        ";
            $this->db->query($query);
            return $this->db->resultSet();
        } catch (PDOException $e) {
            error_log("Database Error in getExecutiveSummaryData: " . $e->getMessage());
            return null;
        }
    }
}
