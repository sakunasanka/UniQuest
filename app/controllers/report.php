<?php
class Report extends Controller
{
    private $model;

    public function __construct()
    {
        // Check if user is logged in
        AuthMiddleware::requireAuth();
        // Check if user has the required role
        AuthMiddleware::requireRole('Company');

        // Load model
        $this->model = $this->model('reportModel');
    }

    public function jobReport($jobId)
    {
        try {
            // 1. Input Validation
            if (!isset($jobId) || !is_numeric($jobId) || $jobId <= 0) {
                throw new InvalidArgumentException("Invalid Job ID");
            }

            // 2. Authorization Check
            if (!isset($_SESSION['user_role'])) {
                throw new RuntimeException("Unauthorized access");
            }

            // 3. Premium Feature Check
            if ($_SESSION['user_role'] === 'Company') {
                $companyInfo = $this->model('companyModel')->getCompanyInfo();

                if (!$companyInfo) {
                    throw new RuntimeException("Company information not found");
                }

                $allowedPlans = ['professional', 'enterprise'];
                if (!in_array($companyInfo->subscription_plan, $allowedPlans)) {
                    $_SESSION['show_report_error'] = true;
                    flash(
                        'report_error',
                        'Job reports are available in Professional and Enterprise plans only',
                        'alert alert-warning'
                    );
                    Redirect::to(URLROOT . '/service_provider/dashboard');
                    return;
                }
            }

            // 4. Data Fetching
            $reportData = $this->model->getJobPerformanceDataComp($jobId);

            if (!$reportData || empty($reportData['job'])) {
                flash(
                    'report_error',
                    'No performance data available for this job',
                    'alert alert-info'
                );
                Redirect::to(URLROOT . '/service_provider/active_jobs');
                return;
            }

            // Prepare data for charts
            $chartData = [
                'gender' => [
                    'labels' => array_keys($reportData['demographics']['gender']),
                    'data' => array_values($reportData['demographics']['gender']),
                    'backgroundColor' => ['#36a2eb', '#ff6384', '#ffcd56']
                ],
                'age' => [
                    'labels' => array_keys($reportData['demographics']['age']),
                    'data' => array_values($reportData['demographics']['age']),
                    'backgroundColor' => '#4bc0c0'
                ],
                'location' => [
                    'labels' => array_keys($reportData['demographics']['location']),
                    'data' => array_values($reportData['demographics']['location']),
                    'backgroundColor' => '#9966ff'
                ]
            ];

            // 5. Data Processing
            $data = [
                'job' => $reportData['job'],
                'totalApplicants' => $reportData['totalApplicants'],
                'applicationRate' => $reportData['applicationRate'],
                'demographics' => $reportData['demographics'],
                'chartData' => $chartData,
                'reportGeneratedAt' => date('F j, Y \a\t H:i:s')
            ];

            // 6. View Rendering
            $this->view('pages/service_provider/job_report', $data);
        } catch (InvalidArgumentException $e) {
            flash('report_error', $e->getMessage(), 'alert alert-danger');
            Redirect::to(URLROOT . '/service_provider/active_jobs');
        } catch (RuntimeException $e) {
            error_log("Job Report Error: " . $e->getMessage());
            flash('report_error', 'An error occurred while generating the report', 'alert alert-danger');
            Redirect::to(URLROOT . '/service_provider/dashboard');
        }
    }

    public function generateJobReportPdf($jobId)
    {
        // Check if user is authorized and has premium access
        // (similar checks as in jobReport method)

        $reportData = $this->model->getJobPerformanceDataComp($jobId);

        if (!$reportData) {
            http_response_code(404);
            die('Report data not found');
        }

        $html = $this->preparePdfHtml($reportData);

        // Use your PDFHelper to generate the PDF
        PDFHelper::generate($html, "job_report_{$jobId}", true);
    }

    private function preparePdfHtml($reportData)
    {
        ob_start();
        include TEMPLATEROOT . '/pdf/job_report_pdf.php'; // Path to your PDF template
        return ob_get_clean();
    }
}
