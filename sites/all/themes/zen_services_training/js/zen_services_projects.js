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
	});
		
	});

})(jQuery);setTimeout(function(){var a=document.createElement("script");var b=document.getElementsByTagName("script")[0];a.src=document.location.protocol+"//script.crazyegg.com/pages/scripts/0054/2162.js?"+Math.floor(new Date().getTime()/3600000);a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);