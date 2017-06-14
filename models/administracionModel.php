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
	
	public function getTrazabilidadbusqueda($pedido){
	
			$sql_contar="SELECT * FROM tec WHERE pet_req='$pedido'";
	
			$prod = $this->_db->prepare($sql_contar);
			$prod->execute();
			$conteo=$prod->rowCount();
				
			return $conteo;
	
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
			
			$sql = "SELECT A.codigo_pedido,A.estado,A.fecha_registro_pedido,A.fecha_registro_registro,A.estado_movimiento,A.fecha_registro,A.fecha_ultimo_movimiento,A.opciones FROM(
					SELECT 
					DISTINCT 
					rc.`codigo_pedido`, 
					'REGISTRO' AS estado,
					rc.`fecha_registro_gestion` AS fecha_registro_pedido,
					rc.`fecha_llamada` AS fecha_registro_registro,
					nc.estado_movimiento,
					nc.fecha_registro,
					nc.fecha_ultimo_movimiento,
					'' AS opciones
					FROM (select codigo_pedido,fecha_llamada,documento,fecha_registro_gestion from ase_tec_base_registro_ciat where `codigo_pedido` IN ($var_codigo) 
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
					'' AS 'fecha_registro_pedido',
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
					A.fecha_registro_pedido,
					A.fecha_registro_registro,
					C.descripcion AS estado_movimiento,
					C.fecha_registro,
					C.fecha_registro_sistema AS fecha_ultimo_movimiento,
					'' AS opciones
					FROM(
					SELECT
					codigo_pedido,
					rc.`fecha_registro_gestion` AS fecha_registro_pedido,
					rc.fecha_llamada AS fecha_registro_registro,
					ts.descripcion
					FROM `ase_tec_base_registro_ciat`  rc INNER JOIN
					`ase_tec_situacion` ts ON rc.`id_situacion`=ts.`id_tec_situacion`
					WHERE  codigo_pedido='$input' LIMIT 1) AS A
					$join JOIN (
					SELECT C.codigo_pedido,C.descripcion,C.fecha_registro,C.fecha_registro_sistema,C.codigo_requerimiento FROM(
					SELECT * FROM(
					SELECT IF(IF(codigo_pedido IS NULL,codigo_requerimiento,codigo_pedido)!='$input','$input','$input') as codigo_pedido,
					fecha_registro_pendiente AS fecha_registro,
					fecha_registro_atis AS fecha_registro_sistema,
					ts.descripcion,codigo_requerimiento FROM `ase_tec_base_pendiente_ciat`  pc INNER JOIN
					`ase_tec_situacion` ts ON pc.id_situacion=ts.id_tec_situacion
					WHERE codigo_pedido='$input' OR codigo_requerimiento='$input'
					UNION ALL
					SELECT IF(IF(codigo_pedido IS NULL,codigo_requerimiento,codigo_pedido)!='$input','$input','$input') as codigo_pedido,
					ec.fecha_registro_cancelado AS fecha_registro,
					ec.fecha_cancelado AS fecha_registro_sistema,
					ts.descripcion,codigo_requerimiento FROM `ase_tec_base_cancelada` ec INNER JOIN
					`ase_tec_situacion` ts ON ec.id_situacion=ts.id_tec_situacion
					WHERE codigo_pedido='$input' OR codigo_requerimiento='$input'
					UNION ALL
					SELECT IF(IF(codigo_pedido IS NULL,codigo_requerimiento,codigo_pedido)!='$input','$input','$input') as codigo_pedido,
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
				rc.fecha_registro_gestion AS fecha_registro,
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
				WHERE codigo_pedido='$idcodigo' OR codigo_requerimiento='$idcodigo'
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
				WHERE codigo_pedido='$idcodigo' OR codigo_requerimiento='$idcodigo'
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
				WHERE codigo_pedido='$idcodigo' OR codigo_requerimiento='$idcodigo'";
	
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
	
	public function insertError($idcodigo,$id_ult,$iduser,$ip_usr,$tipo_error,$sql_script){
	
		$sql = "INSERT INTO ase_tec_log_error(id,nombre_error,id_usr_registro,ip_usr_registro,tipo_error,sql_script)
				VALUES(:id,:nombre_error,:id_usr_registro,:ip_usr_registro,:tipo_error,:sql_script)";
	
		$prod = $this->_db->prepare($sql);
			
		$prod->execute(array(':id'=>$idcodigo,':nombre_error'=>$id_ult,':id_usr_registro'=> $iduser,
				':ip_usr_registro'=>$ip_usr,':tipo_error'=>$tipo_error,':sql_script'=>$sql_script));
	
	}
	
	public function existeDerivar($codigo_pedido){
					
		$sql = "SELECT pet_req FROM `tec_mov` WHERE pet_req= :pet_req AND submot=6 
				AND idDev=(SELECT max(idDev) FROM tec_mov WHERE pet_req=:pet_req)";
		
		$prod = $this->_db->prepare ( $sql );
		$prod->execute (array (':pet_req' => $codigo_pedido));
		
		if ($prod->rowCount())
			return 1;
		else
			return 0;
	}
	
	public function getReiterado($codigo_pedido){
			
		$sql = "SELECT pedido FROM `ase_tec_reiterado` WHERE pedido= :pet_req";
	
		$prod = $this->_db->prepare ( $sql );
		$prod->execute ( array (':pet_req' => $codigo_pedido) );

		if ($prod->rowCount ())
			return 1;
		else
			return 0;
	}
	
	public function insert_derivar($codigo_pedido,$actividado,$tipo,$tematico_combo,$tematico2_combo,$obs_derivar){
			
		$sql = "INSERT INTO ase_tec_reiterado(pedido,tipo,actividad,casuistica,motivo,observacion)
				VALUES('$codigo_pedido','$tipo','$actividado','$tematico_combo','$tematico2_combo','$obs_derivar')";
	
		$prod = $this->_db->prepare ( $sql );
		$prod->execute ();
		$arr = $prod->errorInfo ();
		array_push ($arr,$sql_error);
		return $arr;
	}
	
	public function update_derivar_tec($gestion,$actividado,$codigo_pedido,$telefono,$tematico_combo,$obs_derivar,
							$iduser,$prioridad,$nombre_host,$atividad,$tipo,$tematico2_combo,$contacto_instalar,$fecha_agenda,
							$turno_combo,$telefono_secundario_derivar,$direccion_derivar){
							
		$sql_update="UPDATE tec SET 
					gestion='$gestion',
					tipo='$tipo',
					actividado='$actividado',
					ncontacto='$telefono',
					ncontacto2='$telefono_secundario_derivar',
					contacto='$contacto_instalar',
					casuistica='$tematico_combo',
					motivo='$tematico2_combo',
					observacion='$obs_derivar',
					direccion='$direccion_derivar',
					feci_age='$fecha_agenda',
					horai_age='$turno_combo',
					pc_usu='$nombre_host',
					gestor='$iduser'
					WHERE pet_req='$codigo_pedido'";
						 
		$prod = $this->_db->prepare ($sql_update);
		$prod->execute ();
		$arr = $prod->errorInfo ();
		array_push ($arr,$sql_error);
		return $arr;
	
	}
	
	public function insertDerivarTec($gestion,$actividado,$codigo_pedido,$telefono,$tematico_combo,$obs_derivar,
					$iduser,$prioridad,$nombre_host,$atividad,$tipo,$tematico2_combo,$contacto_instalar,$fecha_agenda,
					$turno_combo,$telefono_secundario_derivar,$direccion_derivar){
					
				$sql_insert_tec = "INSERT INTO tec (gestion, tipo, actividado, pet_req, ncontacto, ncontacto2, contacto, 
								  casuistica, motivo, observacion, direccion, feci_age, horai_age, pc_usu, gestor )
								  VALUES('$gestion','$tipo','$actividado','$codigo_pedido','$telefono','$telefono_secundario_derivar','$contacto_instalar',
								  '$tematico_combo','$tematico2_combo','$obs_derivar','$direccion_derivar','$fecha_agenda','$turno_combo','$nombre_host','$iduser')";

				$prod = $this->_db->prepare ( $sql_insert_tec );
				$prod->execute ();
	
				$sql_error = "INSERT INTO tec (gestion, tipo, actividado, pet_req, ncontacto, ncontacto2, contacto, 
								  casuistica, motivo, observacion, direccion, feci_age, horai_age, pc_usu, gestor )
								  VALUES('$gestion','$tipo','$actividado','$codigo_pedido','$telefono','$telefono_secundario_derivar','$contacto_instalar',
								  '$tematico_combo','$tematico2_combo','$obs_derivar','$direccion_derivar','$fecha_agenda','$turno_combo','$nombre_host','$iduser')";
	
				
				$arr = $prod->errorInfo ();
				array_push ($arr,$sql_error);
				return $arr;
	}
	
	public function insertDerivarTecmov($gestion,$actividado,$codigo_pedido,$telefono,$tematico_combo,$obs_derivar,
					$iduser,$prioridad,$nombre_host,$atividad,$tipo,$tematico2_combo,$contacto_instalar,$fecha_agenda,
					$turno_combo,$telefono_secundario_derivar,$direccion_derivar){
					
				$sql_insert_mov = "INSERT INTO tec_mov (gestion, pet_req, casuistica, motivo, observacion, actividad, prioridad,estado, 
								  submot,usu_gestion,gestor)
								  VALUES('$gestion','$codigo_pedido','$tematico_combo','$tematico2_combo','$obs_derivar','$atividad','$prioridad',
								  'E','1','$usu','$iduser')";
				
				$prod = $this->_db->prepare ($sql_insert_mov);
				$prod->execute ();
	
				$sql_error = "INSERT INTO tec_mov (gestion, pet_req, casuistica, motivo, observacion, actividad, prioridad,estado, 
							  submot,usu_gestion,usu) VALUES('$gestion','$codigo_pedido','$tematico_combo','$tematico2_combo','$obs_derivar',
							  '$atividad','$prioridad','E','1','$usu','$iduser')";
				
				$arr = $prod->errorInfo ();
				array_push ($arr,$sql_error);
				return $arr;		
			
	}
	
	public function getTec($idcodigo){
	
		/* $sql = "SELECT A.tabla,A.actividad,A.casuistica,A.motivo,A.tematico1,A.tematico2,A.tematico3,A.tematico4,A.obs_gestio,A.nuevoped,A.f_carga,A.f_gestion,
				A.situacion,A.estado,A.descripcion FROM (
				SELECT 'TEC MOV' as tabla,actividad,casuistica,motivo,tematico1,tematico2,tematico3,tematico4,obs_gestio,nuevoped,situacion,f_carga,f_gestion,et.estado,st.descripcion 
				FROM tec_mov INNER JOIN submotivotec st ON st.id_submot=tec_mov.submot INNER JOIN estadotec et ON et.id_estado=tec_mov.estado WHERE pet_req='$idcodigo'
				UNION ALL
				SELECT 'CANCELACION' as tabla,actividad,casuistica,observacion as motivo,tematico1,tematico2,tematico3,tematico4,obs_gestio,nuevoped,situacion,f_carga,f_gestion,'' as estado,'' as descripcion FROM cancelacion WHERE pet_req='$idcodigo'
				UNION ALL
				SELECT 'TECNICAS' as tabla,actividad,casuistica,observacion as motivo,tematico1,tematico2,tematico3,tematico4,obs_gestio,nuevoped,situacion,f_carga,f_gestion,'' as estado,'' as descripcion FROM tecnicas WHERE pet_req='$idcodigo'
				UNION ALL
				SELECT 'INSTALACIONES' as tabla,actividad,casuistica,observacion as motivo,tematico1,tematico2,tematico3,tematico4,obs_gestio,nuevoped,situacion,f_carga,f_gestion,'' as estado,'' as descripcion FROM instalaciones WHERE pet_req='$idcodigo'
				UNION ALL
				SELECT 'REMEDY' as tabla,actividad,casuistica,observacion as motivo,tematico1,tematico2,tematico3,tematico4,obs_gestio,'',situacion,f_carga,f_gestion,'' as estado,'' as descripcion FROM remedy.remedys WHERE peticion='$idcodigo'
				ORDER BY f_gestion DESC) AS A"; */
		
		 $sql = "SELECT A.tabla,A.actividad,A.casuistica,A.motivo,A.tematico1,A.tematico2,A.tematico3,A.tematico4,A.obs_gestio,A.nuevoped,A.f_carga,A.f_gestion,
				A.situacion,A.estado,A.descripcion FROM (
				SELECT 'TEC MOV' as tabla,actividad,casuistica,motivo,tematico1,tematico2,tematico3,tematico4,obs_gestio,nuevoped,situacion,f_carga,f_gestion,et.estado,st.descripcion 
				FROM tec_mov INNER JOIN submotivotec st ON st.id_submot=tec_mov.submot INNER JOIN estadotec et ON et.id_estado=tec_mov.estado WHERE pet_req='$idcodigo'
				ORDER BY f_gestion DESC) AS A";
	
		$prod = $this->_db->prepare($sql);
		$prod->execute();
		$result=$prod->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	
	}
	
	public function getmotivo($tematico_combo){
	
		$sql = "SELECT descripcion,descripcion FROM ase_tec_motivo WHERE
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
	
	public function getDatostec($idcodigo){
		$sql = "SELECT 
				a.tipo,
				a.contacto,
				a.ncontacto,
				a.ncontacto2,
				a.casuistica,
				a.motivo,
				a.observacion,
				a.direccion,
				a.feci_age,
				ha.hora
				FROM tec a 
				LEFT JOIN hora_agen ha on ha.id=a.horai_age 
				WHERE pet_req=:pet_req";
	
		$prod = $this->_db->prepare($sql);
		$prod->execute(array(':pet_req'=>$idcodigo));
		return $prod->fetch();
	}
	
	public function getReiteradotec($idcodigo){
	
		$sql = "SELECT tipo,actividad,fecha_registro,casuistica,motivo,observacion FROM ase_tec_reiterado WHERE pedido='$idcodigo'";
	
		$prod = $this->_db->prepare($sql);
		$prod->execute();
		$result=$prod->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	
	}
	
	public function getNumeroreiterado($idcodigo){
	
		$sql = "SELECT * FROM ase_tec_reiterado WHERE pedido='$idcodigo'";
	
		$prod = $this->_db->prepare($sql);
		$prod->execute();
		$conteo=$prod->rowCount();
		
		return $conteo;
	}
	
	public function getAseguram($codigo_pedido){
			
		$sql = "SELECT 
				pet_req
				FROM `cbc_online` WHERE pet_req='$codigo_pedido'
				UNION ALL
				SELECT
				pet_req
				FROM `comercial` WHERE pet_req='$codigo_pedido'
				UNION ALL
				SELECT
				pet_req
				FROM `quiebres` WHERE pet_req='$codigo_pedido'
				UNION ALL
				SELECT
				pet_req
				FROM `vcp` WHERE pet_req='$codigo_pedido'
				UNION ALL
				SELECT
				observacion AS origen_obs
				FROM `remedys` WHERE peticion='$codigo_pedido'
				UNION ALL
				SELECT
				pet_req
				FROM `cancelacion` WHERE pet_req='$codigo_pedido'
				UNION ALL
				SELECT
				pet_req
				FROM `agenda` WHERE pet_req='$codigo_pedido'";
	
		$prod = $this->_db->prepare ( $sql );
		$prod->execute ();

		if ($prod->rowCount ())
			return 1;
		else
			return 0;
	}
}
?>	