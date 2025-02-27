<?php
class AdminModel extends Model {

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
            $reasonNames = $this->select('reason', [['ReasonType', '=', $reasonType]], 'ReasonID, ReasonName', 'AND', '', '', 0, 1, true);
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

    public function addUserAccountLog($userID, $action, $reasonID) {
        try {
            $log = [
                'UserID' => $userID,
                'Action' => $action,
                'ActionBy' => $_SESSION['user_id'],
                'ReasonID' => $reasonID
            ];
            $this->insert('useraccountlog', $log);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
?>