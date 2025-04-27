<?php
// app/helpers/PDFHelper.php

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFHelper
{
    /**
     * Generate PDF from HTML content
     * 
     * @param string $html The HTML content to convert to PDF
     * @param string $filename The output filename (without extension)
     * @param array $options Configuration options [
     *     'download' => bool,     // Whether to force download (default: true)
     *     'paper' => string,      // Paper size (default: 'A4')
     *     'orientation' => string,// 'portrait' or 'landscape' (default: 'portrait')
     *     'watermark' => string,  // Watermark text (optional)
     *     'password' => string    // PDF password (optional)
     * ]
     * @return mixed Returns PDF content if download=false, otherwise outputs to browser
     * @throws Exception On PDF generation failure
     */
    public static function generate($html, $filename = 'document', $download = true)
    {
        try {
            // Clear any existing output
            if (ob_get_length()) ob_end_clean();

            $options = new Options();
            $options->set([
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
                'isPhpEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'isFontSubsettingEnabled' => true,
                'isPdfA' => true,  // PDF/A compliance for Chrome
                'debugKeepTemp' => false
            ]);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Watermark (optional)
            // $canvas = $dompdf->getCanvas();
            // $canvas->page_text(72, 18, "Confidential", "DejaVu Sans", 8, [0.8, 0.8, 0.8], 0.5, 45);

            if ($download) {
                // Explicit headers
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $filename . '.pdf"');
                header('Cache-Control: private, max-age=0, must-revalidate');
                echo $dompdf->output();
                exit;
            }

            return $dompdf->output();
        } catch (Exception $e) {
            error_log("PDF Generation Error: " . $e->getMessage());
            throw new Exception("PDF generation failed: " . $e->getMessage());
        }
    }
}
