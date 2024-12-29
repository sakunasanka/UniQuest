<?php
class ComplaintModel extends Model {

    public function createComplaint($data)
    {
        try {
            $complaintData = [
                'studentId' => $_SESSION['user_id'],
                'jobId' => $data['posts']->JobID,
                'description' => $data['complaint']
            ];
            $this->insert('complaint_jobs', $complaintData);
            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getAllComplaints()
    {
        try {
            $complaints = $this->select('studentjobcomplaints', [], '*', '', '', '', 0, true);
            return $complaints;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getComplaintDetails($complaintId)
    {
        try {
            $complaint = $this->select('studentjobcomplaints', [['ComplaintID', '=',  $complaintId]], '*', 'AND', '', '', 0, false);
            return $complaint;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getComplaintsGroupedByCompany()
    {
        try {
            $complaints = $this->select('studentjobcomplaints', [], 'CompanyID, CompanyName, CompanyEmail, Status, MAX(ComplainedDate) AS LastComplainedDate, COUNT(CompanyID) AS ComplaintCount', '', 'CompanyID', 'ComplaintCount DESC', 0, true);
            return $complaints;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getComplaintsByCompany($companyID)
    {
        try {
            $complaints = $this->select('studentjobcomplaints', [['CompanyID', '=', $companyID]], '*', '', '', '', 0, true);
            return $complaints;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getCountPendingComplaints()
    {
        try {
            $complaints = $this->select('studentjobcomplaints', [['Status', '=', 'Pending']], 'COUNT(ComplaintID) AS PendingCount', '', '', '', 0, false);
            return $complaints->PendingCount;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function resolveComplaint($complaintId)
    {
        try {
            $this->update('studentjobcomplaints', ['Status' =>  'Resolved'], ['ComplaintID' => $complaintId]);
            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function rejectComplaint($complaintId)
    {
        try {
            $this->update('studentjobcomplaints', ['Status' => 'Rejected'], ['ComplaintID' => $complaintId]);
            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }
}
?>