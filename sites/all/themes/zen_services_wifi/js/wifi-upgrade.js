(function ($) {


//FAQ

$(document).ready(function() {
	$(".field-name-field-a").hide();
	$(".field-name-field-a").width($(".field-name-field-q").width());
	$(".field-name-field-q").click(function() {
		$(this).next(".field-name-field-a").slideToggle();
		$(this).toggleClass("open");
	});
	$("#toggle_all").click(function() {
		var text = $('#toggle_all').text();
		$("#toggle_all").text(
			text == "Show All Answers" ? "Hide All Answers" : "Show All Answers");
		if(text == "Show All Answers") { $(".field-name-field-a").slideDown(); $(".field-name-field-q").addClass("open"); } else { $(".field-name-field-a").slideUp(); $(".field-name-field-q").removeClass("open"); }
	});

});

//end FAQ


//image zoom

$(document).ready(function() {
	$(".imagezoom").fancybox({
		'type'		: 'image',
		'titleShow'     : false,
		'onClosed'	: function() {
			$("#fancy-content").empty();
		}
	});
});
	
//end image zoom


//BUILDING STATUS FILTER

    $(document).ready(function() {
        var stripeTable = function(table) { //stripe the table (jQuery selector)
            table.find('tr').removeClass('building-striped').filter(':visible:even').addClass('building-striped');
        };
        $('table').filterTable({ // apply filterTable to all tables on this page
            inputSelector: '#building-input-filter', // use the existing input instead of creating a new one
            callback: function(term, table) { stripeTable(table); } //call the striping after every change to the filter term
        });
        stripeTable($('table')); //stripe the table for the first time


//MENU button
	$("#block-block-9").click(function(){
		$("#header ul.menu").slideToggle();
	});
    });



})(jQuery);

function link() {}