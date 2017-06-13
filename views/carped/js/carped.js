$(document).ready(function() {
	pageSetUp();
	
	$('#trama_txt').change(function(){
		$('#trama_txt').popover('disable')
		$('#trama_txt').popover('hide')
		$('#trama_txt').popover('destroy')
	})
	
	$('#trama_txt').change(function(){

		var file = $("#trama_txt")[0].files[0];
        var fileName = file.name;        
        var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        var fileSize = file.size;
        var fileType = file.type;
        var tamanio
        var descripction
        $('#procesar').css('display','none')
        
        if(fileExtension!='txt'){ 
        	$('#trama_txt').popover({
				html: true,
				placement:'top',
				title: '<i class="fa fa-warning"></i> CORREGIR',
				trigger: 'focus',
				content: 'Seleccione archivo correcto'
			});
        	$('#trama_txt').val('')
        	$('#adjuntos').css('display','none')
			$('#trama_txt').focus()
			$('#procesar').css('display','none')
        }
        else{
        	$('#adjuntos').css('display','block')
        	$('#procesar').css('display','inline')
        	$('#document_name').text(fileName);
        }
		
	})
	
	$('#procesar').click(function(){
		$('#procesar').css('display','none')
		var formData = new FormData($("#formulario_generar")[0]);
		$('#trama_excel').attr('disabled','disabled')
		$.ajax({
			   url: '../carped/insertTrama',  
			   type: 'POST',
			   data: formData,
			   cache: false,
			   contentType: false,
			   processData: false,
			   success: function(data){
				   $('#trama_excel').attr('disabled',false)
				   alert(data)
				   //document.write(data)
			   }
			  });
		
	})
	
	$('#trama_excel').change(function(){
		$('#trama_excel').popover('disable')
		$('#trama_excel').popover('hide')
		$('#trama_excel').popover('destroy')
	})
	
	$('#trama_excel').change(function(){
		var file = $("#trama_excel")[0].files[0];
        var fileName = file.name;        
        var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        var fileSize = file.size;
        var fileType = file.type;
        var tamanio
        var descripction
        
        $('#registros_view').css('display','none')
         $('#resultado_proceso').css('display','none')
         $('#errores').css('display','none')
        
        if(fileExtension!='csv'){ 
        	$('#trama_excel').popover({
				html: true,
				placement:'top',
				title: '<i class="fa fa-warning"></i> CORREGIR',
				trigger: 'focus',
				content: 'Seleccione archivo correcto'
			});
        	$('#trama_excel').val('')
        	$('#adjuntos_excel').css('display','none')
			$('#trama_excel').focus()
			$('#procesar_excel').css('display','none')
        }
        else{
        	$('#adjuntos_excel').css('display','block')
        	$('#procesar_excel').css('display','inline')
        	$('#document_name_excel').text(fileName);
        }
		
	})
	
	$('#procesar_excel').click(function(){
		
		//$('#procesar_excel').css('display','none')
		var formData = new FormData($("#formulario_generar_excel")[0]);
		var radio=$('input:radio[name=radio]:checked').val()
		
		$('#trama_txt').attr('disabled','disabled')
		$('#trama_excel').attr('disabled','disabled')
		$('#procesar_excel').css('display','none')
		$('#registros_view').css('display','inline')
		
		$('#errores').css('display','none')
		
		$.ajax({
			   url: '../carped/getFilasexcel',  
			   type: 'POST',
			   data: formData,
			   cache: false,
			   contentType: false,
			   processData: false,
			   success: function(data){
				   $('#numeros_documento').text(data+" registros");
			   }
		});
		
				$('#icono_reloaded').css('display','inline')
				$('#icono_reloaded_2').css('display','inline')
				
				$.ajax({
					   url: '../carped/insertExcel',  
					   type: 'POST',
					   data: formData,
					   cache: false,
					   contentType: false,
					   processData: false,
					   success: function(data){
						   alert(data)
						   /*if(data==1){
							   $('#errores').css('display','inline')
							   $('#errores').html('<div class="note" style="color: red;">*No se pudo eliminar la base</div>')
							   $('#procesar_excel').css('display','none')
							   $('#trama_txt').attr('disabled',false)
							   $('#trama_excel').attr('disabled',false)
							   $('#icono_reloaded').css('display','none')
							   $('#icono_reloaded_2').css('display','none')
							   $('#resultado_proceso').css('display','none')
						   }
						   else if(data==2){
							   $('#errores').css('display','inline')
							   $('#errores').html('<div class="note" style="color: red;">*Ya se cargo la Base seleccionada</div>')
							   $('#procesar_excel').css('display','none')
							   $('#trama_txt').attr('disabled',false)
							   $('#trama_excel').attr('disabled',false)
							   $('#icono_reloaded').css('display','none')
							   $('#icono_reloaded_2').css('display','none')
							   $('#resultado_proceso').css('display','none')
						   }
						   else if(data==3){
							   $('#errores').css('display','inline')
							   $('#errores').html('<div class="note" style="color: red;">*Archivo no coincide con la base elegida</div>')
							   $('#procesar_excel').css('display','none')
							   $('#trama_txt').attr('disabled',false)
							   $('#trama_excel').attr('disabled',false)
							   $('#icono_reloaded').css('display','none')
							   $('#icono_reloaded_2').css('display','none')
							   $('#resultado_proceso').css('display','none')
						   }
						   else{
							   $('#trama_txt').attr('disabled',false)
							   $('#trama_excel').attr('disabled',false)
							   $('#icono_reloaded').css('display','none')
							   $('#icono_reloaded_2').css('display','none')
							   $('#resultado_proceso').css('display','inline')
							   
							  var myarray = data.split(",")
							  if(myarray[0].trim()==0){
								  bueno=0
							  }else{
								  bueno=myarray[0].trim()
							  }
							   
							  if(myarray[1].trim()==0){
								   malo=0
							  }else{
								  malo=myarray[1].trim()
							  }
							  
							  $('#proceso_bueno').text(bueno+" registros");
							  $('#proceso_malo').text(malo+" registros");
							  $('#procesar_excel').css('display','inline')
						   }
						   */
					   }
				});
	})

})