jQuery(document).ready(function($) {

	$(window).load(function() {
		if (window.innerWidth > 1024) {
			$('.related-content-one-third li h3').equalHeights();
      $('.cta-products-one-half li h3').equalHeights();
			$('.cta-products-description').equalHeights();
			$('.featured-block-2 h3.section-title').equalHeights();
			$('.featured-block-3 h3.section-title').equalHeights();
      $('.featured-block-4 h3.section-title').equalHeights();
      $('.featured-icon-content').equalHeights();
			$('.pricing-title').equalHeights();
			$('.pricing-features').equalHeights();
		}
	});

	$(window).resize(function(){
		if (window.innerWidth > 1024) {
			$('.related-content-one-third li h3').height('auto');
			$('.related-content-one-third li h3').equalHeights();
      $('.cta-products-one-half li h3').height('auto');
			$('.cta-products-one-half li h3').equalHeights();
			$('.cta-products-description').height('auto');
			$('.cta-products-description').equalHeights();
			$('.featured-block-2 h3.section-title').height('auto');
			$('.featured-block-2 h3.section-title').equalHeights();
			$('.featured-block-3 h3.section-title').height('auto');
			$('.featured-block-3 h3.section-title').equalHeights();
			$('.featured-block-4 h3.section-title').height('auto');
			$('.featured-block-4 h3.section-title').equalHeights();
			$('.featured-icon-content').height('auto');
			$('.featured-icon-content').equalHeights();
			$('.pricing-title').height('auto');
			$('.pricing-title').equalHeights();
      $('.pricing-features').height('auto');
			$('.pricing-features').equalHeights();
		}
	});

});

