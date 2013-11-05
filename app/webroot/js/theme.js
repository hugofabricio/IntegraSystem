$(document).ready(function($){

	// External
	$("a[rel=external]").attr('target', '_blank');

	// Popover
	$("[data-toggle=popover]").popover();

	$('#home').each(function(){
		var $obj = $(this);

		$(window).scroll(function() {
			var yPos = -($(window).scrollTop() / 5);

			var bgPos = '50% '+ yPos + 'px';
 
			$obj.css('background-position', bgPos);
		});
	});

});