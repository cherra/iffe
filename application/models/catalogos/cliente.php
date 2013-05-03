<?php

class Cliente extends CI_Model {
    
	private $tbl_clientes = 'Clientes'; 
        private $tbl_dependientes = 'ClienteDependientes'; 
        private $tbl_referencias = 'ClienteReferencias'; 

    function __construct() {
    	parent::__construct();
        $this->load->database();
    }

 	/**
 	* ***********************************************************************
 	* Cantidad de registros
 	* ***********************************************************************
 	*/
    function count_all() {
        return $this->db->count_all($this->tbl_clientes);
    }

    /**
    * ***********************************************************************
 	* Cantidad de registros por pagina
 	* ***********************************************************************
 	*/
 	function get_paged_list($limit = 10, $offset = 0) {
        $this->db->order_by('id_cliente','desc');
        return $this->db->get($this->tbl_clientes, $limit, $offset);
    }

    /**
    * ***********************************************************************
    * Obtener cliente por id
    * ***********************************************************************
    */
    function get_by_id($id) {
        $this->db->where('id_cliente', $id);
        return $this->db->get($this->tbl_clientes);
    }

    /**
    * ***********************************************************************
    * Obtener todos los clientes
    * ***********************************************************************
    */
    function get_all() {
        $this->db->order_by('apellido_paterno, apellido_materno, nombre');
        return $this->db->get($this->tbl_clientes);
    }

    /**
    * ***********************************************************************
    * Alta de Clientes
    * ***********************************************************************
    */
    function save($cliente) {
        $this->db->insert($this->tbl_clientes, $cliente);
        return $this->db->insert_id();
    }

    /**
    * ***********************************************************************
    * Actualizar cliente por id
    * ***********************************************************************
    */
    function update($id, $cliente) {
        $this->db->where('id_cliente', $id);
        $this->db->update($this->tbl_clientes, $cliente);
    }

    /**
    * ***********************************************************************
    * Eliminar cliente por id
    * ***********************************************************************
    */
    function delete($id) {
        $this->db->where('id_cliente', $id);
        $this->db->delete($this->tbl_clientes);
    }

    /**
    * ***********************************************************************
    * servicio autocompletar
    * ***********************************************************************
    */
    function get_by_query($query) {
        $sql = "SELECT id_cliente, concat(nombre, ' ', apellido_paterno, ' ', apellido_materno) as nombre 
                FROM Clientes 
                WHERE concat(nombre, ' ', apellido_paterno, ' ', apellido_materno) like '%" . $query . "%';";
        $query = $this->db->query($sql);
        $num = $query->num_rows();
        if ($num > 0) {
            return $query->result();
        } 
        else {
            return false;
        }    
    }
    
    /**
    * ***********************************************************************
    * Cantidad de registros por pagina de dependientes
    * ***********************************************************************
    */
    function get_paged_list_dependientes($id_cliente, $limit = null, $offset = 0) {
        $this->db->where('id_cliente', $id_cliente);
        $this->db->order_by('nombres','asc');
        return $this->db->get($this->tbl_dependientes, $limit, $offset);
    }
    
    /**
    * ***********************************************************************
    * Obtiene el número total de dependientes registrados
    * ***********************************************************************
    */
    function count_all_dependientes($id_cliente) {
        $this->db->where('id_cliente', $id_cliente);
        return $this->db->count_all($this->tbl_dependientes);
    }
    
    /**
    * ***********************************************************************
    * Get dependiente por id
    * ***********************************************************************
    */
    function get_by_id_dependiente($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->tbl_dependientes);
    }
    
    /**
    * ***********************************************************************
    * Guardar dependiente
    * ***********************************************************************
    */
    function save_dependiente($dependiente) {
        $this->db->insert($this->tbl_dependientes, $dependiente);
        return $this->db->insert_id();
    }
    
    /**
    * ***********************************************************************
    * Actualizar dependiente por id
    * ***********************************************************************
    */
    function update_dependiente($id, $dependiente) {
        $this->db->where('id', $id);
        $this->db->update($this->tbl_dependientes, $dependiente);
    }
    
    /**
    * ***********************************************************************
    * Eliminar dependiente por id
    * ***********************************************************************
    */
    function delete_dependiente($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->tbl_dependientes);
    }
    
    
    /**
    * ***********************************************************************
    * Cantidad de registros por pagina de referencias
    * ***********************************************************************
    */
    function get_paged_list_referencias($id_cliente, $limit = null, $offset = 0) {
        $this->db->where('id_cliente', $id_cliente);
        $this->db->order_by('nombres','asc');
        return $this->db->get($this->tbl_referencias, $limit, $offset);
    }
    
    /**
    * ***********************************************************************
    * Obtiene el número total de dependientes registrados
    * ***********************************************************************
    */
    function count_all_referencias($id_cliente) {
        $this->db->where('id_cliente', $id_cliente);
        return $this->db->count_all($this->tbl_referencias);
    }
    
    /**
    * ***********************************************************************
    * Get dependiente por id
    * ***********************************************************************
    */
    function get_by_id_referencia($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->tbl_referencias);
    }
    
    /**
    * ***********************************************************************
    * Guardar dependiente
    * ***********************************************************************
    */
    function save_referencia($referencia) {
        $this->db->insert($this->tbl_referencias, $referencia);
        return $this->db->insert_id();
    }
    
    /**
    * ***********************************************************************
    * Actualizar dependiente por id
    * ***********************************************************************
    */
    function update_referencia($id, $referencia) {
        $this->db->where('id', $id);
        $this->db->update($this->tbl_referencias, $referencia);
    }
    
    /**
    * ***********************************************************************
    * Eliminar dependiente por id
    * ***********************************************************************
    */
    function delete_referencia($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->tbl_referencias);
    }
}

?>
