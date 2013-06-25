<?php
/**
 * Description of ventas
 *
 * @author cherra
 */
class Informes extends CI_Controller{
    
    public $layout = 'template_backend';
    private $template = '';
    
    function __construct() {
        parent::__construct();
        $this->template = $this->load->file(APPPATH . 'views/templates/template_pdf.php', true);
    }
    
    public function index(){
        $this->load->view('informes/informes');
    }
    
    public function facturas_listado(){
        $data['reporte'] = '';
        if( ($post = $this->input->post()) ){
            
            $data['desde'] = $post['desde'];
            $data['hasta'] = $post['hasta'];
            $data['filtro'] = $post['filtro'];
            
            $this->load->model('factura','f');
            $facturas = $this->f->get_by_fecha( $post['desde'], $post['hasta'], $post['filtro'] )->result();
            
            // generar tabla
            $this->load->library('table');
            $this->table->set_empty('&nbsp;');
            
            $tmpl = array ( 'table_open' => '<table class="table table-condensed" >' );
            $this->table->set_template($tmpl);
            $this->table->set_heading('Serie', 'Folio', 'Fecha', 'Nombre', 'Importe');
            $total = $total_vigentes = $total_canceladas = 0;
            $estatus = 1;
            $clase = '';
            foreach ($facturas as $f){
                if($f->estatus == 0){
                    $clase = 'cancelado';
                    $total_canceladas += $f->total;
                }else{
                    $clase = '';
                    $total_vigentes += $f->total;
                }
                if($estatus != $f->estatus){
                    // Total de facturas vigentes
                    $this->table->add_row( '', '', '', '<strong>Total vigentes</strong>', array('data' => '<strong>'.number_format($total_vigentes,2).'</strong>', 'style' => 'text-align: right;'));
                    $this->table->add_row_class($clase);
                    $estatus = $f->estatus;
                    
                    $this->table->add_row( array('data' => '', 'colspan' => '5'));
                    $this->table->add_row_class($clase);
                    $this->table->add_row( array('data' => 'CANCELADAS', 'colspan' => '5'));
                    $this->table->add_row_class($clase);
                }
                $fecha = date_create($f->fecha);
                $this->table->add_row(
                    array('data' => $f->serie,'class' => $clase),
                    array('data' => $f->folio,'class' => $clase),
                    array('data' => date_format($fecha,'d/m/Y'),'class' => $clase),
                    array('data' => $f->nombre,'class' => $clase),
                    array('data' => number_format($f->total,2), 'style' => 'text-align: right;', 'class' => $clase)
    		);
                
                $this->table->add_row_class($clase);
                
                $total += $f->total;
            }
            
            if($estatus == 1){
                // Total de facturas vigentes
                $this->table->add_row( '', '', '', '<strong>Total vigentes</strong>', array('data' => '<strong>'.number_format($total_vigentes,2).'</strong>', 'style' => 'text-align: right;'));
                $this->table->add_row_class($clase);
            }
            
            // Total de facturas canceladas
            $this->table->add_row( '', '', '', 'Total canceladas', array('data' => number_format($total_canceladas,2), 'style' => 'text-align: right;'));
            $this->table->add_row_class('info text-error');
            
            $this->table->add_row( array('data' => '', 'colspan' => '5'));
            $this->table->add_row_class($clase);
            // Total
            //$this->table->add_row( '', '', '', '<strong>TOTAL</strong>', array('data' => '<strong>'.number_format($total,2).'</strong>', 'style' => 'text-align: right;'));
            //$this->table->add_row_class('info');
            
            $tabla = $this->table->generate();
            
            //$tabla.= '</tbody></table>';
            $this->load->library('tbs');
            $this->load->library('pdf');
            
            // Se obtiene la plantilla (2° parametro se pone false para evitar que haga conversión de caractéres con htmlspecialchars() )
            $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_informes'), false);

            // Se sustituyen los campos en el template
            $this->tbs->VarRef['titulo'] = 'Listado de facturas';
            $this->tbs->VarRef['fecha'] = date('d/m/Y H:i:s');
            $desde = date_create($post['desde']);
            $hasta = date_create($post['hasta']);
            $this->tbs->VarRef['subtitulo'] = 'Del '.date_format($desde, 'd/m/Y').' al '.date_format($hasta, 'd/m/Y');
            $this->tbs->VarRef['contenido'] = $tabla;
            
            $this->tbs->Show(TBS_NOTHING);
            
            // Se regresa el render
            $output = $this->tbs->Source;
            
            $view = str_replace("{contenido_vista}", $output, $this->template);
            
            // PDF
            $this->pdf->pagenumSuffix = '/';
            $this->pdf->SetHeader('{PAGENO}{nbpg}');
            $pdf = $this->pdf->render($view);
            //$pdf = $view;
            
            $fp = fopen($this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('tmp_path').'facturas_listado.pdf','w');
            fwrite($fp, $pdf);
            fclose($fp);
            $data['reporte'] = 'facturas_listado.pdf';
        }
        $data['titulo'] = 'Informe de facturas <small>Listado</small>';
        $this->load->view('informes/listado', $data);
    }
    
    public function recibos_listado(){
        $data['reporte'] = '';
        if( ($post = $this->input->post()) ){
            
            $data['desde'] = $post['desde'];
            $data['hasta'] = $post['hasta'];
            $data['filtro'] = $post['filtro'];
            
            $this->load->model('recibo','r');
            $recibos = $this->r->get_by_fecha( $post['desde'].' 00:00:00', $post['hasta'].' 23:59:59', $post['filtro'] )->result();
            
            // generar tabla
            $this->load->library('table');
            $this->table->set_empty('&nbsp;');
            
            $tmpl = array ( 'table_open' => '<table class="table table-condensed" >' );
            $this->table->set_template($tmpl);
            $this->table->set_heading('Número', 'Fecha', 'Contrato', 'Cliente', 'Importe');
            $total = $total_vigentes = $total_canceladas = 0;
            $estatus = 'vigente';
            $clase = '';
            foreach ($recibos as $r){
                if($r->estado == 'cancelado'){
                    $clase = 'cancelado';
                    $total_canceladas += $r->total;
                }else{
                    $clase = '';
                    $total_vigentes += $r->total;
                }
                if($estatus != $r->estado){
                    // Total de recibos vigentes
                    $this->table->add_row( '', '', '', '<strong>Total vigentes</strong>', array('data' => '<strong>'.number_format($total_vigentes,2).'</strong>', 'style' => 'text-align: right;'));
                    $this->table->add_row_class($clase);
                    $estatus = $r->estado;
                    
                    $this->table->add_row( array('data' => '', 'colspan' => '5'));
                    $this->table->add_row_class($clase);
                    $this->table->add_row( array('data' => 'CANCELADOS', 'colspan' => '5'));
                    $this->table->add_row_class($clase);
                }
                $fecha = date_create($r->fecha);
                $this->table->add_row(
                    array('data' => $r->numero,'class' => $clase),
                    array('data' => date_format($fecha,'d/m/Y'),'class' => $clase),
                    array('data' => $r->contrato,'class' => $clase),
                    array('data' => $r->cliente,'class' => $clase),
                    array('data' => number_format($r->total,2), 'style' => 'text-align: right;', 'class' => $clase)
    		);
                
                $this->table->add_row_class($clase);
                
                $total += $r->total;
            }
            if($estatus == 'vigente'){
                // Total de recibos vigentes
                $this->table->add_row( '', '', '', '<strong>Total vigentes</strong>', array('data' => '<strong>'.number_format($total_vigentes,2).'</strong>', 'style' => 'text-align: right;'));
                $this->table->add_row_class($clase);
            }
            // Total de facturas canceladas
            $this->table->add_row( '', '', '', 'Total cancelados', array('data' => number_format($total_canceladas,2), 'style' => 'text-align: right;'));
            $this->table->add_row_class('info text-error');
            
            $this->table->add_row( array('data' => '', 'colspan' => '5'));
            $this->table->add_row_class($clase);
            // Total
            //$this->table->add_row( '', '', '', '<strong>TOTAL</strong>', array('data' => '<strong>'.number_format($total,2).'</strong>', 'style' => 'text-align: right;'));
            //$this->table->add_row_class('info');
            
            $tabla = $this->table->generate();
            
            //$tabla.= '</tbody></table>';
            $this->load->library('tbs');
            $this->load->library('pdf');
            
            // Se obtiene la plantilla (2° parametro se pone false para evitar que haga conversión de caractéres con htmlspecialchars() )
            $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_informes'), false);

            // Se sustituyen los campos en el template
            $this->tbs->VarRef['titulo'] = 'Listado de recibos';
            $this->tbs->VarRef['fecha'] = date('d/m/Y H:i:s');
            $desde = date_create($post['desde']);
            $hasta = date_create($post['hasta']);
            $this->tbs->VarRef['subtitulo'] = 'Del '.date_format($desde, 'd/m/Y').' al '.date_format($hasta, 'd/m/Y');
            $this->tbs->VarRef['contenido'] = $tabla;
            
            $this->tbs->Show(TBS_NOTHING);
            
            // Se regresa el render
            $output = $this->tbs->Source;
            
            $view = str_replace("{contenido_vista}", $output, $this->template);
            
            // PDF
            $pdf = $this->pdf->render($view,'Letter',null,true);
            //$pdf = $view;
            
            $fp = fopen($this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('tmp_path').'recibos_listado.pdf','w');
            fwrite($fp, $pdf);
            fclose($fp);
            $data['reporte'] = 'recibos_listado.pdf';
        }
        $data['titulo'] = 'Informe de recibos <small>Listado</small>';
        $this->load->view('informes/listado', $data);
    }
    
    public function contratos_listado(){
        $data['reporte'] = '';
        if( ($post = $this->input->post()) ){
            
            $data['desde'] = $post['desde'];
            $data['hasta'] = $post['hasta'];
            $data['filtro'] = $post['filtro'];
            
            $this->load->model('contrato','c');
            $this->load->library('rango');

            $contratos = $this->c->get_by_fecha( $post['desde'].' 00:00:00', $post['hasta'].' 23:59:59', $post['filtro'] )->result();
            
            // generar tabla
            $this->load->library('table');
            $this->table->set_empty('&nbsp;');
            
            $tmpl = array ( 'table_open' => '<table class="table table-condensed" >' );
            $this->table->set_template($tmpl);
            $this->table->set_heading('Número', 'Fecha', 'Cliente', 'Calle', 'Módulos', array('data' => 'Total', 'style' => 'text-align: right;'));
            $total = $total_vigentes = $total_canceladas = 0;
            $estatus = 'autorizado';
            $clase = '';
            $contrato = '';
            foreach ($contratos as $c){
                $importe = $this->c->get_importe($c->id);
                if($c->estado == 'cancelado'){
                    $clase = 'cancelado';
                    $total_canceladas += $importe;
                }else{
                    $clase = '';
                    $total_vigentes += $importe;
                }
                if($estatus != $c->estado){
                    // Total de recibos vigentes
                    $this->table->add_row( '', '', '', array('data' => '<strong>Total vigentes</strong>', 'colspan' => '2'), array('data' => '<strong>'.number_format($total_vigentes,2).'</strong>', 'style' => 'text-align: right;'));
                    $this->table->add_row_class($clase);
                    $estatus = $c->estado;
                    
                    $this->table->add_row( array('data' => '', 'colspan' => '6'));
                    $this->table->add_row_class($clase);
                    $this->table->add_row( array('data' => 'CANCELADOS', 'colspan' => '6'));
                    $this->table->add_row_class($clase);
                }
                $fecha = date_create($c->fecha);
                $modulos_contrato = $this->c->get_modulos_agrupados($c->id)->result();
                $calles = '';
                $modulos = '';
                $i = 0;
                foreach($modulos_contrato as $m){
                    if($i > 0){
                        $calles .= '<br>';
                        $modulos .= '<br>';
                    }
                    $calles .= $m->calle;
                    $arreglo = explode(', ',$m->modulo);
                    $modulos .= $this->rango->array_to_rango($arreglo);
                    $i++;
                }
                
                //if($contrato != $c->id){
                    $this->table->add_row(
                        array('data' => $c->numero.'/'.$c->sufijo,'class' => $clase),
                        array('data' => date_format($fecha,'d/m/Y'),'class' => $clase),
                        array('data' => $c->cliente,'class' => $clase),
                        array('data' => $calles,'class' => $clase),
                        array('data' => $modulos,'class' => $clase),
                        array('data' => number_format($importe,2), 'style' => 'text-align: right;', 'class' => $clase)
                    );
                /*}else{
                    $this->table->add_row('','','',
                        array('data' => $c->calle,'class' => $clase),
                        array('data' => $rango,'class' => $clase),
                        ''
                    );
                }*/
                
                $contrato = $c->id;
                $this->table->add_row_class($clase);
                
                $total += $importe;
            }
            
            if($estatus == 'autorizado'){
                // Total de recibos vigentes
                $this->table->add_row( '', '', '', array('data' => '<strong>Total vigentes</strong>', 'colspan' => '2'), array('data' => '<strong>'.number_format($total_vigentes,2).'</strong>', 'style' => 'text-align: right;'));
                $this->table->add_row_class($clase);
            }
            
            // Total de facturas canceladas
            $this->table->add_row( '', '', '', array('data' => 'Total cancelados', 'colspan' => '2'), array('data' => number_format($total_canceladas,2), 'style' => 'text-align: right;'));
            $this->table->add_row_class('info text-error');
            
            $this->table->add_row( array('data' => '', 'colspan' => '6'));
            $this->table->add_row_class($clase);
            // Total
            //$this->table->add_row( '', '', '', array('data' => '<strong>TOTAL</strong>', 'colspan' => '2' ), array('data' => '<strong>'.number_format($total,2).'</strong>', 'style' => 'text-align: right;'));
            //$this->table->add_row_class('info');
            
            $tabla = $this->table->generate();
            
            //$tabla.= '</tbody></table>';
            $this->load->library('tbs');
            $this->load->library('pdf');
            
            // Se obtiene la plantilla (2° parametro se pone false para evitar que haga conversión de caractéres con htmlspecialchars() )
            $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_informes'), false);

            // Se sustituyen los campos en el template
            $this->tbs->VarRef['titulo'] = 'Listado de contratos';
            $this->tbs->VarRef['fecha'] = date('d/m/Y H:i:s');
            $desde = date_create($post['desde']);
            $hasta = date_create($post['hasta']);
            $this->tbs->VarRef['subtitulo'] = 'Del '.date_format($desde, 'd/m/Y').' al '.date_format($hasta, 'd/m/Y');
            $this->tbs->VarRef['contenido'] = $tabla;
            
            $this->tbs->Show(TBS_NOTHING);
            
            // Se regresa el render
            $output = $this->tbs->Source;
            
            $view = str_replace("{contenido_vista}", $output, $this->template);
            
            // PDF
            $pdf = $this->pdf->render($view,'Letter',null,true);
            //$pdf = $view;
            
            $fp = fopen($this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('tmp_path').'contratos_listado.pdf','w');
            fwrite($fp, $pdf);
            fclose($fp);
            $data['reporte'] = 'contratos_listado.pdf';
        }
        $data['titulo'] = 'Informe de contratos <small>Listado</small>';
        $this->load->view('informes/listado', $data);
    }
}

?>
