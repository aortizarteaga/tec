<?php 

class indexController extends Controller{

	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->_view->setJs(array('index'));
		$this->_view->renderizar('index',true);
	}
	
	public function findUser(){
		$usuario=$_POST['usuario'];
		$objModel=$this->loadModel('index');
		$find_user=$objModel->findUser($usuario);
		echo count($find_user[0]);
	}
	
	public function findDNI(){
		$dni=$_POST['dni'];
		$objModel=$this->loadModel('index');
		$find_dni=$objModel->findDNI($dni);
		echo count($find_dni[0]);
	}
	
	public function findUsr_dni(){
		$usuario=$_POST['usuario'];
		$dni=$_POST['dni'];
		$objModel=$this->loadModel('index');
		$find_ambos=$objModel->findUsr_dni($usuario,$dni);
		echo count($find_ambos[0]);
	}
	
	public function updateUser(){
		$usuario=$_POST['usuario'];
		$dni=sha1(trim($_POST['dni']));
		$objModel=$this->loadModel('index');

		$update=$objModel->updateUser($usuario,$dni);
		
		if($update[0]!='00000'){
			$idusuario=$usuario;
			$tipo_error=1;
			$sql_script=$update[3];
			$log_error=$objModel->insertError($idusuario,$update[2],$iduser,$ip_usr,$tipo_error,$sql_script);
			echo "1";
			exit;
		}
		echo "0";
		
	}
	
	public function login(){
		$user = trim($_POST['usuario']);
		$pass = sha1(trim($_POST['pswd']));
		
		$intentos = isset($_COOKIE['intentos'])?$_COOKIE['intentos']:1;
	
		if ($intentos>3) {
			echo 'Sistema Bloqueado';
		}
		else
		{
		
			$objModel=$this->loadModel('index');

			if ($objModel->validUser($user,$pass)){
				$return=$objModel->getNombre($user);
				$_SESSION['user']=$user;
				$_SESSION['nombre']=$return[0];
				$_SESSION['idperfil']=$return[1];
				$_SESSION['perfil']=$return[2];
				$_SESSION['tipo_perfil']=$return[3];
				$_SESSION['id_tipo_perfil']=$return[4];
				$_SESSION['id_tipo_perfil_prioridad']=$return[5];
				$_SESSION['menu'] = $objModel->getMenu($user);
				$_SESSION['menu_completo'] = $objModel->getMenucompleto($user);
				$intentos=1;
				setcookie('intentos',$intentos,time()+3);
				echo '1';
			}
			else
				echo 'Usuario y/o Password incorrecto';
		}
	
		$intentos++;
		setcookie('intentos',$intentos,time()+3); 
	
	}
	
	public function logout(){
	
		unset($_SESSION['user']);
		unset($_SESSION['menu']);
		$this->redireccionar('index');
	} 
	
	
}


?>