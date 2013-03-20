<?php
/**
 * Description of facturas
 *
 * @author cherra
 */
class Facturas extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('compra/factura');
    }
    
    public function listado(){
        $data = array();
        $this->load->model('catalogo/proveedor');
        
        if($this->input->is_ajax_request()){
            $datos_busqueda = $this->input->post();
        }else{
            $datos_busqueda = $this->session->userdata('filtros');
        }
        
        $data['compras'] = $this->factura->get($datos_busqueda?$datos_busqueda:NULL);
        
        if($this->input->is_ajax_request()){
            echo json_encode($data['compras'], JSON_FORCE_OBJECT);
        }else{
            $data['proveedores'] = $this->proveedor->get_all();
            $data['filtros'] = $datos_busqueda;
            $this->load->view('compra/factura/listado',$data);
        }
    }
    
    public function registro(){
        $this->load->model('catalogo/producto');
        $this->load->model('inventario/almacen');
        if($this->input->is_ajax_request()){
            $data = $this->input->post();
            if($data){
                $this->db->trans_start();
                //var_dump($data);
                $id = $this->uuid->v4();
                $compra = array(
                    'ID' => $id,
                    'DATENEW' => $data['DATENEW'],
                    'LOCATION' => $data['LOCATION'],
                    'SUPPLIER' => $data['SUPPLIER'],
                    'CONDITIONS' => $data['CONDITIONS'],
                    'NUMBER' => $data['NUMBER'],
                    'SUBTOTAL' => $data['SUBTOTAL'],
                    'DISCOUNT' => $data['DISCOUNT'],
                    'TOTAL' => $data['TOTAL'],
                    'DUEDATE' => $data['DUEDATE']
                );
                if($this->factura->insert($compra) > 0){
                    foreach($data['PRODUCTS'] as $producto){
                        $id_producto = $this->uuid->v4();
                        $datos = array(
                            'ID' => $id_producto,
                            'REFERENCE' => $producto[1],
                            'CODE' => $this->producto->genera_codigo($data['SUPPLIER'], $producto[2]),
                            'NAME' => $producto[3],
                            'PRICEBUY' => $producto[6],
                            'PRICESELL' => $producto[7],
                            'CATEGORY' => $producto[2],
                            'SUPPLIER' => $data['SUPPLIER'],
                            'TAXCAT' => '000'
                        );
                        if($this->producto->insert($datos) > 0){
                            $datos = array(
                                'ID' => $this->uuid->v4(),
                                'PURCHASE' => $id,
                                'PRODUCT' => $id_producto,
                                'UNITS' => $producto[0],
                                'PRICE' => $producto[4],
                                'DISCOUNT' => $producto[5],
                                'PRICEDISCOUNT' => $producto[6],
                                'TAXID' => '000',
                                'LINE' => $producto[8]
                            );
                            if($this->factura->insert_producto($datos) > 0){
                                $datos = array(
                                    'ID' => $this->uuid->v4(),
                                    'DATENEW' => $data['DATENEW'],
                                    'REASON' => '1',
                                    'LOCATION' => $data['LOCATION'],
                                    'PRODUCT' => $id_producto,
                                    'UNITS' => $producto[0],
                                    'PRICE' => $producto[6]
                                );
                                if($this->almacen->movimiento($datos) == 0)
                                    echo "ERROR";
                            }else
                                echo "ERROR";
                        }else
                            echo "ERROR";
                    }
                    echo "OK";
                }
                $this->db->trans_complete();
            }
        }else{
            $this->load->model('inventario/almacen');
            $this->load->model('catalogo/proveedor');
            $this->load->model('catalogo/categoria');
            
            $data['almacenes'] = $this->almacen->get_all();
            $data['proveedores'] = $this->proveedor->get_all();
            $data['categorias'] = $this->categoria->get_all();
            $this->load->view('compra/factura/registro',$data);
        }
    }
}

?>
