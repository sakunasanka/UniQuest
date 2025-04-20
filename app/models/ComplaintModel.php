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
            $complaints = $this->select('v_complaints', $conditions, 'ComplaintID, JobTitle, CompanyEmail, Complaint, StudentName, ComplainedDate, Status', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
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
            $complaint = $this->select('v_complaints', [['ComplaintID', '=',  $complaintId]], '*', 'AND', '', '', 0, 1, false);
            return $complaint;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getComplaintsGroupedByCompany($pageNumber = 1, $rowsPerPage = 10, $sort = "LastComplainedDate", $order = "DESC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['ComplaintCount', '>', 0]
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', CompanyEmail, CompanyName, ComplaintCount, DATE_FORMAT(LastComplainedDate, '%Y-%m-%d'))";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }
            $complaints = $this->select('v_complaintsforcompany', $conditions, '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $complaints;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getComplaintsGroupedByJob($pageNumber = 1, $rowsPerPage = 10, $sort = "LastComplainedDate", $order = "DESC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['ComplaintCount', '>', 0]
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', CompanyEmail, CompanyName, ComplaintCount, DATE_FORMAT(LastComplainedDate, '%Y-%m-%d'))";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }
            $complaints = $this->select('v_complaintsforJob', $conditions, '*', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $complaints;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getComplaintsByCompany($companyID, $pageNumber = 1, $rowsPerPage = 10, $sort = "ComplainedDate", $order = "DESC", $search = '')
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
            $complaints = $this->select('v_complaints', $conditions, 'ComplaintID, JobTitle, CompanyEmail, Complaint, StudentName, ComplainedDate, Status', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
            return $complaints;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function getComplaintsByJob($jobID, $pageNumber = 1, $rowsPerPage = 10, $sort = "ComplainedDate", $order = "DESC", $search = '')
    {
        try {
            // Define base conditions
            $conditions = [
                ['JobID', '=', $jobID]
            ];

            // Add search condition if a search term is provided
            if (!empty($search)) {
                $searchTerm = '%' . $search . '%';
                $searchField =  "CONCAT_WS(' ', JobTitle, CompanyEmail, Complaint, StudentName, DATE_FORMAT(ComplainedDate, '%Y-%m-%d'), Status)";

                $conditions[] = [$searchField, 'LIKE', $searchTerm];
            }
            $complaints = $this->select('v_complaints', $conditions, 'ComplaintID, JobTitle, CompanyEmail, Complaint, StudentName, ComplainedDate, Status', 'AND', '', $sort . ' ' . $order, $rowsPerPage, $pageNumber, true);
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
            $complaints = $this->select('v_complaints', [['Status', '=', 'Pending']], 'COUNT(ComplaintID) AS PendingCount', '', '', '', 0, 1, false);
            return $complaints->PendingCount;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }
    

    public function startReview($complaintId)
    {
        try {
            $this->update('complaint_jobs', ['Status' =>  'In-Review'], ['ComplaintID' => $complaintId]);
            return true;
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
            $this->update('complaint_jobs', ['Status' =>  'Resolved'], ['ComplaintID' => $complaintId]);
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
            $this->update('complaint_jobs', ['Status' => 'Rejected'], ['ComplaintID' => $complaintId]);
            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

    public function addComplaintLog($data)
    {
        try {
            $logData = [
                'ComplaintID' => $data['complaintID'],
                'Note' => $data['note'] ?? null,
                'ReasonID' => $data['reasonID'],
                'StatusAfter' => $data['statusAfter']
            ];
            $this->insert('complaint_logs', $logData);
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