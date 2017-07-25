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
        PDF::SetTitle('Payroll Report');
        PDF::SetSubject('Employee Payroll');

        // set custom header and footer data
        PDF::setHeaderCallback(function($pdf){
            // Set font
            $pdf->SetFont('helvetica', 'B', 20);
            // Title
            $pdf->Cell(0, 10, 'Test Org', 0, false, 'C', 0, '', 0, false, 'M', 'M');
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

        // set text shadow effect
        //PDF::setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));



        $data = array(
            'shop' => $reportData
        );

        // Set some content to print
        $view = view('payrollReport')->with($data); //add $data here to pass to view
        $html = $view->render();
        //$html = view('payrollReport', $data)->render();

        // Print text using writeHTMLCell()
        //PDF::writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        //PDF::writeHtml(view('payrollReport', $data)->render());
        PDF::writeHTML($html, true, false, true, false, '');

        // ---------------------------------------------------------

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        PDF::Output('Payroll_Report.pdf', 'I');
    }
}