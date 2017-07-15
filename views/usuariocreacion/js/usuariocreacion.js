$(document).ready(function() {
	pageSetUp();
	/*
	$('#password_usuario').pwstrength({
        ui: { showVerdictsInsideProgressBar: true }
    });
	*/
	
	var options = {};
    options.rules = {
        activated: {
            wordTwoCharacterClasses: true,
            wordRepetitions: true
        }
    };
    
    $('#password_usuario').pwstrength(options);
    
    $('#nombre_usuario').keyup(function(){
		$('#nombre_usuario').popover('disable')
		$('#nombre_usuario').popover('hide')
		$('#nombre_usuario').popover('destroy')
		$('#validacion_nombres').removeClass('state-error')
	})
	
	$('#apellido_usuario').keyup(function(){
		$('#apellido_usuario').popover('disable')
		$('#apellido_usuario').popover('hide')
		$('#apellido_usuario').popover('destroy')
		$('#validacion_apellidos').removeClass('state-error')
	})
	
	$('#tipodoc_usuario').change(function(){
		$('#tipodoc_usuario').popover('disable')
		$('#tipodoc_usuario').popover('hide')
		$('#tipodoc_usuario').popover('destroy')
		$('#validacion_tipodoc').removeClass('state-error')
	})
	
	$('#documento_usuario').keyup(function(){
		$('#documento_usuario').popover('disable')
		$('#documento_usuario').popover('hide')
		$('#documento_usuario').popover('destroy')
		$('#validacion_documento').removeClass('state-error')
	})
	
	$('#email_usuario').keyup(function(){
		$('#email_usuario').popover('disable')
		$('#email_usuario').popover('hide')
		$('#email_usuario').popover('destroy')
		$('#validacion_email').removeClass('state-error')
	})
	
	$('#telefono_usuario').keyup(function(){
		$('#telefono_usuario').popover('disable')
		$('#telefono_usuario').popover('hide')
		$('#telefono_usuario').popover('destroy')
		$('#validacion_telefono').removeClass('state-error')
	})
	
	$('#tipo_usuario').change(function(){
		$('#tipo_usuario').popover('disable')
		$('#tipo_usuario').popover('hide')
		$('#tipo_usuario').popover('destroy')
		$('#validacion_tipouser').removeClass('state-error')
	})
	
	$('#tipo_perfil').change(function(){
		$('#tipo_perfil').popover('disable')
		$('#tipo_perfil').popover('hide')
		$('#tipo_perfil').popover('destroy')
		$('#validacion_tipoperfil').removeClass('state-error')
	})
	
	$('#id_usuario').keyup(function(){
		$('#id_usuario').popover('disable')
		$('#id_usuario').popover('hide')
		$('#id_usuario').popover('destroy')
		$('#validacion_idusuario').removeClass('state-error')
	})
	
	$('#password_usuario').keyup(function(){
		$('#password_usuario').popover('disable')
		$('#password_usuario').popover('hide')
		$('#password_usuario').popover('destroy')
		$('#validacion_pswd').removeClass('state-error')
	})
	
	$('#tipo_acceso').change(function(){
		$('#tipo_acceso').popover('disable')
		$('#tipo_acceso').popover('hide')
		$('#tipo_acceso').popover('destroy')
		$('#validacion_accesos').removeClass('has-error')
	})
    
    $('#guardar').click(function(){
    	var nombres=$('#nombre_usuario').val()
    	var apellidos=$('#apellido_usuario').val()
    	var tipodoc=$('#tipodoc_usuario').val()
    	var documento=$('#documento_usuario').val()
    	var email=$('#email_usuario').val()
    	var telefono=$('#telefono_usuario').val()
    	var tipousuario=$('#tipo_usuario').val()
    	var tipoperfil=$('#tipo_perfil').val()
    	var usuario=$('#id_usuario').val()
    	var pswd=$('#password_usuario').val()
    	var acceso=$('#tipo_acceso').val()
    	var re = /^(-)?[0-9]*$/;
    	var emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;	
    	var formData = new FormData($("#formulario_guardar")[0]);
    	
    	if(nombres==''){
    		$('#nombre_usuario').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Ingresar Nombres'
			});
    		$('#validacion_nombres').addClass('state-error')
			$('#nombre_usuario').focus()
    	}
    	else if(apellidos==''){
    		$('#apellido_usuario').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Ingresar Apellidos'
			});
    		$('#validacion_apellidos').addClass('state-error')
			$('#apellido_usuario').focus()
    	}
    	else if(tipodoc==''){
    		$('#tipodoc_usuario').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Seleccione el Tipo de Documento'
			});
    		$('#validacion_tipodoc').addClass('state-error')
			$('#tipodoc_usuario').focus()
    	}
    	else if(documento==''){
    		$('#documento_usuario').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Ingresar numero de documento'
			});
    		$('#validacion_documento').addClass('state-error')
			$('#documento_usuario').focus()
    	}
    	else if(!re.test(documento)==true){
    		$('#documento_usuario').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Ingresar solo numeros'
			});
    		$('#validacion_documento').addClass('state-error')
			$('#documento_usuario').focus()
    	}
    	else if(!emailRegex.test(email) && email!=''){
    		$('#email_usuario').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Ingresar email correcto'
			});
    		$('#validacion_email').addClass('state-error')
			$('#email_usuario').focus()
    	}
    	else if(!re.test(telefono)){
    		$('#telefono_usuario').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Solo numeros'
			});
    		$('#validacion_telefono').addClass('state-error')
			$('#telefono_usuario').focus()
    	}
    	else if(tipousuario==''){
    		$('#tipo_usuario').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Seleccionar el Tipo de Usuario'
			});
    		$('#validacion_tipouser').addClass('state-error')
			$('#tipo_usuario').focus()
    	}
    	else if(tipoperfil==''){
    		$('#tipo_perfil').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Sleccionar el TIpo de Perfil'
			});
    		$('#validacion_tipoperfil').addClass('state-error')
			$('#tipo_perfil').focus()
    	}
    	else if(usuario==''){
    		$('#id_usuario').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Ingresar Nombre de Usuario'
			});
    		$('#validacion_idusuario').addClass('state-error')
			$('#id_usuario').focus()
    	}
    	else if(pswd==''){
    		$('#password_usuario').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Ingresar Contraseña'
			});
    		$('#validacion_pswd').addClass('state-error')
			$('#password_usuario').focus()
    	}
    	else if(pswd.length<6){
    		$('#password_usuario').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'El password debe ser mayor a 5 letras'
			});
    		$('#validacion_pswd').addClass('state-error')
			$('#password_usuario').focus()
		}
    	else if(acceso=='' || acceso==null){
    		$('#tipo_acceso').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Ingresar los accesos correspondientes'
			});
    		$('#validacion_accesos').addClass('has-error')
			$('#tipo_acceso').focus()
    	}
    	else{
    		$('#guardar').css('display', 'block'); 
    		$('#icono_guardar').removeClass('fa fa-save')
    		$('#icono_guardar').addClass('fa fa-cog fa-spin fa-fw')
    		$('#formulario_guardar').find('input, textarea, button, select').attr('disabled',true);
    		
    		$.ajax({
	 			url: '../usuariocreacion/insertUser',  
	 			type: 'POST',
	 			data:formData,
	 			cache: false,
	 			contentType: false,
	 			processData: false,
	 			success: function(data){
	 				if(data==1){
	 					$('#modal_derivar').modal('hide');
	 					$.bigBox({
	 						title : "Error",
	 						content : "Falla en el registro de usuario",
	 						color : "#C46A69",
	 						//timeout: 6000,
	 						icon : "fa fa-warning shake animated",
	 						timeout : 6000
	 					});
	 			
	 					e.preventDefault();
	 				}
					else if(data==2){
	 					$('#modal_derivar').modal('hide');
	 					$.bigBox({
	 						title : "Error",
	 						content : "Falla en los accesos",
	 						color : "#C46A69",
	 						//timeout: 6000,
	 						icon : "fa fa-warning shake animated",
	 						timeout : 6000
	 					});
	 			
	 					e.preventDefault();
	 				}
					else{
	 					$.bigBox({
		 					title : "USUARIO REGISTRADO",
		 					content : "El usuario se registro correctamente",
		 					color : "#739E73",
		 					//timeout: 3000,
		 					icon : "fa fa-check",
		 					//number : "4"
		 				}, function() {
		 					//closedthis();
		 				});
		 				e.preventDefault();
		 				$('#icono_guardar').removeClass('fa fa-cog fa-spin fa-fw')
		 				$('#icono_guardar').removeClass('fa fa-save')
					}
	 				
	 			}  
			})
    		
    	}
    })

})