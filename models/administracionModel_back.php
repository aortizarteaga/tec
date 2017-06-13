<?php
class administracionModel extends Model {
	public function __construct() {
		parent::__construct ();
	}
	
	public function getBusqueda($input,$criterios){
	
		if($criterios==1){
				
			$sql_contar="SELECT documento FROM `ase_tec_base_registro_ciat` WHERE `documento`='$input'
						 UNION ALL
						 SELECT documento FROM `ase_tec_base_pendiente_ciat` WHERE `documento`='$input'";

			$prod = $this->_db->prepare($sql_contar);
			$prod->execute();
			$conteo=$prod->rowCount();
			
			return $conteo;
		}
		else{
			
			$sql_contar="SELECT codigo_pedido FROM `ase_tec_base_registro_ciat` 
						 WHERE codigo_pedido='$input'
						 UNION ALL
						 SELECT codigo_pedido FROM `ase_tec_base_pendiente_ciat`  
						 WHERE codigo_pedido='$input' OR codigo_requerimiento='$input'
						 UNION ALL
						 SELECT codigo_pedido FROM `ase_tec_base_cancelada`
						 WHERE codigo_pedido='$input' OR codigo_requerimiento='$input'
						 UNION ALL
						 SELECT codigo_pedido FROM `ase_tec_base_ejecutada_ciat`
						 WHERE codigo_pedido='$input' OR codigo_requerimiento='$input'";
				
			$prod = $this->_db->prepare($sql_contar);
			$prod->execute();
			$conteo=$prod->rowCount();
			
			return $conteo;
		}
	
	}
	
	public function getPedido($input,$criterios){
		set_time_limit(60);
		if($criterios==1){
			
			$sql_contar="SELECT DISTINCT codigo_pedido FROM(
						SELECT codigo_pedido FROM `ase_tec_base_registro_ciat` WHERE `documento`='$input'
						UNION ALL
						SELECT codigo_pedido FROM `ase_tec_base_pendiente_ciat` WHERE documento='$input') as A";
			
			
			
			$prod = $this->_db->prepare($sql_contar);
			$prod->execute();
			$conteo=$prod->rowCount();
			
			$array=$prod->fetchAll();
			
			$var_codigo="";
			
			foreach ( $array as $codigo => $value ) :
				$var_codigo=$var_codigo."'$value[0]'".",";
			endforeach;
			
			$var_codigo=$var_codigo."'000000'";
			
			$sql = "SELECT A.codigo_pedido,A.estado,A.fecha_registro_registro,A.estado_movimiento,A.fecha_registro,A.fecha_ultimo_movimiento,A.opciones FROM(
					SELECT 
					DISTINCT 
					rc.`codigo_pedido`, 
					'REGISTRO' AS estado,
					rc.`fecha_llamada` AS fecha_registro_registro,
					nc.estado_movimiento,
					nc.fecha_registro,
					nc.fecha_ultimo_movimiento,
					'' AS opciones
					FROM (select codigo_pedido,fecha_llamada,documento from ase_tec_base_registro_ciat where `codigo_pedido` IN ($var_codigo) 
					and documento='$input') rc
					LEFT JOIN  (
					SELECT A.codigo_pedido,A.estado_movimiento,max(A.fecha_registro) as fecha_registro,A.fecha_ultimo_movimiento FROM(	
					SELECT codigo_pedido,ts.`descripcion` AS estado_movimiento,pc.`fecha_registro_pendiente` AS fecha_registro,pc.`fecha_registro_atis` AS fecha_ultimo_movimiento FROM `ase_tec_base_pendiente_ciat` pc
					INNER JOIN `ase_tec_situacion` ts ON pc.`id_situacion`=ts.`id_tec_situacion`
					UNION ALL
					SELECT codigo_pedido,ts.`descripcion` AS estado_movimiento,ec.fecha_registro_ejecutada AS fecha_registro,ec.fecha_ejecucion AS fecha_ultimo_movimiento  FROM `ase_tec_base_ejecutada_ciat` ec
					INNER JOIN `ase_tec_situacion` ts ON ec.`id_situacion`=ts.`id_tec_situacion`
					UNION ALL
					SELECT codigo_pedido,ts.`descripcion` AS estado_movimiento,bc.fecha_registro_cancelado AS fecha_registro,bc.fecha_cancelado AS fecha_ultimo_movimiento FROM `ase_tec_base_cancelada` bc
					INNER JOIN `ase_tec_situacion` ts ON bc.`id_situacion`=ts.`id_tec_situacion`
					) AS A GROUP BY A.codigo_pedido
					) 
					nc on nc.codigo_pedido=rc.codigo_pedido
					WHERE rc.`codigo_pedido` IN ($var_codigo) and rc.documento='$input'
					UNION ALL
					SELECT 
					DISTINCT 
					pc.`codigo_pedido` AS `codigo_pedido`, 
					'' AS 'estado',
					'' AS 'fecha_registro_registro',
					nc.estado_movimiento,
					nc.fecha_registro,
					nc.fecha_ultimo_movimiento,
					'' AS opciones
					FROM 
					(select * from ase_tec_base_pendiente_ciat where `codigo_pedido` IN ($var_codigo) 
					and documento='$input') pc
					LEFT JOIN  (
					SELECT A.codigo_pedido,A.estado_movimiento,max(A.fecha_registro) as fecha_registro,A.fecha_ultimo_movimiento FROM(	
					SELECT codigo_pedido,ts.`descripcion` AS estado_movimiento,pc.`fecha_registro_pendiente` AS fecha_registro,pc.`fecha_registro_atis` AS fecha_ultimo_movimiento FROM `ase_tec_base_pendiente_ciat` pc
					INNER JOIN `ase_tec_situacion` ts ON pc.`id_situacion`=ts.`id_tec_situacion`
					UNION ALL
					SELECT codigo_pedido,ts.`descripcion` AS estado_movimiento,ec.fecha_registro_ejecutada AS fecha_registro,ec.fecha_ejecucion AS fecha_ultimo_movimiento  FROM `ase_tec_base_ejecutada_ciat` ec
					INNER JOIN `ase_tec_situacion` ts ON ec.`id_situacion`=ts.`id_tec_situacion`
					UNION ALL
					SELECT codigo_pedido,ts.`descripcion` AS estado_movimiento,bc.fecha_registro_cancelado AS fecha_registro,bc.fecha_cancelado AS fecha_ultimo_movimiento FROM `ase_tec_base_cancelada` bc
					INNER JOIN `ase_tec_situacion` ts ON bc.`id_situacion`=ts.`id_tec_situacion`
					) AS A GROUP BY A.codigo_pedido
					) 
					nc on nc.codigo_pedido=pc.codigo_pedido
					WHERE pc.`codigo_pedido` IN ($var_codigo) and pc.documento='$input'
					) as A GROUP BY A.codigo_pedido";
		
		}
		else{
			$sql_contar="SELECT codigo_pedido FROM `ase_tec_base_registro_ciat`
			WHERE  codigo_pedido='$input'";
			
			$prod = $this->_db->prepare($sql_contar);
			$prod->execute();
			$conteo=$prod->rowCount();
			
			if($conteo>=1){
				$join="LEFT";
			}
			else{
				$join="RIGHT";
			}
			
			$sql = "SELECT
					IF(A.codigo_pedido IS NULL,C.codigo_pedido,A.codigo_pedido) AS codigo_pedido,
					A.descripcion AS estado,
					A.fecha_registro_registro,
					C.descripcion AS estado_movimiento,
					C.fecha_registro,
					C.fecha_registro_sistema AS fecha_ultimo_movimiento,
					'' AS opciones
					FROM(
					SELECT
					codigo_pedido,
					rc.fecha_llamada AS fecha_registro_registro,
					ts.descripcion
					FROM `ase_tec_base_registro_ciat`  rc INNER JOIN
					`ase_tec_situacion` ts ON rc.`id_situacion`=ts.`id_tec_situacion`
					WHERE  codigo_pedido='$input' LIMIT 1) AS A
					$join JOIN (
					SELECT C.codigo_pedido,C.descripcion,C.fecha_registro,C.fecha_registro_sistema,C.codigo_requerimiento FROM(
					SELECT * FROM(
					SELECT codigo_pedido,
					fecha_registro_pendiente AS fecha_registro,
					fecha_registro_atis AS fecha_registro_sistema,
					ts.descripcion,codigo_requerimiento FROM `ase_tec_base_pendiente_ciat`  pc INNER JOIN
					`ase_tec_situacion` ts ON pc.id_situacion=ts.id_tec_situacion
					WHERE codigo_pedido='$input' OR codigo_requerimiento='$input'
					UNION ALL
					SELECT codigo_pedido,
					ec.fecha_registro_cancelado AS fecha_registro,
					ec.fecha_cancelado AS fecha_registro_sistema,
					ts.descripcion,codigo_requerimiento FROM `ase_tec_base_cancelada` ec INNER JOIN
					`ase_tec_situacion` ts ON ec.id_situacion=ts.id_tec_situacion
					WHERE codigo_pedido='$input' OR codigo_requerimiento='$input'
					UNION ALL
					SELECT codigo_pedido,
					ejc.fecha_registro_ejecutada AS fecha_registro,
					ejc.fecha_ejecucion AS fecha_registro_sistema,
					ts.descripcion,codigo_requerimiento FROM `ase_tec_base_ejecutada_ciat` ejc INNER JOIN
					`ase_tec_situacion` ts ON ejc.id_situacion=ts.id_tec_situacion
					WHERE codigo_pedido='$input' OR codigo_requerimiento='$input') AS B ORDER BY 2 DESC LIMIT 1)
					AS C) AS C ON C.codigo_pedido=A.codigo_pedido OR C.codigo_requerimiento=A.codigo_pedido";
		}
	
		$prod = $this->_db->prepare($sql);
		$prod->execute();
		$result=$prod->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
	
	public function getTrazabilidad($idcodigo,$input){
		
		if($idcodigo=='' || $idcodigo==null){
			$consulta="documento='$input' and codigo_pedido=''";
		}
		else{
			$consulta="codigo_pedido='$idcodigo'";
		}
	
		$sql = "SELECT 
				rc.codigo_pedido,
				rc.documento,
				rc.estado_gestion,
				rc.detalle_gestion,
				rc.subdetalle_gestion,
				rc.observacion_gestion,
				rc.`pedido_vuelo`,
				rc.flg_dependencia,
				rc.fecha_llamada AS fecha,
				ts.descripcion
				FROM `ase_tec_base_registro_ciat`  rc INNER JOIN 
				`ase_tec_situacion` ts ON rc.`id_situacion`=ts.`id_tec_situacion`
				WHERE  $consulta";
	
		$prod = $this->_db->prepare($sql);
		$prod->execute();
		$result=$prod->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
	
	public function getTrazabilidad2($idcodigo){
	
		$sql = "SELECT
				documento,
				tipo_operacion,
				cod_oc,
				producto,
				fecha_registro_pendiente AS fecha_registro,
				fecha_registro_atis AS fecha_base,
				motivo,
				descripcion AS observacion,
				'PENDIENTE' AS situacion
				FROM `ase_tec_base_pendiente_ciat`
				WHERE codigo_pedido='$idcodigo'
				UNION ALL
				SELECT
				'' AS 'documento',
				tipo_operacion AS 'tipo_operacion',
				cod_oc as 'cod_oc',
				producto as 'producto',
				fecha_registro_cancelado AS fecha_registro,
				fecha_cancelado AS fecha_base,
				motivo,
				observacion,
				'CANCELADAS' AS situacion
				FROM `ase_tec_base_cancelada`
				WHERE codigo_pedido='$idcodigo'
				UNION ALL
				SELECT
				'' AS 'documento',
				tipo_operacion AS 'tipo_operacion',
				tip_catv as 'cod_oc',
				ind_paq as 'producto',
				fecha_registro_ejecutada AS fecha_registro,
				fecha_ejecucion AS fecha_base,
				movimiento AS motivo,
				descripcion AS observacion,
				'EJECUTADAS' AS situacion
				FROM `ase_tec_base_ejecutada_ciat`
				WHERE codigo_pedido='$idcodigo'";
	
		$prod = $this->_db->prepare($sql);
		$prod->execute();
		$result=$prod->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}
	
	public function getAseguramiento($idcodigo){
	
		$sql = "SELECT 
				'ONLINE' AS 'Gestion',pet_req,des_mot,origen_obs,tematico1,tematico2,tematico3,
				tematico4,obs_gestio,f_carga,f_gestion,situacion,usu_gestion
				FROM `cbc_online` WHERE pet_req='$idcodigo'
				UNION ALL
				SELECT
				'COMERCIAL' AS 'Gestion',pet_req,desmotv,detmotv AS 'origen_obs',tematico1,tematico2,tematico3,
				tematico4,obs_gestio,f_carga,f_gestion,situacion,usu_gestion
				FROM `comercial` WHERE pet_req='$idcodigo'
				UNION ALL
				SELECT
				'QUIEBRES' AS 'Gestion',pet_req,desmotv,detmotv AS 'origen_obs',tematico1,tematico2,tematico3,
				tematico4,obs_gestio,f_carga,f_gestion,situacion,usu_gestion
				FROM `quiebres` WHERE pet_req='$idcodigo'
				UNION ALL
				SELECT
				'VCP' AS 'Gestion',pet_req,desobsordt AS 'desmotv','' AS 'origen_obs',tematico1,tematico2,tematico3,
				tematico4,obs_gestio,f_carga,f_gestion,situacion,usu_gestion
				FROM `vcp` WHERE pet_req='$idcodigo'
				UNION ALL
				SELECT
				'REMEDYS' AS 'Gestion',tipo AS 'desmotv',motivo AS desmotv,observacion AS origen_obs,'tematico1','tematico2','tematico3',
				'tematico4',obs_resolucion AS obs_gestio,f_resolucion AS f_carga,f_modificacion AS f_gestion,'situacion',
				us_val_resolucion AS usu_gestion
				FROM `remedys` WHERE peticion='$idcodigo'
				UNION ALL
				SELECT
				'REGISTRO' AS 'Gestion',pet_req,casuistica AS desmotv,observacion AS origen_obs,tematico1,tematico2,tematico3,
				tematico4,obs_gestio,f_carga,f_gestion,situacion,usu_gestion
				FROM `cancelacion` WHERE pet_req='$idcodigo'
				UNION ALL
				SELECT
				'AGENDA' AS 'Gestion',pet_req,tipagen AS desmotv,'' AS origen_obs,'tematico1','tematico2','tematico3',
				'tematico4',obs_gestio,f_carga,f_gestion,situacion,usu_gestion
				FROM `agenda` WHERE pet_req='$idcodigo'";
	
		$prod = $this->_db->prepare($sql);
		$prod->execute();
		$result=$prod->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	
	}
	
	public function getTematico(){
		$sql = "SELECT id_tec_tematico,descripcion FROM `ase_tec_tematico` WHERE flg_activo='Y'";
		$prod = $this->_db->prepare($sql);
		$prod->execute();
		return $prod;
	}
	
	public function insertDerivar($gestion,$actividado,$codigo_pedido,$telefono,$tematico_combo,$obs_derivar,
					$iduser,$flg_redessociales,$nombre_host,$atividad,$tipo,$tematico2_combo,$contacto_instalar,$fecha_agenda,
					$turno_combo,$telefono_secundario_derivar,$direccion_derivar){
					
				$sql_insert = "INSERT INTO `tec`(`gestion`,`actividado`,`pet_req`,`ncontacto`,`estado`,`casuistica`,
             				`observacion`,`gestor`,`prioridad`,`pc_usu`,`actividad`,`tipo`,`ncontacto2`,motivo,nombre_contacto,
             				direccion,feci_age,horai_age) 
             				VALUES ('$gestion','$actividado','$codigo_pedido','$telefono','EN PROCESO','$tematico_combo','$obs_derivar',
							'$iduser','$flg_redessociales','$nombre_host','$atividad','$tipo','$telefono_secundario_derivar',$tematico2_combo,
							'$contacto_instalar','$direccion_derivar','$fecha_agenda','$turno_combo')";
	
				$sql_error = "INSERT INTO `tec`(`gestion`,`actividado`,`pet_req`,`ncontacto`,`casuistica`,
             				`observacion`,`gestor`,`prioridad`,`pc_usu`,`actividad`,`tipo`,`ncontacto2`,motivo,nombre_contacto,
             				direccion,feci_age,horai_age) 
             				VALUES ('$gestion','$actividado','$codigo_pedido','$telefono','EN PROCESO','$tematico_combo','$obs_derivar',
							'$iduser','$flg_redessociales','$nombre_host','$atividad','$tipo','$telefono_secundario_derivar',$tematico2_combo,
							'$contacto_instalar','$direccion_derivar','$fecha_agenda','$turno_combo')";
	
				$prod = $this->_db->prepare ( $sql_insert );
				$prod->execute ();
				$arr = $prod->errorInfo ();
				array_push ($arr,$sql_error);
				return $arr;
	}
	
	public function insertError($idcodigo,$id_ult,$iduser,$ip_usr,$tipo_error,$sql_script){
	
		$sql = "INSERT INTO ase_tec_log_error(id,nombre_error,id_usr_registro,ip_usr_registro,tipo_error,sql_script)
				VALUES(:id,:nombre_error,:id_usr_registro,:ip_usr_registro,:tipo_error,:sql_script)";
	
		$prod = $this->_db->prepare($sql);
			
		$prod->execute(array(':id'=>$idcodigo,':nombre_error'=>$id_ult,':id_usr_registro'=> $iduser,
				':ip_usr_registro'=>$ip_usr,':tipo_error'=>$tipo_error,':sql_script'=>$sql_script));
	
	}
	
	public function existeDerivar($codigo_pedido){
					
		$sql = "SELECT pet_req FROM `tec` WHERE pet_req= :pet_req AND 
				situacion IN ('pendiente','registrado') AND usu_bloqueo!=NULL";
		
		$prod = $this->_db->prepare ( $sql );
		$prod->execute ( array (
				':pet_req' => $codigo_pedido
		) );
		
		if ($prod->rowCount ())
			return 1;
		else
			return 0;
	}
	
	public function getReiterado($codigo_pedido){
			
		$sql = "SELECT pet_req FROM `tec` WHERE pet_req= :pet_req AND
				gestion='1RALINEA'";
	
		$prod = $this->_db->prepare ( $sql );
		$prod->execute ( array (
				':pet_req' => $codigo_pedido
		) );
	
		if ($prod->rowCount ())
			return 1;
		else
			return 0;
	}
	
	public function getUpdatereiterado($codigo_pedido,$iduser){
		
		$sql = "SELECT pet_req FROM `tec` WHERE pet_req= :pet_req AND
				situacion IN ('pendiente','registrado') AND usu_bloqueo=''
				AND idDev=(SELECT MAX(idDev) FROM tec WHERE pet_req=:pet_req)";
		
		$prod = $this->_db->prepare ( $sql );
		$prod->execute ( array (
				':pet_req' => $codigo_pedido
		) );
		
		$conteo=$prod->rowCount();
		
		if ($conteo==1){
			$sql_update="UPDATE `desarollo-ase`.`tec`
						 SET 
						  `tematico1` = '',
						  `tematico2` = '',
						  `tematico3` = '',
						  `tematico4` = '',
						  `obs_gestio` = '',
						  `f_gestion` = NOW(),
						  `situacion` = 'cancelado',
						  `usu_gestion` = '$iduser'
						 WHERE `pet_req` = '$codigo_pedido'";
			
			$prods = $this->_db->prepare ($sql_update);
			$prods->execute ();
			
			return "1";
		}
		else{
			$sql = "SELECT pet_req FROM `tec` WHERE pet_req=:pet_req AND
				situacion IN ('gestionado','cancelado') AND usu_gestion!=''
				AND idDev=(SELECT MAX(idDev) FROM tec WHERE pet_req=:pet_req)";
			
			$prod = $this->_db->prepare ( $sql );
			$prod->execute ( array (
					':pet_req' => $codigo_pedido
			) );
			
			$conteo=$prod->rowCount();
			
			if($conteo==1){
				return "1";
			}
			else{
				return "0";
			}
		}
	}
	
	public function getTec($idcodigo){
	
		$sql = "SELECT
				gestion,
				tipo,
				actividado,
				casuistica,
				observacion,
				tematico1,
				tematico2,
				tematico3,
				tematico4,
				obs_gestio,
				f_carga,
				f_gestion,
				situacion,
				usu_gestion
				FROM `tec` WHERE `pet_req`='$idcodigo'";
	
		$prod = $this->_db->prepare($sql);
		$prod->execute();
		$result=$prod->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	
	}
	
	public function getmotivo($tematico_combo){
	
		$sql = "SELECT id_tec_motivo,descripcion FROM ase_tec_motivo WHERE
				flg_activo='Y' AND id_tec_tematico=:id ORDER BY 1 ASC";
	
		$prod = $this->_db->prepare($sql);
		$prod->execute(array(':id'=>$tematico_combo));
		return $prod;
	}
	
	public function getFecharegistro($pedido){
	
		$sql = "SELECT fecha_registro_pendiente FROM `ase_tec_base_pendiente_ciat` WHERE codigo_pedido=:id";
	
		$prod = $this->_db->prepare($sql);
		$prod->execute(array(':id'=>$pedido));
		return $prod->fetch();
	}
	
	public function updatePswd($iduser){
	
		$sql = "SELECT * FROM `ase_tec_usuario` WHERE `flg_pswd`='N' AND `id_tec_usuario`='$iduser'";
	
		$prod = $this->_db->prepare($sql);
		$prod->execute();
		$conteo=$prod->rowCount();
			
			if($conteo==1){
				return "1";
			}
			else{
				return "0";
			}
	}
	
	public function updateContra($iduser,$pswd,$ip_usr){
	
		$fecha_modificacion=date('Y-m-d H:i:s');
		
		$sql_update = "UPDATE `ase_tec_usuario` SET `password` = '$pswd',`flg_pswd` = 'Y',`id_usr_modificacion` = '$iduser',
				  	  `ip_usr_modificacion` = '$ip_usr',`fecha_modificacion` = '$fecha_modificacion' 
					  WHERE `id_tec_usuario` = '$iduser'";
		
		$sql_error = "UPDATE `ase_tec_usuario`
				SET 
				  `password` = '$pswd',
				  `flg_pswd` = 'Y',
				  `id_usr_modificacion` = '$iduser',
				  `ip_usr_modificacion` = '$ip_usr',
				  `fecha_modificacion` = '$fecha_modificacion'
				WHERE `id_tec_usuario` = '$iduser'";
	
		$prod = $this->_db->prepare ( $sql_update );
		$prod->execute ();
		$arr = $prod->errorInfo ();
		array_push ($arr,$sql_error);
		return $arr;
	}
}
?>	