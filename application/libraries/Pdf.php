<?php
/**
 * Description of Mpdf
 *
 * @author cherra
 */
class Pdf {
    
    private $CI;
    
    function __construct() {
        require_once ("mpdf/mpdf.php");
        
        $this->CI =& get_instance();
    }
    
    function render( $html, $pagesize = 'Letter', $watermark = null ){
        $pdf = new mPDF('utf-8', $pagesize);
        //$pdf->bottom-margin = "500";
        if(!empty($watermark)){
            $pdf->SetWatermarkText($watermark);
            $pdf->showWatermarkText = true;
        }
        $pdf->WriteHTML($html);
        
        return $pdf->Output('','S');
        //$pdf->Output();
    }
}

?>
