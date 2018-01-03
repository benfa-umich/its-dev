(function ($) {

	$(document).ready(function() {

	$(".special").attr("href","javascript:void(0)");
	$(".special").click(function() {
		$("#edit-field-for-which-position-s-are-y-und input").trigger( "change" );
		if ($(this).text() == "Select All") {
			$("#edit-field-for-which-position-s-are-y-und input").attr('checked', true);
		}
		else if ($(this).text() == "Clear All") {
			$("#edit-field-for-which-position-s-are-y-und input").attr('checked', false);
		}
	});			$(".image-zoom").fancybox({		'autoScale'	: true,		'titleShow' : false,		'onClosed': function() {			$("#fancy-content").empty();			}		});
		
	});

})(jQuery);