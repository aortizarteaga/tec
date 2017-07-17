$(document).ready(function() {
	pageSetUp();
	
	var responsiveHelper_datatable_fixed_column = undefined;
	
	var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};
	
	responsiveHelper_datatable_fixed_column = undefined
	$('#datatable_fixed_column').dataTable().fnDestroy();
    var otable = $('#datatable_fixed_column').DataTable({
    	"ajax": {
	    	 "url":'../usuarioupdate/getUsuario',
  	        	"type": 'POST',
  	            "data": {}
  	     },
  	    "bAutoWidth": false,
	    "autoWidth": false,
	    "autoWidth" : true,
	    "columns": [
	                    { "data": "id_tec_usuario"},
	                    { "data": "nombres"},
	                    { "data": "apellidos" },
	                    { "data": "documento" },
	                    { "data": "area"  },
	                    { "data": "fecha_registro" },
	                    { "data": "flg_activo" },
	                    { "data": "opciones",
	                    	"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
	                    		$(nTd).html("<center><a id_usuario='"+oData.id_tec_usuario+"' title='Actualizacion Usuario' class='usuario fa fa-edit'  style='cursor: pointer;display:inline;color: #3276b1;font-size:18px'></a></center>")
	                    	}
	                    }
	                  ],
		"sDom": "<'dt-toolbar'>"+"t"+"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		"preDrawCallback" : function() {
			// Initialize the responsive datatables helper once.
			if (!responsiveHelper_datatable_fixed_column) {
				responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_datatable_fixed_column.respond();
		}		
	
    });

    $("#datatable_fixed_column thead th input[type=text]").on( 'keyup change', function () {
    	
        otable
            .column( $(this).parent().index()+':visible' )
            .search( this.value )
            .draw();
            
    } );

    
    $("#datatable_fixed_column tbody").on('click','a.usuario',function(){
		 id_usuario= $(this).attr("id_usuario");
		 $('#pedido_derivar').html("<strong>"+id_usuario+"</strong>")
		 $('#usuario_actualizar').val(id_usuario)
		 $('#modal_usuario').modal();
		 
		 $.post('../usuarioupdate/getUsuariodatos/' + id_usuario, function(data) {
				
				var myarray = data.split("|")
				
				$('#nombre_usuario').val(myarray[3].trim())
				$('#apellido_usuario').val(myarray[4].trim())
				$('#documento_usuario').val(myarray[7].trim())
				$('#email_usuario').val(myarray[5].trim())
				$('#telefono_usuario').val(myarray[8].trim())
				$('#unidad_usuario').val(myarray[9].trim())
				$('#area_usuario').val(myarray[10].trim())
				
				
				combo_tipo_documento = document.forms["formulario_actualizar"].tipodoc_usuario;
				cantidad_tipo_documento = combo_tipo_documento.length;
				
				for (i = 0; i < cantidad_tipo_documento; i++) {
				 if(combo_tipo_documento[i].value ==myarray[6].trim()) {
					 combo_tipo_documento[i].selected = true;
					 }
				}
				
				combo_tipo_usuario = document.forms["formulario_actualizar"].tipo_usuario;
				cantidad_tipo_usuario = combo_tipo_usuario.length;
				
				for (i = 0; i < cantidad_tipo_usuario; i++) {
				 if(combo_tipo_usuario[i].value ==myarray[1].trim()) {
					 combo_tipo_usuario[i].selected = true;
					 }
				}
				
				combo_tipo_perfil = document.forms["formulario_actualizar"].tipo_perfil;
				cantidad_tipo_perfil = combo_tipo_perfil.length;
				
				for (i = 0; i < cantidad_tipo_perfil; i++) {
				 if(combo_tipo_perfil[i].value ==myarray[2].trim()) {
					 combo_tipo_perfil[i].selected = true;
					 }
				}
				
				if(myarray[12].trim()=='Y'){
					$('#chk_usuario').prop('checked',true)
					$('#status_usuario').text('Activo')
				}
				else{
					$('#chk_usuario').prop('checked',false)
					$('#status_usuario').text('Inactivo')
				}

				
			});
    })
    
    $('#chk_usuario').change(function(){
    	if ($('#chk_usuario').is(':checked')) {
    		$('#status_usuario').text('Activo')
    	}
    	else{
    		$('#status_usuario').text('Inactivo')
    	}
    })
    
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
	
    
    $('#guardar').click(function(){
    	var nombres=$('#nombre_usuario').val()
    	var apellidos=$('#apellido_usuario').val()
    	var tipodoc=$('#tipodoc_usuario').val()
    	var documento=$('#documento_usuario').val()
    	var email=$('#email_usuario').val()
    	var telefono=$('#telefono_usuario').val()
    	var tipousuario=$('#tipo_usuario').val()
    	var tipoperfil=$('#tipo_perfil').val()
    	var pswd=$('#password_usuario').val()
    	var re = /^(-)?[0-9]*$/;
    	var emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;	
    	var formData = new FormData($("#formulario_actualizar")[0]);
    	
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
    	else{
    		$('#guardar').css('display', 'block'); 
    		$('#icono_guardar').removeClass('fa fa-save')
    		$('#icono_guardar').addClass('fa fa-cog fa-spin fa-fw')
    		$('#formulario_guardar').find('input, textarea, button, select').attr('disabled',true);
    		
    		$.ajax({
	 			url: '../usuarioupdate/updateUser',  
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
	 					$('#icono_guardar').removeClass('fa fa-cog fa-spin fa-fw')
		 				$('#icono_guardar').addClass('fa fa-refresh')
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
	 					$('#icono_guardar').removeClass('fa fa-cog fa-spin fa-fw')
		 				$('#icono_guardar').addClass('fa fa-refresh')
	 					e.preventDefault();
	 				}
					else if(data==0){
	 					$.bigBox({
		 					title : "USUARIO REGISTRADO",
		 					content : "El usuario se registro correctamente",
		 					color : "#739E73",
		 					//timeout: 3000,
		 					icon : "fa fa-check",
		 					//number : "4"
		 				}, function() {
		 					closedthis();
		 					//window.location = "../usuarioupdate/"
		 				});
		 				e.preventDefault();
		 				$('#icono_guardar').removeClass('fa fa-cog fa-spin fa-fw')
		 				$('#icono_guardar').addClass('fa fa-refresh')
					}
					else{
	 					$('#modal_derivar').modal('hide');
	 					$.bigBox({
	 						title : "Error",
	 						content : "Falla",
	 						color : "#C46A69",
	 						//timeout: 6000,
	 						icon : "fa fa-warning shake animated",
	 						timeout : 6000
	 					});
	 					$('#icono_guardar').removeClass('fa fa-cog fa-spin fa-fw')
		 				$('#icono_guardar').addClass('fa fa-refresh')
	 					e.preventDefault();
	 				}
	 				
	 			}  
			})
    		
    	}
    })
    
    function closedthis() {
    	window.location = "../usuarioupdate/"
	}
    

})