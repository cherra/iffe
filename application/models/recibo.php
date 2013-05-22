<?php
/**
 * Description of contrato
 *
 * @author cherra
 */
class Recibo extends CI_Model{
    
    private $tbl = 'Recibos'; 
    /**
    * ***********************************************************************
    * Cantidad de registros
    * ***********************************************************************
    */
    function count_all() {
        return $this->db->count_all_results($this->tbl);
    }

    /**
    * ***********************************************************************
    * Cantidad de registros por pagina
    * ***********************************************************************
    */
    function get_paged_list($limit = null, $offset = 0) {
        $this->db->select('r.*, CONCAT(cl.nombre," ",cl.apellido_paterno," ",cl.apellido_materno) AS cliente', FALSE);
        $this->db->join('Contratos c','r.id_contrato = c.id');
        $this->db->join('Clientes cl','c.id_cliente = cl.id');
        $this->db->order_by('r.numero','desc');
        return $this->db->get($this->tbl.' r',$limit, $offset);
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
