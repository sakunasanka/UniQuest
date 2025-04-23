<?php
class AdminModel extends Model {
    
    public function storeToken($email, $token, $expiration)
    {
        try {
            // Save token to the database
            $tokenData = [
                'Email' => $email,
                'Token' => $token,
                'Expiration' => $expiration
            ];

            if ($this->insert('token', $tokenData)) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getTokenDetails($token)
    {
        try {
            // Get the token details from the database
            $tokenData = $this->select('token', [['Token', '=', $token]], 'Email, Expiration', 'AND', '', '', 0, 1, false);
            if ($tokenData) {
                return $tokenData;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteToken($token)
    {
        try {
            // Delete the token from the database
            if ($this->delete('token', ['Token' => $token])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function verifyEmail($email)
    {
        try {
            $emailData = [
                'Email' => $email,
                'VerifiedDate' => date('Y-m-d H:i:s'),
                'isVerified' => 'Y'
            ];

            if ($this->insert('email_verification', $emailData)) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function isEmailVerified($email)
    {
        try {
            $emailData = $this->select('email_verification', [['Email', '=', $email]], 'isVerified', 'AND', '', '', 0, 1, false);
            if ($emailData->isVerified === 'Y') {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function updateVerifyEmail($email)
    {
        try {
            $emailData = [
                'VerifiedDate' => date('Y-m-d H:i:s'),
                'isVerified' => 'Y'
            ];
            if ($this->update('email_verification', $emailData, ['Email' => $email])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getReasonsByType($reasonType) {
        try {
            $reasonNames = $this->select('reason', [['ReasonType', '=', $reasonType]], 'ReasonID, ReasonName, Reason', 'AND', '', '', 0, 1, true);
            return $reasonNames;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getReasonByID($reasonID) {
        try {
            $reason = $this->select('reason', [['ReasonID', '=', $reasonID]], 'Reason', 'AND', '', '', 0, 1, false);
            return $reason;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function addReason($reasonName, $reason, $reasonType) {
        try {
            $reason = [
                'ReasonName' => $reasonName,
                'Reason' => $reason,
                'ReasonType' => $reasonType
            ];
            if ($this->insert('reason', $reason)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getReasonByType($reasonType) {
        try {
            // retrieve a single reason by type
            $reason = $this->select('reason', [['ReasonType', '=', $reasonType]], 'ReasonID, ReasonName, Reason', 'AND', '', '', 0, 1, false);
            return $reason;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateReason($reasonID, $reasonName, $reason) {
        try {
            $reason = [
                'ReasonName' => $reasonName,
                'Reason' => $reason
            ];
            if ($this->update('reason', $reason, ['ReasonID' => $reasonID])) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteReason($reasonID) {
        try {
            if ($this->delete('reason', ['ReasonID' => $reasonID])) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function addUserAccountLog($userID, $action, $reasonID) {
        try {
            $log = [
                'UserID' => $userID,
                'Action' => $action,
                'ActionBy' => $_SESSION['user_id'] ?? $userID,
                'ReasonID' => $reasonID
            ];
            $this->insert('useraccountlog', $log);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //retrieve reason for last account log by userID for a specific action order by date desc
    public function getLastAccountLogReason($userID) {
        try {
            $log = $this->select('v_account_logs', [['UserID', '=', $userID], ['Action', 'NOT IN', ['ChangePass', 'ResetPass']]], 'Reason, ActionDate, ActionByID', 'AND', '', 'ActionDate DESC', 0, 1, false);
            if ($log) {
                $log->ActionDate = date('Y-m-d H:i:s', strtotime($log->ActionDate));
                return $log;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //add verificationlogs 
    public function addVerificationLog($entityID, $entityType, $action, $reasonID) {
        try {
            $log = [
                'EntityID' => $entityID,
                'EntityType' => $entityType,
                'Action' => $action,
                'ActionBy' => $_SESSION['user_id'],
                'ReasonID' => $reasonID
            ];
            $this->insert('verificationlogs', $log);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //retrieve log for last verification log by entityID order by date desc
    public function getLastVerificationLog($entityID) {
        try {
            $log = $this->select('v_verification_logs', [['EntityID', '=', $entityID]], 'Action, ActionDate, ActionByID, ActionByName, ActionByRole, Reason', 'AND', '', 'ActionDate DESC', 0, 1, false);
            if ($log) {
                $log->ActionDate = date('Y-m-d H:i:s', strtotime($log->ActionDate));
                return $log;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //retrieve all industries
    public function getIndustries() {
        try {
            $industries = $this->select('industry', [], 'IndustryID, IndustryName', 'AND', '', 'IndustryName ASC', 0, 1, true);
            return $industries;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // add industry
    public function addIndustry($industryName) {
        try {
            $industry = [
                'IndustryName' => $industryName
            ];
            if ($this->insert('industry', $industry)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // update industry
    public function updateIndustry($industryID, $industryName) {
        try {
            $industry = [
                'IndustryName' => $industryName
            ];
            if ($this->update('industry', $industry, ['IndustryID' => $industryID])) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // delete industry
    public function deleteIndustry($industryID) {
        try {
            if ($this->delete('industry', ['IndustryID' => $industryID])) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // get all districts
    public function getDistricts() {
        try {
            $districts = $this->select('districts', [], 'DistrictID, DistrictName', 'AND', '', 'DistrictName ASC', 0, 1, true);
            return $districts;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //get all cities for a district
    public function getCitiesByDistrict($districtID) {
        try {
            $cities = $this->select('cities', [['DistrictID', '=', $districtID]], 'CityID, CityName', 'AND', '', 'CityName ASC', 0, 1, true);
            return $cities;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //restrict posting for a company
    public function restrictPosting($companyID)
    {
        try {
            $this->update('company', ['can_post' => 'N'], ['CompanyID' => $companyID]);
            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function getRegistrationStats($months = 5) {
        try {
            $query = "SELECT 
                        DATE_FORMAT(RegisterDate, '%Y-%m') AS month,
                        COUNT(CASE WHEN Role = 'Student' THEN UserID END) AS students,
                        COUNT(CASE WHEN Role = 'Company' THEN UserID END) AS companies
                      FROM user
                      WHERE RegisterDate >= DATE_SUB(NOW(), INTERVAL ? MONTH)
                      AND Verified = 'Y'
                      GROUP BY DATE_FORMAT(RegisterDate, '%Y-%m')
                      ORDER BY month ASC
                      LIMIT ?";
            
            // Use the parent class's database access method
            return $this->query($query, [$months, $months]);
        } catch (Exception $e) {
            error_log("Error getting registration stats: " . $e->getMessage());
            return [];
        }
    }

    public function getJobListingStats($months = 5) {
        try {
            $query = "SELECT 
                        DATE_FORMAT(verifiedDate, '%Y-%m') AS month,
                        COUNT(CASE WHEN JobCategory = 'Part-time' THEN JobID END) AS part_time,
                        COUNT(CASE WHEN JobCategory = 'Internship' THEN JobID END) AS internships
                      FROM jobs
                      WHERE verifiedDate >= DATE_SUB(NOW(), INTERVAL ? MONTH)
                      AND Verified = 'Y'
                      GROUP BY DATE_FORMAT(verifiedDate, '%Y-%m')
                      ORDER BY month ASC
                      LIMIT ?";
            
            return $this->query($query, [$months, $months]);
        } catch (Exception $e) {
            error_log("Error getting job listing stats: " . $e->getMessage());
            return [];
        }
    }

    public function getRevenueStats($months = 5) {
        try {
            $query = "SELECT 
                        DATE_FORMAT(Payment_date, '%Y-%m') AS month,
                        SUM(Amount) AS revenue
                      FROM payments
                      WHERE Payment_date >= DATE_SUB(NOW(), INTERVAL ? MONTH)
                      GROUP BY DATE_FORMAT(Payment_date, '%Y-%m')
                      ORDER BY month ASC
                      LIMIT ?";
            
            return $this->query($query, [$months, $months]);
        } catch (Exception $e) {
            error_log("Error getting revenue stats: " . $e->getMessage());
            return [];
        }
    }

    public function getLoginStats() {
        try {
            $query = "SELECT 
                        Role,
                        COUNT(*) AS count
                      FROM login_logs
                      WHERE LoginTime >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                      AND Role IN ('Student', 'Company')
                      GROUP BY Role";
            
            return $this->query($query);
        } catch (Exception $e) {
            error_log("Error getting login stats: " . $e->getMessage());
            return [];
        }
    }

    public function getActiveCounts() {
        try {
            return [
                'students' => $this->countActiveUsers('Student'),
                'companies' => $this->countActiveUsers('Company'),
                'part_time_jobs' => $this->countActiveJobs('Part-time'),
                'internships' => $this->countActiveJobs('Internship')
            ];
        } catch (Exception $e) {
            error_log("Error getting active counts: " . $e->getMessage());
            return [];
        }
    }

    private function countActiveUsers($role) {
        $result = $this->select('user', 
            [['Role', '=', $role], ['Status', '=', 'Active'], ['Verified', '=', 'Y']], 
            'COUNT(*) AS count'
        );
        
        // Handle both object and array return types
        if (is_object($result)) {
            return $result->count ?? 0;
        } elseif (is_array($result)) {
            return $result['count'] ?? ($result[0]->count ?? 0);
        }
        return 0;
    }

    private function countActiveJobs($category) {
        $result = $this->select('job',  // Changed from 'jobs' to 'job' to match your other queries
            [['JobCategory', '=', $category], ['Status', '=', 'Active'], ['Verified', '=', 'Y']], 
            'COUNT(*) AS count'
        );
        
        // Handle both object and array return types
        if (is_object($result)) {
            return $result->count ?? 0;
        } elseif (is_array($result)) {
            return $result['count'] ?? ($result[0]->count ?? 0);
        }
        return 0;
    }
    // Helper method for executing raw queries
    protected function query($sql, $params = []) {
        try {
            // Use your framework's preferred query execution method
            // This might vary based on your Database class implementation
            $result = $this->db->query($sql, $params);
            return $result['data'] ?? [];
        } catch (Exception $e) {
            error_log("Query error: " . $e->getMessage());
            return [];
        }
    }

}

?>