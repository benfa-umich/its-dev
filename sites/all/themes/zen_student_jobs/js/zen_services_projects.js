(function ($) {

	$(document).ready(function() {

	//$("#edit-field-position-specific-question-und-0-field-4help-und-0-field-4help-test").html("<p><strong>REQUIRED:</strong> Please submit a cover letter and resume to <a href='mailto:4HELPemployment@umich.edu'>4HELPemployment@umich.edu</a>. Include the following three questions in your cover letter:<br />1 - Please share your reasons for your interest in this position. <br />2 - Please outline your particular skills and experience that directly relates to this position. <br />3 - Describe your customer service philosophy. </p><p>This position requires a 15-20 hour per week commitment; possible hours include Mon-Thu 7am-7pm, Fri 7am-6pm, Sun 2pm-7pm. I am able to work.</p>");


	$(".special").attr("href","javascript:void(0)");
	$(".special").click(function() {
		
		if ($(this).text() == "Select All") {
			$("#edit-field-for-which-position-s-are-y-und input").attr('checked', true);
		}
		else if ($(this).text() == "Clear All") {
			$("#edit-field-for-which-position-s-are-y-und input").attr('checked', false);
		}
		
		$("#edit-field-for-which-position-s-are-y-und input").trigger( "change" );
		
	});
		
	});

})(jQuery);