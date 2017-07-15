<?php
class usuariocreacionController extends Controller {
	public function __construct() {
		parent::__construct ();
		if (!isset($_SESSION['user']))
			$this->redireccionar ('index');

		$paginas_usuario= array_column($_SESSION['menu'], 'id_tec_pagina');
		$pagina="MENU_USUARIO";
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
		$this->_view->setJs ( array ('usuariocreacion' ) );
		$this->_view->renderizar ( 'usuariocreacion' );
	}
	
	public function insertUser(){
	
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
		$id_usuario=trim($_POST['id_usuario']);
		$tipo_acceso=$_POST['tipo_acceso'];
		$password=sha1(trim($_POST['password_usuario']));
		$iduser=trim($_SESSION['user']);
		$ip_usr=trim($_SERVER['REMOTE_ADDR']);
		
		$objModel=$this->loadModel('usuariocreacion');
		$insert_usuario=$objModel->insertUsuario($nombre_usuario,$apellido_usuario,$tipodoc_usuario,$documento_usuario,$email_usuario,$telefono_usuario,
		$unidad_usuario,$area_usuario,$tipo_usuario,$tipo_perfil,$id_usuario,$password,$iduser,$ip_usr);
		
		if($insert_usuario[0]!='00000'){
			$idusuario=0;
			$tipo_error=1;
			$sql_script=$insert_usuario[3];
			$log_error=$objModel->insertError($idusuario,$insert_usuario[2],$iduser,$ip_usr,$tipo_error,$sql_script);
			echo "1";
			exit;
		}
		
		$longitud=count($tipo_acceso);
		
		for($i=0;$i<$longitud;$i++){
			$paginas=trim($tipo_acceso[$i]);
			$insert_paginas=$objModel->insertPaginas($paginas,$id_usuario,$iduser);
				
			if($insert_paginas[0]!='00000'){
				$idemision=0;
				$tipo_error=2;
				$sql_script=$insert_paginas[3];
				$log_error=$objModel->insertError($idemision,$insert_paginas[2],$iduser,$ip_usr,$tipo_error,$sql_script);
				echo "2";
				exit;
			}
		}
		
		echo "0";
	}
	
}
?>