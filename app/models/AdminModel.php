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
    public function addVerificationLog($entityID, $entityType, $action, $reasonID = 10) {
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
            $log = $this->select('v_verification_logs', [['EntityID', '=', $entityID]], 'Action, ActionDate, ActionByID, ActionByName, Reason', 'AND', '', 'ActionDate DESC', 0, 1, false);
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

}
?>