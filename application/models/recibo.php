<?php
/**
 * Description of contrato
 *
 * @author cherra
 */
class Recibo extends CI_Model{
    
    private $tbl = 'Recibos';
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
        if(!empty($this->periodo)){
            $this->db->join('Contratos c','r.id_contrato = c.id');
            $this->db->join('Clientes cl','c.id_cliente = cl.id');
            $this->db->where('c.id_periodo', $this->periodo->id);
            return $this->db->get($this->tbl.' r')->num_rows();
        }else{
            return 0;
        }
    }

    /**
    * ***********************************************************************
    * Cantidad de registros por pagina
    * ***********************************************************************
    */
    function get_paged_list($limit = null, $offset = 0) {
        if(!empty($this->periodo)){
            $this->db->select('r.*, IF(cl.tipo = "moral", cl.razon_social, CONCAT(cl.nombre," ",cl.apellido_paterno," ",cl.apellido_materno)) AS cliente, f.serie, f.folio, f.estatus AS estatus_factura', FALSE);
            $this->db->join('Contratos c','r.id_contrato = c.id');
            $this->db->join('Clientes cl','c.id_cliente = cl.id');
            $this->db->join('Facturas f','r.id_factura = f.id','left');
            $this->db->where('c.id_periodo', $this->periodo->id);
            $this->db->order_by('r.numero','desc');
            return $this->db->get($this->tbl.' r',$limit, $offset);
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
        $this->db->select('r.*, f.serie, f.folio');
        $this->db->join('Facturas f','r.id_factura = f.id','left');
        $this->db->where('r.id', $id);
        return $this->db->get($this->tbl.' r');
    }
    
    function get_last(){
        $this->db->order_by('id', 'desc');
        return $this->db->get($this->tbl, 1);
    }
    
    /**
     * **********************************************************************
     * Obtener los recibos que no tienen factura
     * **********************************************************************
     */
    function get_sin_factura(){
        $this->db->select('r.*, IF(c.tipo = "moral", c.razon_social, CONCAT( c.nombre, " ", c.apellido_paterno," ",c.apellido_materno )) AS cliente', FALSE);
        $this->db->join('Contratos co','r.id_contrato = co.id');
        $this->db->join('Clientes c','co.id_cliente = c.id');
        $this->db->join('Facturas f','r.id_factura = f.id','left');
        $this->db->where('id_factura IS NULL OR f.estatus = 0');
        $this->db->where('r.estado = "vigente"');
        $this->db->order_by('r.numero','desc');
        return $this->db->get($this->tbl." r");
    }

    /**
    * ***********************************************************************
    * Alta de recibo
    * ***********************************************************************
    */
    function save( $recibo ) {
        if( $this->db->insert($this->tbl, $recibo) )
            return $this->db->insert_id();
        else
            return false;
    }

    /**
    * ***********************************************************************
    * Actualizar recibo por id
    * ***********************************************************************
    */
    function update( $id, $recibo ) {
        $this->db->where('id', $id);
        $this->db->update($this->tbl, $recibo);
    }

    
    /**
    * ***********************************************************************
    * Cancelar
    * ***********************************************************************
    */
    function cancelar( $id ) {
        $this->db->where('id', $id);
        $this->db->update($this->tbl, array('estado' => 'cancelado'));
    }

}

?>
