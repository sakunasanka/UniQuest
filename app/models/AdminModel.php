<?php
class AdminModel extends Model {
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