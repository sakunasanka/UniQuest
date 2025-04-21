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
     * @param bool $download Whether to force download (default: true)
     * @return mixed
     */
    public static function generate($html, $filename = 'document', $download = true)
    {
        try {
            // Configure DomPDF
            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('defaultFont', 'DejaVu Sans');
            $options->set('isPhpEnabled', true);
            $options->set('isHtml5ParserEnabled', true);
            
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            // Add watermark
            $canvas = $dompdf->getCanvas();
            $font = "DejaVu Sans";
            $canvas->page_text(72, 18, "Confidential", $font, 8, array(0,0,0));

            if ($download) {
                // Output as downloadable PDF
                $dompdf->stream("{$filename}.pdf", [
                    'Attachment' => 1
                ]);
                exit;
            }

            // Return PDF as string
            return $dompdf->output();

        } catch (Exception $e) {
            error_log("PDF Generation Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate PDF from a view file
     * 
     * @param string $viewPath Path to the view file
     * @param array $data Data to pass to the view
     * @param string $filename Output filename
     * @param bool $download Whether to force download
     * @return mixed
     */
    // public static function generateFromView($viewPath, $data = [], $filename = 'document', $download = true)
    // {
    //     try {
    //         // Render the view
    //         $html = \Illuminate\Support\Facades\View::make($viewPath, $data)->render();

    //         // Generate PDF
    //         return self::generate($html, $filename, $download);
            
    //     } catch (Exception $e) {
    //         error_log("PDF View Generation Error: " . $e->getMessage());
    //         return false;
    //     }
    // }
}