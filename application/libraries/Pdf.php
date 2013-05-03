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
    
    function render( $html, $pagesize = 'Letter' ){
        $pdf = new mPDF('', $pagesize);
        
        $pdf->WriteHTML($html);
        
        return $pdf->Output('','S');
        //$pdf->Output();
    }
}

?>
