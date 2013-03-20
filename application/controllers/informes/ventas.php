<?php
/**
 * Description of informes
 *
 * @author cherra
 */
class Ventas extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('informe/venta');
    }
    
    public function productos(){
        $this->load->model('catalogo/sucursal');
        $this->load->model('catalogo/proveedor');
        $this->load->model('catalogo/categoria');
        $datos_busqueda = $this->session->userdata('filtros');

        $data['sucursales'] = $this->sucursal->get_all();
        $data['proveedores'] = $this->proveedor->get_all();
        $data['categorias'] = $this->categoria->get_all();
        
        $data['ventas'] = $this->venta->producto($datos_busqueda['PRODUCT'], $datos_busqueda['CATEGORY'], $datos_busqueda['SUPPLIER'], $datos_busqueda['LOCATION'], $datos_busqueda['FECHAINICIO'], $datos_busqueda['FECHAFIN']);
        
        $data['filtros'] = $datos_busqueda;
        $this->load->view('informe/venta/producto',$data);
    }
    
    public function categorias(){
        $this->load->model('catalogo/proveedor');
        $this->load->model('catalogo/sucursal');
        
        $datos_busqueda = $this->session->userdata('filtros');
        
        $data['proveedores'] = $this->proveedor->get_all();
        $data['sucursales'] = $this->sucursal->get_all();
        $data['ventas'] = $this->venta->categoria($datos_busqueda['SUPPLIER'], $datos_busqueda['LOCATION'], $datos_busqueda['FECHAINICIO'], $datos_busqueda['FECHAFIN']);
        
        $data['filtros'] = $datos_busqueda;
        
        $this->load->view('informe/venta/categoria', $data);
    }
}

?>
