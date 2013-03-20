<?php
/**
 * Description of informes
 *
 * @author cherra
 */
class Informes extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('venta/informe');
    }
    
    public function proveedor(){
        $this->load->model('catalogo/proveedor');
        $datos_busqueda = $this->session->userdata('filtros');
        //if(strlen($datos_busqueda['SUPPLIER']) > 0){
            $data['ventas'] = $this->informe->productos_por_proveedor($datos_busqueda['SUPPLIER'], $datos_busqueda['FECHAINICIO'], $datos_busqueda['FECHAFIN']);
        //}
        $data['proveedores'] = $this->proveedor->get_all();
        $data['filtros'] = $datos_busqueda;
        $this->load->view('venta/informe/proveedor',$data);
    }
}

?>
