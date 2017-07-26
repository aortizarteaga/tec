		<!-- PAGE FOOTER -->
		<div class="page-footer">
			<div class="row">
				<div class="col-xs-12 col-sm-6"></div>
				<div class="col-xs-6 col-sm-6 text-right hidden-xs">
					<span class="txt-color-white">&copy; Copyright <?php echo date('Y');?><a style="text-decoration: none;color: white;cursor: pointer;" title="Anthony Cesar Ortiz Arteaga"> ACOA</a>. All rights reserved.</span>
				</div>
			</div>
		</div>
		<!-- END PAGE FOOTER -->
	</body>
	
	<!-- Change Pasword -->
<div style="display: none;" id="addtab" title="<div  class='widget-header'><h4><i class='fa fa-retweet'></i> Actualizaci&oacute;n de Contrase&ntilde;a</h4></div>">
<form id="smart-form-register" class="smart-form client-form">
	<fieldset>
		<section>
			<div class="form-group">
				<p>*Por medidas de seguridad es necesario cambiar la
					contrase&ntilde;a en el primer ingreso</p>
			</div>
		</section>
		<br>
		<section>
			<div class="form-group">
				<label class="input"> <i class="icon-append fa fa-lock"></i> <input
					type="password" id="pswd" name="pswd"
					placeholder="*Contrase&ntilde;a"> 
				</label>
				<ul class="list-unstyled uploaded-attachment">
					<li style="color: red;display: none;" id="malo_update"><i class="fa fa-times"></i>&nbsp;&nbsp;<em
						id="malo_digitar" name="malo_digitar" style="font-size: 11px"></em></a>
					</li>
				</ul>
			</div>
		</section>
		<section>
			<div class="form-group">
				<label class="input"> <i class="icon-append fa fa-lock"></i> <input
					type="password" id="pswd2" name="pswd2"
					placeholder="*Contrase&ntilde;a">
				</label>
				<ul class="list-unstyled uploaded-attachment">
					<li style="color: red;display: none;" id="malo_update2"><i class="fa fa-times"></i>&nbsp;&nbsp;<em
						id="malo_digitar2" name="malo_digitar2" style="font-size: 11px"></em></a>
					</li>
				</ul>
			</div>
		</section>
	</fieldset>
</form>


<div style="display: none;" id="logout_sesion" title="<div  class='widget-header'><h4><i class='fa fa-power-off'></i> Tu sesion ha expirado</h4></div>
<form id="smart-form-register" class="smart-form client-form">
	<fieldset>
			 <p>Has estado inactivo por mucho tiempo. Por tu seguridad cierra sesion y vuelve a ingresar</p>
	</fieldset>
</form>

<!-- Change Pasword -->
		
		<script data-pace-options='{ "restartOnRequestAfter": true }' src="<?php echo BASE_URL ?>views/layout/default/js/plugin/pace/pace.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script>
			if (!window.jQuery) {
				document.write('<script src="<?php echo BASE_URL ?>views/layout/default/js/libs/jquery-2.1.1.min.js"><\/script>');
			}
		</script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script>
			if (!window.jQuery.ui) {
				document.write('<script src="<?php echo BASE_URL ?>views/layout/default/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
			}
		</script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/app.config.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> 
		<script src="<?php echo BASE_URL ?>views/layout/default/js/bootstrap/bootstrap.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/notification/SmartNotification.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/smartwidgets/jarvis.widget.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/sparkline/jquery.sparkline.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/jquery-validate/jquery.validate.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/masked-input/jquery.maskedinput.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/select2/select2.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/fastclick/fastclick.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
		<script src="<?php echo BASE_URL ?>public/assets/moment/moment.min.js"></script> 
		<script src="<?php echo BASE_URL ?>views/layout/default/js/app.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/smart-chat-ui/smart.chat.ui.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/smart-chat-ui/smart.chat.manager.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/jquerystrength/dist/pwstrength-bootstrap.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/idle_timer/idle-timer.js"></script>
		
		<script type="text/javascript">

		$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
			_title : function(title) {
				if (!this.options.title) {
					title.html("&#160;");
				} else {
					title.html(this.options.title);
				}
			}
		}));

		(function ($) {
            var
                session = {
                    inactiveTimeout: 1500000,
                    warningTimeout: 1500000     
                }
            ;

            $(document).on("idle.idleTimer", function (event, elem, obj) {
                var diff = (+new Date()) - obj.lastActive - obj.timeout, 
                	warning = (+new Date()) - diff;

                if (diff >= session.warningTimeout || warning <= session.minWarning) {
                    //$("#mdlLoggedOut").modal("show");
                } else {
                    var dialog = $("#logout_sesion").dialog({
						autoOpen : true,
						width : 600,
						resizable : false,
						modal : true,
						buttons : [ {
							html : "<i class='fa fa-power-off'></i>&nbsp; Cerrar Sesion",
							"class" : "btn btn-danger",
							click : function() {
								window.location="http://localhost:800/tec/";
								}
							}]
						});

                    $('.ui-dialog-titlebar-close').css('display','none')
		            session.warningStart = (+new Date()) - diff;

                }
            });

            $.idleTimer(session.inactiveTimeout);
        })(jQuery);
		
		$(document).ready(function() {

			$('#ocultarse').click().change();

			//function udpdate_pswd(){
			$.post('http://localhost:800/tec/administracion/updatePswd/', function(data) {
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
					$('.ui-dialog-titlebar-close').css('display','none')
					
					}
				})

			//}

			//setInterval(function(){ udpdate_pswd() }, 3000);

		})
		</script>
		
		<?php if(isset($_layoutParams['js']) && count($_layoutParams['js'])): ?>
			<?php foreach($_layoutParams['js'] as $layout): ?>
   				<script src="<?php echo  $layout ?>" type="text/javascript"></script>
			<?php endforeach; ?>
		<?php endif; ?>  
</html>