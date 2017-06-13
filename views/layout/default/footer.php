		<!-- PAGE FOOTER -->
		<div class="page-footer">
			<div class="row">
				<div class="col-xs-12 col-sm-6"></div>
				<div class="col-xs-6 col-sm-6 text-right hidden-xs">
					<span class="txt-color-white">&copy; Copyright <?php echo date('Y');?><a style="text-decoration: none;color: white;cursor: pointer;" title="Antony Cesar Ortiz Arteaga"> ACOA</a>. All rights reserved.</span>
				</div>
			</div>
		</div>
		<!-- END PAGE FOOTER -->
	</body>
	
	<!--================================================== -->
		
		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		<script data-pace-options='{ "restartOnRequestAfter": true }' src="<?php echo BASE_URL ?>views/layout/default/js/plugin/pace/pace.min.js"></script>

		<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
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

		<!-- IMPORTANT: APP CONFIG -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/app.config.js"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> 

		<!-- BOOTSTRAP JS -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/bootstrap/bootstrap.min.js"></script>

		<!-- CUSTOM NOTIFICATION -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/notification/SmartNotification.min.js"></script>

		<!-- JARVIS WIDGETS -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/smartwidgets/jarvis.widget.min.js"></script>

		<!-- EASY PIE CHARTS -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

		<!-- SPARKLINES -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/sparkline/jquery.sparkline.min.js"></script>

		<!-- JQUERY VALIDATE -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/jquery-validate/jquery.validate.min.js"></script>

		<!-- JQUERY MASKED INPUT -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/masked-input/jquery.maskedinput.min.js"></script>

		<!-- JQUERY SELECT2 INPUT -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/select2/select2.min.js"></script>

		<!-- JQUERY UI + Bootstrap Slider -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

		<!-- browser msie issue fix -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

		<!-- FastClick: For mobile devices -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/fastclick/fastclick.min.js"></script>
		
		<!-- MAIN APP JS FILE -->
		<script src="js/app.min.js"></script>
		
		<!-- PAGE RELATED PLUGIN(S) -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
		
		<!-- MOMENT-->
		<script src="<?php echo BASE_URL ?>public/assets/moment/moment.min.js"></script> 
		

		<!--[if IE 8]>

		<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

		<![endif]-->

		<!-- MAIN APP JS FILE -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/app.min.js"></script>

		<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
		<!-- Voice command : plugin -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/speech/voicecommand.min.js"></script>

		<!-- SmartChat UI : plugin -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/smart-chat-ui/smart.chat.ui.min.js"></script>
		<script src="<?php echo BASE_URL ?>views/layout/default/js/smart-chat-ui/smart.chat.manager.min.js"></script>
		
		<!-- PAGE RELATED PLUGIN(S) -->
		<script src="<?php echo BASE_URL ?>views/layout/default/js/plugin/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
		
		<script type="text/javascript">
		$(document).ready(function() {

			 //$('#ocultarse').trigger('click');
			 $('#ocultarse').click().change();
			 //document.getElementById("#ocultarse").click();
			/* $('#ocultarse').click(function(){
				alert('fddfdf')
			}) */
		})
		</script>
		
		<?php if(isset($_layoutParams['js']) && count($_layoutParams['js'])): ?>
			<?php foreach($_layoutParams['js'] as $layout): ?>
   				<script src="<?php echo  $layout ?>" type="text/javascript"></script>
			<?php endforeach; ?>
		<?php endif; ?>  
</html>