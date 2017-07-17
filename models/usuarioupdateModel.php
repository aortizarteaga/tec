<?php
class usuarioupdateModel extends Model {
	public function __construct() {
		parent::__construct ();
		if (!isset($_SESSION['user']))
			$this->redireccionar ('index');
	}
	
	public function getUsuario(){
		
		$usuario=$_SESSION['user'];
		
		if($_SESSION['idperfil']!=1){
			$consulta="WHERE id_usr_registro='$usuario'";
		}
	
		$sql = "SELECT id_tec_usuario,
				nombres,
				apellidos,
				documento,
				area,
				fecha_registro,
				IF(flg_activo='Y','activo','inactivo') AS flg_activo,
				'' AS 'opciones' 
				FROM `ase_tec_usuario` $consulta";
		
		$prod = $this->_db->prepare($sql);
		$prod->execute();
		$result=$prod->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
	
	public function getUsuariodatos($id_usuario){
		$sql = "SELECT * FROM ase_tec_usuario WHERE id_tec_usuario=:id_usuario";
	
		$prod = $this->_db->prepare($sql);
		$prod->execute(array(':id_usuario'=>$id_usuario));
		return $prod->fetch();
	}
	
	public function updateUser($nombre_usuario,$apellido_usuario,$tipodoc_usuario,$documento_usuario,$email_usuario,$telefono_usuario,
				$unidad_usuario,$area_usuario,$tipo_usuario,$tipo_perfil,$iduser,$ip_usr,$usuario_actualizar,$status){
					
				try{
					$sql_update = "UPDATE `ase_tec_usuario` SET id_tipo_usuario=$tipo_usuario,id_tipo_perfil=$tipo_perfil,nombres='$nombre_usuario',apellidos='$apellido_usuario',
					email='$email_usuario',id_tec_tipo_doc=$tipodoc_usuario,documento='$documento_usuario',telefono='$telefono_usuario',
					unidad='$unidad_usuario',area='$area_usuario',ip_usr_modificacion='$ip_usr',id_usr_modificacion='$iduser',flg_activo='$status' WHERE id_tec_usuario='$usuario_actualizar'";

					$prod = $this->_db->prepare ( $sql_update );
					$prod->execute ();
						
					$arr = $prod->errorInfo ();
					return $arr;
				}
				catch(Exception $e){
						
					$sql_error = "UPDATE `ase_tec_usuario` SET id_tipo_usuario=$tipo_usuario,id_tipo_perfil=$tipo_perfil,nombres='$nombre_usuario',apellidos='$apellido_usuario',
					email='$email_usuario',id_tec_tipo_doc=$tipodoc_usuario,documento='$documento_usuario',telefono='$telefono_usuario',
					unidad='$unidad_usuario',area='$area_usuario',ip_usr_modificacion='$ip_usr',id_usr_modificacion='$iduser' WHERE id_tec_usuario='$usuario_actualizar'";
						
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