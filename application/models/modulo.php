<?php

class Modulo extends CI_Model {
    
    private $tbl = 'Modulos'; 
    private $periodo;
    
    function __construct() {
    	parent::__construct();
        $this->load->database();
        $this->periodo = $this->session->userdata('periodo'); // Período activo de la feria
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
    
    function get_all(){
        $this->db->select('m.*, c.id AS id_calle, c.nombre AS calle, IF(LENGTH(cl.razon_social) > 0, cl.razon_social, CONCAT(cl.nombre, " ", cl.apellido_paterno, " ", cl.apellido_materno)) AS cliente, g.nombre as giro', FALSE);
        $this->db->join('Calles c', 'm.id_calle = c.id');
        $this->db->join('ContratoModulos cm','m.id = cm.id_modulo','left');
        $this->db->join('Contratos co', 'cm.id_contrato = co.id AND co.id_periodo = '.$this->periodo->id,'left');
        $this->db->join('Clientes cl', 'co.id_cliente = cl.id','left');
        $this->db->join('Giros g', 'cl.id_giro = g.id', 'left');
        $this->db->group_by('m.id');
        $this->db->order_by('m.id_calle, m.numero');
        return $this->db->get($this->tbl.' m');
    }
    
    function get_all_vigentes(){
        $this->db->select('m.*, c.id AS id_calle, c.nombre AS calle, 
            IF(LENGTH(cl.razon_social) > 0, cl.razon_social, CONCAT(cl.nombre, " ", cl.apellido_paterno, " ", cl.apellido_materno)) AS cliente, 
            g.nombre as giro,
            co.estado AS estado', FALSE);
        $this->db->join('Calles c', 'm.id_calle = c.id');
        $this->db->join('(ContratoModulos cm JOIN Contratos co)','m.id = cm.id_modulo AND cm.id_contrato = co.id AND co.estado != "cancelado" AND co.id_periodo = '.$this->periodo->id.'','left');
        $this->db->join('Clientes cl', 'co.id_cliente = cl.id','left');
        $this->db->join('Giros g', 'cl.id_giro = g.id', 'left');
        //$this->db->group_by('m.id');
        //$this->db->having('estado != "cancelado" OR estado IS NULL');
        $this->db->order_by('m.id_calle, m.numero');
        return $this->db->get($this->tbl.' m');
    }
    
    /**
    * ***********************************************************************
    * Obtener todos los modulos disponibles por $id_calle
    * ***********************************************************************
    */
    function get_disponibles($id_calle){
        //$this->db->select('m.*, c.id AS contrato, c.estado as estado');
        $this->db->select('m.*');
        //$this->db->join('ContratoModulos cm','m.id = cm.id_modulo','left');
        //$this->db->join('Contratos c','cm.id_contrato = c.id AND c.id_periodo = '.$this->periodo->id.' AND cm.id_modulo NOT IN (SELECT m.id from Modulos m JOIN ContratoModulos cm ON m.id = cm.id_modulo join Contratos c on cm.id_contrato = c.id AND c.id_periodo = '.$this->periodo->id.' where estado = "pendiente" or estado = "autorizado")','left');
        $this->db->where('m.id NOT IN (SELECT m.id from Modulos m JOIN ContratoModulos cm ON m.id = cm.id_modulo join Contratos c on cm.id_contrato = c.id AND c.id_periodo = '.$this->periodo->id.' where estado = "pendiente" or estado = "autorizado")');
        $this->db->where('m.id_calle', $id_calle);
        //$this->db->where('c.id NOT IN (SELECT id FROM Contratos WHERE estado = "pendiente" OR estado = "autorizado")');
        $this->db->group_by('m.id');
        //$this->db->having('contrato IS NULL OR estado = "cancelado"');
        $this->db->order_by('m.numero');
        return $this->db->get($this->tbl.' m');
    }
    
    function disponible( $id ){
        $this->db->select('m.*, c.id AS contrato, c.estado as estado');
        $this->db->join('ContratoModulos cm','m.id = cm.id_modulo','left');
        $this->db->join('Contratos c','cm.id_contrato = c.id AND c.id_periodo = '.$this->periodo->id.' AND cm.id_modulo IN (SELECT m.id from Modulos m JOIN ContratoModulos cm ON m.id = cm.id_modulo join Contratos c on cm.id_contrato = c.id AND c.id_periodo = '.$this->periodo->id.' where estado = "pendiente" or estado = "autorizado")','left');
        $this->db->where('m.id', $id);
        $this->db->having('contrato IS NOT NULL OR estado != "cancelado"');
        $query = $this->db->get($this->tbl.' m');
        if($query->num_rows() > 0)
            return false;
        else
            return true;
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
    
    function get_by_calle( $id_calle ){
        $this->db->where('id_calle', $id_calle);
        return $this->db->get($this->tbl);
    }
    
    function get_by_calle_numero($id_calle, $numero){
        $this->db->where('id_calle', $id_calle);
        $this->db->where('numero', $numero);
        return $this->db->get($this->tbl)->row();
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
