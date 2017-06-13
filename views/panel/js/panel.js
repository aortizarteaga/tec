$(document).ready(function() {
	pageSetUp();
	$("#menu").menu();
	
	function log(message) {
		$("<div>").text(message).prependTo("#log");
		$("#log").scrollTop(0);
	}
	
	$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
		_title : function(title) {
			if (!this.options.title) {
				title.html("&#160;");
			} else {
				title.html(this.options.title);
			}
		}
	}));
	
	$('#dialog_link').click(function() {
		$('#dialog_simple').dialog('open');
		return false;

	});
	
	//$('#dialog_simple').dialog('open');
	//return false;
	
	//$('#dialog_simple').dialog('open');

	$('#dialog_simple').dialog({
		autoOpen : true,
		width : 600,
		resizable : false,
		modal : true,
		title : "<div class='widget-header'><h4><i class='fa fa-warning'></i> Empty the recycle bin?</h4></div>",
		buttons : [{
			html : "<i class='fa fa-trash-o'></i>&nbsp; Delete all items",
			"class" : "btn btn-danger",
			click : function() {
				$(this).dialog("close");
			}
		}, {
			html : "<i class='fa fa-times'></i>&nbsp; Cancel",
			"class" : "btn btn-default",
			click : function() {
				$(this).dialog("close");
			}
		}]
	});
	
	$('.ui-dialog :button').blur();
	
	/*$('#modal_link').click(function() {
		$('#dialog-message').dialog('open');
		return false;
	});*/

	$("#dialog-message").dialog({
		autoOpen : false,
		width : 600,
		modal : true,
		title : "<div class='widget-header'><h4><i class='icon-ok'></i> jQuery UI Dialog</h4></div>",
		buttons : [{
			html : "Cancel",
			"class" : "btn btn-default",
			click : function() {
				$(this).dialog("close");
			}
		}, {
			html : "<i class='fa fa-check'></i>&nbsp; OK",
			"class" : "btn btn-primary",
			click : function() {
				$(this).dialog("close");
			}
		}]

	});

})