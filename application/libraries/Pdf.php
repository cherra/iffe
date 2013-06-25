<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Mpdf
 *
 * @author cherra
 */
require_once ("mpdf/mpdf.php");

class Pdf extends mPDF {
    
    private $CI;
    
    function __construct() {
        $this->CI =& get_instance();
    }
    
    function render( $html, $pagesize = 'Letter', $watermark = null, $pagenum = false ){
        $pdf = new mPDF('utf-8', $pagesize);
        //$pdf->bottom-margin = "500";
        if(!empty($watermark)){
            $pdf->SetWatermarkText($watermark);
            $pdf->showWatermarkText = true;
        }
        if($pagenum){
            $pdf->pagenumSuffix = '/';
            $pdf->SetFooter('{PAGENO}{nbpg}');
        }
        $pdf->WriteHTML($html);
        //$pdf->WriteHTML("Prueba de texto");
        
        return $pdf->Output('','S');
        //$pdf->Output();
    }
}

?>
