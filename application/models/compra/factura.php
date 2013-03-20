<?php
/**
 * Description of factura
 *
 * @author cherra
 */
class Factura extends CI_Model{
    
    public function get_all(){
        $this->db->select('P.*, S.NAME AS SUPPLIERNAME')->from('PURCHASE AS P');
        $this->db->join('SUPPLIERS AS S','P.SUPPLIER = S.ID');
        $this->db->order_by('P.DATENEW, P.NUMBER');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get($filtros = null){
        $this->db->select('P.*, S.NAME AS SUPPLIERNAME')->from('PURCHASE AS P');
        $this->db->join('SUPPLIERS AS S','P.SUPPLIER = S.ID');
        
        if(!is_null($filtros)){
            foreach($filtros as $key => $valor){
                $this->db->where($key,$valor);
            }
        }
        
        $this->db->order_by('P.DATENEW','DESC');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function insert($data){
        $this->db->insert('PURCHASE',$data);
        return $this->db->affected_rows();
    }
    
    public function insert_producto($data){
        $this->db->insert('PURCHASELINE',$data);
        return $this->db->affected_rows();
    }
}

?>
