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
	alert("Hello");
	$(".technical-training-banner").hide();

});

//end TRAINING FILTER

})(jQuery);

//function link() {}