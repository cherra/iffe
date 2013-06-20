<?php
/**
 * Description of contrato
 *
 * @author cherra
 */
class Contrato extends CI_Model{
    
    private $tbl = 'Contratos'; 
    private $tbl_contrato_modulos = 'ContratoModulos'; 
    private $tbl_adjuntos_contrato = 'ContratoAdjuntos';
    private $tbl_adjuntos = 'Adjuntos';
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
            $this->db->join('Clientes cl','c.id_cliente = cl.id');
            $this->db->join('ContratoModulos cm', 'c.id = cm.id_contrato','left');
            $this->db->join('Modulos m','cm.id_modulo = m.id','left');
            $this->db->join('Calles ca','m.id_calle = ca.id','left');
            $this->db->where('c.id_periodo', $this->periodo->id);
            if(!empty($filtro)){
                $filtro = explode(' ', $filtro);
                foreach($filtro as $f){
                    $like = '(cl.nombre LIKE "%'.$f.'%" OR cl.apellido_paterno LIKE "%'.$f.'%" OR cl.apellido_materno LIKE "%'.$f.'%" OR cl.razon_social LIKE "%'.$f.'%" OR ca.nombre LIKE "%'.$f.'%")';
                    $this->db->where($like);
                }
            }
            $this->db->group_by('c.id');
            return $this->db->get($this->tbl.' c')->num_rows();
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
            $this->db->select('c.*, IF(cl.tipo = "moral", cl.razon_social, CONCAT(cl.nombre," ",cl.apellido_paterno," ",cl.apellido_materno)) AS cliente', FALSE);
            $this->db->join('Clientes cl','c.id_cliente = cl.id');
            $this->db->join('ContratoModulos cm', 'c.id = cm.id_contrato','left');
            $this->db->join('Modulos m','cm.id_modulo = m.id','left');
            $this->db->join('Calles ca','m.id_calle = ca.id','left');
            $this->db->where('c.id_periodo', $this->periodo->id);
            if(!empty($filtro)){
                $filtro = explode(' ', $filtro);
                foreach($filtro as $f){
                    $like = '(cl.nombre LIKE "%'.$f.'%" OR cl.apellido_paterno LIKE "%'.$f.'%" OR cl.apellido_materno LIKE "%'.$f.'%" OR cl.razon_social LIKE "%'.$f.'%" OR ca.nombre LIKE "%'.$f.'%")';
                    $this->db->where($like);
                }
            }
            $this->db->group_by('c.id');
            $this->db->order_by('numero','desc');
            return $this->db->get($this->tbl.' c',$limit, $offset);
        }else {
            return false;
        }
    }
    
    function get_con_adeudo( $query = null ) {
        $this->db->select('c.id, c.id_periodo, c.id_cliente, c.id_usuario, c.sufijo, c.numero, c.fecha, c.fecha_inicio, c.fecha_vencimiento, c.testigo1, c.testigo2, c.observaciones, c.estado');
        $this->db->select('IF(cl.tipo = "moral", cl.razon_social, CONCAT(cl.nombre," ",cl.apellido_paterno," ",cl.apellido_materno)) AS cliente', FALSE);
        $this->db->select('IFNULL((SELECT IFNULL(SUM(ncc.importe),0) FROM NotaCreditoContratos ncc JOIN NotasCredito nc ON ncc.id_nota_credito = nc.id WHERE ncc.id_contrato = c.id AND nc.estatus = "autorizada" GROUP BY ncc.id_contrato),0) + SUM(r.total) as abonos',FALSE);
        $this->db->select('(SELECT SUM(cm.importe) FROM ContratoModulos cm WHERE cm.id_contrato = c.id GROUP BY cm.id_contrato) AS total',FALSE);
        $this->db->join('Clientes cl','c.id_cliente = cl.id');
        $this->db->join('Recibos r','c.id = r.id_contrato','left');
        $this->db->where('c.estado','autorizado');
        $this->db->where('(r.estado = "vigente" OR r.estado IS NULL)');
        $this->db->where('c.id_periodo', $this->periodo->id);
        if(!empty($query))
            $this->db->where("(concat(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) like '%" . $query . "%' OR c.numero = '".$query."' OR cl.razon_social like '%".$query."%')");
        $this->db->having('(SELECT SUM(cm.importe) FROM ContratoModulos cm WHERE cm.id_contrato = c.id GROUP BY cm.id_contrato) > abonos OR abonos IS NULL OR abonos = 0');
        $this->db->group_by('c.id');
        $this->db->order_by('numero','desc');
        
        return $this->db->get($this->tbl.' c');
    }
    
    function get_modulos( $id, $limit = null, $offset = 0 ){
        $this->db->select('c.nombre as calle, m.id as id_modulo, m.numero as modulo, m.categoria, m.tipo, cm.importe, m.id_calle');
        $this->db->join('Modulos m','cm.id_modulo = m.id');
        $this->db->join('Calles c','m.id_calle = c.id');
        $this->db->where('cm.id_contrato',$id);
        $this->db->order_by('c.nombre, m.numero');
        return $this->db->get($this->tbl_contrato_modulos.' cm', $limit, $offset);
    }
    
    function get_modulos_agrupados( $id, $limit = null, $offset = 0 ){
        $this->db->select('c.nombre as calle, m.id as id_modulo, COUNT(DISTINCT m.id) AS cantidad, GROUP_CONCAT(DISTINCT m.numero ORDER BY m.numero SEPARATOR ",") as modulo, cm.importe AS importe, SUM(cm.importe) AS total, m.categoria, m.id_calle', FALSE);
        $this->db->join('Modulos m','cm.id_modulo = m.id');
        $this->db->join('Calles c','m.id_calle = c.id');
        $this->db->where('cm.id_contrato',$id);
        $this->db->group_by('c.id');
        $this->db->order_by('c.nombre, m.numero');
        return $this->db->get($this->tbl_contrato_modulos.' cm', $limit, $offset);
    }
    
    function get_importe( $id ){
        $this->db->select('SUM(cm.importe) as importe', FALSE);
        $this->db->join('Modulos m','cm.id_modulo = m.id');
        $this->db->where('cm.id_contrato',$id);
        $this->db->group_by('cm.id_contrato');
        $query = $this->db->get($this->tbl_contrato_modulos.' cm');
        if($query->num_rows() > 0)
            return $query->row()->importe;
        else
            return 0;
    }
    
    function get_abonos( $id ){
        $this->db->select('SUM(r.total) as abonos', FALSE);
        $this->db->where('r.id_contrato',$id);
        $this->db->where('r.estado','vigente');
        $this->db->group_by('r.id_contrato');
        $query = $this->db->get('Recibos r');
        if($query->num_rows() > 0){
            return $query->row()->abonos;
        }else{
            return 0;
        }
    }
    
    function get_notas( $id ){
        $this->db->select('IFNULL(SUM(ncc.importe),0) as notas', FALSE);
        $this->db->join('NotasCredito nc','ncc.id_nota_credito = nc.id');
        $this->db->where('ncc.id_contrato', $id);
        $this->db->where('nc.estatus = "autorizada"');
        $this->db->group_by('ncc.id_contrato');
        $query = $this->db->get('NotaCreditoContratos ncc');
        if($query->num_rows() > 0){
            return $query->row()->notas;
        }else{
            return 0;
        }
    }
    
    function get_saldo( $id ){
        $importe = $this->get_importe($id);
        $abonos = $this->get_abonos($id);
        $notas = $this->get_notas($id);
        
        return number_format($importe-$abonos-$notas,2,'.','');
    }

    /**
    * ***********************************************************************
    * Obtener contrato por id
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
    * Alta de contrato
    * ***********************************************************************
    */
    function save( $contrato ) {
        if( $this->db->insert($this->tbl, $contrato) )
            return $this->db->insert_id();
        else
            return false;
    }
    
    function save_modulo( $modulo ) {
        if( $this->db->insert($this->tbl_contrato_modulos, $modulo) )
            return $this->db->insert_id();
        else
            return false;
    }
    
    function delete_modulo($id_modulo){
        $this->db->delete($this->tbl_contrato_modulos, array('id_modulo' => $id_modulo));
    }

    /**
    * ***********************************************************************
    * Actualizar contrato por id
    * ***********************************************************************
    */
    function update( $id, $contrato ) {
        $this->db->where('id', $id);
        $this->db->update($this->tbl, $contrato);
    }

    /**
    * ***********************************************************************
    * Autorizar
    * ***********************************************************************
    */
    function autorizar( $id, $documento ) {
        if(!empty($id) && !empty($documento)){
            $this->db->where('id', $id);
            $this->db->update($this->tbl, array('estado' => 'autorizado', 'documento' => $documento));
        }
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
