<?php
class administracionController extends Controller {
	public function __construct() {
		parent::__construct ();
		if (!isset($_SESSION['user']))
			$this->redireccionar ('index');
	}
	
	public function index() {
		$objModel =$this->loadModel('administracion');
		$this->_view->tematico=$objModel->getTematico();
		$this->_view->setJs ( array ('administracion' ) );
		$this->_view->renderizar ( 'administracion' );
	}
	
	public function getBusqueda(){
	
		$input=trim($_POST['input']);
		$criterios=$_POST['criterios'];
	
		$objModel=$this->loadModel('administracion');
		$pedidos_busqueda=$objModel->getBusqueda($input,$criterios);
		
		if($pedidos_busqueda>=1){
			echo "1";
		}
		else{
			echo "0";
		}

	}
	
	public function getTrazabilidadbusqueda(){
	
		$pedido=trim($_POST['pedido']);
	
		$objModel=$this->loadModel('administracion');
		$pedidos_busqueda=$objModel->getTrazabilidadbusqueda($pedido);
	
		if($pedidos_busqueda>=1){
			echo "1";
		}
		else{
			echo "0";
		}
	
	}
	
	public function getTecdatos(){
		
		$pedido=trim($_POST['pedido']);
		
		$objModel=$this->loadModel('administracion');
		$pedidos=$objModel->getReiterado($pedido);
	
		echo $pedidos;
	
	}
	
	public function getAseguram(){
		$pedido=trim($_POST['pedido']);
		
		$objModel=$this->loadModel('administracion');
		$pedidos=$objModel->getAseguram($pedido);
	
		echo $pedidos;
		
	}
	
	public function getPedido(){
		set_time_limit(60);
		$input=trim($_POST['input']);
		$criterios=$_POST['criterios'];
		
		$objModel=$this->loadModel('administracion');
		$pedidos=$objModel->getPedido($input,$criterios);
	
		foreach ($pedidos as $reg):
			$miArray['data'][]=$reg;
		endforeach;
	
		echo json_encode ($miArray);
	}
	
	public function getTrazabilidad(){
	
		$idcodigo=$_POST['idcodigo'];
		$input=$_POST['input'];
	
		$objModel=$this->loadModel('administracion');
		$pedidos=$objModel->getTrazabilidad($idcodigo,$input);
	
		foreach ($pedidos as $reg):
			$miArray['data'][]=$reg;
		endforeach;
	
		echo json_encode ($miArray);
	}
	
	public function getTrazabilidad2(){
	
		$idcodigo=$_POST['idcodigo'];
	
		$objModel=$this->loadModel('administracion');
		$pedidos=$objModel->getTrazabilidad2($idcodigo);
	
		foreach ($pedidos as $reg):
		$miArray['data'][]=$reg;
		endforeach;
	
		echo json_encode ($miArray);
	}
	
	public function getAseguramiento(){
	
		$idcodigo=$_POST['idcodigo'];
	
		$objModel=$this->loadModel('administracion');
		$pedidos=$objModel->getAseguramiento($idcodigo);
	
		foreach ($pedidos as $reg):
		$miArray['data'][]=$reg;
		endforeach;
	
		echo json_encode ($miArray);
	}
	
	public function getDias(){
		//$fecha_registro_sistema=$_POST['fecha_registro_sistema'];
		$fecha_registro=$_POST['fecha_registro'];
		$fechaactual=date('Y-m-d');
		//$a = new DateTime($fecha_registro_sistema);
		$b = new DateTime($fecha_registro);

		if($fecha_registro!=null || $fecha_registro!=''){
			$fecha_registro=date_format($b,'Y-m-d');
			$var_fecha_fin= (((strtotime($fechaactual) -strtotime($fecha_registro))/60)/60)/24;
		}
		else{
			$var_fecha_fin=10;
		}
		
		if($var_fecha_fin<=7){
			$clase="success2";
		}
		else{
			$clase="warning2";
		}
		
		echo $clase;
	}
	
	public function insertDerivar(){
	
		$codigo_pedido=trim($_POST['pedido_derivar_input']);
		$telefono=trim($_POST['telefono_derivar']);
		$tematico_combo=trim($_POST['tematico_combo']);
		$tematico2_combo=$_POST['motivo_combo'];
		$contacto_instalar=$_POST['conctacto_instalar'];
		$fecha_agenda=$_POST['fecha_agenda'];
		$turno_combo=$_POST['turno_combo'];
		$telefono_secundario_derivar=$_POST['telefono_secundario_derivar'];
		$direccion_derivar=addslashes(strtoupper(trim($_POST['direccion_derivar_input'])));
		$obs_derivar=addslashes(strtoupper(trim($_POST['obs_derivar'])));
		//$flg_redessociales=trim($_POST['checkbox-toggle']);
		$flg_redessociales=trim($_SESSION['id_tipo_perfil']);
		$prioridad=$_SESSION['id_tipo_perfil_prioridad'];
		$atividad='ANALIZAR';
		$iduser=trim($_SESSION['user']);
		$ip_usr=trim($_SERVER['REMOTE_ADDR']);
		$nombre_host=gethostname();
		$gestion='1RALINEA';
		if($tematico_combo==2)$tematico_combo='CANCELAR';
		elseif($tematico_combo==3)$tematico_combo='REINGRESAR';
		else $tematico_combo='INSTALAR';
		//if($turno_combo==''){$turno_combo=2;}
		
		$objModel=$this->loadModel('administracion');
		
		if($flg_redessociales=='2'){
			$tipo='SOCIAL';
			$actividado='SOCIAL';
		}else if($flg_redessociales=='1'){
			$tipo='104';
			$actividado='104';
		};
		
		$reiterado=$objModel->getReiterado($codigo_pedido);

		if($reiterado==1){
			$actividado='REITERADO';
			$prioridad='1';
			
			//REITERAR TEC
			$insert_derivar=$objModel->insert_derivar($codigo_pedido,$actividado,$tipo,$tematico_combo,$tematico2_combo,$obs_derivar);
			
			//VERIFICA SI ESTA CERRADO EL PEDIDO
			$existe_derivar=$objModel->existeDerivar($codigo_pedido);
			
			if($existe_derivar==1){
				//ACTUALIZAR  TEC
				$update_derivar_tec=$objModel->update_derivar_tec($gestion,$actividado,$codigo_pedido,$telefono,$tematico_combo,$obs_derivar,
							$iduser,$prioridad,$nombre_host,$atividad,$tipo,$tematico2_combo,$contacto_instalar,$fecha_agenda,
							$turno_combo,$telefono_secundario_derivar,$direccion_derivar);
				
				if($update_derivar_tec[0]!='00000'){
					$id=$codigo_pedido;
					$tipo_error=4;
					$sql_script=$update_derivar_tec[3];
					$log_error=$objModel->insertError($id,$update_derivar_tec[2],$iduser,$ip_usr,$tipo_error,$sql_script);
					echo "4";
					exit;
				}
				
				//INSERTAR EN TEC MOV
				$insert_derivar_tec_mov=$objModel->insertDerivarTecmov($gestion,$actividado,$codigo_pedido,$telefono,$tematico_combo,$obs_derivar,
							$iduser,$prioridad,$nombre_host,$atividad,$tipo,$tematico2_combo,$contacto_instalar,$fecha_agenda,
							$turno_combo,$telefono_secundario_derivar,$direccion_derivar);
				
				if($insert_derivar_tec_mov[0]!='00000'){
					$id=$codigo_pedido;
					$tipo_error=5;
					$sql_script=$insert_derivar_tec[3];
					$log_error=$objModel->insertError($id,$insert_derivar_tec_mov[2],$iduser,$ip_usr,$tipo_error,$sql_script);
					echo "5";
					exit;
				}
				
				echo "0";
			}
			else{
				//ACTUALIZAR  TEC
				/* $update_derivar_tec=$objModel->update_derivar_tec($gestion,$actividado,$codigo_pedido,$telefono,$tematico_combo,$obs_derivar,
							$iduser,$prioridad,$nombre_host,$atividad,$tipo,$tematico2_combo,$contacto_instalar,$fecha_agenda,
							$turno_combo,$telefono_secundario_derivar,$direccion_derivar);
				
				if($update_derivar_tec[0]!='00000'){
					$id=$codigo_pedido;
					$tipo_error=4;
					$sql_script=$update_derivar_tec[3];
					$log_error=$objModel->insertError($id,$update_derivar_tec[2],$iduser,$ip_usr,$tipo_error,$sql_script);
					echo "4";
					exit;
				} */
				
				echo "6";
			}
			
		}
		else{
			//REITERAR TEC
			$insert_derivar=$objModel->insert_derivar($codigo_pedido,$actividado,$tipo,$tematico_combo,$tematico2_combo,$obs_derivar);
			
			if($insert_derivar[0]!='00000'){
				$id=$codigo_pedido;
				$tipo_error=1;
				$sql_script=$insert_derivar[3];
				$log_error=$objModel->insertError($id,$insert_derivar[2],$iduser,$ip_usr,$tipo_error,$sql_script);
				echo "1";
				exit;
			}
			
			//INSERTAR DERIVAR TEC Y TEC MOV
			$insert_derivar_tec=$objModel->insertDerivarTec($gestion,$actividado,$codigo_pedido,$telefono,$tematico_combo,$obs_derivar,
						$iduser,$prioridad,$nombre_host,$atividad,$tipo,$tematico2_combo,$contacto_instalar,$fecha_agenda,
						$turno_combo,$telefono_secundario_derivar,$direccion_derivar);
	
			if($insert_derivar_tec[0]!='00000'){
				$id=$codigo_pedido;
				$tipo_error=2;
				$sql_script=$insert_derivar_tec[3];
				$log_error=$objModel->insertError($id,$insert_derivar_tec[2],$iduser,$ip_usr,$tipo_error,$sql_script);
				echo "2";
				exit;
			}
	
			$insert_derivar_tec_mov=$objModel->insertDerivarTecmov($gestion,$actividado,$codigo_pedido,$telefono,$tematico_combo,$obs_derivar,
						$iduser,$prioridad,$nombre_host,$atividad,$tipo,$tematico2_combo,$contacto_instalar,$fecha_agenda,
						$turno_combo,$telefono_secundario_derivar,$direccion_derivar);
			
			if($insert_derivar_tec_mov[0]!='00000'){
				$id=$codigo_pedido;
				$tipo_error=3;
				$sql_script=$insert_derivar_tec[3];
				$log_error=$objModel->insertError($id,$insert_derivar_tec_mov[2],$iduser,$ip_usr,$tipo_error,$sql_script);
				echo "3";
				exit;
			}
		
			echo "0";
			exit;
		
		}
		
	
	}
	
	public function getTec(){
	
		$idcodigo=$_POST['idcodigo'];
	
		$objModel=$this->loadModel('administracion');
		$pedidos=$objModel->getTec($idcodigo);
	
		foreach ($pedidos as $reg):
		$miArray['data'][]=$reg;
		endforeach;
	
		echo json_encode ($miArray);
	}
	
	public function getmotivo($tematico_combo){
	
		$objModel=$this->loadModel('administracion');
		$motivo=$objModel->getmotivo($tematico_combo);
		$html='';
		$html.="<option value='' selected>SELECCIONE</option>";
		foreach($motivo as $indice =>$value):
			$html.="<option value='$value[0]'> $value[1]</option>";
		endforeach;
		echo $html;
	}
	
	public function getFecharegistro(){
		
		$pedido=$_POST['pedido'];
		
		if($pedido==''){
			echo '';
			exit;
		}
	
		$objModel=$this->loadModel('administracion');
		$fecha_registro=$objModel->getFecharegistro($pedido);
		
		if($fecha_registro[0]==''){
			$fecha_registro[0]='';
			$fechita="1";
			echo trim($fechita);
		}
		else{
			$date_inicial = explode(" ", $fecha_registro[0]);
			echo trim($date_inicial[0]);
		}
	
	}
	
	public function getDiasderivar($fecha_pendiente){
		
		$fechaactual=date('Y-m-d');
		$var_fecha_fin= (((strtotime($fechaactual) -strtotime($fecha_pendiente))/60)/60)/24;
		
		echo $var_fecha_fin;
	}
	
	public function getDiasrecomendado(){
		$fechaactual=date('Y-m-d');
		$var_fecha_fin= date("Y-m-d", strtotime("$fechaactual +2 day"));
		
		echo $var_fecha_fin;
	}
	
	public function getFechacomparacion($fecha_agenda,$fecha_recomendada){
		if($fecha_agenda>=$fecha_recomendada){
			echo "0";
		}
		else{
			echo "1";
		}
	}
	
	public function updatePswd(){
	
		$iduser=trim($_SESSION['user']);
	
		$objModel=$this->loadModel('administracion');
		$udpdatePswd=$objModel->updatePswd($iduser);
	
		echo $udpdatePswd;
	
	}
	
	public function updateContra(){
	
		$iduser=trim($_SESSION['user']);
		$pswd=sha1($_POST['pswd']);
		$ip_usr=trim($_SERVER['REMOTE_ADDR']);
	
		$objModel=$this->loadModel('administracion');
		$update=$objModel->updateContra($iduser,$pswd,$ip_usr);
	
		if($update[0]!='00000'){
			$id=0;
			$tipo_error=1;
			$sql_script=$update[3];
			$log_error=$objModel->insertError($id,$update[2],$iduser,$ip_usr,$tipo_error,$sql_script);
			echo "1";
			exit;
		}
		echo "0";
	}
	
	public function getDatostec($idcodigo){
		$objModel=$this->loadModel('administracion');
		$datos_tec=$objModel->getDatostec($idcodigo);
		echo $datos_tec[0].",".$datos_tec[1].",".$datos_tec[2].",".$datos_tec[3].",".
			 $datos_tec[4].",".$datos_tec[5].",".$datos_tec[6].",".$datos_tec[7].",".
			 $datos_tec[8].",".$datos_tec[9];
	}
	
	public function getReiteradotec(){
	
		$idcodigo=$_POST['idcodigo'];
	
		$objModel=$this->loadModel('administracion');
		$pedidos=$objModel->getReiteradotec($idcodigo);
	
		foreach ($pedidos as $reg):
			$miArray['data'][]=$reg;
		endforeach;
	
		echo json_encode ($miArray);

	}
	
	public function getNumeroreiterado(){
	
		$idcodigo=$_POST['idcodigo'];
	
		$objModel=$this->loadModel('administracion');
		$numeroreiterado=$objModel->getNumeroreiterado($idcodigo);
	
		echo $numeroreiterado;
	
	}
}
?>