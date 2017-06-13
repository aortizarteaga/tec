<?php 

class carpedController extends Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->_view->setJs(array('carped'));
		$this->_view->renderizar('carped');
	  
	}
	
	public function insertTrama(){
		ini_set ( 'memory_limit', '1024M' );
		ini_set('max_execution_time', 300);
		
		$objModel =$this->loadModel('carped');
		
		$nombre_txt=$_FILES['trama_txt']['tmp_name'];
		$mime = $_FILES ['trama_txt'] ['type'];
		$destino_archivo="temp/nombre1.txt";
		$iduser=trim($_SESSION['user']);
		$ip_usr=trim($_SERVER['REMOTE_ADDR']);
		$situacion=2;
		
		move_uploaded_file($nombre_txt,$destino_archivo);
		$fp = file($destino_archivo);
		$nro_filas=count($fp);
		
		if($nro_filas==0){
			echo "1";
			exit;
		}
		
		$delete_trama=$objModel->deleteTrama();
		
		if($delete_trama[0]!='00000'){
			$id=0;
			$tipo_error=1;
			$sql_script=$delete_trama[3];
			$log_error=$objModel->insertError($id,$delete_trama[2],$iduser,$ip_usr,$tipo_error,$sql_script);
			echo "1";
			exit;
		}

		$nro_linea=1;
		foreach ($fp as $line_num => $line):
	
			$array_trama=explode(chr(124), $line);
			$codigo_pedido=trim($array_trama[9]);
			$numero_documento=trim($array_trama[11]);
			$tipo_comercial=trim($array_trama[0]);
			$cod_oc=trim($array_trama[1]);
			$producto=trim($array_trama[2]);
			$fecha_registro=$array_trama[3];
			$fecha_registro_atis=$array_trama[14];
			$marca3=trim($array_trama[5]);
			$req_fe_sitped=trim($array_trama[6]);
			$descripcion=trim($array_trama[7]);
			$negocio2=trim($array_trama[8]);
					
			$array_datos[$nro_linea]['codigo_pedido']=$codigo_pedido;
			$array_datos[$nro_linea]['numero_documento']=$numero_documento;
			$array_datos[$nro_linea]['tipo_comercial']=$tipo_comercial;
			$array_datos[$nro_linea]['cod_oc']=$cod_oc;
			$array_datos[$nro_linea]['producto']=$producto;
			$array_datos[$nro_linea]['fecha_registro']=$fecha_registro;
			$array_datos[$nro_linea]['fecha_registro_atis']=$fecha_registro_atis;
			$array_datos[$nro_linea]['marca3']=$marca3;
			$array_datos[$nro_linea]['req_fe_sitped']=$req_fe_sitped;
			$array_datos[$nro_linea]['descripcion']=$descripcion;
			$array_datos[$nro_linea]['negocio2']=$negocio2;
			$nro_linea=$nro_linea + 1;
			
			if($array_datos[1]['tipo_comercial']!='tipo_operacion_comercial' || $array_datos[1]['cod_oc']!='cod_oc'){
				echo "1";
				exit;
			}
			
		endforeach;
		
		$array_datos_claves=array_keys($array_datos);
		$filas_mostrar=count($array_datos_claves);
		
		for($i=1;$i<$filas_mostrar;$i++){
			$array_datos[$nro_linea]['codigo_pedido']=$codigo_pedido;
			$array_datos[$nro_linea]['numero_documento']=$numero_documento;
			$array_datos[$nro_linea]['tipo_comercial']=$tipo_comercial;
			$array_datos[$nro_linea]['cod_oc']=$cod_oc;
			$array_datos[$nro_linea]['producto']=$producto;
			$array_datos[$nro_linea]['fecha_registro']=$fecha_registro;
			$array_datos[$nro_linea]['fecha_registro_atis']=$fecha_registro_atis;
			$array_datos[$nro_linea]['marca3']=$marca3;
			$array_datos[$nro_linea]['req_fe_sitped']=$req_fe_sitped;
			$array_datos[$nro_linea]['descripcion']=$descripcion;
			$array_datos[$nro_linea]['negocio2']=$negocio2;
			
			$codigo_pedido=$array_datos[$i+1]['codigo_pedido'];
			$numero_documento=$array_datos[$i+1]['numero_documento'];
			$tipo_comercial=$array_datos[$i+1]['tipo_comercial'];
			$cod_oc=$array_datos[$i+1]['cod_oc'];
			$producto=$array_datos[$i+1]['producto'];
			$fecha_registro=$array_datos[$i+1]['fecha_registro'];
			$fecha_registro_atis=$array_datos[$i+1]['fecha_registro_atis'];
			$marca3=$array_datos[$i+1]['marca3'];
			$req_fe_sitped=$array_datos[$i+1]['req_fe_sitped'];
			$descripcion=$array_datos[$i+1]['descripcion'];
			$negocio2=$array_datos[$i+1]['negocio2'];
			
			$trama=$objModel->insertTrama($codigo_pedido,$numero_documento,$tipo_comercial,$cod_oc,$producto,$fecha_registro,$marca3,
					$req_fe_sitped,$descripcion,$negocio2,$iduser,$ip_usr,$situacion,$fecha_registro_atis);
			
			if($trama[0]!='00000'){
				$id=$codigo_pedido;
				$tipo_error=1;
				$sql_script=$trama[3];
				$log_error=$objModel->insertError($id,$trama[2],$iduser,$ip_usr,$tipo_error,$sql_script);
				echo "1";
				exit;
			}
			echo "0";
		}
	}
	
	public function getFilasexcel(){
		$nombre_excel=$_FILES['trama_excel']['tmp_name'];
		$mime = $_FILES ['trama_excel'] ['type'];
		$destino_archivo="temp/excel.csv";
		
		move_uploaded_file($nombre_excel,$destino_archivo);
		
		$fp = file($destino_archivo);
		$nro_filas=count($fp);
		
		if($nro_filas==0){
			echo "0";
			exit;
		}
		
		echo $nro_filas;
	}
	
	public function insertExcel(){
		ini_set ( 'memory_limit', '1024M' );
		ini_set('max_execution_time', 300);
		
		$objModel =$this->loadModel('carped');
	
		$nombre_excel=$_FILES['trama_excel']['tmp_name'];
		$mime = $_FILES ['trama_excel'] ['type'];
		$criterio=$_POST['radio'];
		
		$destino_archivo="temp/excel.csv";
		$iduser=trim($_SESSION['user']);
		$ip_usr=trim($_SERVER['REMOTE_ADDR']);
		$situacion=4;
	
		move_uploaded_file($nombre_excel,$destino_archivo);

		$fp = file($destino_archivo);
		$nro_filas=count($fp);
	
		if($nro_filas==0){
			echo "1";
			exit;
		}
		
		if($criterio==1){
			
			/* $verificar_base=$objModel->verificar_base($criterio);

			if($verificar_base==1){
				echo "2"; //Ya se cargo
				exit;
			}
			else if($verificar_base==2){
				$delete_trama=$objModel->deleteTrama($criterio);
				
				if($delete_trama[0]!='00000'){
					$id=0;
					$tipo_error=1;
					$sql_script=$delete_trama[3];
					$log_error=$objModel->insertError($id,$delete_trama[2],$iduser,$ip_usr,$tipo_error,$sql_script);
					echo "1";
					exit;
				}
			} */
			
			$nro_linea=1;
			foreach ($fp as $line_num => $line):
			
			$array_trama=explode(chr(44), $line);
			$fecha_registro=$array_trama[0];
			$fecha_cancelado=$array_trama[1];
			$codigo_peticion=trim($array_trama[2]);
			$edo_pet=trim($array_trama[6]);
			$usr_ultimo=trim($array_trama[16]);
			$czonal=trim($array_trama[32]);
			$servicio=trim($array_trama[37]);
			$modalidad=trim($array_trama[38]);
			$motivo=trim($array_trama[41]);
			$desobsges=trim($array_trama[42]);
			$codigo_requerimiento=trim($array_trama[43]);
			$motctv=trim($array_trama[45]);
			$desobsctv=trim($array_trama[46]);
			$grupo=trim($array_trama[51]);
				
			$array_datos[$nro_linea]['fecreg']=$fecha_registro;
			$array_datos[$nro_linea]['feccan']=$fecha_cancelado;
			$array_datos[$nro_linea]['codpeti']=$codigo_peticion;
			$array_datos[$nro_linea]['edopet']=$edo_pet;
			$array_datos[$nro_linea]['userultimo']=$usr_ultimo;
			$array_datos[$nro_linea]['czonal']=$czonal;
			$array_datos[$nro_linea]['servicio']=$servicio;
			$array_datos[$nro_linea]['modali']=$modalidad;
			$array_datos[$nro_linea]['motivo']=$motivo;
			$array_datos[$nro_linea]['desobsges']=$desobsges;
			$array_datos[$nro_linea]['codreq']=$codigo_requerimiento;
			$array_datos[$nro_linea]['motctv']=$motctv;
			$array_datos[$nro_linea]['desobsctv']=$desobsctv;
			$array_datos[$nro_linea]['grupo']=$grupo;
			$nro_linea=$nro_linea + 1;
			
			if($array_datos[1]['fecreg']!='fecreg' || $array_datos[1]['feccan']!='feccan'){
				echo "3";
				exit;
			}
				
			endforeach;
			
			$array_datos_claves=array_keys($array_datos);
			$filas_mostrar=count($array_datos_claves);
			
			for($i=1;$i<$filas_mostrar;$i++){
					
				$array_datos[$nro_linea]['fecreg']=$fecha_registro;
				$array_datos[$nro_linea]['feccan']=$fecha_cancelado;
				$array_datos[$nro_linea]['codpeti']=$codigo_peticion;
				$array_datos[$nro_linea]['edopet']=$edo_pet;
				$array_datos[$nro_linea]['userultimo']=$usr_ultimo;
				$array_datos[$nro_linea]['czonal']=$czonal;
				$array_datos[$nro_linea]['servicio']=$servicio;
				$array_datos[$nro_linea]['modali']=$modalidad;
				$array_datos[$nro_linea]['motivo']=$motivo;
				$array_datos[$nro_linea]['desobsges']=$desobsges;
				$array_datos[$nro_linea]['codreq']=$codigo_requerimiento;
				$array_datos[$nro_linea]['motctv']=$motctv;
				$array_datos[$nro_linea]['desobsctv']=$desobsctv;
				$array_datos[$nro_linea]['grupo']=$grupo;
			
				$fecha_registro=$array_datos[$i+1]['fecreg'];
				$fecha_cancelado=$array_datos[$i+1]['feccan'];
				$codigo_peticion=$array_datos[$i+1]['codpeti'];
				$edo_pet=$array_datos[$i+1]['edopet'];
				$usr_ultimo=$array_datos[$i+1]['userultimo'];
				$czonal=$array_datos[$i+1]['czonal'];
				$servicio=$array_datos[$i+1]['servicio'];
				$modalidad=$array_datos[$i+1]['modali'];
				$motivo=$array_datos[$i+1]['motivo'];
				$desobsges=$array_datos[$i+1]['desobsges'];
				$codigo_requerimiento=$array_datos[$i+1]['codreq'];
				$motctv=$array_datos[$i+1]['motctv'];
				$desobsctv=$array_datos[$i+1]['desobsctv'];
				$grupo=$array_datos[$i+1]['grupo'];
			
				$trama_excel_atis=$objModel->insertExcelcancelado($fecha_registro,$fecha_cancelado,$codigo_peticion,$edo_pet,$usr_ultimo,$czonal,$servicio,
						$modalidad,$motivo,$desobsges,$codigo_requerimiento,$motctv,$desobsctv,$grupo,$iduser,
						$ip_usr,$situacion);
			
				if($trama_excel_atis[0]!='00000'){
					$id=$codigo_pedido;
					$tipo_error=1;
					$sql_script=$trama_excel_atis[3];
					$log_error=$objModel->insertError($id,$trama_excel_atis[2],$iduser,$ip_usr,$tipo_error,$sql_script);
			
					$k=$k+1;
				}
				else{
					$j=$j+1;
				}
			}
			
			$tipo_base='ATIS';
			$log_carga=$objModel->insertLogcarga($j,$k,$nro_filas,$nombre_excel,$situacion,$iduser,$ip_usr,$tipo_base);
			echo $j.",".$k;
			
		}
		else if($criterio==2){
			
			/* $verificar_base=$objModel->verificar_base($criterio);
				
			if($verificar_base==1){
				echo "2"; //Ya se cargo
				exit;
			}
			else if($verificar_base==2){
				$delete_trama=$objModel->deleteTrama($criterio);
			
				if($delete_trama[0]!='00000'){
					$id=0;
					$tipo_error=1;
					$sql_script=$delete_trama[3];
					$log_error=$objModel->insertError($id,$delete_trama[2],$iduser,$ip_usr,$tipo_error,$sql_script);
					echo "1";
					exit;
				}
			} */
			
			$nro_linea=1;
			foreach ($fp as $line_num => $line):
				
			$array_trama=explode(chr(44), $line);
			$fecha_registro=$array_trama[18];
			$fecha_cancelado=$array_trama[58];
			$codigo_peticion='';
			$edo_pet='';
			$usr_ultimo=trim($array_trama[59]);
			$czonal='';
			$servicio='';
			$modalidad='';
			$motivo=trim($array_trama[38]);
			$desobsges=trim($array_trama[42]);
			$codigo_requerimiento=trim($array_trama[4]);
			$motctv=trim($array_trama[52]);
			$desobsctv=trim($array_trama[53]);
			$grupo=trim($array_trama[43]);
			
			$array_datos[$nro_linea]['fecreg']=$fecha_registro;
			$array_datos[$nro_linea]['feccan']=$fecha_cancelado;
			$array_datos[$nro_linea]['codpeti']=$codigo_peticion;
			$array_datos[$nro_linea]['edopet']=$edo_pet;
			$array_datos[$nro_linea]['userultimo']=$usr_ultimo;
			$array_datos[$nro_linea]['czonal']=$czonal;
			$array_datos[$nro_linea]['servicio']=$servicio;
			$array_datos[$nro_linea]['modali']=$modalidad;
			$array_datos[$nro_linea]['motivo']=$motivo;
			$array_datos[$nro_linea]['desobsges']=$desobsges;
			$array_datos[$nro_linea]['codreq']=$codigo_requerimiento;
			$array_datos[$nro_linea]['motctv']=$motctv;
			$array_datos[$nro_linea]['desobsctv']=$desobsctv;
			$array_datos[$nro_linea]['grupo']=$grupo;
			$nro_linea=$nro_linea + 1;
				
			if($array_datos[1]['userultimo']!='user_ultim' || $array_datos[1]['desobsctv']!='des_motivo'){
				echo "3";
				exit;
			}
			
			endforeach;
				
			$array_datos_claves=array_keys($array_datos);
			$filas_mostrar=count($array_datos_claves);
				
			for($i=1;$i<$filas_mostrar;$i++){
					
				$array_datos[$nro_linea]['fecreg']=$fecha_registro;
				$array_datos[$nro_linea]['feccan']=$fecha_cancelado;
				$array_datos[$nro_linea]['codpeti']=$codigo_peticion;
				$array_datos[$nro_linea]['edopet']=$edo_pet;
				$array_datos[$nro_linea]['userultimo']=$usr_ultimo;
				$array_datos[$nro_linea]['czonal']=$czonal;
				$array_datos[$nro_linea]['servicio']=$servicio;
				$array_datos[$nro_linea]['modali']=$modalidad;
				$array_datos[$nro_linea]['motivo']=$motivo;
				$array_datos[$nro_linea]['desobsges']=$desobsges;
				$array_datos[$nro_linea]['codreq']=$codigo_requerimiento;
				$array_datos[$nro_linea]['motctv']=$motctv;
				$array_datos[$nro_linea]['desobsctv']=$desobsctv;
				$array_datos[$nro_linea]['grupo']=$grupo;
					
				$fecha_registro=$array_datos[$i+1]['fecreg'];
				$fecha_cancelado=$array_datos[$i+1]['feccan'];
				$codigo_peticion=$array_datos[$i+1]['codpeti'];
				$edo_pet=$array_datos[$i+1]['edopet'];
				$usr_ultimo=$array_datos[$i+1]['userultimo'];
				$czonal=$array_datos[$i+1]['czonal'];
				$servicio=$array_datos[$i+1]['servicio'];
				$modalidad=$array_datos[$i+1]['modali'];
				$motivo=$array_datos[$i+1]['motivo'];
				$desobsges=$array_datos[$i+1]['desobsges'];
				$codigo_requerimiento=$array_datos[$i+1]['codreq'];
				$motctv=$array_datos[$i+1]['motctv'];
				$desobsctv=$array_datos[$i+1]['desobsctv'];
				$grupo=$array_datos[$i+1]['grupo'];
					
				$trama_excel_cms=$objModel->insertExcelcancelado($fecha_registro,$fecha_cancelado,$codigo_peticion,$edo_pet,$usr_ultimo,$czonal,$servicio,
						$modalidad,$motivo,$desobsges,$codigo_requerimiento,$motctv,$desobsctv,$grupo,$iduser,
						$ip_usr,$situacion);
					
				if($trama_excel_cms[0]!='00000'){
					$id=$codigo_pedido;
					$tipo_error=1;
					$sql_script=$trama_excel_cms[3];
					$log_error=$objModel->insertError($id,$trama_excel_cms[2],$iduser,$ip_usr,$tipo_error,$sql_script);
						
					$k=$k+1;
				}
				else{
					$j=$j+1;
				}
			}
				
			$tipo_base='CMS';
			$log_carga=$objModel->insertLogcarga($j,$k,$nro_filas,$nombre_excel,$situacion,$iduser,$ip_usr,$tipo_base);
			echo $j.",".$k;
			
		}
		else if($criterio==3){
			
			$delete_trama=$objModel->deleteTrama($criterio);
			
			if($delete_trama[0]!='00000'){
				$id=0;
				$tipo_error=1;
				$sql_script=$delete_trama[3];
				$log_error=$objModel->insertError($id,$delete_trama[2],$iduser,$ip_usr,$tipo_error,$sql_script);
				echo "1";
				exit;
			}
			
			$situacion=3;
			
			$nro_linea=1;
			foreach ($fp as $line_num => $line):
			
			$array_trama=explode(chr(44), $line);
			$negocio=trim($array_trama[1]);
			$gzonal=trim($array_trama[8]);
			$jefatura=trim($array_trama[9]);
			$mov=trim($array_trama[10]);
			$ccontr=trim($array_trama[12]);
			$contra=trim($array_trama[13]);
			$desseg=trim($array_trama[19]);
			$pet_req=trim($array_trama[21]);
			$codreq=trim($array_trama[23]);
			$descript=trim($array_trama[67]);
			$fecreg=$array_trama[30];
			$feceje=$array_trama[32];
			$up_front=trim($array_trama[73]);
				
			$array_datos[$nro_linea]['negocio']=$negocio;
			$array_datos[$nro_linea]['gzonal']=$gzonal;
			$array_datos[$nro_linea]['jefatura']=$jefatura;
			$array_datos[$nro_linea]['mov']=$mov;
			$array_datos[$nro_linea]['ccontr']=$ccontr;
			$array_datos[$nro_linea]['contra']=$contra;
			$array_datos[$nro_linea]['desseg']=$desseg;
			$array_datos[$nro_linea]['pet_req']=$pet_req;
			$array_datos[$nro_linea]['codreq']=$codreq;
			$array_datos[$nro_linea]['descript']=$descript;
			$array_datos[$nro_linea]['fecreg']=$fecreg;
			$array_datos[$nro_linea]['feceje']=$feceje;
			$array_datos[$nro_linea]['up_front']=$up_front;
			$nro_linea=$nro_linea + 1;
			
			if($array_datos[1]['jefatura']!='JEFATURA' || $array_datos[1]['pet_req']!='PET_REQ'){
				echo "3";
				exit;
			}
				
			endforeach;
			
			$array_datos_claves=array_keys($array_datos);
			$filas_mostrar=count($array_datos_claves);
			
			for($i=1;$i<$filas_mostrar;$i++){
					
				$array_datos[$nro_linea]['negocio']=$negocio;
				$array_datos[$nro_linea]['gzonal']=$gzonal;
				$array_datos[$nro_linea]['jefatura']=$jefatura;
				$array_datos[$nro_linea]['mov']=$mov;
				$array_datos[$nro_linea]['ccontr']=$ccontr;
				$array_datos[$nro_linea]['contra']=$contra;
				$array_datos[$nro_linea]['desseg']=$desseg;
				$array_datos[$nro_linea]['pet_req']=$pet_req;
				$array_datos[$nro_linea]['codreq']=$codreq;
				$array_datos[$nro_linea]['descript']=$descript;
				$array_datos[$nro_linea]['fecreg']=$fecreg;
				$array_datos[$nro_linea]['feceje']=$feceje;
				$array_datos[$nro_linea]['up_front']=$up_front;
					
				$negocio=$array_datos[$i+1]['negocio'];
				$gzonal=$array_datos[$i+1]['gzonal'];
				$jefatura=$array_datos[$i+1]['jefatura'];
				$mov=$array_datos[$i+1]['mov'];
				$ccontr=$array_datos[$i+1]['ccontr'];
				$contra=$array_datos[$i+1]['contra'];
				$desseg=$array_datos[$i+1]['desseg'];
				$pet_req=$array_datos[$i+1]['pet_req'];
				$codreq=$array_datos[$i+1]['codreq'];
				$descript=$array_datos[$i+1]['descript'];
				$fecreg=$array_datos[$i+1]['fecreg'];
				$feceje=$array_datos[$i+1]['feceje'];
				$up_front=$array_datos[$i+1]['up_front'];
					
				$trama_excel_ejecutadas=$objModel->insertExcelejecutado($negocio,$gzonal,$jefatura,$mov,$ccontr,$contra,$desseg,$pet_req,$codreq,
								  $descript,$fecreg,$feceje,$up_front,$iduser,$ip_usr,$situacion);
					
				if($trama_excel_ejecutadas[0]!='00000'){
					$id=$codigo_pedido;
					$tipo_error=1;
					$sql_script=$trama_excel_ejecutadas[3];
					$log_error=$objModel->insertError($id,$trama_excel_ejecutadas[2],$iduser,$ip_usr,$tipo_error,$sql_script);
			
					$k=$k+1;
				}
				else{
					$j=$j+1;
				}
			}
			$tipo_base='EJECUTADA';
			$log_carga=$objModel->insertLogcarga($j,$k,$nro_filas,$nombre_excel,$situacion,$iduser,$ip_usr,$tipo_base);
			
			echo $j.",".$k;
			
		}
	
	}

}
?>