
$(function(){
	$('#tabs').tabs({
		show: { effect: "fade", duration: 300 },
		hide: { effect: "fade", duration: 300 },
		event: "mouseover"
	});
});


$('.c').click(function() { 
	$('.wrapper-items').html($(this).attr('block2-data'));
		$('.wrapper-item-factory').fadeIn();
	});


$(document).mouseup(function (e) { 
	var popup = $('.wrapper-item-factory');
	if (e.target!=popup[0]&&popup.has(e.target).length === 0){
		$('.wrapper-item-factory').fadeOut(250);
		}
	});




