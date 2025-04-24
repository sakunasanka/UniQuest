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
    public static function generate(string $html, string $filename = 'document', array $options = [])
    {
        // Merge default options
        $defaults = [
            'download' => true,
            'paper' => 'A4',
            'orientation' => 'portrait',
            'watermark' => null,
            'password' => null
        ];
        $options = array_merge($defaults, $options);

        try {
            // Configure DomPDF
            $dompdfOptions = new Options();
            $dompdfOptions->set([
                'isRemoteEnabled' => true,
                'defaultFont' => 'DejaVu Sans',
                'isPhpEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'isFontSubsettingEnabled' => true,
                'debugKeepTemp' => false,
                'tempDir' => sys_get_temp_dir()
            ]);

            $dompdf = new Dompdf($dompdfOptions);
            $dompdf->loadHtml($html);
            $dompdf->setPaper($options['paper'], $options['orientation']);
            $dompdf->render();

            // Add watermark if specified
            if ($options['watermark']) {
                $canvas = $dompdf->getCanvas();
                $font = "DejaVu Sans";
                $canvas->page_text(
                    72, 18, 
                    $options['watermark'], 
                    $font, 
                    8, 
                    [0.75, 0.75, 0.75], // Light gray color
                    0.5,                // Opacity
                    45,                 // Angle
                    'center'             // Alignment
                );
            }

            // Set password if specified
            // if ($options['password']) {
            //     $dompdf->getCanvas()->get_cpdf()->setEncryption(
            //         $options['password'],
            //         null,
            //         ['copy', 'print'] // Allowed permissions
            //     );
            // }

            if ($options['download']) {
                // Output as downloadable PDF
                $dompdf->stream("{$filename}.pdf", [
                    'Attachment' => 1,
                    'compress' => 1
                ]);
                exit;
            }

            // Return PDF as string
            return $dompdf->output();

        } catch (Exception $e) {
            error_log("PDF Generation Error: " . $e->getMessage());
            throw new Exception("Failed to generate PDF: " . $e->getMessage());
        }
    }
}