<?php
class Report extends Controller
{
    private $reportModel;

    public function __construct()
    {
        // Check if user is logged in
        AuthMiddleware::requireAuth();
        // Check if user has the required role
        AuthMiddleware::requireRole('Company');
        
        // Load model
        $this->reportModel = $this->model('ReportModel');
    }

    public function jobReport($jobId)
{
    // Validate job ID
    // if (empty($jobId) || !is_numeric($jobId)) {
    //     flash('report_error', 'Invalid Job ID', 'alert alert-danger');
    //     Redirect::to(URLROOT . '/service_provider/ongoing_jobs');
    //     return;
    // }

    // Premium check
    if ($_SESSION['user_role'] == 'Company') {
        $companyInfo = $this->model('companyModel')->getCompanyInfo();
        if (!in_array($companyInfo->subscription_plan, ['professional', 'enterprise']) || 
            $companyInfo->subscription_status != 'active') {
            $_SESSION['show_report_error'] = true;
            Redirect::to(URLROOT . '/service_provider/dashboard');
            return;
        }
    }

    // Fetch data
    $reportData = $this->reportModel->getJobPerformanceData($jobId);

    // Validate report data
    if (!$reportData || empty($reportData['job'])) {
        flash('report_error', 'No data found for this job', 'alert alert-danger');
        Redirect::to(URLROOT . '/service_provider/ongoing_jobs');
        return;
    }

    // Prepare view data
    $data = [
        'job' => $reportData['job'],
        'totalApplicants' => $reportData['totalApplicants'] ?? 0,
        'applicationRate' => $reportData['applicationRate'] ?? 0,
        'demographics' => $reportData['demographics'] ?? []
    ];
// In your controller before passing to view:
    
    $this->view('pages/service_provider/job_report', $data);
}
public function generatePdf($jobId)
{
    // Get report data
    $reportData = $this->reportModel->getJobPerformanceData($jobId);

    if (!$reportData) {
        http_response_code(404);
        echo json_encode(['error' => 'Report data not found']);
        exit;
    }

    // Generate PDF
    $this->generatePdfContent($reportData, $jobId);
    exit;
}
private function generatePdfContent($reportData, $jobId)
{
    // Create simple PDF content
    $content = "%PDF-1.4\n";
    $content .= "%¥±ë\n";
    $content .= "1 0 obj\n";
    $content .= "<< /Type /Catalog /Pages 2 0 R >>\n";
    $content .= "endobj\n";
    $content .= "2 0 obj\n";
    $content .= "<< /Type /Pages /Kids [3 0 R] /Count 1 >>\n";
    $content .= "endobj\n";
    $content .= "3 0 obj\n";
    $content .= "<< /Type /Page /Parent 2 0 R /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>\n";
    $content .= "endobj\n";
    $content .= "4 0 obj\n";
    $content .= "<< /Type /Font /Subtype /Type1 /Name /F1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >>\n";
    $content .= "endobj\n";
    
    // Add your content as PDF text
    $text = "Job Performance Report\n\n";
    $text .= "Title: " . $reportData['job']->Title . "\n";
    $text .= "Location: " . $reportData['job']->Location . "\n";
    $text .= "Total Applicants: " . $reportData['totalApplicants'] . "\n";
    $text .= "Application Rate: " . $reportData['applicationRate'] . "%\n\n";
    
    // Add demographics
    $text .= "Gender Distribution:\n";
    foreach ($reportData['demographics']['gender'] as $gender => $percent) {
        $text .= $gender . ": " . $percent . "%\n";
    }
    
    // Similar for age and location...
    
    // Add text to PDF
    $stream = "BT /F1 12 Tf 72 720 Td (" . str_replace(")", "\)", str_replace("(", "\(", $text)) . ") Tj ET";
    
    $content .= "5 0 obj\n";
    $content .= "<< /Length " . strlen($stream) . " >>\n";
    $content .= "stream\n";
    $content .= $stream . "\n";
    $content .= "endstream\n";
    $content .= "endobj\n";
    $content .= "xref\n";
    $content .= "0 6\n";
    $content .= "0000000000 65535 f \n";
    // Add more xref entries...
    $content .= "trailer\n";
    $content .= "<< /Size 6 /Root 1 0 R >>\n";
    $content .= "startxref\n";
    $content .= strlen($content) . "\n";
    $content .= "%%EOF";
    
    // Output PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="job_report_' . $jobId . '.pdf"');
    echo $content;
    exit;
}
}