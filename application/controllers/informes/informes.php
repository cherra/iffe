<?php
/**
 * Description of ventas
 *
 * @author cherra
 */
class Informes extends CI_Controller{
    
    public $layout = 'template_backend';
    private $template = '';
    private $data = array();
    
    function __construct() {
        parent::__construct();
        $this->template = $this->load->file(APPPATH . 'views/templates/template_pdf.php', true);
    }
    
    public function index(){
        $this->load->view('informes/informes');
    }
    
    public function imprimir( ){
        if($this->session->flashdata('pdf')){
            $this->layout = 'template_pdf';
            $this->load->library('tbs');

            // Nombres de meses en español (config/sitio.php)
            $meses = $this->config->item('meses');

            // Se carga el template predefinido para los recibos (tabla Configuracion)
            $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_informes'));

            // Se sustituyen los campos en el template
            $this->tbs->VarRef['titulo'] = 'Informe';
            $this->tbs->VarRef['titulo'] = 'Informe';
            $this->tbs->VarRef['titulo'] = 'Informe';
            $this->tbs->VarRef['titulo'] = 'Informe';
        }else{
            $this->session->set_flashdata('pdf', true);
            redirect('informes/informes/imprimir');
        }
    }
    
    public function facturas_listado(){
        $data['reporte'] = '';
        if( ($post = $this->input->post()) ){
            
            $data['desde'] = $post['desde'];
            $data['hasta'] = $post['hasta'];
            $data['filtro'] = $post['filtro'];
            
            $this->load->model('factura','f');
            $facturas = $this->f->get_by_fecha( $data['desde'], $data['hasta'], $data['filtro'] )->result();
            
            // generar tabla
            $this->load->library('table');
            $this->table->set_empty('&nbsp;');
            
            $tmpl = array ( 'table_open' => '<table class="' . $this->config->item('tabla_css') . '" >' );
            $this->table->set_template($tmpl);
            $this->table->set_heading('Estado', 'Fecha','Serie', 'Folio', 'Nombre', 'Importe');
            $total = $total_vigentes = $total_canceladas = 0;
            foreach ($facturas as $f){
                if($f->estatus == 0){
                    $clase = 'text-error';
                    $total_canceladas += $f->total;
                }else{
                    $clase = '';
                    $total_vigentes += $f->total;
                }
                $this->table->add_row(
                    ($f->estatus == 1 ? '<i class="icon-ok"></i>' : '<i class="icon-remove"></i>'),
                    $f->fecha,
                    $f->serie,
                    $f->folio,
                    $f->nombre,
                    array('data' => number_format($f->total,2), 'style' => 'text-align: right;')
    		);
                
                $this->table->add_row_class($clase);
                
                $total += $f->total;
            }
            // Total de facturas vigentes
            $this->table->add_row( '', '', '', '', 'Total vigentes', array('data' => number_format($total_vigentes,2), 'style' => 'text-align: right;'));
            $this->table->add_row_class('info');
            // Total de facturas canceladas
            $this->table->add_row( '', '', '', '', 'Total canceladas', array('data' => number_format($total_canceladas,2), 'style' => 'text-align: right;'));
            $this->table->add_row_class('info text-error');
            // Total
            $this->table->add_row( '', '', '', '', '<strong>TOTAL</strong>', array('data' => '<strong>'.number_format($total,2).'</strong>', 'style' => 'text-align: right;'));
            $this->table->add_row_class('info');
            
            $tabla = $this->table->generate();
            
            //$tabla.= '</tbody></table>';
            $this->load->library('tbs');
            $this->load->library('pdf');
            
            // Se obtiene la plantilla (2° parametro se pone false para evitar que haga conversión de caractéres con htmlspecialchars() )
            $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_informes'), false);

            // Se sustituyen los campos en el template
            $this->tbs->VarRef['titulo'] = 'Informe';
            $this->tbs->VarRef['fecha'] = 'Fecha';
            $this->tbs->VarRef['rango'] = 'Rango';
            $this->tbs->VarRef['contenido'] = $tabla;
            
            $this->tbs->Show(TBS_NOTHING);
            
            // Se regresa el render
            $output = $this->tbs->Source;
            
            $view = str_replace("{contenido_vista}", $output, $this->template);
            
            // PDF
            $pdf = $this->pdf->render($view);
            //$pdf = $template;
            
            $fp = fopen($this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('tmp_path').'facturas_listado.pdf','w');
            fwrite($fp, $pdf);
            fclose($fp);
            $data['reporte'] = 'facturas_listado.pdf';
        }
        $data['titulo'] = 'Informe de facturas <small>Listado</small>';
        //$data['action'] = 'informes/informes/facturas_listado';
        $this->load->view('informes/facturas_listado', $data);
    }
}

?>
