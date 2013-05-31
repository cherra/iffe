<?php
/**
  *
 * @author cherra
 */
class Nota_credito extends CI_Model{
    
    private $tbl = 'NotasCredito';
    private $tbl_nt_contratos = 'NotaCreditoContratos';
    private $tbl_contratos = "Contratos";
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
        $this->db->join('NotaCreditoContratos ntc','nt.id = ntc.id_nota_credito','left');
        $this->db->join('Contratos c','ntc.id_contrato = c.id','left');
        $this->db->where('c.id_periodo', $this->periodo->id);
        $this->db->group_by('nt.id');
        $query = $this->db->get($this->tbl.' nt');
        return $query->num_rows();
    }

    /**
    * ***********************************************************************
    * Cantidad de registros por pagina
    * ***********************************************************************
    */
    function get_paged_list($limit = null, $offset = 0) {
        $this->db->select('nt.*');
        $this->db->join('NotaCreditoContratos ntc','nt.id = ntc.id_nota_credito','left');
        $this->db->join('Contratos c','ntc.id_contrato = c.id AND c.id_periodo = '.$this->periodo->id,'left');
        $this->db->group_by('nt.id');
        $this->db->order_by('nt.serie, nt.folio','desc');
        return $this->db->get($this->tbl.' nt',$limit, $offset);
    }
    
    function get_contratos( $id, $limit = null, $offset = 0 ){
        $this->db->select('co.id, co.numero, ntc.importe, co.id_cliente');
        $this->db->join($this->tbl_contratos.' co','ntc.id_contrato = co.id');
        $this->db->where('ntc.id_nota_credito',$id);
        $this->db->order_by('co.numero');
        return $this->db->get($this->tbl_nt_contratos.' ntc', $limit, $offset);
    }
    
    function get_importe( $id ){
        $this->db->select('SUM(ntc.importe) as importe', FALSE);
        $this->db->join($this->tbl_contratos.' co','ntc.id_contrato = co.id');
        $this->db->where('ntc.id_nota_credito',$id);
        $this->db->group_by('ntc.id_nota_credito');
        $query = $this->db->get($this->tbl_nt_contratos.' ntc');
        if($query->num_rows() > 0)
            return $query->row()->importe;
        else
            return 0;
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
    * Alta de nota
    * ***********************************************************************
    */
    function save( $datos ) {
        if( $this->db->insert($this->tbl, $datos) )
            return $this->db->insert_id();
        else
            return false;
    }
    
    function save_contrato( $datos ) {
        $this->db->where('id_contrato',$datos['id_contrato']);
        $this->db->where('id_nota_credito', $datos['id_nota_credito']);
        $query = $this->db->get($this->tbl_nt_contratos);
        if($query->num_rows() > 0){
            $registro = $query->row();
            $datos['importe'] += $registro->importe;
            $this->db->where('id',$registro->id);
            $this->db->update($this->tbl_nt_contratos, $datos);
        }else{
            $this->db->insert($this->tbl_nt_contratos, $datos);
        }
        
        return $this->db->affected_rows();
    }
    
    function delete_contrato($id, $id_contrato){
        $this->db->delete($this->tbl_nt_contratos, array('id_nota_credito' => $id, 'id_contrato' => $id_contrato));
    }

    /**
    * ***********************************************************************
    * Actualizar nota por id
    * ***********************************************************************
    */
    function update( $id, $datos ) {
        $this->db->where('id', $id);
        $this->db->update($this->tbl, $datos);
    }
    
    /**
    * ***********************************************************************
    * Revisar
    * ***********************************************************************
    */
    function revisar( $id, $id_usuario ) {
        if(!empty($id) && !empty($id_usuario)){
            $this->db->where('id', $id);
            $this->db->update($this->tbl, array('estatus' => 'revisada', 'id_usuario_revisa' => $id_usuario));
        }
    }
    
    /**
    * ***********************************************************************
    * Autorizar
    * ***********************************************************************
    */
    function autorizar( $id, $id_usuario, $documento = null ) {
        if(!empty($id) && !empty($id_usuario)){
            $this->db->where('id', $id);
            $this->db->update($this->tbl, array('estatus' => 'autorizada', 'id_usuario_autoriza' => $id_usuario, 'documento' => $documento));
        }
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
