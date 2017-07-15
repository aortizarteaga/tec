<?php
class usuariocreacionModel extends Model {
	public function __construct() {
		parent::__construct ();
		if (!isset($_SESSION['user']))
			$this->redireccionar ('index');
	}
	
	public function getDocumento(){
		$sql = "SELECT id_tec_tipo_documento,descripcion FROM `ase_tec_tipo_documento`";
		$prod = $this->_db->prepare($sql);
		$prod->execute();
		return $prod;
	}
	
	public function getUsuario(){
		$usuario=$_SESSION['idperfil'];
		if($usuario==1){
			$sql = "SELECT id_tec_tipo_usuario,descripcion FROM `ase_tec_tipo_usuario`";
		}
		else{
			$sql = "SELECT id_tec_tipo_usuario,descripcion FROM `ase_tec_tipo_usuario` WHERE id_tec_tipo_usuario NOT IN (1)";
		}
		$prod = $this->_db->prepare($sql);
		$prod->execute();
		return $prod;
	}
	
	public function getPerfil(){
		$sql = "SELECT id_tec_perfil,descripcion FROM `ase_tec_tipo_perfil`";
		$prod = $this->_db->prepare($sql);
		$prod->execute();
		return $prod;
	}
	
	public function getAcceso(){
		if($_SESSION['idperfil']==1){
			$sql = "SELECT id_tec_pagina,descripcion,tipo FROM `ase_tec_pagina`";
		}
		else{
			$sql = "SELECT id_tec_pagina,descripcion,tipo FROM `ase_tec_pagina` WHERE id_tec_pagina NOT IN('MENU_CARGA','MENU_PANEL')";
		}
		
	
		$prod = $this->_db->prepare($sql);
		$prod->execute();
		return $prod->fetchAll();
	}
	
	public function insertUsuario($nombre_usuario,$apellido_usuario,$tipodoc_usuario,$documento_usuario,$email_usuario,$telefono_usuario,
							   $unidad_usuario,$area_usuario,$tipo_usuario,$tipo_perfil,$id_usuario,$password,$iduser,$ip_usr){
					
				try{
					$sql_insert = "INSERT INTO `ase_tec_usuario` SET id_tec_usuario='$id_usuario', password='$password',
					id_tipo_usuario=$tipo_usuario,id_tipo_perfil=$tipo_perfil,nombres='$nombre_usuario',apellidos='$apellido_usuario',
					email='$email_usuario',id_tec_tipo_doc=$tipodoc_usuario,documento='$documento_usuario',telefono='$telefono_usuario',
					unidad='$unidad_usuario',area='$area_usuario',ip_usr_registro='$ip_usr',id_usr_registro='$iduser'";
		
					$prod = $this->_db->prepare ( $sql_insert );
					$prod->execute ();
					
					$arr = $prod->errorInfo ();
					return $arr;
				}
				catch(Exception $e){
					
					$sql_error = "INSERT INTO `ase_tec_usuario` SET id_tec_usuario='$nombre_usuario', password='$apellido_usuario',
					id_tipo_usuario=$tipo_usuario,id_tipo_perfil=$tipo_perfil,nombres='$nombre_usuario',apellidos='$apellido_usuario',
					email='$email_usuario',id_tec_tipo_doc=$tipodoc_usuario,documento='$documento_usuario',telefono='$telefono_usuario',
					unidad='$unidad_usuario',area='$area_usuario',ip_usr_registro='$ip_usr',id_usr_registro='$iduser'";
					
					$arr = $prod->errorInfo ();
					array_push ($arr,$sql_error);
					return $arr;
					
					
				}
				
			
	}
	
	public function insertPaginas($paginas,$usuario,$iduser){
		$sql_insert = "INSERT INTO `ase_tec_usuario_pagina`(id_tec_pagina,usuario_permiso,
					   id_usr_registro) VALUES(:id_pagina,:id_usuario,:id_usr_registro)";
		
		try{
			$sql_error = "INSERT INTO `ase_tec_usuario_pagina`(id_pagina,id_usuario,
			id_usr_registro) VALUES('$paginas','$usuario','$iduser')";
		
			$prod = $this->_db->prepare ( $sql_insert );
			$prod->execute(array(':id_pagina'=> $paginas,
					':id_usuario'=> $usuario,
					':id_usr_registro'=>$iduser));
		
			$arr = $prod->errorInfo ();
			return $arr;
		}
		catch(Exception $e){
			$sql_error = "INSERT INTO `ase_tec_usuario_pagina`(id_pagina,id_usuario,
			id_usr_registro) VALUES('$paginas','$usuario','$iduser')";
				
			$arr = $prod->errorInfo ();
			array_push ($arr,$sql_error);
			return $arr;
		}
	
	}
	
	public function insertError($idcodigo,$id_ult,$iduser,$ip_usr,$tipo_error,$sql_script){
	
		$sql = "INSERT INTO ase_tec_log_error(id,nombre_error,id_usr_registro,ip_usr_registro,tipo_error,sql_script)
				VALUES(:id,:nombre_error,:id_usr_registro,:ip_usr_registro,:tipo_error,:sql_script)";
	
		$prod = $this->_db->prepare($sql);
			
		$prod->execute(array(':id'=>$idcodigo,':nombre_error'=>$id_ult,':id_usr_registro'=> $iduser,
				':ip_usr_registro'=>$ip_usr,':tipo_error'=>$tipo_error,':sql_script'=>$sql_script));
	
	}
}
?>	