var mobileDevice = false;
var smallDevice = false;
if(
	navigator.userAgent.match(/Android/i) ||
	navigator.userAgent.match(/webOS/i) ||
	navigator.userAgent.match(/iPhone/i) ||
	navigator.userAgent.match(/iPad/i) ||
	navigator.userAgent.match(/iPod/i))
{
	mobileDevice = true;
}
if (
	navigator.userAgent.match(/iPod/i) ||
	navigator.userAgent.match(/iPhone/i))
{
	smallDevice = true;
}

$(document).ready(function(){
	$('.optionset').find('a').click(function(){
		if ($(this).attr('data-option-value') == '*') {
			$('.load_more_grid').show('fast');
		} else {
			$('.load_more_grid').hide('fast');
		}
	});
	$('.load_more_grid').click(function() {
		var count = $(this).attr('data-count');
		var $newEls = $(fakeElement2.getGroup(count));
		/*$('.columns-grid').append($newEls).isotope('appended', $newEls, function(){
			console.log('shyt');
			$('.portfolio_content').each(function(){
				$(this).css('margin-top', -($(this).height()/2)+'px');
				$('.prettyPhotoLoaded').prettyPhoto();
			});
			relocate();			
		});*/
		$('.columns-grid').isotope('insert', $newEls, function(){
			$('.portfolio_content').each(function(){
				$(this).css('margin-top', -($(this).height()/2)+'px');
				$('.prettyPhotoLoaded').prettyPhoto();
			});
			relocate();
		});
	});
});

$(window).load(function(){
	relocate();
	setTimeout("relocate()",1000);
	setTimeout("$('.columns-grid').isotope('reLayout')",1500);
});    
$(window).resize(function(){
	relocate();
});

function relocate() {
	if ($(window).width() > 0) itemInRow = 1;
	if ($(window).width() > 500) itemInRow = 2;
	if ($(window).width() > 766) itemInRow = 3;
	if ($(window).width() > 1200) itemInRow = 4;
	if ($(window).width() > 1440) itemInRow = 5;	
	$('.columns-grid').width($(window).width()-5);
	$('.columns-grid').find('.element').each(function(){
		$(this).width(Math.floor((($(window).width()-5)/itemInRow)-5));
		$(this).find('.portfolio_content').css('margin-top', -($(this).find('.portfolio_content').height()/2)+'px');
	});		
	last_item = $('.columns-grid').find('.element:last');
	lm_width = last_item.width();
	lm_height = last_item.height();
	item_ends = ($('.columns-grid').find('.element').size() - (Math.floor($('.columns-grid').find('.element').size()/itemInRow)*itemInRow));
	//console.log(itemInRow+';'+Math.floor($('.columns-grid').find('.element').size()/itemInRow)+';'+item_ends);
	if (item_ends == 0 && $('.columns-grid').find('.element').size() != 0) {
		item_ends = itemInRow;
	} 
	if (item_ends == 1) {
		position = 5;
	} else if (itemInRow == 1) {
		position = 5;
	}
	else {
		position = ((item_ends-1)*(lm_width+5))+5;
	}	
	//console.log(position);
	$('.load_more_grid').width(lm_width).height(lm_height).css('left', position + 'px');
	setTimeout("$('.columns-grid').isotope('reLayout')",300);	
}