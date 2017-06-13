<?php
class panelController extends Controller {
	public function __construct() {
		parent::__construct ();
		if (!isset($_SESSION['user']))
			$this->redireccionar ('index');
	}
	
	public function index() {
		/* $objModel=$this->loadModel('panel');
		$this->_view->tipo_documento=$objModel->getDocumento();
		$this->_view->estado_consulta=$objModel->getEstado(); */
		$this->_view->setJs ( array ('panel' ) );
		$this->_view->renderizar ( 'panel' );
		
	}
	
	public function getPedido(){
		$objModel=$this->loadModel('panel');
		$pedidos=$objModel->getPedido();
	
		foreach ($pedidos as $reg):
		$miArray['data'][]=$reg;
		endforeach;
	
		echo json_encode ($miArray);
	}
}
?>