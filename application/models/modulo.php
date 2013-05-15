<?php

class Modulo extends CI_Model {
    
    private $tbl = 'Modulos'; 

    function __construct() {
    	parent::__construct();
        $this->load->database();
    }

    /**
    * ***********************************************************************
    * Cantidad de registros
    * ***********************************************************************
    */
    function count_all($id_calle) {
        $this->db->where('id_calle', $id_calle);
        return $this->db->count_all_results($this->tbl);
    }

    /**
    * ***********************************************************************
    * Cantidad de registros por pagina
    * ***********************************************************************
    */
    function get_paged_list($id_calle, $limit = null, $offset = 0) {
        $this->db->where('id_calle', $id_calle);
        $this->db->order_by('numero','asc');
        return $this->db->get($this->tbl, $limit, $offset);
    }
    
    /**
    * ***********************************************************************
    * Obtener todos los modulos disponibles por $id_calle
    * ***********************************************************************
    */
    function get_disponibles($id_calle){
        $this->db->select('m.*, cm.id_contrato AS contrato, c.estado as estado');
        $this->db->join('ContratoModulos cm','m.id = cm.id_modulo','left');
        $this->db->join('Contratos c','cm.id_contrato = c.id AND c.estado != "cancelado"','left');
        $this->db->where('m.id_calle', $id_calle);
        //$this->db->where('c.estado != "cancelado"');
        $this->db->having('contrato IS NULL');
        $this->db->order_by('m.numero');
        return $this->db->get($this->tbl.' m');
    }
    
 
    /**
    * ***********************************************************************
    * Obtener modulo por id
    * ***********************************************************************
    */
    function get_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->tbl);
    }

    /**
    * ***********************************************************************
    * Alta de modulo
    * ***********************************************************************
    */
    function save($datos) {
        $this->db->insert($this->tbl, $datos);
        return $this->db->insert_id();
    }

    /**
    * ***********************************************************************
    * Actualizar modulo por id
    * ***********************************************************************
    */
    function update($id, $datos) {
        $this->db->where('id', $id);
        $this->db->update($this->tbl, $datos);
    }

    /**
    * ***********************************************************************
    * Eliminar modulo por id
    * ***********************************************************************
    */
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->tbl);
    }

}

?>
