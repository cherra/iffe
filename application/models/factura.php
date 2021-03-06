<?php
/**
  *
 * @author cherra
 */
class Factura extends CI_Model{
    
    private $tbl = 'Facturas'; 
    private $periodo = '';
    
    function __construct() {
        parent::__construct();
        $this->periodo = $this->session->userdata('periodo'); // Período activo de la feria
    }
    
    /**
    * ***********************************************************************
    * Cantidad de registros
    * ***********************************************************************
    */
    function count_all( $filtro = null ) {
        if(!empty($this->periodo)){
            $this->db->join('Recibos r','f.id = r.id_factura');
            $this->db->join('Contratos c','r.id_contrato = c.id');
            $this->db->join('ContratoModulos cm', 'c.id = cm.id_contrato');
            $this->db->join('Modulos m','cm.id_modulo = m.id');
            $this->db->join('Calles ca','m.id_calle = ca.id');
            $this->db->where('c.id_periodo', $this->periodo->id);
            if(!empty($filtro)){
                $filtro = explode(' ', $filtro);
                foreach($filtro as $f){
                    $like = '(f.nombre LIKE "%'.$f.'%" 
                        OR ca.nombre LIKE "%'.$f.'%"
                        OR r.numero = "'.$f.'")';
                    $this->db->where($like);
                }
            }
            $this->db->group_by('f.id');
            $query = $this->db->get($this->tbl.' f');
            return $query->num_rows();
        }else{
            return 0;
        }
    }

    /**
    * ***********************************************************************
    * Cantidad de registros por pagina
    * ***********************************************************************
    */
    function get_paged_list($limit = null, $offset = 0, $filtro = null) {
        if(!empty($this->periodo)){
            $this->db->select('f.*');
            $this->db->join('Recibos r','f.id = r.id_factura');
            $this->db->join('Contratos c','r.id_contrato = c.id');
            $this->db->join('ContratoModulos cm', 'c.id = cm.id_contrato');
            $this->db->join('Modulos m','cm.id_modulo = m.id');
            $this->db->join('Calles ca','m.id_calle = ca.id');
            $this->db->where('c.id_periodo', $this->periodo->id);
            if(!empty($filtro)){
                $filtro = explode(' ', $filtro);
                foreach($filtro as $f){
                    $like = '(f.nombre LIKE "%'.$f.'%" 
                        OR ca.nombre LIKE "%'.$f.'%"
                        OR r.numero = "'.$f.'")';
                    $this->db->where($like);
                }
            }
            $this->db->group_by('f.id');
            $this->db->order_by('f.serie, f.folio','desc');
            return $this->db->get($this->tbl.' f',$limit, $offset);
        }else{
            return false;
        }
    }
    
    function get_by_fecha( $desde, $hasta, $filtro = null ){
        if(!empty($this->periodo)){
            $this->db->select('f.*');
            $this->db->join('Recibos r','f.id = r.id_factura');
            $this->db->join('Contratos c','r.id_contrato = c.id');
            $this->db->join('ContratoModulos cm', 'c.id = cm.id_contrato');
            $this->db->join('Modulos m','cm.id_modulo = m.id');
            $this->db->join('Calles ca','m.id_calle = ca.id');
            $this->db->where('c.id_periodo', $this->periodo->id);
            $this->db->where('f.fecha BETWEEN "'.$desde.'" AND "'.$hasta.'"');
            if(!empty($filtro)){
                $filtro = explode(' ', $filtro);
                foreach($filtro as $f){
                    $like = '(f.nombre LIKE "%'.$f.'%" 
                        OR ca.nombre LIKE "%'.$f.'%"
                        OR r.numero = "'.$f.'")';
                    $this->db->where($like);
                }
            }
            $this->db->group_by('f.id');
            $this->db->order_by('f.estatus', 'desc');
            $this->db->order_by('f.serie, f.folio','asc');
            return $this->db->get($this->tbl.' f');
        }else{
            return false;
        }
    }
    
    /**
    * ***********************************************************************
    * Obtener recibo por id
    * ***********************************************************************
    */
    function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->tbl);
    }
    
    function get_last(){
        $this->db->order_by('id', 'desc');
        return $this->db->get($this->tbl, 1);
    }
    
    function get_ultimo_folio($serie = null){
        $this->db->select('folio');
        if(!empty($serie)){
            $this->db->where('serie',$serie);
        }
        $this->db->order_by('folio','desc');
        return $this->db->get($this->tbl, 1);
    }
    
    function folio_disponible($folio, $serie = null){
        $this->db->where('folio',$folio);
        if(!empty($serie)){
            $this->db->where('serie',$serie);
        }
        $query = $this->db->get($this->tbl);
        if($query->num_rows() > 0){
            return false;
        }else{
            return true;
        }
    }

    /**
    * ***********************************************************************
    * Alta de factura
    * ***********************************************************************
    */
    function save( $datos ) {
        if( $this->db->insert($this->tbl, $datos) )
            return $this->db->insert_id();
        else
            return false;
    }

    /**
    * ***********************************************************************
    * Actualizar recibo por id
    * ***********************************************************************
    */
    function update( $id, $datos ) {
        $this->db->where('id', $id);
        $this->db->update($this->tbl, $datos);
    }

    
    /**
    * ***********************************************************************
    * Cancelar
    * ***********************************************************************
    */
    function cancelar( $id ) {
        $this->db->where('id', $id);
        $this->db->update($this->tbl, array('estatus' => '0'));
    }

}

?>
