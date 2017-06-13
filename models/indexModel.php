<?php
class indexModel extends Model {
	public function __construct() {
		parent::__construct ();
	}

	public function validUser($user,$pass){
		$sql ="SELECT id_tec_usuario FROM ase_tec_usuario WHERE id_tec_usuario = :id 
			   AND PASSWORD = :pass AND flg_activo='y'";
		
		$prod = $this->_db->prepare($sql);
		$prod->execute(array(':id'=>$user,':pass'=>$pass));
		
		if ($prod->rowCount()) return true;
		 else return false;

	}
	
	public function getNombre($user){
		$sql="SELECT CONCAT(nombres,' ',apellidos) AS nombres,
			  etu.`id_tec_tipo_usuario` AS id_usuario,
			  etu.descripcion AS tipo_usuario,
			  tp.`descripcion` AS tipo_perfil,
			  tp.`id_tec_perfil` AS id_tipo_perfil,
			  tp.prioridad
			  FROM `ase_tec_usuario` eu 
			  INNER JOIN `ase_tec_tipo_usuario` etu ON eu.id_tipo_usuario=etu.id_tec_tipo_usuario 
			  INNER JOIN `ase_tec_tipo_perfil` tp ON tp.`id_tec_perfil`=eu.`id_tipo_perfil`
			  WHERE id_tec_usuario=:id";
	
		$prod = $this->_db->prepare($sql);
		$prod->execute(array(':id'=>$user));
		
		return $prod->fetch();
	}
	
	public function getMenu($user){
		
		$sql="SELECT up.id_tec_pagina,
			 p.descripcion,
			 p.tipo,
			 p.ubicacion 
			 FROM `ase_tec_usuario_pagina` up,`ase_tec_pagina` p
			 WHERE up.id_tec_pagina=p.id_tec_pagina AND
			 up.usuario_permiso='$user' ORDER BY p.tipo,p.prioridad";
		
		$prod = $this->_db->prepare($sql);
		$prod->execute(array(':id'=>$user));
		
		return $prod->fetchAll();
		
	}
}
?>	