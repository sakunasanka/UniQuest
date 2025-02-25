<?php
class AdminModel extends Model {
    public function getUserRejectReasons() {
        try {
            $reasonNames = $this->select('user_reject_reason', [], 'ReasonID, ReasonName', 'AND', '', '', 0, 1, true);
            return $reasonNames;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUserRejectReasonByID($reasonID) {
        try {
            $reason = $this->select('user_reject_reason', [['ReasonID', '=', $reasonID]], 'Reason', 'AND', '', '', 0, 1, false);
            return $reason;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
?>