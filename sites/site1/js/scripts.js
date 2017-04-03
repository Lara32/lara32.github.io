
$(function(){
	$('.menu_button').on('click', function() {
		$('ul.main_menu').slideToggle(300, function(){
        if($(this).css('display')=== 'none'){
		$(this).removeAttr('style');}
		});
	});
});

$(function(){
	$('.menu_button2').on('click', function() {
		$('.aside_menu').slideToggle(300, function(){
        if($(this).css('display')=== 'none'){
		$(this).removeAttr('style');}
		});
	});
});

