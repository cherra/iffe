<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Configuracion
 *
 * @author cherra
 * 
 * Tabla Configuración:
 * 
CREATE TABLE IF NOT EXISTS Configuracion (
  id_configuracion int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(128) NOT NULL,
  valor varchar(128) NOT NULL,
  descripcion varchar(128) NOT NULL,
  PRIMARY KEY (id_configuracion)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
 * 
 */
class Configuracion {
    
    private $CI;
    private $tbl = "Configuracion";
    
    function __construct() {
        $this->CI =& get_instance();
    }
    
    function count_all() {
        return $this->CI->db->count_all($this->tbl);
    }
    
    public function get_valor( $key ){
        if(!empty($key)){
            $this->CI->db->where('key', $key);
            $resultado = $this->CI->db->get($this->tbl)->row();
            if($resultado)
                return $resultado->valor;
            else
                return false;
        }
    }
    
    public function get_by_id( $id ){
        $this->CI->db->where('id', $id);
        return $this->CI->db->get($this->tbl);
    }
    
    public function get_paged_list($limit = null, $offset = 0){
        $this->CI->db->order_by('key');
        return $this->CI->db->get($this->tbl, $limit, $offset);
    }
    
    public function set_valor( $id = null, $datos = null ){
        if(!empty($datos) && !empty($id)){
            $this->CI->db->where('id', $id);
            $this->CI->db->update($this->tbl, $datos);
            return $this->CI->db->affected_rows();
        }
    }
    
    public function save( $parametro ){
        $this->CI->db->insert($this->tbl, $parametro);
        return $this->CI->db->insert_id();
    }
    
    public function delete( $id ){
        $this->CI->db->where('id', $id);
        $this->CI->db->delete($this->tbl);
    }
}

?>
