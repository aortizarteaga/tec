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


});