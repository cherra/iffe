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
    function count_all() {
        $this->db->join('Recibos r','f.id = r.id_factura');
        $this->db->join('Contratos c','r.id_contrato = c.id');
        $this->db->join('Clientes cl','c.id_cliente = cl.id');
        $this->db->where('c.id_periodo', $this->periodo->id);
        return $this->db->get($this->tbl.' f')->num_rows();
    }

    /**
    * ***********************************************************************
    * Cantidad de registros por pagina
    * ***********************************************************************
    */
    function get_paged_list($limit = null, $offset = 0) {
        $this->db->select('f.*, CONCAT(cl.nombre," ",cl.apellido_paterno," ",cl.apellido_materno) AS cliente', FALSE);
        $this->db->join('Recibos r','f.id = r.id_factura');
        $this->db->join('Contratos c','r.id_contrato = c.id');
        $this->db->join('Clientes cl','c.id_cliente = cl.id');
        $this->db->where('c.id_periodo', $this->periodo->id);
        $this->db->order_by('f.serie, f.folio','desc');
        return $this->db->get($this->tbl.' f',$limit, $offset);
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
        $this->db->update($this->tbl, array('estado' => '0'));
    }

}

?>
