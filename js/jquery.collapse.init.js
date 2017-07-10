jQuery(function( $ ){

	$(".faqs").collapse({
		// options...
		query: 'div h4',
		open: function() {
			this.slideDown(150);
		},
		close: function() {
			this.slideUp(150);
		}
	});

	$("#btn-open-all").click(function() {
		$(".faqs").trigger("open");
	});

	$("#btn-close-all").click(function() {
		$(".faqs").trigger("close");
	});

});