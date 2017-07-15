$(document).ready(function() {
	
	$("#acceso").click(function() {
		var usuario=$("#usuario").val()
		var pswd=$("#password").val()

		if(usuario=='' || usuario==null){
			$("#user_tooltip").css('display','block')
			$("#user_tooltip").html('<i class="fa fa-user txt-color-teal"></i> Ingrese Usuario')
			$("#usuario").focus()
		}
		else if(pswd=='' || pswd==null){
			$("#pswd_tooltip").css('display','block')
			$("#pswd_tooltip").html('<i class="fa fa-lock txt-color-teal"></i> Ingrese Contrase&ntilde;a')
			$("#password").focus()
		}
		else{
			$.post('index/login',{
				usuario : usuario,
				pswd : pswd
				
			},function(data){
				if(data==1){
					window.location="administracion/";
				}
				else{
					$("#user_tooltip").css('display','block')
					$("#user_tooltip").html('<i class="fa fa-user txt-color-teal"></i>'+data)
					$("#usuario").val('')
					$("#password").val('')
					$("#usuario").focus()
				}
			})
		}
		
	})

	$("#usuario").keyup(function() {
		$("#user_tooltip").css('display','none')
	})
	
	$("#password").keyup(function() {
		$("#pswd_tooltip").css('display','none')
	})
	
	
	$(document).keypress(function(e) {
	    if(e.which == 13) {
	    	var usuario=$("#usuario").val()
			var pswd=$("#password").val()

			if(usuario=='' || usuario==null){
				$("#user_tooltip").css('display','block')
				$("#user_tooltip").html('<i class="fa fa-user txt-color-teal"></i> Ingrese Usuario')
				$("#usuario").focus()
			}
			else if(pswd=='' || pswd==null){
				$("#pswd_tooltip").css('display','block')
				$("#pswd_tooltip").html('<i class="fa fa-lock txt-color-teal"></i> Ingrese Contrase&ntilde;a')
				$("#password").focus()
			}
			else{
				$.post('index/login',{
					usuario : usuario,
					pswd : pswd
					
				},function(data){
					if(data==1){
						window.location="administracion/";
					}
					else{
						$("#user_tooltip").css('display','block')
						$("#user_tooltip").html('<i class="fa fa-user txt-color-teal"></i>'+data)
						$("#usuario").val('')
						$("#password").val('')
						$("#usuario").focus()
					}
				})
			}
	    }
    })
    
    $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
		_title : function(title) {
			if (!this.options.title) {
				title.html("&#160;");
			} else {
				title.html(this.options.title);
			}
		}
	}));
	
	$('#usuario_olvido').keyup(function(){
		$('#usuario_olvido').popover('disable')
		$('#usuario_olvido').popover('hide')
		$('#usuario_olvido').popover('destroy')
		$('#validacion_usuario').removeClass('state-error')
	})
	
	$('#dni_olvido').keyup(function(){
		$('#dni_olvido').popover('disable')
		$('#dni_olvido').popover('hide')
		$('#dni_olvido').popover('destroy')
		$('#validacion_documento').removeClass('state-error')
	})

    $('#pswd_actualizar').click(function(){
    	
    	$("#usuario_olvido").val('');
		$("#dni_olvido").val('');
		$('#smart-form-register').find('input, textarea, select').attr('disabled',false);

    	var dialog = $("#addtab").dialog({
			autoOpen : true,
			width : 600,
			resizable : false,
			modal : true,
			buttons : [ {
				html : "<i class='fa fa-refresh' id='refrescar_boton'></i>&nbsp; Restablecer",
				"class" : "btn btn-primary",
				click : function() {
					var usuario=$("#usuario_olvido").val();
					var dni=$("#dni_olvido").val();
					var re = /^(-)?[0-9]*$/;
					
					if(usuario!=''){
						$.ajax({
				 			url: 'index/findUser',  
				 			type: 'POST',
						    data: {
						    	usuario:usuario,
						    },
						    async: false,
				 			success: function(s){
				 				json_events = s;
				 			}				
					   	});
					}
					
					if(dni!=''){
						$.ajax({
				 			url: 'index/findDNI',  
				 			type: 'POST',
						    data: {
						    	dni:dni,
						    },
						    async: false,
				 			success: function(s){
				 				json_events_2 = s;
				 			}				
					   	});
					}
					
					if(dni!='' && usuario!=''){
						$.ajax({
				 			url: 'index/findUsr_dni',  
				 			type: 'POST',
						    data: {
						    	usuario:usuario,
						    	dni:dni
						    },
						    async: false,
				 			success: function(s){
				 				json_events_3 = s;
				 			}				
					   	});
					}
					
					if(usuario==''){
			    		$('#usuario_olvido').popover({
							html: true,
							placement:'top',
							title: 'CORREGIR',
							trigger: 'focus',
							content: 'Ingresar Usuario'
						});
			    		$('#validacion_usuario').addClass('state-error')
						$('#usuario_olvido').focus()
			    	}
					else if(json_events==0){
			    		$('#usuario_olvido').popover({
							html: true,
							placement:'top',
							title: 'CORREGIR',
							trigger: 'focus',
							content: 'Usuario no existe'
						});
			    		$('#validacion_usuario').addClass('state-error')
						$('#usuario_olvido').focus()
			    	}
			    	else if(dni==''){
			    		$('#dni_olvido').popover({
							html: true,
							placement:'top',
							title: 'CORREGIR',
							trigger: 'focus',
							content: 'Ingresar Apellidos'
						});
			    		$('#validacion_documento').addClass('state-error')
						$('#dni_olvido').focus()
			    	}
			    	else if(!re.test(dni)==true){
			    		$('#dni_olvido').popover({
							html: true,
							placement:'top',
							title: 'CORREGIR',
							trigger: 'focus',
							content: 'Ingresar solo numeros'
						});
			    		$('#validacion_documento').addClass('state-error')
						$('#dni_olvido').focus()
			    	}
			    	else if(json_events_2==0){
			    		$('#dni_olvido').popover({
							html: true,
							placement:'top',
							title: 'CORREGIR',
							trigger: 'focus',
							content: 'DNI no existe'
						});
			    		$('#validacion_documento').addClass('state-error')
						$('#dni_olvido').focus()
			    	}
			    	else if(json_events_3==0){
			    		$('#dni_olvido').popover({
							//html: true,
							placement:'top',
							title: 'CORREGIR',
							trigger: 'focus',
							content: 'Usuario y DNI no se asocian y/o coinciden'
						});
			    		$('#validacion_documento').addClass('state-error')
						$('#dni_olvido').focus()
			    	}
			    	else{
			    		$('#refrescar_boton').removeClass('fa fa-refresh')
			    		$('#refrescar_boton').addClass('fa fa-cog fa-spin fa-fw')
			    		$('#smart-form-register').find('input, textarea, select').attr('disabled',true);
			    		
			    		$.ajax({
				 			url: 'index/updateUser',  
				 			type: 'POST',
				 			data: {
				 				usuario:usuario,
						    	dni:dni,
						    },
						    async: false,
				 			success: function(data){
				 				if(data==1){
				 					$('#modal_derivar').modal('hide');
				 					$.bigBox({
				 						title : "Error",
				 						content : "No se actualizo el usuario - fallo de sistemas",
				 						color : "#C46A69",
				 						//timeout: 6000,
				 						icon : "fa fa-warning shake animated",
				 						timeout : 6000
				 					});
				 			
				 					e.preventDefault();
				 				}
				 				else{
				 					$.bigBox({
					 					title : "USUARIO RESTABLECIDO",
					 					content : "El usuario se restablecio correctamente",
					 					color : "#739E73",
					 					//timeout: 3000,
					 					icon : "fa fa-check",
					 					//number : "4"
					 				}, function() {
					 					//closedthis();
					 				});
					 				//e.preventDefault();
				 					
				 					$('#refrescar_boton').removeClass('fa fa-cog fa-spin fa-fw')
					 				$('#refrescar_boton').addClass('fa fa-refresh')
					 				$('#addtab').dialog("close");
								}
				 			}
			    		})
			    	}
					
				}
			}]
		});
    	
    	//$('.ui-dialog :button').blur();
    })

});