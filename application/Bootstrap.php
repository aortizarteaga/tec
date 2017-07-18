<?php

/*
 * -------------------------------------
 * 
 * Bootstrap.php
 * -------------------------------------
 */


class Bootstrap
{
    public static function run(Request $peticion)
    {
    	
        $controller = $peticion->getControlador() . 'Controller';   //  ejem:  indexController o postController
        $rutaControlador = ROOT . 'controllers' . DS . $controller . '.php';  // ejem:  .../controllers/indexController.php
        $metodo = $peticion->getMetodo();
        $args = $peticion->getArgs();
        
        if(is_readable($rutaControlador)){
            require_once $rutaControlador;
            $controller = new $controller;
            
            if(is_callable(array($controller, $metodo))){
                $metodo = $peticion->getMetodo();
            }
          	else{
                $metodo = 'index';
            }

            if(isset($args)){
                call_user_func_array(array($controller, $metodo), $args);
            }
            else{
                call_user_func(array($controller, $metodo));
            }
            
        } else {
        	
        	$controller="error500Controller";
        	$rutaControlador = ROOT . 'controllers' . DS . $controller . '.php';
        	$metodo = $peticion->getMetodo();
        	$args = $peticion->getArgs();
        	
        	require_once $rutaControlador;
        	
        	$controller = new $controller;
        	
        	if(is_callable(array($controller, $metodo))){
        		//echo "ddf";
        		$metodo = $peticion->getMetodo();
        		
        	}
        	else{
        		$metodo = 'index';
        		
        	}
        	
        	if(isset($args)){
        		
        		call_user_func_array(array($controller, $metodo), $args);

        	}
        	else{
        		
        		call_user_func(array($controller, $metodo));
        		
        	}
        	
        	
            throw new Exception('no encontrado');
        }
    }
}

?>