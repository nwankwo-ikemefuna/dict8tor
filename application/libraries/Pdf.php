<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once FCPATH . '/application/third_party/tcpdf/tcpdf.php';

class Pdf
{
    private $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }


    public function generate($config)
    {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($config['author'] ?? SITE_NAME);
        $pdf->SetTitle($config['title']);
        $pdf->SetSubject($config['subject']);
        $pdf->SetKeywords($config['keywords'] ?? SITE_NAME);

        // header & footer
        $pdf->setPrintHeader($config['with_header']);
        $pdf->setPrintFooter($config['with_footer']);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // set font
        $font_family = $config['font_family'] ?? 'helvetica'; //regular if empty
        $font_style = $config['font_style'] ?? ''; //regular if empty
        $font_size = $config['font_size'] ?? 12;
        $pdf->SetFont($font_family, $font_style, $font_size);

        // add a page
        $pdf->AddPage();

        $output_type = $config['output_type'] ?? 'text';
        if ($output_type == 'html') {
            $pdf->writeHTML($config['content'], true, false, true, false, '');
        } else {
            $pdf->Write(0, $config['content'], '', 0, ($config['align'] ?? 'L'), true, 0, false, false, 0);
        }

        //Close and output PDF document
        $destination = ($config['download'] ?? false) ? 'D' : 'I'; 
        $destination = ($config['save_local'] ?? false) ? 'F' : $destination; 
        if (isset($config['save_local']) && $config['save_local']) {
            $dox_dir = 'uploads/dox';
            create_dir($dox_dir);
            $config['file_name'] = FCPATH.'/'.$dox_dir.'/'.$config['file_name'];
        }
        return $pdf->Output($config['file_name'], $destination);
    }

}
