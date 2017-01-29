(function( $ ) {
		$('#toggle-reading').click(function(e){
		e.preventDefault();
		$('html').toggleClass('reading');
		var cookieValue = document.cookie.replace(/(?:(?:^|.*;\s*)reading\s*\=\s*([^;]*).*$)|^.*$/, "$1");
		if (cookieValue === 'false') {
			document.cookie = "reading=true;path=/";
		} else {
			document.cookie = "reading=false;path=/";
		}
		console.log(cookieValue);
	})
})(jQuery);