window.$ = window.jQuery = require('jquery');
require('bootstrap');

require('cookieconsent/build/cookieconsent.min');
require('./link_to_top');

function setTopPadding()
{
	let top = parseInt($('nav.navbar').height()) + 14;
	$('main').css({ paddingTop: top });
}

setTopPadding();
$(document).ready(function(e) {
	$(window).resize(function () {
		setTopPadding();
	});
});
