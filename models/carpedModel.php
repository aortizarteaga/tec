<?php
class carpedModel extends Model {
	public function __construct() {
		parent::__construct ();
	}
	
	public function insertTrama($codigo_pedido,$numero_documento,$tipo_comercial,$cod_oc,$producto,$fecha_registro,$marca3,$req_fe_sitped,
								$descripcion,$negocio2,$iduser,$ip_usr,$situacion,$fecha_registro_atis){
		
		$fecha_registro = $fecha_registro;
		$arr = explode('/', $fecha_registro);
		$fecha_registro = $arr[2].'-'.$arr[1].'-'.$arr[0];
		
		$date_inicial = explode(" ", $fecha_registro_atis);
		$date[0] = explode("/", $date_inicial[0]);
		$date[0] = $date[0][2] . "-" . $date[0][1] . "-" . $date[0][0]." ".$date_inicial[1];
		
		
		$sql_insert = "INSERT INTO `desarollo-ase`.`ase_tec_base_pendiente_ciat`(`codigo_pedido`,`documento`,`tipo_operacion`,`cod_oc`,
             		   `producto`,`fecha_registro_pendiente`,`motivo`,`codigo_requerimiento`,`descripcion`,`flg_negocio`,`id_situacion`,
             		   `id_usr_registro`,`ip_usr_registro`,`fecha_registro_atis`)
					   VALUES ('$codigo_pedido','$numero_documento','$tipo_comercial','$cod_oc','$producto','$fecha_registro','$marca3',
					   '$req_fe_sitped','$descripcion','$negocio2',$situacion,'$iduser','$ip_usr','$date[0]');";
		
		$sql_error = "INSERT INTO `desarollo-ase`.`ase_tec_base_pendiente_ciat`(`codigo_pedido`,`documento`,`tipo_operacion`,`cod_oc`,
             		   `producto`,`fecha_registro_pendiente`,`motivo`,`codigo_requerimiento`,`descripcion`,`flg_negocio`,`id_situacion`,
             		   `id_usr_registro`,`ip_usr_registro`)
					   VALUES ('$codigo_pedido','$numero_documento','$tipo_comercial','$cod_oc','$producto','$fecha_registro','$marca3',
					   '$req_fe_sitped','$descripcion','$negocio2',$situacion,'$iduser','$ip_usr','$date[0]');";
		
		$prod = $this->_db->prepare ( $sql_insert );
		$prod->execute ();
		$arr = $prod->errorInfo ();
		array_push ( $arr, $sql_error );
		return $arr;
	
	}
	
	public function deleteTrama($criterio){
		
		if($criterio==1){
			$sql_delete = "DELETE FROM `desarollo-ase`.`ase_tec_base_cancelada`";
			$sql_error = "DELETE FROM `desarollo-ase`.`ase_tec_base_cancelada`";
		}
		else if($criterio==2){
			$sql_delete = "DELETE FROM `desarollo-ase`.`ase_tec_base_cancelada`";
			$sql_error = "DELETE FROM `desarollo-ase`.`ase_tec_base_cancelada`";
		}
		else{
			$sql_delete = "DELETE FROM `desarollo-ase`.`ase_tec_base_ejecutada_ciat`";
			$sql_error = "DELETE FROM `desarollo-ase`.`ase_tec_base_ejecutada_ciat`";
		}
	
				$prod = $this->_db->prepare ( $sql_delete );
				$prod->execute ();
				$arr = $prod->errorInfo ();
				array_push ( $arr, $sql_error );
				return $arr;
	
	}
	
	public function insertError($idcodigo,$id_ult,$iduser,$ip_usr,$tipo_error,$sql_script){
	
		$sql = "INSERT INTO ase_tec_log_error(id,nombre_error,id_usr_registro,ip_usr_registro,tipo_error,sql_script)
				VALUES(:id,:nombre_error,:id_usr_registro,:ip_usr_registro,:tipo_error,:sql_script)";
	
		$prod = $this->_db->prepare($sql);
			
		$prod->execute(array(':id'=>$idcodigo,':nombre_error'=>$id_ult,':id_usr_registro'=> $iduser,
				':ip_usr_registro'=>$ip_usr,':tipo_error'=>$tipo_error,':sql_script'=>$sql_script));
	
	}
	
	public function insertExcelcancelado($fecha_registro,$fecha_cancelado,$codigo_peticion,$edo_pet,$usr_ultimo,$czonal,$servicio,
										 $modalidad,$motivo,$desobsges,$codigo_requerimiento,$motctv,$desobsctv,$grupo,$iduser,
										 $ip_usr,$situacion){
	
				$date_inicial = explode(" ", $fecha_registro);
				$date_registro[0] = explode("/", $date_inicial[0]);
				$date_registro[0] = $date_registro[0][2] . "-" . $date_registro[0][1] . "-" . $date_registro[0][0]." ".$date_inicial[1];
	
				$date_inicial_cancelado = explode(" ", $fecha_cancelado);
				$date_cancelado[0] = explode("/", $date_inicial_cancelado[0]);
				$date_cancelado[0] = $date_cancelado[0][2] . "-" . $date_cancelado[0][1] . "-" . $date_cancelado[0][0]." ".$date_inicial_cancelado[1];
	
	
				$sql_insert = "INSERT INTO `desarollo-ase`.`ase_tec_base_cancelada`(`fecha_registro_cancelado`,`fecha_cancelado`,`codigo_pedido`,
             				  `edopet`,`user_ultimo`,`czonal`,`servicio`,`modalidad`,`motivo`,`observacion`,`codigo_requerimiento`,`motctv`,
             				  `descripcion_motivo`,`grupo`,`id_situacion`,`id_usr_registro`,`ip_usr_registro`)
							  VALUES ('$date_registro[0]','$date_cancelado[0]','$codigo_peticion','$edo_pet','$usr_ultimo','$czonal','$servicio',
        					  '$modalidad','$motivo','$desobsges','$codigo_requerimiento','$motctv','$desobsctv','$grupo','$situacion',
        					  '$iduser','$ip_usr');";
	
				$sql_error = "INSERT INTO `desarollo-ase`.`ase_tec_base_cancelada`(`fecha_registro_cancelado`,`fecha_cancelado`,`codigo_pedido`,
             				  `edopet`,`user_ultimo`,`czonal`,`servicio`,`modalidad`,`motivo`,`observacion`,`codigo_requerimiento`,`motctv`,
             				  `descripcion_motivo`,`grupo`,`id_situacion`,`id_usr_registro`,`ip_usr_registro`)
							  VALUES ('$date_registro[0]','$date_cancelado[0]','$codigo_peticion','$edo_pet','$usr_ultimo','$czonal','$servicio',
        					  '$modalidad','$motivo','$desobsges','$codigo_requerimiento','$motctv','$desobsctv','$grupo','$situacion',
        					  '$iduser','$ip_usr');";
	
				$prod = $this->_db->prepare ( $sql_insert );
				$prod->execute ();
				$arr = $prod->errorInfo ();
				array_push ( $arr, $sql_error );
				return $arr;
	
	}
	
	public function insertExcelejecutado($negocio,$gzonal,$jefatura,$mov,$ccontr,$contra,$desseg,$pet_req,$codreq,$descript,$fecreg,
										 $feceje,$up_front,$iduser,$ip_usr,$situacion){
	
				$date_inicial = explode(" ", $fecreg);
				$date_registro[0] = explode("/", $date_inicial[0]);
				$date_registro[0] = $date_registro[0][2] . "-" . $date_registro[0][1] . "-" . $date_registro[0][0]." ".$date_inicial[1];
	
				$date_inicial_ejecutado = explode(" ", $feceje);
				$date_ejecutado[0] = explode("/", $date_inicial_ejecutado[0]);
				$date_ejecutado[0] = $date_ejecutado[0][2] . "-" . $date_ejecutado[0][1] . "-" . $date_ejecutado[0][0]." ".$date_inicial_ejecutado[1];
	
	
				$sql_insert = "INSERT INTO `desarollo-ase`.`ase_tec_base_ejecutada_ciat`(`negocio`,`gzonal`,`jefatura`,`movimiento`,
             				  `codigo_contrata`,`contrata`,`segmento`,`codigo_pedido`,`codigo_requerimiento`,`descripcion`,`fecha_registro_ejecutada`,
             				  `fecha_ejecucion`,`upfront`,`id_situacion`,`id_usr_registro`,`ip_usr_registro`)
							  VALUES ('$negocio','$gzonal','$jefatura','$mov','$ccontr','$contra','$desseg','$pet_req','$codreq',
							  '$descript','$date_registro[0]','$date_ejecutado[0]','$up_front','$situacion','$iduser','$ip_usr');";
	
				$sql_error = "INSERT INTO `desarollo-ase`.`ase_tec_base_ejecutada_ciat`(`negocio`,`gzonal`,`jefatura`,`movimiento`,
             				  `codigo_contrata`,`contrata`,`segmento`,`codigo_pedido`,`codigo_requerimiento`,`descripcion`,`fecha_registro_ejecutada`,
             				  `fecha_ejecucion`,`upfront`,`id_situacion`,`id_usr_registro`,`ip_usr_registro`)
							  VALUES ('$negocio','$gzonal','$jefatura','$mov','$ccontr','$contra','$desseg','$pet_req','$codreq',
							  '$descript','$date_registro[0]','$date_ejecutado[0]','$up_front','$situacion','$iduser','$ip_usr');";
	
				$prod = $this->_db->prepare ( $sql_insert );
				$prod->execute ();
				$arr = $prod->errorInfo ();
				array_push ( $arr, $sql_error );
				return $arr;
	
	}
	
	public function insertLogcarga($j,$k,$nro_filas,$nombre_excel,$situacion,$iduser,$ip_usr,$tipo_base){
	
		$sql = "INSERT INTO `desarollo-ase`.`ase_tec_log_carga`(`procesados`,`no_procesados`,`total`,`nombre_archivo`,`base`,`usr_registro`,
             	`ip_registro`,`tipo_base`)
				VALUES ('$j','$k','$nro_filas','$nombre_excel','$situacion','$iduser','$ip_usr','$tipo_base');";
	
		$prod = $this->_db->prepare($sql);
		$prod->execute();
	
	}
	
	public function verificar_base($criterio){
		
		if($criterio==1){
			
			$sql_contar="SELECT * FROM `ase_tec_log_carga` WHERE 
						tipo_base='ATIS' AND DATE(fecha_registro)=DATE(NOW()) AND flg_subido='Y'";
				
			$prod = $this->_db->prepare($sql_contar);
			$prod->execute();
			$conteo=$prod->rowCount();
			
			if($conteo>=1){
				echo "2";
			}
			else{
				$sql_contar_2="SELECT * FROM `ase_tec_log_carga` WHERE `tipo_base`='ATIS' AND
							   DATE(fecha_registro)=DATE(NOW()) AND
							   (SELECT COUNT(id_tec_carga) FROM `ase_tec_log_carga` WHERE 
							   tipo_base='CMS' AND DATE(fecha_registro)=DATE(NOW()) AND flg_subido='Y')>=1";
				
				$prod2 = $this->_db->prepare($sql_contar_2);
				$prod2->execute();
				$conteo2=$prod2->rowCount();
				
				if($conteo2>=1){
					return "1";
				}
				
				return "2";
			}
		}
		else{
			
			$sql_contar="SELECT * FROM `ase_tec_log_carga` WHERE
						tipo_base='CMS' AND DATE(fecha_registro)=DATE(NOW()) AND flg_subido='Y'";
			
			$prod = $this->_db->prepare($sql_contar);
			$prod->execute();
			$conteo=$prod->rowCount();
				
			if($conteo>=1){
			
				$sql_contar_2="SELECT * FROM `ase_tec_log_carga` WHERE `tipo_base`='CMS' AND
								DATE(fecha_registro)=DATE(NOW()) AND
								(SELECT COUNT(id_tec_carga) FROM `ase_tec_log_carga` WHERE
								tipo_base='ATIS' AND DATE(fecha_registro)=DATE(NOW()) AND flg_subido='Y')>=1";
			
				$prod2 = $this->_db->prepare($sql_contar_2);
				$prod2->execute();
				$conteo2=$prod2->rowCount();
			
				if($conteo2>=1){
					return "1";
				}
			
				return "2";
			
			}
				
			return "0";
			
		}

	}
	

}
?>	