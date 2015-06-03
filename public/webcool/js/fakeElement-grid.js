var fakeElement2 = {};
fakeElement2.constanants = 'b c d f g k l m n p q r s t v x z'.split(' ');
fakeElement2.vowels = 'a e i o u y'.split(' ');
fakeElement2.categories = 'portraits landscapes fashion advertising else'.split(' ');
fakeElement2.suffices = 'on ium ogen'.split(' ');
fakeElement2.titles = 'Aliquam tempor, Fermentum, Ante Elementum, turpis mauris, fermentum vel, Nulla porttitor'.split(',');

fakeElement2.texts1 = 'Phasellus eu tincidunt quam. Etiam tortor massa, mollis at ultricies eu, blandit eget libero. Phasellus eget dolor diam, at aliquet mi. Donec quis lectus.'.split('..');
fakeElement2.texts2 = 'Cursus sodales mattis. Morbi eros augue, viverra nec blandit eget lore vitae vestibul, hendrerit eget nisi.'.split('..');

fakeElement2.images = 'gallery01 gallery02 gallery03 gallery04 gallery05 gallery06 gallery07 gallery08 gallery09 gallery10 gallery11 gallery12 gallery13 gallery14 gallery15 gallery16 gallery17 gallery18 gallery19 gallery20 gallery21 gallery22 gallery23 gallery24 gallery25'.split(' ');
fakeElement2.getRandom = function(property) {
	var values = fakeElement2[property];
	return values[ Math.floor(Math.random() * values.length)];
};
fakeElement2.create = function(count) {
	var category = fakeElement2.getRandom('categories');
	image = fakeElement2.getRandom('images');
	title = fakeElement2.getRandom('titles');
	text1 = fakeElement2.getRandom('texts1');
	text2 = fakeElement2.getRandom('texts2');
	
	category = fakeElement2.getRandom('categories');
	className = 'element ' + category;
	set_width = $('.columns-grid').find('.element:first').width();
		return '<div data-category="' + category + '" class="' + category + ' element" style="width:'+set_width+'px;"><div class="filter_img"><img src="img/portfolio/grid-gallery/thmb/thmb_'+ image +'.jpg" alt=""><div class="portfolio_wrapper"></div><div class="portfolio_content"><h5>'+ title +'</h5><p>'+ text1 +'</p><span class="ico_block"><a href="img/portfolio/grid-gallery/'+ image +'.jpg" class="ico_zoom prettyPhotoLoaded"><span></span></a><a href="portfolio_post.html" class="ico_link"><span></span></a></span></div></div></div>';
};
fakeElement2.getGroup = function(count) {
	var i = Math.ceil(count), newEls = '';
	while (i--) {
		newEls += fakeElement2.create(count);
	}
	return newEls;
};

