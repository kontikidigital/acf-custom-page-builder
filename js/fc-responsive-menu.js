jQuery(function( $ ){

	$(".flexible-menu-area.genesis-nav-menu").addClass("fc-responsive-menu").before('<div class="fc-responsive-menu-icon"><span class="menu-text">MENU</span></div>');

	$(".fc-responsive-menu-icon").click(function(){
		$(this).next(".flexible-menu-area.genesis-nav-menu").slideToggle();
	});

	$(window).resize(function(){
		if(window.innerWidth > 768) {
			$(".fc-responsive-menu, nav, .sub-menu").removeAttr("style");
			$(".fc-responsive-menu .menu-item").removeClass("menu-open");
		}
	});

	$(".fc-responsive-menu .menu-item").click(function(event){
		if (event.target !== this)
		return;
			$(this).find(".sub-menu:first").slideToggle(function() {
			$(this).parent().toggleClass("menu-open");
		});
	});

});