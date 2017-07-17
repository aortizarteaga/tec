<?php
class usuarioupdateController extends Controller {
	public function __construct() {
		parent::__construct ();
		if (!isset($_SESSION['user']))
			$this->redireccionar ('index');

		$paginas_usuario= array_column($_SESSION['menu'], 'id_tec_pagina');
		$pagina="MENU_UPDATE_USUARIO";
		$valores=in_array($pagina,$paginas_usuario);
		
		if($valores!=1){
			$this->redireccionar ('error');
		}
		
	}
	
	public function index() {
		$objModel=$this->loadModel('usuariocreacion');
		$this->_view->tipo_documento=$objModel->getDocumento();
		$this->_view->tipo_usuario=$objModel->getUsuario();
		$this->_view->tipo_perfil=$objModel->getPerfil();
		$this->_view->tipo_acceso=$objModel->getAcceso();
		$this->_view->setJs ( array ('usuarioupdate' ) );
		$this->_view->renderizar ( 'usuarioupdate' );
	}
	
	public function getUsuario(){
	
		$objModel=$this->loadModel('usuarioupdate');
		$usuarios=$objModel->getUsuario();
	
		foreach ($usuarios as $reg):
		$miArray['data'][]=$reg;
		endforeach;
	
		echo json_encode ($miArray);
	}
	
	public function getUsuariodatos($id_usuario){
		$objModel=$this->loadModel('usuarioupdate');
		$datos_usuario=$objModel->getUsuariodatos($id_usuario);
		echo $datos_usuario[0]."|".$datos_usuario[2]."|".$datos_usuario[3]."|".
				$datos_usuario[4]."|".$datos_usuario[5]."|".$datos_usuario[6]."|".$datos_usuario[7]."|".
				$datos_usuario[8]."|".$datos_usuario[9]."|".$datos_usuario[10]."|".$datos_usuario[11]."|".
				$datos_usuario[14]."|".$datos_usuario[18];
	}
	
	public function updateUser(){
		
		$usuario_actualizar=trim($_POST['usuario_actualizar']);
		$nombre_usuario=strtoupper(trim($_POST['nombre_usuario']));
		$apellido_usuario=strtoupper(trim($_POST['apellido_usuario']));
		$tipodoc_usuario=trim($_POST['tipodoc_usuario']);
		$documento_usuario=strtoupper(trim($_POST['documento_usuario']));
		$email_usuario=strtoupper(trim($_POST['email_usuario']));
		$telefono_usuario=trim($_POST['telefono_usuario']);
		$unidad_usuario=strtoupper(trim($_POST['unidad_usuario']));
		$area_usuario=strtoupper(trim($_POST['area_usuario']));
		$tipo_usuario=trim($_POST['tipo_usuario']);
		$tipo_perfil=trim($_POST['tipo_perfil']);
		$status=$_POST['chk_usuario'];
		$iduser=trim($_SESSION['user']);
		$ip_usr=trim($_SERVER['REMOTE_ADDR']);
		if($status=='on')$status='Y';else $status='N';
	
		$objModel=$this->loadModel('usuarioupdate');
		$update_usuario=$objModel->updateUser($nombre_usuario,$apellido_usuario,$tipodoc_usuario,$documento_usuario,$email_usuario,$telefono_usuario,
				$unidad_usuario,$area_usuario,$tipo_usuario,$tipo_perfil,$iduser,$ip_usr,$usuario_actualizar,$status);

		if($update_usuario[0]!='00000'){
			$idusuario=$usuario_actualizar;
			$tipo_error=1;
			$sql_script=$insert_usuario[3];
			$log_error=$objModel->insertError($idusuario,$update_usuario[2],$iduser,$ip_usr,$tipo_error,$sql_script);
			echo "1";
			exit;
		}
	
		echo "0";
	}
	
}
?>