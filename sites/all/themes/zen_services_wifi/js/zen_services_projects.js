(function ($) {

	$(document).ready(function() {

if ($('#features').length > 0) {		
$('#features').jshowoff({
		speed:10000,
		changeSpeed:800,
		effect:'slideLeft'
		});		
}
		//$(".cke_show_borders").css("background-image","none");
			
		//add default alt text
		$("img[src*='service-placeholder.png']").attr('alt','Default Service Icon');
		
		//remove the one weird search breadcrumb:
		if ($(".breadcrumb").length > 0) {
		$(".breadcrumb").html($(".breadcrumb").html().replace('›  Service Info', '')); 
		$(".breadcrumb").html($(".breadcrumb").html().replace('› Service Info', '')); 
		$(".breadcrumb").html($(".breadcrumb").html().replace('›  IT Documentation', '')); 
		$(".breadcrumb").html($(".breadcrumb").html().replace('› IT Documentation', '')); 
		}

		if ($("#tabsornot").val() == "no")
		{
			$("#node_service_offering_full_group_overviewtab").parent().parent().css("display","none");
		}
		
		//console.log($(".field-name-field-service-status .field-item").text());
		
		if ($(".field-name-field-service-status .field-item").text() && $(".field-name-field-service-status .field-item").text() == "Available") {
				$(".field-name-field-service-status").css("display","none");
			}
		
		if (window.location.hash) {
			//console.log(window.location.hash);
			
			$(window).scrollTop($('#page-title').position().top)

			//window.location.hash = "#page-menu";
		}
		//else {console.log("not");}		
		
	});

})(jQuery);