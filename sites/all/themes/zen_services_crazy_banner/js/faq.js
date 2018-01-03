(function ($) {

//FAQ

$(document).ready(function() {
	$(".field-name-field-answer").hide();
	$(".field-name-field-question").click(function() {
		$(this).next(".field-name-field-answer").slideToggle();
		$(this).toggleClass("open");
	});
	$("#toggle_all").click(function() {
		var text = $('#toggle_all').text();
		$("#toggle_all").text(
			text == "Show All Answers" ? "Hide All Answers" : "Show All Answers");
		if(text == "Show All Answers") { $(".field-name-field-answer").slideDown(); $(".field-name-field-question").addClass("open"); } else { $(".field-name-field-answer").slideUp(); $(".field-name-field-question").removeClass("open"); }
	});

});

//end FAQ

//image zoom

//$(document).ready(function() {
	//$(".imagezoom").fancybox({
		//'type'		: 'image',
		//'titleShow'     : false,
		//'onClosed'	: function() {
			//$("#fancy-content").empty();
		//}
	//});
//});
	
//end image zoom


//TRAINING FILTER

$(document).ready(function() {
//	$("#block-views-exp-all-courses-page .views-exposed-form .views-exposed-widget .views-widget").hide();
//	$("#block-views-exp-all-courses-page .views-exposed-form .views-exposed-widget label").toggleClass("training-widget-closed");
//	$("#block-views-exp-all-courses-page .views-exposed-form .views-exposed-widget label").click(function() {
//		$(this).next("#block-views-exp-all-courses-page .views-exposed-form .views-exposed-widget .views-widget").slideToggle();
//		$(this).toggleClass("training-widget-open");
//	});
});

//end TRAINING FILTER

})(jQuery);

//function link() {}