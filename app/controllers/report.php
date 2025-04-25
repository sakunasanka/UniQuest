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
                'university' => [
                    'labels' => array_keys($reportData['demographics']['university']),
                    'data' => array_values($reportData['demographics']['university']),
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

            // die(var_dump($data)); // Debugging line to check the report data
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
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Job reports are available in Professional and Enterprise plans only']);
                    exit;
                }
            }

            // 4. Data Fetching
            $reportData = $this->model->getJobPerformanceDataComp($jobId);

            if (!$reportData || empty($reportData['job'])) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'No performance data available for this job']);
                exit;
            }

            // die(var_dump($reportData)); // Debugging line to check the report data
            // Log that we're generating PDF
            error_log("Generating PDF for Job ID: " . $jobId);

            // 5. Generate PDF
            $html = $this->preparePdfHtml($reportData);
            $filename = "job_report_" . $jobId . "_" . date('Y-m-d');

            // Use PDFHelper to generate the PDF
            PDFHelper::generate($html, $filename, true);
        } catch (InvalidArgumentException $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            exit;
        } catch (RuntimeException $e) {
            error_log("Job Report PDF Error: " . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'An error occurred while generating the PDF report']);
            exit;
        } catch (Exception $e) {
            error_log("Unexpected Error in PDF Generation: " . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'An unexpected error occurred']);
            exit;
        }
    }

    private function preparePdfHtml($reportData)
    {
        // Start output buffering
        ob_start();

        // Store the report data in a variable accessible in the template
        // This allows the template to access data as $reportData instead of $data

        // Include the template
        require_once TEMPLATEROOT . '/pdf/job_report_pdf.php';

        // Get the buffered content and clean the buffer
        $html = ob_get_clean();

        return $html;
    }
}
