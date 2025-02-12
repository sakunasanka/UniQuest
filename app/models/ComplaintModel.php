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

    public function getAllComplaints($pageNumber = 1, $rowsPerPage = 2, $sort = "ComplaintID", $order = "ASC")
    {
        try {
            $complaints = $this->select('studentjobcomplaints', [], '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
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
            $complaint = $this->select('studentjobcomplaints', [['ComplaintID', '=',  $complaintId]], '*', 'AND', '', '', 0, 1, false);
            return $complaint;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getComplaintsGroupedByCompany($pageNumber = 1, $rowsPerPage = 2, $sort = "ComplaintID", $order = "ASC")
    {
        try {
            $complaints = $this->select('studentjobcomplaints', [], 'CompanyID, CompanyName, CompanyEmail, Status, MAX(ComplainedDate) AS LastComplainedDate, COUNT(CompanyID) AS ComplaintCount', '', 'CompanyID', 'ComplaintCount DESC', $rowsPerPage, $pageNumber, true);
            return $complaints;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getComplaintsByCompany($companyID, $pageNumber = 1, $rowsPerPage = 2, $sort = "ComplaintID", $order = "ASC")
    {
        try {
            $complaints = $this->select('studentjobcomplaints', [['CompanyID', '=', $companyID]], '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
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
            $complaints = $this->select('studentjobcomplaints', [['Status', '=', 'Pending']], 'COUNT(ComplaintID) AS PendingCount', '', '', '', 0, 1, false);
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