<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title> Telefonica - Aseguramiento </title>
		<meta name="description" content="CIAT">
		<meta name="author" content="ACOA">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
			
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASE_URL ?>views/layout/default/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASE_URL ?>views/layout/default/css/font-awesome.min.css">

		<!-- SmartAdmin Styles : Caution! DO NOT change the order -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASE_URL ?>views/layout/default/css/smartadmin-production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASE_URL ?>views/layout/default/css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASE_URL ?>views/layout/default/css/smartadmin-skins.min.css">
		
		<!-- SmartAdmin RTL Support -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASE_URL ?>views/layout/default/css/smartadmin-rtl.min.css"> 

		<!-- We recommend you use "your_style.css" to override SmartAdmin
		     specific styles this will also ensure you retrain your customization with each SmartAdmin update.-->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASE_URL ?>views/layout/default/css/your_style.css"> 
		
		<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASE_URL ?>views/layout/default/css/demo.min.css">
		
		<!-- #FAVICONS -->
		<link rel="shortcut icon" href="<?php echo BASE_URL ?>views/layout/default/img/favicon/telefonica.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo BASE_URL ?>views/layout/default/img/favicon/telefonica.ico" type="image/x-icon">

		<!-- GOOGLE FONT -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

		<!-- Specifying a Webpage Icon for Web Clip 
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<link rel="apple-touch-icon" href="<?php echo BASE_URL ?>views/layout/default/img/splash/sptouch-icon-iphone.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo BASE_URL ?>views/layout/default/img/splash/touch-icon-ipad.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo BASE_URL ?>views/layout/default/img/splash/touch-icon-iphone-retina.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php echo BASE_URL ?>views/layout/default/img/splash/touch-icon-ipad-retina.png">
		
		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		
		<!-- Startup image for web apps -->
		<link rel="apple-touch-startup-image" href="<?php echo BASE_URL ?>views/layout/default/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
		<link rel="apple-touch-startup-image" href="<?php echo BASE_URL ?>views/layout/default/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
		<link rel="apple-touch-startup-image" href="<?php echo BASE_URL ?>views/layout/default/img/splash/iphone.png" media="screen and (max-device-width: 320px)">
	
	<style>
    .datepicker {
      z-index: 1600 !important; /* has to be larger than 1050 */
    }
</style>
	</head>

<?php
$array = array ();

foreach ( $_SESSION ['menu'] as $submenu => $value ) :
	if (isset ( $value [2] )) :
		array_push ( $array, $value [2] );
			endif;
endforeach;

$menu = array_unique ( $array );
$menu = array_values ( $menu );
$longitud = count ( $menu );

$arraysito_pan='MENU_NADA';
$arraysito_car='MENU_NADA';
$arraysito_reg='MENU_NADA';

for($i = 0; $i < $longitud; $i ++) {
	if ($menu [$i] == 'MENU_PAN') {
		$arraysito_pan = 'MENU_PAN';
	} else if ($menu [$i] == 'MENU_CAR') {
		$arraysito_car = 'MENU_CAR';
	} else if ($menu [$i] == 'MENU_INICIAL') {
		$arraysito_reg = 'MENU_INICIAL';
	}
}

$menu = array (
		0 => $arraysito_pan,
		1 => $arraysito_car,
		2 => $arraysito_reg 
);

?>
	<!--

	TABLE OF CONTENTS.
	
	Use search to find needed section.
	
	===================================================================
	
	|  01. #CSS Links                |  all CSS links and file paths  |
	|  02. #FAVICONS                 |  Favicon links and file paths  |
	|  03. #GOOGLE FONT              |  Google font link              |
	|  04. #APP SCREEN / ICONS       |  app icons, screen backdrops   |
	|  05. #BODY                     |  body tag                      |
	|  06. #HEADER                   |  header tag                    |
	|  07. #PROJECTS                 |  project lists                 |
	|  08. #TOGGLE LAYOUT BUTTONS    |  layout buttons and actions    |
	|  09. #MOBILE                   |  mobile view dropdown          |
	|  10. #SEARCH                   |  search field                  |
	|  11. #NAVIGATION               |  left panel & navigation       |
	|  12. #RIGHT PANEL              |  right panel userlist          |
	|  13. #MAIN PANEL               |  main panel                    |
	|  14. #MAIN CONTENT             |  content holder                |
	|  15. #PAGE FOOTER              |  page footer                   |
	|  16. #SHORTCUT AREA            |  dropdown shortcuts area       |
	|  17. #PLUGINS                  |  all scripts and plugins       |
	
	===================================================================
	
	-->
	
	<!-- #BODY -->
	<!-- Possible Classes

		* 'smart-style-{SKIN#}'
		* 'smart-rtl'         - Switch theme mode to RTL
		* 'menu-on-top'       - Switch to top navigation (no DOM change required)
		* 'no-menu'			  - Hides the menu completely
		* 'hidden-menu'       - Hides the main menu but still accessable by hovering over left edge
		* 'fixed-header'      - Fixes the header
		* 'fixed-navigation'  - Fixes the main menu
		* 'fixed-ribbon'      - Fixes breadcrumb
		* 'fixed-page-footer' - Fixes footer
		* 'container'         - boxed layout mode (non-responsive: will not work with fixed-navigation & fixed-ribbon)
	-->
	<body class="">
		<!-- HEADER -->
		<header id="header">
			<div id="logo-group">
				<!-- PLACE YOUR LOGO HERE -->
				<span id="logo"><img src="<?php echo BASE_URL ?>views/layout/default/img/logo_telefonica.png" alt="Telefonica - Aseguramiento" style="width: 80px;"> </span>
				<!-- END LOGO PLACEHOLDER -->
			</div>

			<!-- pulled right: nav area -->
			<div class="pull-right">
				
				<!-- collapse menu button -->
				<div id="hide-menu" class="btn-header pull-right">
					<span> <a style="cursor: pointer;" data-action="toggleMenu" title="Menu"><i class="fa fa-reorder"></i></a> </span>
				</div>
				<!-- end collapse menu -->
				
				<!-- #MOBILE -->
				<!-- Top menu profile link : this shows only when top menu is active -->
				<ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
					<li class="">
						<a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown"> 
							<img src="img/avatars/sunny.png" alt="John Doe" class="online" />  
						</a>
						<ul class="dropdown-menu pull-right">
							<li>
								<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"><i class="fa fa-cog"></i> Setting</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="profile.html" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-user"></i> <u>P</u>rofile</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="toggleShortcut"><i class="fa fa-arrow-down"></i> <u>S</u>hortcut</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i> Full <u>S</u>creen</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="login.html" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout"><i class="fa fa-sign-out fa-lg"></i> <strong><u>L</u>ogout</strong></a>
							</li>
						</ul>
					</li>
				</ul>

				<!-- logout button -->
				<div id="logout" class="btn-header transparent pull-right">
					<span> <a href="<?php echo BASE_URL?>index/logout" title="Cerrar Sesion" data-action="userLogout" data-logout-msg="Desea cerrar la sesion?"><i class="fa fa-sign-out"></i></a> </span>
				</div>
				<!-- end logout button -->

				<!-- fullscreen button -->
				<div id="fullscreen" class="btn-header transparent pull-right">
					<span> <a style="cursor: pointer;" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
				</div>
				<!-- end fullscreen button -->

			</div>
			<!-- end pulled right: nav area -->

		</header>
		<!-- END HEADER -->

		<!-- Left panel : Navigation area -->
		<!-- Note: This width of the aside area can be adjusted through LESS variables -->
		<aside id="left-panel">
			<!-- User info -->
			<div class="login-info">
				<span> <!-- User image size is adjusted inside CSS, it should stay as it --> 
					
					<a id="show-shortcut" data-action="toggleShortcut" style="color: white;">
						<img src="<?php echo BASE_URL ?>views/layout/default/img/avatars/sunny.png" alt="me" class="online" /> 
						<span><?php echo $_SESSION['nombre'];?> </span>
					</a> 
					
				</span>
			</div>
			<!-- end user info -->

			<nav>
				<!-- 
				NOTE: Notice the gaps after each icon usage <i></i>..
				Please note that these links work a bit different than
				traditional href="" links. See documentation for details.
				-->

				<ul>
					<?php if ($menu[0]=='MENU_PAN'):?>
					<li class="top-menu-invisible">
							<a href="#"><i class="fa fa-lg fa-fw fa-cogs txt-color-blue"></i> <span class="menu-item-parent">Administracion</span></a>
							<ul>
							<?php foreach ($_SESSION['menu'] as $submenu=>$value):?>
												<?php if ($value[2]=='MENU_PAN'):?>
													<li><a href="<?php echo BASE_URL . $value[3]?>"><span class="text"><?php echo $value[1]?></span></a></li>
												<?php endif;?>
							<?php endforeach;?>
								
							</ul>
						</li>
					<?php endif;?>
					
					<?php if ($menu[1]=='MENU_CAR'):?>
					<li class="top-menu-invisible">
							<a href="#"><i class="fa fa-lg fa-fw fa-upload txt-color-blue"></i> <span class="menu-item-parent">Carga</span></a>
							<ul>
							<?php foreach ($_SESSION['menu'] as $submenu=>$value):?>
												<?php if ($value[2]=='MENU_CAR'):?>
													<li><a href="<?php echo BASE_URL . $value[3]?>"><span class="text"><?php echo $value[1]?></span></a></li>
												<?php endif;?>
							<?php endforeach;?>
								
							</ul>
						</li>
					<?php endif;?>
				</ul>
			</nav>
			
			<span class="minifyme" data-action="minifyMenu" id="ocultarse"> 
				<i class="fa fa-arrow-circle-left hit"></i> 
			</span>

		</aside>
		<!-- END NAVIGATION -->				
