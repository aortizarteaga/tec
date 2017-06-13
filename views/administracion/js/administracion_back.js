$(document).ready(function() {
	pageSetUp();
	
	$("#menu").menu();
	
	$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
		_title : function(title) {
			if (!this.options.title) {
				title.html("&#160;");
			} else {
				title.html(this.options.title);
			}
		}
	}));
	
	$('#pswd').keyup(function(){
		$('#malo_update').css('display','none')
	})
	
	$('#pswd2').keyup(function(){
		$('#malo_update2').css('display','none')
	})
	
	$.post('../administracion/updatePswd/', function(data) {
			update=data
			
			if(update==1){
				
				var dialog = $("#addtab").dialog({
					autoOpen : true,
					width : 600,
					resizable : false,
					modal : true,
					buttons : [ {
						html : "<i class='fa fa-refresh'></i>&nbsp; Actualizar",
						"class" : "btn btn-primary",
						click : function() {
							var pswd=$("#pswd").val();
							var pswd2=$("#pswd2").val();
							
							var n = pswd.localeCompare(pswd2);
							
							if(pswd==''){
								$('#malo_digitar').html("Ingresar Contrase&ntilde;a");
								$('#malo_update').css('display','inline')
								$('#pswd').focus()
								$("#pswd").val('');
							}
							else if(pswd.length<6){
								$('#malo_digitar').html("El numero de caracteres debe ser mayor a 5");
								$('#malo_update').css('display','inline')
								$('#pswd').focus()
								$("#pswd").val('');
							}
							else if(pswd2==''){
								$('#malo_digitar2').html("Ingresar nuevamente Contrase&ntilde;a");
								$('#malo_update2').css('display','inline')
								$('#pswd2').focus()
								$("#pswd2").val('');
							}
							else if(pswd2.length<6){
								$('#malo_digitar2').html("El numero de caracteres debe ser mayor a 5");
								$('#malo_update2').css('display','inline')
								$('#pswd2').focus()
								$("#pswd2").val('');
							}
							else if(n==1 || pswd.length!=pswd2.length){
								$('#malo_digitar').html("Las conrase&ntilde;as deben coincidir");
								$('#malo_update').css('display','inline')
								//$('#pswd').val('')
								//$('#pswd2').val('')
								$('#pswd').focus()
							}
							else if(pswd != pswd2 || pswd.length!=pswd2.length){
								$('#malo_digitar').html("Las conrase&ntilde;as deben coincidir");
								$('#malo_update').css('display','inline')
								//$('#pswd').val('')
								//$('#pswd2').val('')
								$('#pswd').focus()
							}
							else{
								$.ajax({
 				         			url: '../administracion/updateContra',  
 				         			type: 'POST',
 				        		    data: {
 				        		    	pswd:pswd
 				        		    },
 				         			success: function(s){
 				         				if(s==1){
 				         					alert('No se puedo actualizar la informacion')
 				         				}
 				         				else{
 				         					window.location="../administracion/";
 				         				}
 				         			}				
 				        	   	});
							}
							
							
						}
					}]
				});
				//$('.ui-dialog :button').blur();
			}
	})
	
	var tematico_combo
	var tematico2_combo
	var fecha_registro_pendiente
	
	$('#fecha_agenda').datepicker({
	    dateFormat: 'yy-mm-dd',
	})
	
	var criterios=0
	
	var responsiveHelper_dt_basic = undefined;
	var responsiveHelper_dt_modal = undefined;
	var responsiveHelper_dt_modal_base = undefined;
	var responsiveHelper_dt_modal_aseguramiento = undefined;
	var responsiveHelper_dt_modal_tec = undefined;
	var breakpointDefinition = {
		tablet : 1024,
		phone : 480
	};

	$('#criterios').change(function(){
		criterios=$('#criterios').val()
		if(criterios==0 || criterios=='0'){
			$('#criterio_digitar').val('')
			$('#contenedor_oculto').css('display','none')
			$('#dt_basic').dataTable().fnDestroy();
			
			$('#criterios').popover('disable')
			$('#criterios').popover('hide')
			$('#criterios').popover('destroy')
			
			$('#derivar_si').css('display','none')
		}
		else if(criterios==1 || criterios=='1'){
			$('#criterio_digitar').val('')
			$('#contenedor_oculto').css('display','none')
			$('#dt_basic').dataTable().fnDestroy();
			
			$('#criterios').popover('disable')
			$('#criterios').popover('hide')
			$('#criterios').popover('destroy')
			
			$('#derivar_si').css('display','none')
		}
		else if(criterios==2 || criterios=='2'){
			$('#criterio_digitar').val('')
			$('#contenedor_oculto').css('display','none')
			$('#dt_basic').dataTable().fnDestroy();
			
			$('#criterios').popover('disable')
			$('#criterios').popover('hide')
			$('#criterios').popover('destroy')
			
			$('#derivar_si').css('display','none')
		}
	})
	
	$('#criterio_digitar').keyup(function(){
		$('#criterio_digitar').popover('disable')
		$('#criterio_digitar').popover('hide')
		$('#criterio_digitar').popover('destroy')
	})
	
	$('#buscar').click(function(){
		var input=$('#criterio_digitar').val()

		if(criterios==0 || criterios=='0' || criterios==''){
			$('#criterios').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Seleccionar el criterio'
			});
			/*$("#combo_tooltip").css('display','block')
			$("#combo_tooltip").html('<i class="fa fa-pencil-square-o txt-color-teal"></i> Elija Tipo de Busqueda')*/
			$("#criterios").focus()
		}
		else if(input=='' || input==null){
			$('#criterio_digitar').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Ingrese el criterio'
			});
			/*$("#criterio_tooltip").css('display','block')
			$("#criterio_tooltip").html('<i class="fa fa-pencil-square-o txt-color-teal"></i> Ingrese criterio')*/
			$("#criterio_digitar").focus()
		}
		else{
			 $.ajax({
		 			url: '../administracion/getBusqueda',  
		 			type: 'POST',
		 			data: {
	  	            	input: input,
	  	            	criterios:criterios
	  	            },
		 			//processData: false,
		 		    //contentType: false,
		 			success: function(data){
		 				if(data==0){
		 					$.smallBox({
		 						title : "ERROR",
		 						content : "No se encontro el registro, derivar manualmente!!",
		 						color : "#C46A69",
		 						timeout: 6000,
		 						icon : "fa fa-warning swing animated"
		 					});
		 					$('#derivar_si').css('display','inline')
		 					$('#contenedor_oculto').css('display','none')
		 					$('#dt_basic').dataTable().fnDestroy();
		 				}
		 				else{
		 					$('#derivar_si').css('display','none')
		 					$('#contenedor_oculto').css('display','inline')
		 					responsiveHelper_dt_basic = undefined
		 					$('#dt_basic').dataTable().fnDestroy();
		 					$('#dt_basic').dataTable({
		 					     "ajax": {
		 					    	 "url":'../administracion/getPedido',
		 				  	        	"type": 'POST',
		 				  	            "data": {
		 				  	            	input: input,
		 				  	            	criterios:criterios
		 				  	            }
		 				  	        },
		 				  	      "bAutoWidth": false,
		 				  	      "autoWidth": false,
		 				  	      "autoWidth" : true,
		 				  	      "columns": [
		 				                    { "data": "codigo_pedido"},
		 				                    { "data": "estado",
		 				                    	"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
		 				                    		if(oData.estado=='REGISTRO'){
		 				                    			data=oData.estado
		 				                    			icono="cursor: pointer;display:inline;color: #005c84;font-size:20px"
		 				                    		}
		 				                    		else{
		 				                    			data=''
		 						                    	icono="cursor: pointer;display:none;color: #005c84;font-size:20px"
		 				                    		}
		 				                    		$(nTd).html(""+data+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id_codigo='"+oData.codigo_pedido+"' class='bitacora fa fa-archive' title='Consultar Trazabilidad' style='"+icono+"'></a>")
		 				                    	} 
		 				                    },
		 				                    { "data": "fecha_registro_registro" },
		 				                    { "data": "estado_movimiento" ,
		 				                    	"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
		 				                    		if(oData.estado_movimiento=='PENDIENTE' || oData.estado_movimiento=='CANCELADAS' || oData.estado_movimiento=='EJECUTADAS'){
		 				                    			data=oData.estado_movimiento
		 				                    			icono="cursor: pointer;display:inline;color: #005c84;font-size:20px"
		 				                    		}
		 				                    		else{
		 				                    			
		 				                    			data=''
		 						                    	icono="cursor: pointer;display:none;color: #005c84;font-size:20px"
		 				                    		}
		 				                    		$(nTd).html("<strong>"+data+"</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id_codigo='"+oData.codigo_pedido+"' class='bitacora2 fa fa-archive' title='Consultar Trazabilidad' style='"+icono+"'></a> ")
		 				                    	}  
		 				                    },
		 				                    { "data": "fecha_registro"  },
		 				                    { "data": "fecha_ultimo_movimiento" },
		 				                    { "data": "opciones",
		 				                    	"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
		 				                    		if(oData.estado==null){data=''}
		 				                    		else{data=oData.estado}
		 				                    		$(nTd).html("<center><a id_codigo='"+oData.codigo_pedido+"' title='Consultar Aseguramiento' class='aseguramiento fa fa-database'  style='cursor: pointer;display:inline;color: #48c400;font-size:20px'></a>" +
		 				                    				"&nbsp;&nbsp;&nbsp;<a id_codigo='"+oData.codigo_pedido+"' title='Derivar' class='derivar fa fa-mail-forward'  style='cursor: pointer;display:inline;color: red;font-size:20px'></a>"+
		 				                    				"&nbsp;&nbsp;&nbsp;<a id_codigo='"+oData.codigo_pedido+"' title='Trazabilidad TEC' class='tec fa fa-hdd-o'  style='cursor: pointer;display:inline;color: #005c84;font-size:20px'></a></center>")
		 				                    	}
		 				                    }
		 				                   ],
		 				   			"sDom": "<'dt-toolbar'>"+"t"+"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		 				           	"preDrawCallback" : function() {
		 				           			if (!responsiveHelper_dt_basic) {
		 				           				responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
		 				           			}
		 				           		},
		 				           	"fnRowCallback" : function(nRow,oData) {
		 				           		
		 				           		//var fecha_registro_sistema=oData.fecha_registro_sistema
		 				           		var fecha_registro=oData.fecha_registro
		 				           			
		 				           		$.ajax({
		 				         			url: '../administracion/getDias',  
		 				         			type: 'POST',
		 				        		    data: {
		 				        		    	//fecha_registro_sistema: fecha_registro_sistema,
		 				        		    	fecha_registro: fecha_registro
		 				        		    },
		 				         			success: function(s){
		 				         				json_events=s
		 				         				$(nRow).addClass(json_events)
		 				         			}				
		 				        	   	});
		 				           		
		 				           		responsiveHelper_dt_basic.createExpandIcon(nRow);
		 				           			
		 				           		},
		 				           	"drawCallback" : function(oSettings) {
		 				           			responsiveHelper_dt_basic.respond();
		 				           		}
		 					});
		 					
		 				}
		 			}				
			   	});
			
		}
	})
	
	$('#derivar_si').click(function(){
		 
		 $('#pedido_derivar').css('display','none')
		 $('#pedido_derivar_input').css('display','block')
		 $('#pedido_derivar_input').val('')
		  $('#telefono_derivar').val('')
		 $('#telefono_secundario_derivar').val('')
		  $('#tematico_combo').val('')
		  $('#motivo_combo').val('')
		 //$('#tematico_combo option:eq(0)').prop('selected', true).change();
		 //$('#motivo_combo option:eq(0)').prop('selected', true).change();
		 $('#conctacto_instalar').val('')
		 $('#fecha_agenda').val('')
		 $('#turno_combo option:eq(0)').prop('selected', true).change();
		 $('#direccion_derivar_input').val('')
		 $('#obs_derivar').val('')
		 $('#obs_derivar').text('')
		 $('#fecha_agenda').val('')
		 $('#btn_enviar').css('display','block')
		 $('#instalar_oculto').css('display','none')
		 $('#direccion_ocultar').css('display','none')
		 $('#enviado_boton_derivar').val('1')
		 
		 $('#myModalLabelenviar').html("<div class='widget-header'><h4><i class='fa fa-mail-forward'></i> Derivacion TEC</h4></div>");
		 //$('#pedido_derivar').html("<strong>"+idcodigo+"</strong>")
		 //$('#pedido_derivar_input').val(idcodigo)
		 $('#modal_derivar').modal();
	})
	
	
	$("#dt_basic tbody").on('click','a.bitacora',function(){
		 idcodigo = $(this).attr("id_codigo");
		 var input=$('#criterio_digitar').val()
		 
		 $('#myModalLabel').html("<div class='widget-header'><h4><i class='fa fa-archive'></i> Trazabilidad del Pedido Nro "+"<strong>"+idcodigo+"</strong>"+" </h4></div>");
		 $('#myModal').modal();
		 
		 responsiveHelper_dt_modal = undefined
		 $('#dt_modal').dataTable().fnDestroy();
			$('#dt_modal').dataTable({
			     "ajax": {
			    	 "url":'../administracion/getTrazabilidad',
		  	        	"type": 'POST',
		  	            "data": {
		  	            	idcodigo: idcodigo,
		  	            	input:input
		  	            }
		  	        },
		  	      "bAutoWidth": false,
		  	      "autoWidth": false,
				  "autoWidth" : true,
		  	      //"scrollX": true,
		          "columns": [
		                    { "data": "codigo_pedido" },
		                    { "data": "documento" },
		                    { "data": "estado_gestion" },
		                    { "data": "detalle_gestion" },
		                    { "data": "subdetalle_gestion" },
		                    { "data": "observacion_gestion" },
		                    { "data": "pedido_vuelo" },
		                    { "data": "flg_dependencia" },
		                    { "data": "fecha" },
		                    { "data": "descripcion" }
		                   ],
				"sDom": "<'dt-toolbar'>"+
					"t"+"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		        "oLanguage": {
				    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
				},
	           	"preDrawCallback" : function() {
           			if (!responsiveHelper_dt_modal) {
           				responsiveHelper_dt_modal = new ResponsiveDatatablesHelper($('#dt_modal'), breakpointDefinition);
           			}
           		},
           	"rowCallback" : function(nRow) {
           			responsiveHelper_dt_modal.createExpandIcon(nRow);
           		},
           	"drawCallback" : function(oSettings) {
           			responsiveHelper_dt_modal.respond();
           		}
			});
	})
	
	$("#dt_basic tbody").on('click','a.bitacora2',function(){
		 idcodigo = $(this).attr("id_codigo");
		 $('#myModalLabelbase').html("<div class='widget-header'><h4><i class='fa fa-archive'></i> Trazabilidad del Pedido Nro "+"<strong>"+idcodigo+"</strong>"+" </h4></div>");
		 $('#myModalbase').modal();
		 
		 responsiveHelper_dt_modal_base = undefined
		 $('#dt_modal_base').dataTable().fnDestroy();
			$('#dt_modal_base').dataTable({
			     "ajax": {
			    	 "url":'../administracion/getTrazabilidad2',
		  	        	"type": 'POST',
		  	            "data": {
		  	            	idcodigo: idcodigo,
		  	            }
		  	        },
		  	      "bAutoWidth": false,
		  	      "autoWidth": false,
				  "autoWidth" : true,
		  	      //"scrollX": true,
		          "columns": [
		                    { "data": "documento" },
		                    { "data": "tipo_operacion" },
		                    { "data": "cod_oc" },
		                    { "data": "producto" },
		                    { "data": "fecha_registro" },
		                    { "data": "fecha_base" },
		                    { "data": "motivo" },
		                    { "data": "observacion" },
		                    { "data": "situacion" }
		                   ],
				"sDom": "<'dt-toolbar'>"+
					"t"+"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		        "oLanguage": {
				    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
				},
	           	"preDrawCallback" : function() {
           			if (!responsiveHelper_dt_modal_base) {
           				responsiveHelper_dt_modal_base = new ResponsiveDatatablesHelper($('#dt_modal_base'), breakpointDefinition);
           			}
           		},
           	"rowCallback" : function(nRow) {
           			responsiveHelper_dt_modal_base.createExpandIcon(nRow);
           		},
           	"drawCallback" : function(oSettings) {
           			responsiveHelper_dt_modal_base.respond();
           		}
			});
	})
	
	$("#dt_basic tbody").on('click','a.aseguramiento',function(){
		 idcodigo = $(this).attr("id_codigo");
		 $('#myModalLabel2').html("<div class='widget-header'><h4><i class='fa fa-archive'></i> Trazabilidad Base Aseguramiento del Pedido Nro "+"<strong>"+idcodigo+"</strong>"+" </h4></div>");
		 $('#myModal2').modal()
		 
		 responsiveHelper_dt_modal_aseguramiento = undefined
		 $('#dt_modal_aseguramiento').dataTable().fnDestroy();
			$('#dt_modal_aseguramiento').dataTable({
				  "order" : [ [ 9, "desc" ] ],
			     "ajax": {
			    	 "url":'../administracion/getAseguramiento',
		  	        	"type": 'POST',
		  	            "data": {
		  	            	idcodigo: idcodigo,
		  	            }
		  	        },
		  	      "bAutoWidth": false,
		  	      "autoWidth": false,
				  "autoWidth" : false,
		          "columns": [
		                    { "data": "Gestion" },
		                    { "data": "pet_req" },
		                    { "data": "des_mot" },
		                    { "data": "origen_obs" },
		                    { "data": "tematico1" },
		                    { "data": "tematico2" },
		                    { "data": "tematico3" },
		                    { "data": "tematico4" },
		                    { "data": "obs_gestio" },
		                    { "data": "f_carga" },
		                    { "data": "f_gestion" },
		                    { "data": "situacion" },
		                    { "data": "usu_gestion" }
		                   ],
				"sDom": "<'dt-toolbar'>"+
					"t"+"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		        "oLanguage": {
				    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
				},
	           	"preDrawCallback" : function() {
           			if (!responsiveHelper_dt_modal_aseguramiento) {
           				responsiveHelper_dt_modal_aseguramiento = new ResponsiveDatatablesHelper($('#dt_modal_aseguramiento'), breakpointDefinition);
           			}
           		},
           	"rowCallback" : function(nRow) {
           			responsiveHelper_dt_modal_aseguramiento.createExpandIcon(nRow);
           		},
           	"drawCallback" : function(oSettings) {
           			responsiveHelper_dt_modal_aseguramiento.respond();
           		},
           		"language": {
			      	"url": "/gc_emision/public/assets/cdn/datatable.spanish.lang"
			     } 
			});
	})
	
	$("#dt_basic tbody").on('click','a.derivar',function(){
		 idcodigo = $(this).attr("id_codigo");
		 $('#enviado_boton_derivar').val('')
		 
		 $('#pedido_derivar_input').css('display','none')
		 $('#pedido_derivar').css('display','block')
		 $('#pedido_derivar_input').val('')
		 $('#telefono_derivar').val('')
		 $('#telefono_secundario_derivar').val('')
		 $('#tematico_combo option:eq(0)').prop('selected', true).change();
		 $('#motivo_combo option:eq(0)').prop('selected', true).change();
		 $('#conctacto_instalar').val('')
		 $('#fecha_agenda').val('')
		 $('#turno_combo option:eq(0)').prop('selected', true).change();
		 $('#direccion_derivar_input').val('')
		 $('#obs_derivar').val('')
		 $('#obs_derivar').text('')
		 $('#fecha_agenda').val('')
		 $('#btn_enviar').css('display','block')
		 $('#instalar_oculto').css('display','none')
		 $('#direccion_ocultar').css('display','none')
		  
		 $('#myModalLabelenviar').html("<div class='widget-header'><h4><i class='fa fa-mail-forward'></i> Derivacion TEC</h4></div>");
		 $('#pedido_derivar').html("<strong>"+idcodigo+"</strong>")
		 $('#pedido_derivar_input').val(idcodigo)
		 $('#modal_derivar').modal();
	})
	
	function tabla_tec(){
		responsiveHelper_dt_modal_tec = undefined
		 $('#dt_modal_tec').dataTable().fnDestroy();
		 $('#dt_modal_tec').dataTable({
				  "order" : [ [ 9, "desc" ] ],
			     "ajax": {
			    	 "url":'../administracion/getTec',
		  	        	"type": 'POST',
		  	            "data": {
		  	            	idcodigo: idcodigo,
		  	            }
		  	        },
		  	      "bAutoWidth": false,
		  	      "autoWidth": false,
				  "autoWidth" : false,
		          "columns": [
		                    { "data": "gestion" },
		                    { "data": "tipo" },
		                    { "data": "actividado" },
		                    { "data": "casuistica" },
		                    { "data": "observacion" },
		                    { "data": "tematico1" },
		                    { "data": "tematico2" },
		                    { "data": "tematico3" },
		                    { "data": "tematico4" },
		                    { "data": "obs_gestio" },
		                    { "data": "f_carga" },
		                    { "data": "f_gestion" },
		                    { "data": "situacion" },
		                    { "data": "usu_gestion" }
		                   ],
				"sDom": "<'dt-toolbar'>"+
					"t"+"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		        "oLanguage": {
				    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
				},
	           	"preDrawCallback" : function() {
          			if (!responsiveHelper_dt_modal_tec) {
          				responsiveHelper_dt_modal_tec = new ResponsiveDatatablesHelper($('#dt_modal_tec'), breakpointDefinition);
          			}
          		},
          	"rowCallback" : function(nRow) {
          			responsiveHelper_dt_modal_tec.createExpandIcon(nRow);
          		},
          	"drawCallback" : function(oSettings) {
          			responsiveHelper_dt_modal_tec.respond();
          		},
          		"language": {
			      	"url": "/gc_emision/public/assets/cdn/datatable.spanish.lang"
			     } 
			});
	}
	
	$("#dt_basic tbody").on('click','a.tec',function(){
		 idcodigo = $(this).attr("id_codigo");
		 $('#codigo_pedido_tec').val(idcodigo)
		 $('#myModalLabel_tec').html("<div class='widget-header'><h4><i class='fa fa-archive'></i> Trazabilidad TEC del Pedido Nro "+"<strong>"+idcodigo+"</strong></h4></div>");
		 $('#myModal_tec').modal()
		 $('#enviado_boton_derivar').val('')
		 tabla_tec()
	})
	
	
	$('#tematico_combo').change(function(){	
		tematico_combo=$('#tematico_combo').val()
		$('#instalar_oculto').css('display','none')
		$('#instalar_oculto').css('display','none')
		$('#direccion_ocultar').css('display','none')
		$('#icono_no_agendar').css('display','none')
		$('#agenda_document').text('')
		
		$.post('../administracion/getmotivo/'+tematico_combo,function(data){
			$('#motivo_combo').html(data);	
		});
	
	})
	
	$('#pedido_derivar_input').keyup(function(){	
		$('#trama_txt').popover('disable')
		$('#trama_txt').popover('hide')
		$('#trama_txt').popover('destroy')
		$('#motivo_combo').val('')
		$('#tematico_combo').val('')
		$('#fecha_registro_pendiente').val('')
		$('#instalar_oculto').css('display','none')
		$('#direccion_ocultar').css('display','none')
	})
	
	$('#motivo_combo').change(function(){	
		
		tematico2_combo=$('#motivo_combo').val()
		pedido=$('#pedido_derivar_input').val().trim()
		var re = /^(-)?[0-9]*$/
		$('#fecha_registro_pendiente').val('')
		
		if(pedido==''){
			$('#pedido_derivar_input').popover({
				html: true,
				placement:'top',
				title: '<i class="fa fa-warning"></i> CORREGIR',
				trigger: 'focus',
				content: 'No se puede agendar, ingrese pedidos'
			});
			$('#pedido_derivar_input').val('')
			$('#pedido_derivar_input').focus()
			$('#tematico_combo option:eq(0)').prop('selected', true).change();
		}
		else if(!re.test(pedido)==true){
			$('#pedido_derivar_input').popover({
				html: true,
				placement:'top',
				title: '<i class="fa fa-warning"></i> CORREGIR',
				trigger: 'focus',
				content: 'Solo caracteres numericos'
			});
			$('#pedido_derivar_input').val('')
			$('#pedido_derivar_input').focus()
			$('#tematico_combo option:eq(0)').prop('selected', true).change();
		}
		else if((pedido.length>0 && pedido.length<6)||(pedido.length>9)){
			$('#pedido_derivar_input').popover({
				html: true,
				placement:'top',
				title: '<i class="fa fa-warning"></i> CORREGIR',
				trigger: 'focus',
				content: 'Numeros entre 6 y 9 caracteres'
			});
			$('#pedido_derivar_input').val('')
			$('#pedido_derivar_input').focus()
			$('#tematico_combo option:eq(0)').prop('selected', true).change();
		}
		else if(tematico_combo==1 && tematico2_combo==1){
			
				$('#conctacto_instalar').val('')
				$('#fecha_agenda').val('')
				$('#agenda_document').text('')
				$('#icono_no_agendar').css('display','none')
				
			$.ajax({
	 			url: '../administracion/getFecharegistro/', 
	 			type: 'POST',
			    data: {
			    	pedido:pedido
			    },
	 			success: function(s){
	 				json_events = s;

					if(json_events!=1){
						$('#fecha_registro_pendiente').val(json_events)
						document.formulario_derivar.fecha_registro_pendiente.value = document.formulario_derivar.fecha_registro_pendiente.value.replace(/\s/gi,'');
					}
					
	 				$.post('../administracion/getDiasrecomendado/', function(data) {
						fecha_pendiente=$('#fecha_registro_pendiente').val()
	 					fecha_recomendada=data
						
						if(fecha_pendiente.length=='0'){
							$('#instalar_oculto').css('display','block')
							$('#direccion_ocultar').css('display','none')
							$('#agenda_document').text("Agendar a partir de "+fecha_recomendada);
							$('#icono_no_agendar').css('display','inline')
						}
						else{
							$.post('../administracion/getDiasderivar/' + fecha_pendiente, function(data) {
									$('#dias_pendiente').val(data)
									if(data<7){
										$('#instalar_oculto').css('display','block')
										$('#direccion_ocultar').css('display','none')
										$('#agenda_document').text("Agendar a partir de "+fecha_recomendada);
										$('#agenda_document').css('color','green')
										$('#icono_no_agendar').css('display','inline')
										$('#icono_no_agendar').css('color','green')
									}
									else {
										$('#instalar_oculto').css('display','block')
										$('#direccion_ocultar').css('display','none')
										$('#agenda_document').text("Agendar a partir de "+fecha_recomendada);
										$('#agenda_document').css('color','red')
										$('#icono_no_agendar').css('display','inline')
										$('#icono_no_agendar').css('color','red')
									}
									
		
							});
						}
	 				})
					
					//alert(fecha_recomendada)
	 				
	 				
	 				
	 			}				
		   	});
		}
		else if(tematico_combo==3 && tematico2_combo!=''){
			$('#instalar_oculto').css('display','none')
			$('#direccion_ocultar').css('display','block')
		}
		else if(tematico_combo==1 && (tematico2_combo==2 || tematico2_combo=='')){
			$('#instalar_oculto').css('display','none')
			$('#direccion_ocultar').css('display','none')
			$('#icono_no_agendar').css('display','none')
			$('#agenda_document').text('')
			$('#conctacto_instalar').val('')
			$('#fecha_agenda').val('')
			$('#turno_combo option:eq(0)').prop('selected', true).change();
		}
		
	})
	
	$('#derivacion_tec').click(function(){
		 idcodigo=$('#codigo_pedido_tec').val()
		 $('#pedido_derivar_input').css('display','none')
		 $('#pedido_derivar').css('display','block')
		 $('#pedido_derivar_input').val('')
		 $('#telefono_derivar').val('')
		 $('#telefono_secundario_derivar').val('')
		 $('#tematico_combo option:eq(0)').prop('selected', true).change();
		 $('#motivo_combo option:eq(0)').prop('selected', true).change();
		 $('#conctacto_instalar').val('')
		 $('#fecha_agenda').val('')
		 $('#turno_combo option:eq(0)').prop('selected', true).change();
		 $('#direccion_derivar_input').val('')
		 $('#obs_derivar').val('')
		 $('#obs_derivar').text('')
		 $('#fecha_agenda').val('')
		 $('#btn_enviar').css('display','block')
		 $('#instalar_oculto').css('display','none')
		 $('#direccion_ocultar').css('display','none')
		  
		 $('#myModalLabelenviar').html("<div class='widget-header'><h4><i class='fa fa-mail-forward'></i> Derivacion TEC</h4></div>");
		 $('#pedido_derivar').html("<strong>"+idcodigo+"</strong>")
		 $('#pedido_derivar_input').val(idcodigo)
		 $('#modal_derivar').modal();
	})
	
	
	$('#conctacto_instalar').keyup(function(){
		$('#conctacto_instalar').popover('disable')
		$('#conctacto_instalar').popover('hide')
		$('#conctacto_instalar').popover('destroy')
	})
	
	$('#fecha_agenda').change(function(){
		$('#fecha_agenda').popover('disable')
		$('#fecha_agenda').popover('hide')
		$('#fecha_agenda').popover('destroy')
	})
	
	$('#turno_combo').change(function(){
		$('#turno_combo').popover('disable')
		$('#turno_combo').popover('hide')
		$('#turno_combo').popover('destroy')
	})
	
	$('#telefono_derivar').keyup(function(){
		$('#telefono_derivar').popover('disable')
		$('#telefono_derivar').popover('hide')
		$('#telefono_derivar').popover('destroy')
	})
	
	$('#tematico_combo').change(function(){
		$('#tematico_combo').popover('disable')
		$('#tematico_combo').popover('hide')
		$('#tematico_combo').popover('destroy')
	})
	
	$('#pedido_derivar_input').change(function(){
		$('#pedido_derivar_input').popover('disable')
		$('#pedido_derivar_input').popover('hide')
		$('#pedido_derivar_input').popover('destroy')
	})
	
	$('#obs_derivar').change(function(){
		$('#obs_derivar').popover('disable')
		$('#obs_derivar').popover('hide')
		$('#obs_derivar').popover('destroy')
	})

	function closedthis() {
				$.smallBox({
					title : "Felicitaciones!",
					content : "Este mensaje se borrara en 5 segundos!",
					color : "#739E73",
					iconSmall : "fa fa-cloud",
					timeout : 3000
				});
	}
	
	
	window.onload = function() {
		 var myInput = document.getElementById('telefono_derivar');
		 myInput.onpaste = function(e) {
		   e.preventDefault();
		 }
	}
	
	
	$('#btn_enviar').click(function(){
		var pedido=$('#pedido_derivar_input').val()
		var tematico=$('#tematico_combo').val()
		var telefono=$('#telefono_derivar').val()
		var observaciones=$('#obs_derivar').val()
		var contacto_instalar= $('#conctacto_instalar').val()
		var fecha_agenda=$('#fecha_agenda').val()
		var turno_combo= $('#turno_combo').val()
		var direccion=$('#direccion_derivar_input').val()
		var manual_derivar=$('#enviado_boton_derivar').val()
		
		$.post('../administracion/getDiasrecomendado/', function(data) {
	 					fecha_recomendada=data
	 	})	
	 	
	 	if(fecha_agenda!=''){
	 		var fecha1 = moment(fecha_recomendada);
			var fecha2 = moment(fecha_agenda);
			var dias=fecha2.diff(fecha1, 'days')
	 	}
		
		var formData = new FormData($("#formulario_derivar")[0]);
		var re = /^(-)?[0-9]*$/
				
		if(pedido==''){
			$('#pedido_derivar_input').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Ingresar Pedido'
			});
			$('#pedido_derivar_input').focus()
		}
		else if(!re.test(pedido)==true){
			$('#pedido_derivar_input').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Solo caracteres numericos'
			});
			$('#pedido_derivar_input').focus()
		}
		else if((pedido.length>0 && pedido.length<6)||(pedido.length>9)){
			$('#pedido_derivar_input').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Numeros entre 6 y 9 caracteres'
			});
			$('#pedido_derivar_input').focus()
		}
		else if(tematico_combo==''){
			$('#tematico_combo').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Seleccionar el tematico'
			});
			$('#tematico_combo').focus()
		}
		else if(tematico2_combo==''){
			$('#motivo_combo').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Seleccionar el tematico 2'
			});
			$('#motivo_combo').focus()
		}
		else if(tematico_combo==1 && tematico2_combo==1 && contacto_instalar==''){
			$('#conctacto_instalar').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Escribir el contacto'
			});
			$('#conctacto_instalar').focus()
		}
		else if(tematico_combo==1 && tematico2_combo==1 && fecha_agenda==''){
			$('#fecha_agenda').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Escribir la fecha de agendamiento'
			});
			$('#fecha_agenda').focus()
			//$('#fecha_agenda').val('')
		}
		else if(tematico_combo==1 && tematico2_combo==1 && dias<0){
			$('#fecha_agenda').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'La fecha debe ser mayor o igual a la indicada'
			});
			$('#fecha_agenda').focus()
		}
		else if(tematico_combo==1 && tematico2_combo==1 && turno_combo==''){
			$('#turno_combo').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Seleccione el turno'
			});
			$('#turno_combo').focus()
		}
		else if(telefono==''){
			$('#telefono_derivar').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Completar'
			});
			$('#telefono_derivar').focus()
		}		
		else if(!re.test(telefono)==true){
			$('#telefono_derivar').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Solo caracteres numericos'
			});
			$('#telefono_derivar').focus()
		}
		else if((telefono.length>0 && telefono.length<7)||(telefono.length>9)){
			$('#telefono_derivar').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Numeros entre 7 y 9 caracteres'
			});
			$('#telefono_derivar').focus()
		}
		else if(tematico_combo==3 && tematico2_combo!='' && direccion==''){
			$('#direccion_derivar_input').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Escriba la direccion'
			});
			$('#direccion_derivar_input').focus()
		}
		else if(observaciones==''){
			$('#obs_derivar').popover({
				html: true,
				placement:'top',
				title: 'CORREGIR',
				trigger: 'focus',
				content: 'Completar'
			});
			$('#obs_derivar').focus()
		}	
		else{
			$('#btn_enviar').css('display','none')
				 setTimeout(function(){
					 $.ajax({
				 			url: '../administracion/insertDerivar',  
				 			type: 'POST',
				 			data: formData,
				 			processData: false,
				 		    contentType: false,
				 			success: function(data){
							alert(data)
				 				if(data==1){
				 					$('#modal_derivar').modal('hide');
				 					$.bigBox({
				 						title : "Error",
				 						content : "No se derivo correctamente",
				 						color : "#C46A69",
				 						//timeout: 6000,
				 						icon : "fa fa-warning shake animated",
				 						timeout : 6000
				 					});
				 			
				 					e.preventDefault();
				 				}
				 				else if(data==3 || data==4){
				 					$('#modal_derivar').modal('hide');
				 					$.bigBox({
				 						title : "Error",
				 						content : "No sepuede derivar, el pedido esta siendo procesado",
				 						color : "#C46A69",
				 						//timeout: 6000,
				 						icon : "fa fa-warning shake animated",
				 						timeout : 6000
				 					});
				 			
				 					e.preventDefault();
				 				}
				 				else{
									if(manual_derivar!=1){
										tabla_tec()
									}
				 					
				 					$('#modal_derivar').modal('hide');
				 					$.bigBox({
					 					title : "PEDIDO DERIVADO",
					 					content : "El pedido se derivo correctamente al area de TEC para su gestion, gracias",
					 					color : "#739E73",
					 					//timeout: 3000,
					 					icon : "fa fa-check",
					 					//number : "4"
					 				}, function() {
					 					//closedthis();
					 				});
					 		
					 				e.preventDefault();
					 				

				 				}
				 			}				
					   	});
				 }, 500);
		}
	})
	

})