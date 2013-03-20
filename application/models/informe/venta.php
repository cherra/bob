<?php
/**
 * Description of informe
 *
 * @author cherra
 */
class Venta extends CI_Model {
    
    public function producto($producto = null, $categoria = null, $proveedor = null, $sucursal = null, $fecha_inicio = null, $fecha_fin = null){
        if(!empty($fecha_inicio)){
            $this->db->select('PRODUCTS.ID, PRODUCTS.CODE, PRODUCTS.REFERENCE, PRODUCTS.NAME, SUM(TICKETLINES.UNITS) AS UNITS, SUM(TICKETLINES.PRICE) AS PRICESELL, PRODUCTS.PRICEBUY * SUM(TICKETLINES.UNITS) AS PRICEBUY');
            $this->db->from('PRODUCTS');
            $this->db->join('CATEGORIES','PRODUCTS.CATEGORY = CATEGORIES.ID');
            $this->db->join('TICKETLINES','PRODUCTS.ID = TICKETLINES.PRODUCT');
            $this->db->join('TICKETS','TICKETLINES.TICKET = TICKETS.ID');
            $this->db->join('RECEIPTS','TICKETS.ID = RECEIPTS.ID');
            if(!empty($sucursal))
                $this->db->where('TICKETS.LOCATION',$sucursal);
            if(!empty($proveedor))
                $this->db->where('PRODUCTS.SUPPLIER',$proveedor);
            
            $this->db->where('RECEIPTS.DATENEW >=',$fecha_inicio.' 00:00:00');
            if(!empty($fecha_fin))
                $this->db->where('RECEIPTS.DATENEW <=',$fecha_fin.' 23:59:59');
            if(!empty($categoria))
                $this->db->where('PRODUCTS.CATEGORY',$categoria);
            if(!empty($producto)){
                $this->db->like('PRODUCTS.NAME',$producto);
                $this->db->or_like('PRODUCTS.CODE',$producto);
                $this->db->or_like('PRODUCTS.REFERENCE',$producto);
            }
            
            $this->db->group_by('PRODUCTS.ID');
            $this->db->order_by('CATEGORIES.NAME, PRODUCTS.CODE');
            $query = $this->db->get();
            return $query->result();
        }
    }
    
    public function categoria($proveedor = null, $sucursal = null, $fecha_inicio = null, $fecha_fin = null){
        if(!empty($fecha_inicio)){
            $this->db->select('CATEGORIES.ID, CATEGORIES.NAME, SUM(TICKETLINES.UNITS) AS UNITS, SUM(TICKETLINES.PRICE) AS PRICESELL, SUM(PRODUCTS.PRICEBUY * TICKETLINES.UNITS) AS PRICEBUY');
            $this->db->from('CATEGORIES');
            $this->db->join('PRODUCTS', 'CATEGORIES.ID = PRODUCTS.CATEGORY');
            $this->db->join('TICKETLINES','PRODUCTS.ID = TICKETLINES.PRODUCT');
            $this->db->join('TICKETS','TICKETLINES.TICKET = TICKETS.ID');
            $this->db->join('RECEIPTS','TICKETS.ID = RECEIPTS.ID');
            if(!empty($sucursal))
                $this->db->where('TICKETS.LOCATION',$sucursal);
            if(!empty($proveedor))
                $this->db->where('PRODUCTS.SUPPLIER',$proveedor);
            
            $this->db->where('RECEIPTS.DATENEW >=',$fecha_inicio.' 00:00:00');
            if(!empty($fecha_fin))
                $this->db->where('RECEIPTS.DATENEW <=',$fecha_fin.' 23:59:59');
            
            $this->db->group_by('CATEGORIES.ID');
            $this->db->order_by('CATEGORIES.NAME');
            $query = $this->db->get();
            return $query->result();
        }
    }
}

?>
