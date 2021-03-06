<?php

/**
 * @author cherra
 */
class Administracion extends CI_Controller{
    
    public $layout = 'template_backend';
    
    /**
     * ----------------------------------------------------
     * Métodos para facturas
     * ----------------------------------------------------
     */
    
    public function facturas( $offset = 0 ){
        $this->load->model('factura','a');
        $this->load->model('contrato','c');
        
        $offset = floatval($offset);
        
        // generar paginacion
        $this->config->load("pagination");
        $page_limit = $this->config->item("per_page");
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        $data['action'] = 'operacion/administracion/facturas';
        
        $resultado = $this->a->get_paged_list($page_limit, $offset, $filtro);
        if($resultado)
            $facturas = $resultado->result();
        $this->load->library('pagination');
        $config['base_url'] = site_url('operacion/administracion/facturas/');
        $config['total_rows'] = $this->a->count_all( $filtro );
        $config['uri_segment'] = 4;
        $config['per_page'] = $page_limit;
        $this->pagination->initialize($config);

        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('-');
        $tmpl = array ('table_open'  => '<table class="' . $this->config->item('tabla_css') . '" >' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Estado', 'Fecha', 'Serie', 'Folio', 'Cliente', array('data' => 'Importe','class' => 'hidden-phone'), '','','', '');
        if(isset($facturas)){
            foreach ($facturas as $factura) {
                //$contrato = $this->c->get_by_id($factura->id_recibo)->row();
                $clase = '';
                if($factura->estatus == 0)
                    $clase = 'muted';
                $this->table->add_row(
                    '<i class="'.($factura->estatus == '1' ? 'icon-ok' : 'icon-remove').'"></i>',
                    $factura->fecha,
                    $factura->serie,
                    $factura->folio,
                    $factura->nombre, 
                    array('data' => number_format($factura->total,2,'.',','), 'class' => 'hidden-phone'),
                    array('data' => anchor_popup('operacion/administracion/facturas_documento/' . $factura->id, '<i class="icon-print"></i>', array('class' => 'btn btn-small', 'title' => 'Imprimir')), 'class' => 'hidden-phone'),
                    array('data' => anchor_popup('operacion/administracion/facturas_recibos/' . $factura->id, '<i class="icon-th-list"></i>', array('class' => 'btn btn-small', 'title' => 'Recibos')), 'class' => 'hidden-phone'),
                    array('data' => ($factura->estatus == '0' ? '<a class="btn btn-small disabled"><i class="icon-ban-circle"></i></a>' : anchor('operacion/administracion/facturas_cancelar/'.$factura->id,'<i class="icon-ban-circle"></i>', array('class' => 'btn btn-small', 'title' => 'Cancelar', 'id' => 'cancelar'))), 'class' => 'hidden-phone')
                );
                $this->table->add_row_class($clase);
            }
            $data['link_add'] = anchor('operacion/administracion/facturas_add/','<i class="icon-plus icon-white"></i> Agregar', array('class' => 'btn btn-inverse'));
        }else{
            $data['link_add'] = '<div class="alert"><strong>Aviso:</strong> No hay período activo.</div>';
        }
        
        $data['pagination'] = $this->pagination->create_links();
        $data['table'] = $this->table->generate();
        $data['titulo'] = 'Facturas <small>Listado</small>';
        
        $this->load->view('operacion/facturas/lista', $data);
    }
    
    public function facturas_add( $id_recibo = null ){
        
        $data['titulo'] = 'Facturas <small>Nueva</small>';
        $data['link_back'] = anchor('operacion/administracion/facturas','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        
        $data['action'] = site_url('operacion/administracion/facturas_add');
	
        // Se envía el id del recibo a la vista si viene predefinida en el url
        if(!empty($id_recibo)){
            $data['id_recibo'] = $id_recibo;
        }
        
        $this->load->model('factura','f');
        $this->load->model('recibo','r');
        
        // Si se hizo submit en el formulario
        // $datos es lo que se inserta en la base de datos
        if ( ($datos = $this->input->post()) ) {
            
            if(($this->f->folio_disponible($datos['folio'], $datos['serie']))){
            
                $datos['id_usuario'] = $this->session->userdata('userid');

                // Importes
                $tasa_iva = $this->configuracion->get_valor('iva');
                $datos['subtotal'] = $datos['total'] / (1+$tasa_iva);
                $datos['iva'] = $datos['total'] - $datos['subtotal'];

                // Si vienen dos o mas recibos es factura de Público en General
                // el key 'id_recibo' es un Array de checkbox que viene del formulario de captura
                if(sizeof($datos['id_recibo']) > 1){
                    $cliente = (object)Array('rfc' => $this->configuracion->get_valor('clientes_varios_rfc'), 'razon_social' => $this->configuracion->get_valor('clientes_varios_nombre'), 'tipo' => 'moral', 'calle' => '', 'numero_exterior' => '', 'numero_interior' => '', 'colonia' => '', 'ciudad' => '', 'estado' => '');
                    $concepto = "Renta de espacios varios en la Feria de Todos los Santos Colima";
                }
                // Si es solo un recibo es factura para un solo cliente
                else{

                    $recibo = $this->r->get_by_id($datos['id_recibo'][0])->row();

                    // Datos del contrato
                    $this->load->model('contrato','c');
                    $contrato = $this->c->get_by_id($recibo->id_contrato)->row();

                    // Concepto de la factura
                    if($recibo->tipo == 'anticipo')
                        $concepto = "Anticipo";
                    elseif($recibo->tipo == 'total')
                        $concepto = "Pago total";
                    $concepto.=" al contrato No. ".$contrato->numero."/".$contrato->sufijo." por renta de espacio para la Feria de Todos los Santos Colima ";

                    // Datos del cliente
                    $this->load->model('cliente','cl');
                    $cliente = $this->cl->get_by_id($contrato->id_cliente)->row();
                }
                // Documento
                $this->load->library('tbs');
                $this->load->library('numero_letras');

                // Nombres de meses en español (config/sitio.php)
                $meses = $this->config->item('meses');

                // Se carga el template predefinido para las facturas (tabla Configuracion)
                $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_facturas'));

                // Se sustituyen los campos en el template
                $logo = $this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('imagenes').$this->configuracion->get_valor('logo');
                $this->tbs->VarRef['logo'] = base_url($logo);
                $this->tbs->VarRef['serie'] = $datos['serie'];
                $this->tbs->VarRef['folio'] = $datos['folio'];
                if($cliente->tipo == 'moral'){
                    $this->tbs->VarRef['cliente'] = $cliente->razon_social;
                }else{
                    $this->tbs->VarRef['cliente'] = $cliente->nombre.' '.$cliente->apellido_paterno.' '.$cliente->apellido_materno;
                }
                $this->tbs->VarRef['rfc'] = $cliente->rfc;
                $this->tbs->VarRef['calle'] = $cliente->calle;
                $this->tbs->VarRef['numero'] = $cliente->numero_exterior.$cliente->numero_interior;
                $this->tbs->VarRef['colonia'] = $cliente->colonia;
                $this->tbs->VarRef['ciudad'] = $cliente->ciudad;
                $this->tbs->VarRef['estado'] = $cliente->estado;

                $this->tbs->VarRef['concepto'] = $concepto;
                $this->tbs->VarRef['total'] = '$'.number_format($datos['total'],2,'.',',');
                $this->tbs->VarRef['importe'] = '$'.number_format($datos['total'] / (1 + $this->configuracion->get_valor('iva')),2,'.',',');
                $this->tbs->VarRef['subtotal'] = '$'.number_format($datos['total'] / (1 + $this->configuracion->get_valor('iva')),2,'.',',');
                $this->tbs->VarRef['iva'] = '$'.number_format($datos['total'] / (1 + $this->configuracion->get_valor('iva')) * $this->configuracion->get_valor('iva'),2,'.',',');
                $this->tbs->VarRef['importe_letra'] = $this->numero_letras->convertir(number_format($datos['total'],2,'.',''));

                $fecha = date_create($datos['fecha']);
                $this->tbs->VarRef['fecha'] = date_format($fecha,'d/m/Y');
                $this->tbs->VarRef['dia'] = date_format($fecha,'d');
                $this->tbs->VarRef['mes'] = $meses[date_format($fecha,'n')-1];
                $this->tbs->VarRef['ano'] = date_format($fecha,'Y');
                // Render sin desplegar en navegador
                $this->tbs->Show(TBS_NOTHING);
                // Se almacena el render en el array $data
                $datos['documento'] = $this->tbs->Source;

                // Datos del cliente para guardarlos en la factura
                if($cliente->tipo == 'moral'){
                    $datos['nombre'] = $cliente->razon_social;
                }else{
                    $datos['nombre'] = $cliente->nombre.' '.$cliente->apellido_paterno.' '.$cliente->apellido_materno;
                }
                $datos['rfc'] =  $cliente->rfc;
                $datos['calle'] =  $cliente->calle;
                $datos['no_exterior'] =  $cliente->numero_exterior;
                $datos['no_interior'] =  $cliente->numero_interior;
                $datos['colonia'] =  $cliente->colonia;
                $datos['ciudad'] =  $cliente->ciudad;
                $datos['estado'] =  $cliente->estado;

                // Se almacena el array de recibos en una variable
                $recibo = $datos['id_recibo'];
                // Borramos el campo id_recibo del array $datos para que no marque error al insertar en la base de datos
                unset($datos['id_recibo']);

                // Aquí inica el registro de la factura
                $this->db->trans_start();
                $id_factura = $this->f->save($datos); // Se guarda la factura y se obtiene el id
                foreach ($recibo as $id_recibo) // Se agrega el id de la factura a cada recibo incluido
                    $this->r->update($id_recibo, array('id_factura' => $id_factura));
                $this->db->trans_complete();

                $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Factura registrada</div>';
            }else{
                $data['mensaje'] = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Error! Folio de factura no disponible</div>';
            }
        }
        
        // Recibos disponibles para facturar
        $data['recibos'] = $this->r->get_sin_factura()->result();
        // Serie predefinida en los parametros de configuracion
        $data['serie'] = $this->configuracion->get_valor('facturas_serie');
        
        // Se sugiere el siguiente folio disponible
        $ultimo_folio = $this->f->get_ultimo_folio($data['serie'])->row();
        if(!empty($ultimo_folio))
            $data['folio'] = $ultimo_folio->folio + 1;
        else
            $data['folio'] = 1;
        
        $this->load->view('operacion/facturas/formulario', $data);
    }
    
    public function facturas_cancelar( $id = null ) {
        
        if(!empty($id)){
            $this->load->model('factura', 'f');
            $this->f->cancelar($id);
        }
        redirect(site_url('operacion/administracion/facturas/'));
    }
    
    /********************
     *  Impresión de facturas
     * 
     ********************/
    public function facturas_documento( $id = null ){
        if(!empty($id)){
            $this->layout = "template_pdf";
            $this->load->model('factura', 'f');
            $factura = $this->f->get_by_id($id)->row();
            if( $this->session->flashdata('pdf') ){
                if($factura){
                    $data['contenido'] = $factura->documento;
                    $this->load->view('documento', $data);
                }else{
                    redirect('operacion/administracion/facturas');
                }
            }else{
                $this->session->set_flashdata('pdf', true);
                if($factura){
                    if($factura->estatus == 0)  // Se agrega una marca de agua al PDF
                        $this->session->set_flashdata('watermark', 'Cancelada');
                }
                redirect('operacion/administracion/facturas_documento/'.$id); // Se recarga el método para imprimirlo como PDF
            }
        }else{
            redirect('operacion/administracion/facturas');
        }
    }
    
    public function facturas_recibos( $id = null ){
        if(!empty($id)){
            $this->layout = "template_pdf";
            $this->load->model('factura','f');
            $this->load->model('recibo', 'r');
            $this->load->model('contrato', 'c');
            $this->load->model('cliente', 'cl');
            $this->load->model('giro', 'g');
            $this->load->model('concesion', 'co');
            
            $factura = $this->f->get_by_id( $id )->row();
            $recibos = $this->r->get_by_factura( $id )->result();
            if( $this->session->flashdata('pdf') ){
                if($recibos){
                    // generar tabla
                    $this->load->library('table');
                    $this->table->set_empty('&nbsp;');

                    $tmpl = array ( 'table_open' => '<table class="table table-condensed" >' );
                    $this->table->set_template($tmpl);
                    $this->table->set_heading('Recibo', 'Fecha', 'Cliente', 'Giro', 'Concesión', 'Importe');
                    $total = 0;
                    foreach ($recibos as $r){
                        $fecha = date_create($r->fecha);
                        $contrato = $this->c->get_by_id($r->id_contrato)->row();
                        $cliente = $this->cl->get_by_id( $contrato->id_cliente )->row();
                        $giro = $this->g->get_by_id($cliente->id_giro)->row();
                        $concesion = $this->co->get_by_id($cliente->id_concesion)->row();
                        $this->table->add_row(
                            $r->numero,
                            date_format($fecha,'d/m/Y'),
                            $cliente->tipo == 'moral' ? $cliente->razon_social : $cliente->nombre.' '.$cliente->apellido_paterno.' '.$cliente->apellido_materno,
                            $giro->nombre,
                            $concesion->nombre,
                            array('data' => number_format($r->total,2),'style' => 'text-align: right;')
                        );
                        $total += $r->total;
                    }
                    // Total
                    $this->table->add_row('', '', '', '', '<h5>TOTAL</h5>', array('data' => '<h5>'.number_format($total,2).'</h5>', 'style' => 'text-align: right;'));
                    
                    $tabla = $this->table->generate();
            
                    $this->load->library('tbs');

                    // Se obtiene la plantilla (2° parametro se pone false para evitar que haga conversión de caractéres con htmlspecialchars() )
                    $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_informes'), false);

                    // Se sustituyen los campos en el template
                    $this->tbs->VarRef['titulo'] = 'Recibos por factura';
                    date_default_timezone_set('America/Mexico_City'); // Zona horaria
                    $this->tbs->VarRef['fecha'] = date('d/m/Y H:i:s');
                    $this->tbs->VarRef['subtitulo'] = 'Factura: <strong>'.$factura->serie.' - '.$factura->folio.'</strong>';
                    $this->tbs->VarRef['contenido'] = $tabla;

                    $this->tbs->Show(TBS_NOTHING);

                    $data['contenido'] = $this->tbs->Source;
                    $this->load->view('documento', $data);
                }else{
                    redirect('operacion/administracion/facturas');
                }
            }else{
                $this->session->set_flashdata('pdf', true);
                redirect('operacion/administracion/facturas_recibos/'.$id); // Se recarga el método para imprimirlo como PDF
            }
        }else{
            redirect('operacion/administracion/facturas');
        }
    }


    /***************************************************
     * NOTAS DE CREDITO
     ***************************************************/
    
    public function notas_credito( $offset = 0 ){
        $this->load->model('nota_credito','a');
        $this->load->model('contrato','c');
        
        $offset = floatval($offset);
        
        // generar paginacion
        $this->config->load("pagination");
        $page_limit = $this->config->item("per_page");
        
        // Filtro de busqueda (se almacenan en la sesión a través de un hook)
        $filtro = $this->session->userdata('filtro');
        if($filtro)
            $data['filtro'] = $filtro;
        $data['action'] = 'operacion/administracion/notas_credito';
        
        $resultado = $this->a->get_paged_list($page_limit, $offset, $filtro);
        if($resultado)
            $notas = $resultado->result();
        $this->load->library('pagination');
        $config['base_url'] = site_url('operacion/administracion/facturas/');
        $config['total_rows'] = $this->a->count_all( $filtro );
        $config['uri_segment'] = 4;
        $config['per_page'] = $page_limit;
        $this->pagination->initialize($config);

        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('-');
        $tmpl = array ('table_open'  => '<table class="' . $this->config->item('tabla_css') . '" >' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Estado', 'Fecha', 'Serie', 'Folio', 'Cliente', array('data' => 'Importe','class' => 'hidden-phone'), '','','', '');
        if(isset($notas)){
            foreach ($notas as $nota) {
                //$contrato = $this->c->get_by_id($factura->id_recibo)->row();
                $importe = $this->a->get_importe($nota->id);
                $clase = '';
                if($nota->estatus == 'cancelada')
                    $clase = 'muted';
                $this->table->add_row(
                    '<i class="'.($nota->estatus == 'pendiente' ? 'icon-search' : ($nota->estatus == 'revisada' ? 'icon-zoom-in' : ($nota->estatus == 'autorizada' ? 'icon-ok' : 'icon-remove'))).'"></i>',
                    $nota->fecha,
                    $nota->serie,
                    $nota->folio,
                    $nota->nombre, 
                    array('data' => number_format($importe,2,'.',','), 'class' => 'hidden-phone'),
                    array('data' => anchor_popup('operacion/administracion/notas_credito_documento/' . $nota->id, '<i class="icon-print"></i>', array('class' => 'btn btn-small', 'title' => 'Imprimir')), 'class' => 'hidden-phone'),
                    $nota->estatus == 'pendiente' ? anchor('operacion/administracion/notas_credito_contratos/'.$nota->id,'<i class="icon-list"></i>', array('class' => 'btn btn-small', 'title' => 'Contratos', 'id' => 'contratos')) : '<a class="btn btn-small disabled"><i class="icon-list"></i></a>',
                    array('data' => ($nota->estatus == 'pendiente' ? anchor('operacion/administracion/notas_credito_revisar/' . $nota->id, '<i class="icon-zoom-in"></i>', array('class' => 'btn btn-small', 'title' => 'Marcar como revisada', 'id' => 'revisar')) : '<a class="btn btn-small disabled"><i class="icon-zoom-in"></i></a>'), 'class' => 'hidden-phone'),    
                    array('data' => ($nota->estatus == 'revisada' ? anchor('operacion/administracion/notas_credito_autorizar/' . $nota->id, '<i class="icon-ok"></i>', array('class' => 'btn btn-small', 'title' => 'Autorizar', 'id' => 'autorizar')) : '<a class="btn btn-small disabled"><i class="icon-ok"></i></a>'), 'class' => 'hidden-phone'),    
                    array('data' => ($nota->estatus == 'cancelada' ? '<a class="btn btn-small disabled"><i class="icon-ban-circle"></i></a>' : anchor('operacion/administracion/notas_credito_cancelar/'.$nota->id,'<i class="icon-ban-circle"></i>', array('class' => 'btn btn-small', 'title' => 'Cancelar', 'id' => 'cancelar'))), 'class' => 'hidden-phone')
                );
                $this->table->add_row_class($clase);
            }
            $data['link_add'] = anchor('operacion/administracion/notas_credito_add/','<i class="icon-plus icon-white"></i> Agregar', array('class' => 'btn btn-inverse'));
        }else{
            $data['link_add'] = '<div class="alert"><strong>Aviso:</strong> No hay período activo.</div>';
        }
        
        $data['pagination'] = $this->pagination->create_links();
        $data['table'] = $this->table->generate();
        $data['titulo'] = 'Notas de crédito <small>Listado</small>';
        
        $this->load->view('operacion/notas_credito/lista', $data);
    }
    
    public function notas_credito_add(){
        
        $data['titulo'] = 'Nota de crédito <small>Alta</small>';
        $data['link_back'] = anchor('operacion/administracion/notas_credito','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('operacion/administracion/notas_credito_add');
      
        $this->load->model('nota_credito', 'nt');
        
        if ( ($datos = $this->input->post()) ) {
            $datos['id_usuario'] = $this->session->userdata('userid');
            
            $this->load->model('cliente','c');
            $cliente = $this->c->get_by_id($datos['id_cliente'])->row();
            unset($datos['id_cliente']);
            $datos['rfc'] = $cliente->rfc;
            if($cliente->tipo == 'moral'){
                $datos['nombre'] = $cliente->razon_social;
            }else{
                $datos['nombre'] = $cliente->nombre.' '.$cliente->apellido_paterno.' '.$cliente->apellido_materno;
            }
            $datos['calle'] = $cliente->calle;
            $datos['no_exterior'] = $cliente->numero_exterior;
            $datos['no_interior'] = $cliente->numero_interior;
            $datos['colonia'] = $cliente->colonia;
            $datos['ciudad'] = $cliente->ciudad;
            $datos['estado'] = $cliente->estado;
            
            $this->nt->save($datos);
            $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Nota de crédito registrada</div>';
        }
        if( ($ultimo_folio = $this->nt->get_ultimo_folio()->row()) )
            $data['folio'] = $ultimo_folio->folio + 1;
        else
            $data['folio'] = 1;
        $data['serie'] = $this->configuracion->get_valor('notas_credito_serie');
        $this->load->view('operacion/notas_credito/formulario', $data);
    }
    
    public function notas_credito_revisar( $id = null ) {
        if(!empty($id)){
            $this->load->model('nota_credito', 'nc');
            
            $nota = $this->nc->get_by_id($id)->row();
            if($nota){
                $id_usuario = $this->session->userdata('userid');
                $this->nc->revisar($id, $id_usuario);
            }
        }
        redirect('operacion/administracion/notas_credito/');
    }
    
    /*
     * FALTA HABILITAR EL TEMPLATE
     */
    public function notas_credito_autorizar( $id = null ) {
        if(!empty($id)){
            $this->load->model('nota_credito', 'nc');
            
            $nota = $this->nc->get_by_id($id)->row();
            if($nota){
                $id_usuario = $this->session->userdata('userid');
                $documento = $this->notas_credito_render_template($id);
                $this->nc->autorizar($id, $id_usuario, $documento);
            }
        }
        redirect('operacion/administracion/notas_credito/');
    }
    
    public function notas_credito_contratos($id = null, $id_contrato = null) {
        
        if (empty($id)) {
            redirect('operacion/administracion/notas_credito/');
        }

        $this->load->model('nota_credito','nt');
        $this->load->model('contrato', 'co');
        $this->load->model('cliente','cl');
        
        $data['nota'] = $this->nt->get_by_id($id)->row();
        
        $data['titulo'] = 'Nota de crédito <small>Contratos</small>';
        $data['link_back'] = anchor('operacion/administracion/notas_credito','<i class="icon-arrow-left"></i> Regresar',array('class'=>'btn'));
        $data['mensaje'] = '';
        $data['action'] = site_url('operacion/administracion/notas_credito_contratos') . '/' . $id;
        
        if(!empty($id_contrato)){
            $data['contrato'] = $this->co->get_by_id($id_contrato)->row();
            $data['cliente'] = $this->cl->get_by_id($data['contrato']->id_cliente)->row();
        }
        if ( ($datos = $this->input->post()) ) {
            $importe_contrato = $this->co->get_importe($datos['id_contrato']);
            $datos['importe'] = ($datos['descuento'] / 100) * $importe_contrato;
            unset($datos['descuento']);
            
            $result = $this->nt->save_contrato( $datos );
            if($result > 0){
                unset($datos);
                $datos['total'] = $this->nt->get_importe($id);
                $datos['subtotal'] = $datos['total'] / (1 + $this->configuracion->get_valor('iva'));
                $datos['iva'] = $datos['subtotal'] * $this->configuracion->get_valor('iva');
                $this->nt->update($id, $datos);
                $data['mensaje'] = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Contrato agregado correctamente</div>';
            }else{
                $data['mensaje'] = '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>Error al agregar el contrato</div>';
            }
            //$data['contratos'] = $this->co->get_con_adeudo()->result();
        }
        
        $contratos = $this->nt->get_contratos($id)->result();
        // generar tabla
        $this->load->library('table');
        $this->table->set_empty('-');
        $tmpl = array ('table_open'  => '<table class="' . $this->config->item('tabla_css') . '" >' );
        $this->table->set_template($tmpl);
        $this->table->set_heading('Número', 'Cliente', array('data' => 'Importe','class' => 'hidden-phone'), 'Descuento', '%', '');
        
        foreach ($contratos as $c) {
            $cliente = $this->cl->get_by_id($c->id_cliente)->row();
            
            $importe_contrato = $this->co->get_importe($c->id);
            $this->table->add_row(
                $c->numero,
                $cliente->nombre.' '.$cliente->apellido_paterno.' '.$cliente->apellido_materno,
                array('data' => number_format($importe_contrato,2,'.',','), 'class' => 'hidden-phone'),
                number_format($c->importe,2,'.',','),
                number_format($c->importe / $importe_contrato * 100,2,'.',',').'%',
                array('data' => anchor('operacion/administracion/notas_credito_delete_contrato/' . $id.'/'.$c->id, '<i class="icon-remove"></i>', array('class' => 'btn btn-small', 'title' => 'Quitar')), 'class' => 'hidden-phone')
            );
        }
        $data['table'] = $this->table->generate();

        $this->load->helper('form');
        $this->load->view('operacion/notas_credito/notas_credito_contratos', $data);

    }
    
    public function notas_credito_delete_contrato( $id = null, $id_contrato = null ){
        if(empty($id_contrato) or empty($id)){
            redirect('operacion/administracion/notas_credito_contratos/');
        }
        $this->load->model('nota_credito','nc');
        $this->nc->delete_contrato($id, $id_contrato);
        redirect('operacion/administracion/notas_credito_contratos/'.$id);
    }
    
    public function notas_credito_cancelar($id = null){
        if(!empty($id)){
            $this->load->model('nota_credito','nc');
            $this->nc->cancelar($id);
        }
        redirect('operacion/administracion/notas_credito');
    }
    
    private function notas_credito_render_template($id){
        $this->load->model('nota_credito','nc');
        
        $nota = $this->nc->get_by_id($id)->row();
        
        $this->load->library('tbs');
        $this->load->library('numero_letras');

        // Nombres de meses en español (config/sitio.php)
        $meses = $this->config->item('meses');
        
        // Se carga el template predefinido para las notas de crédito (tabla Configuracion)
        $this->tbs->LoadTemplate($this->configuracion->get_valor('template_path').$this->configuracion->get_valor('template_notas_credito'));

        // Se sustituyen los campos en el template
        $logo = $this->configuracion->get_valor('asset_path').$this->configuracion->get_valor('imagenes').$this->configuracion->get_valor('logo');
        $this->tbs->VarRef['logo'] = base_url($logo);
        $this->tbs->VarRef['serie'] = $nota->serie;
        $this->tbs->VarRef['folio'] = $nota->folio;
        $this->tbs->VarRef['cliente'] = $nota->nombre;
        $this->tbs->VarRef['rfc'] = $nota->rfc;
        $this->tbs->VarRef['calle'] = $nota->calle;
        $this->tbs->VarRef['numero'] = $nota->no_exterior.$nota->no_interior;
        $this->tbs->VarRef['colonia'] = $nota->colonia;
        $this->tbs->VarRef['ciudad'] = $nota->ciudad;
        $this->tbs->VarRef['estado'] = $nota->estado;

        $this->load->model('contrato','co');
        $contratos = $this->nc->get_contratos($id)->result();
        if($contratos){
            $this->tbs->VarRef['contratos'] = "";
            $i=0;
            $total = 0;
            foreach($contratos as $c){
                if($i > 0)
                    $this->tbs->VarRef['contratos'] .= ",";
                $this->tbs->VarRef['contratos'] .= $c->numero;
                $i++;
                $total += $this->co->get_importe($c->id);
            }
        }
        $this->tbs->VarRef['porcentaje'] = number_format($nota->total / $total * 100,2,'.','');
        $this->tbs->VarRef['concepto'] = $nota->concepto;
        $this->tbs->VarRef['total'] = '$'.number_format($nota->total,2,'.',',');
        $this->tbs->VarRef['importe'] = '$'.number_format($nota->subtotal,2,'.',',');
        $this->tbs->VarRef['subtotal'] = '$'.number_format($nota->subtotal,2,'.',',');
        $this->tbs->VarRef['iva'] = '$'.number_format($nota->iva,2,'.',',');
        $this->tbs->VarRef['importe_letra'] = $this->numero_letras->convertir(number_format($nota->total,2,'.',''));

        $fecha = date_create($nota->fecha);
        $this->tbs->VarRef['fecha'] = date_format($fecha,'d/m/Y');
        $this->tbs->VarRef['dia'] = date_format($fecha,'d');
        $this->tbs->VarRef['mes'] = $meses[date_format($fecha,'n')-1];
        $this->tbs->VarRef['ano'] = date_format($fecha,'Y');

        $this->load->model('usuario','u');
        $usuario = $this->u->get_by_id($nota->id_usuario)->row();
        $usuario_revisa = $this->u->get_by_id($nota->id_usuario_revisa)->row();
        $this->tbs->VarRef['usuario'] = $usuario->nombre;
        if($usuario_revisa)
            $this->tbs->VarRef['usuario_revisa'] = $usuario_revisa->nombre;
        else
            $this->tbs->VarRef['usuario_revisa'] = '';
        $this->tbs->VarRef['usuario_autoriza'] = '';

        // Render sin desplegar en navegador
        $this->tbs->Show(TBS_NOTHING);
        // Se almacena el render en el array $data
        return $this->tbs->Source;
    }
    
    public function notas_credito_documento($id = null){
        if(!empty($id)){
            $this->layout = "template_pdf";
            $this->load->model('nota_credito', 'nc');
            $nota = $this->nc->get_by_id($id)->row();
            if( $this->session->flashdata('pdf') ){
                if($nota){
                    if($nota->estatus == 'autorizada'){
                        $data['contenido'] = $nota->documento;
                    }else{
                        $data['contenido'] = $this->notas_credito_render_template($id);
                    }
                    $this->load->view('documento',$data);
                }else{
                    redirect('operacion/administracion/notas_credito');
                }
            }else{
                $this->session->set_flashdata('pdf', true);
                if($nota){
                    if($nota->estatus == 'pendiente'){  // Se agrega una marca de agua al PDF
                        $this->session->set_flashdata('watermark', 'En revisión');
                    }elseif($nota->estatus == 'revisada'){
                        $this->session->set_flashdata('watermark', 'Para autorización ');
                    }
                }
                redirect('operacion/administracion/notas_credito_documento/'.$id); // Se recarga el método para imprimirlo como PDF
            }
        }else{
            redirect('operacion/administracion/notas_credito');
        }
    }
}

?>
