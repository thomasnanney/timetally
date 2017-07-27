<?php
namespace App\Reports\Models;
use Illuminate\Database\Eloquent\Model;
use PDF;

class Report extends Model
{

    public function createPayrollReport($reportData)
    {
        // set document information
        PDF::SetAuthor('Org Name');
        PDF::SetTitle('Time Entry Report');
        PDF::SetSubject('Employee Hours');

        // set custom header and footer data
        PDF::setHeaderCallback(function($pdf){
            // Set font
            $pdf->SetFont('helvetica', 'B', 20);
            // Title
            $pdf->Cell(0, 10, 'Time Entry Report', 0, false, 'C', 0, '', 0, false, 'M', 'M');
            //separator line
            $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
            $pdf->Line(10, 12, 200, 12, $style);
        });
        PDF::setFooterCallback(function($pdf){
            // Position at 15 mm from bottom
            $pdf->SetY(-15);
            // Set font
            $pdf->SetFont('helvetica', 'I', 8);
            // Page number
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->Cell(0, 10, 'Page '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 'T', 0, 'C', 0, '', 0, false, 'C', 'C');
        });

        // set header and footer fonts
        PDF::setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        PDF::setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        PDF::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP-10, PDF_MARGIN_RIGHT);
        PDF::SetHeaderMargin(PDF_MARGIN_HEADER);
        PDF::SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);

        PDF::setCellPaddings(2,2,2,2);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        PDF::AddPage();

        $data = array(
            'data' => $reportData
        );

        // Set some content to print
        $view = view('payrollReport')->with($data); //add $data here to pass to view
        $html = $view->render();

        // Print text using writeHTMLCell()
        PDF::writeHTML($html, true, false, false, false, '');

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        PDF::Output('Time_Entry_Report.pdf', 'I');
    }
}