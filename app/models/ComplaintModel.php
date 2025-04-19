<?php
class ComplaintModel extends Model {

    public function createComplaint($data)
    {
        try {
            $complaintData = [
                'StudentID' => $_SESSION['user_id'],
                'JobID' => $data['jobID'],
                'Complaint' => $data['complaint'],
                'Proof' => $data['proofName'],
                'Status' => 'Pending'
            ];
            $this->insert('complaint_jobs', $complaintData);
            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getAllComplaints($pageNumber = 1, $rowsPerPage = 10, $sort = "ComplainedDate", $order = "DESC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', JobTitle, CompanyEmail, Complaint, StudentName, DATE_FORMAT(ComplainedDate, '%Y-%m-%d'), Status)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }
            $complaints = $this->select('studentjobcomplaints', $conditions, 'ComplaintID, JobTitle, CompanyEmail, Complaint, StudentName, ComplainedDate, Status', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
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

    public function getComplaintsGroupedByCompany($pageNumber = 1, $rowsPerPage = 10, $sort = "CompanyID", $order = "ASC", $search = '', $searchBy = 'CompanyID')
    {
        try {
            // Define base conditions
            $conditions = [];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', CompanyEmail, CompanyName, ComplaintCount, DATE_FORMAT(LastComplainedDate, '%Y-%m-%d'))";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }
            // $complaints = $this->select('studentjobcomplaints', [], 'CompanyID, CompanyName, CompanyEmail, Status, MAX(ComplainedDate) AS LastComplainedDate, COUNT(CompanyID) AS ComplaintCount', '', 'CompanyID', 'ComplaintCount DESC', $rowsPerPage, $pageNumber, true);
            $complaints = $this->select('v_complaintsforcompany', [[$searchBy, 'LIKE', $search . '%']], '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $complaints;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getComplaintsByCompany($companyID, $pageNumber = 1, $rowsPerPage = 10, $sort = "ComplaintID", $order = "ASC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['CompanyID', '=', $companyID]
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', JobTitle, CompanyEmail, Complaint, StudentName, DATE_FORMAT(ComplainedDate, '%Y-%m-%d'), Status)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }
            $complaints = $this->select('studentjobcomplaints', $conditions, 'ComplaintID, JobTitle, CompanyEmail, Complaint, StudentName, ComplainedDate, Status', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
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