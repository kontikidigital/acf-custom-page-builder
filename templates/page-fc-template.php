<?php
/**
* Template Name: Flexible Content Page Template
* Description: Used as a page template to use ACF Flexible Content Blocks ideal for Landing Pages in Genesis
*/


// Remove site header elements
if ( !get_field('display_site_header') ) { //Check if display site header in False in ACF
	remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
	remove_action( 'genesis_header', 'genesis_do_header' );
	remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
}

// Remove navigation
if ( !get_field('display_site_menus') ) { //Check if display site menus in False in ACF
	remove_action( 'genesis_after_header', 'genesis_do_nav',1 );
}

// Remove Site Footer
if ( !get_field('display_site_footer') ) {  //Check if display site footer in False in ACF
	//* Remove site footer widgets
	remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
	//* Remove site footer elements
	remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
	remove_action( 'genesis_footer', 'genesis_do_footer' );
	remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );
}

// Display Site Logo
if ( get_field('display_site_logo') ) { //Check if display site header in False in ACF
	function tgt_display_site_logo() { ?>
	<header class="site-header" itemscope="" itemtype="http://schema.org/WPHeader">
		<div class="wrap">
			<div class="title-area">
				<p class="site-title" itemprop="headline">
					<a href="<?php bloginfo( 'url' ) ?>">
						<?php bloginfo( 'name' ) ?>
					</a>
				</p>
				<p class="site-description" itemprop="description">
				<?php bloginfo( 'description' ) ?>
				</p>
			</div>
	</header> <?php
	} //tgt_display_site_logo()
	add_action( 'genesis_header', 'tgt_display_site_logo' );
} //display_site_logo

// Display Custom Menu

if ( get_field( 'custom_menu' ) ) { //Check if display Custom Menu is TRUE in ACF	
	function register_additional_menu() {
		register_nav_menu( 'flexible-menu' ,__( 'Flexible Template Navigation Menu' ));
	} //register_additional_menu()
	add_action( 'init', 'register_additional_menu' );	
	add_action( 'genesis_after_header', 'add_flexible_nav_genesis' ); 
	function add_flexible_nav_genesis() {
		wp_nav_menu( array( 'theme_location' => 'flexible-menu', 'menu' => get_field('custom_menu'), 'container_class' => 'flexible-menu-area genesis-nav-menu') );
	} //add_flexible_nav_genesis()
} //custom_menu

// Function displaying Flexible Content Field
function tgt_display_fc() {
	// loop through the rows of data
	while ( have_rows('flexible_content') ) : the_row();
		// "Hero" Layout
		if( get_row_layout() == 'hero' ) { //Hero Image Layout
			$hero_image = get_sub_field( 'hero_image' ); 
			$css_id = get_sub_field( 'css_id' );
			
			if ($css_id) { ?>
				<section id="<?php the_sub_field( 'css_id' ); ?>" class="hero" style="background-image: url(<?php the_sub_field( 'hero_image' ); ?>);"> <?php  
			} else {  ?>
				<section class="hero" style="background-image: url(<?php the_sub_field( 'hero_image' ); ?>);"> <?php
			} //if else $css_id ?>

					<div class="overlay">
						<div class="wrap">
						<?php the_sub_field( 'hero_text' );
						if( get_sub_field( 'display_cta_button' ) ) { ?>
							<a href="<?php the_sub_field( 'hero_cta_button_url' ) ?>" class="cta-button">
							<?php echo the_sub_field( 'hero_cta_button_text' );?> <i class="fa <?php echo the_sub_field('hero_cta_button_icon');?>"></i></a> <?php 
						} //display_cta_button ?>
						</div> <!-- wrap -->
					</div> <!-- overlay -->
				</section> <!-- hero --> <?php
			
	} elseif (get_row_layout() == 'wrapped_image' ) { // "Wrapped Image" Layout		
		$css_id = get_sub_field( 'css_id' );
		$image = get_sub_field( 'image' );
		$image_size = 'large';
			
			if ($css_id) { ?>
				<section id="<?php the_sub_field( 'css_id' ); ?>" class="wrapped-image <?php the_sub_field( 'css_class' ); ?>" style="background-color:<?php the_sub_field('background_color'); ?>;"> <?php  
			} else {  ?>
				<section class="wrapped-image <?php the_sub_field( 'css_class' ); ?>" style="background-color:<?php the_sub_field('background_color'); ?>;"> <?php  
			} //else if $css_id ?>

					<div class="wrap">
						<?php echo wp_get_attachment_image( $image, array (1280, 0, TRUE) );?>
					</div> <!-- wrap -->
				</section> <!-- wrapped-image --> <?php
			
			
	} elseif( get_row_layout() == 'full_width_text' ) { // "Full Width Text" Layout
		$section_title = get_sub_field( 'section_title' ); 
		$css_id = get_sub_field( 'css_id' );
			
			if ($css_id) { ?>
				<section id="<?php the_sub_field( 'css_id' ); ?>" class="full-width-text <?php the_sub_field( 'css_class' ); ?>" style="background-color:<?php the_sub_field('background_color'); ?>; color:<?php the_sub_field('text_color'); ?>;"> <?php  
			} else {  ?>
				<section class="full-width-text <?php the_sub_field( 'css_class' ); ?>" style="background-color:<?php the_sub_field('background_color'); ?>; color:<?php the_sub_field('text_color'); ?>;"> <?php  
			} //else if $css_id ?>

					<div class="wrap"> <?php
						if ($section_title) { ?>
							<div class="section-title">
								<h2 style="color:<?php the_sub_field('text_color'); ?>;"><?php	the_sub_field( 'section_title' );?></h2>
							</div> <!-- section-title --> <?php
						} //if $section_title ?>
							<div class="section-content"> <?php
								the_sub_field( 'full_width_text' );
								if( get_sub_field( 'display_cta_button' ) ) { ?>
									<div class="tgt-fc-cta-button">
										<a href="<?php echo the_sub_field( 'cta_button_url' ); ?>" class="cta-button"> <?php 
										echo the_sub_field( 'cta_button_text' );?> <i class="fa <?php echo the_sub_field('cta_button_icon');?>"></i></a>
									</div> <!-- display_cta_button --> <?php 
								} //if display_cta_button ?>
							</div> <!-- section-content -->
					</div> <!-- wrap -->
				</section> <!-- full-width-text --> <?php
			
	} elseif( get_row_layout() == 'image_-_text' ) { // "Image - Text" Layout
		$css_id = get_sub_field( 'css_id' );
		$section_title = get_sub_field( 'section_title' );
		$left_image = get_sub_field( 'left_image' ); 
		$left_image_size = 'large'; // (thumbnail, medium, large, full or custom size)

		if ($css_id) { ?>
			<section id="<?php the_sub_field( 'css_id' );?>" class="row image-text <?php the_sub_field( 'css_class' ); ?>"> <?php  
		} else {  ?>
			<section class="row image-text <?php the_sub_field( 'css_class' ); ?>"> <?php  
		} //if else $css_id

			if ($section_title) { ?>
				<div class="full-section-title">
					<h2 style="color:<?php the_sub_field('text_color'); ?>;"><?php	the_sub_field( 'section_title' );?></h2>
				</div> <!-- full-section-title --> <?php
			} //$section_title ?>
				<div class="left-half" style="background-color:<?php the_sub_field('left_image_background_color'); ?>">
					<?php echo wp_get_attachment_image( $left_image, $left_image_size ); ?>
				</div> <!-- left-half -->
				<div class="right-half" style="background-color:<?php the_sub_field('right_text_background_color'); ?>">
					<?php the_sub_field( 'right_text' ); ?>
					<div class="wrap"> <?php	
						if( get_sub_field( 'display_right_cta_lirt' ) ) { ?>
							<div class="right-cta" style="background-color:<?php the_sub_field('right_cta_background_color_lirt'); ?>"> <?php 
								the_sub_field( 'right_cta_text_lirt' );
									if (get_sub_field( 'right_cta_button_url_lirt' )) { ?>
										<a href="<?php echo the_sub_field( 'right_cta_button_url_lirt' ); ?>" class="cta-button"> <?php 
										echo the_sub_field( 'right_cta_button_text_lirt' );?> <i class="fa <?php echo the_sub_field('right_cta_button_icon_lirt');?>"></i></a> <?php 
									} //right_cta_button_url_lirt
						} //display_right_cta_lirt?>
							</div> <!-- right-cta -->
					</div> <!-- wrap -->
				</div> <!-- right-half -->
			</section> <!-- row image-text --> <?php 

	} elseif( get_row_layout() == 'text_-_image' ) { // "Text - Image" Layout
		$css_id = get_sub_field( 'css_id' );			
		$section_title = get_sub_field( 'section_title' );
		$right_image = get_sub_field( 'right_image' ); 
		$right_image_size = 'large'; // (thumbnail, medium, large, full or custom size)

		if ($css_id) { ?>
			<section id="<?php the_sub_field( 'css_id' );?>" class="row text-image <?php the_sub_field( 'css_class' ); ?>"> <?php  	
		} else {  ?>
			<section class="row text-image <?php the_sub_field( 'css_class' ); ?>"> <?php  
		}  //else if $css_id

			if ($section_title) { ?>
				<div class="full-section-title">
					<h2 style="color:<?php the_sub_field('text_color'); ?>;"><?php	the_sub_field( 'section_title' );?></h2>
				</div> <!-- full-section-title --> <?php
			} //$section_title ?>

				<div class="left-half" style="background-color:<?php the_sub_field('left_text_background_color'); ?>"> <?php 
					the_sub_field( 'left_text' ); ?>
				</div> <!-- left-half -->
				<div class="right-half" style="background-color:<?php the_sub_field('right_image_background_color'); ?>"> <?php 
					echo wp_get_attachment_image( $right_image, $right_image_size ); ?>
					<div class="wrap"> <?php 
						if( get_sub_field( 'display_right_cta_ltri' ) ) { ?>
							<div class="right-cta" style="background-color:<?php the_sub_field('right_cta_background_color_ltri'); ?>"> <?php 
							the_sub_field( 'right_cta_text_ltri' );
							if (get_sub_field( 'right_cta_button_url_ltri' )) { ?>
							<a href="<?php echo the_sub_field( 'right_cta_button_url_ltri' ); ?>" class="cta-button">
								<?php echo the_sub_field( 'right_cta_button_text_ltri' );?> <i class="fa <?php echo the_sub_field('right_cta_button_icon_ltri');?>"></i></a> <?php 
							} //right_cta_button_url_ltri
						} //display_right_cta_ltri ?>
							</div> <!-- right-cta -->
					</div> <!-- wrap -->
				</div> <!-- right-half -->
			</section> <!-- row text-image --> <?php 
		
	} elseif( get_row_layout() == 'faq_section' ) {  // "FAQ" Layout 
		$faq_section_title = get_sub_field( 'faq_section_title' );
		$faq_section_subtitle = get_sub_field( 'faq_section_subtitle' );
		$css_id =	get_sub_field( 'css_id' );
		
		if ($css_id) { ?>
			<section id="<?php the_sub_field( 'css_id' ); ?>" class="full-width-faqs <?php the_sub_field( 'css_class' ); ?>" style="background-color:<?php the_sub_field('faq_background_color'); ?>"> <?php  
		} else {  ?>
			<section class="full-width-faqs <?php the_sub_field( 'css_class' ); ?>" style="background-color:<?php the_sub_field('faq_background_color'); ?>"> <?php  
		} //elseif $css_id ?>
				<div class="wrap" style="background-color:<?php the_sub_field('faq_inner_background_color'); ?>"><?php 
					if ($faq_section_title)	{ ?>
						<h2><?php the_sub_field( 'faq_section_title' ); ?></h2> <?php 
					} //$faq_section_title
					if ($faq_section_subtitle)	{ ?>
						<h3><?php the_sub_field( 'faq_section_subtitle' ); ?></h3> <?php 
					} //$faq_section_subtitle

					if ( have_rows( 'faq' ) ) { // check if the repeater field has rows of data ?>
						<div class="open-close-btns">
							<button id="btn-open-all">Open all</button> <span class="pipe">|</span> <button id="btn-close-all">Close all</button>
						</div> <!-- open-close-btns --> <?php 
						echo '<div class="faqs">';
							// loop through the rows of data
							while ( have_rows( 'faq' ) ) : the_row(); ?>
								<div class="faq">
									<h4 class="question"> <?php 
										the_sub_field( 'question' ); ?>
									</h4> <!-- question -->
									<div class="answer">
										<?php the_sub_field( 'answer' ); ?>
									</div> <!-- answer -->
								</div> <!-- faq --> <?php
							endwhile; 
					} else {
					// no rows found
					} //else if faq ?>
				</div> <!-- wrap -->
			</section> <!-- full-width-faqs --> <?php 
	
	} elseif( get_row_layout() == 'author_box' ) {  // Author Box Layout
		$author_title = get_sub_field( 'author_title' );
		$author_description = get_sub_field( 'author_description' );
		$author_image = get_sub_field('author_image');
		$author_image_image_size = 'agency-like-featured-posts'; //array(320, 320, TRUE );
		$css_id =	get_sub_field( 'css_id' );

		if ($css_id) { ?>
			<section id="<?php the_sub_field( 'css_id' ); ?>" class="fw-author-box <?php the_sub_field( 'css_class' ); ?>" style="background-color:<?php the_sub_field('author_background_color'); ?>"> <?php  
		} else {  ?>
			<section class="fw-author-box <?php the_sub_field( 'css_class' ); ?>" style="background-color:<?php the_sub_field('author_background_color'); ?>"> <?php  
		} //else if $css_id ?>
				<div class="wrap" style="background-color:<?php the_sub_field('author_inner_background_color'); ?>">
					<div class="fw-author-container-wrapper"> <?php
						if ($author_title) { ?>
							<div class="fw-author-title">
								<h2> <?php the_sub_field( 'author_title' ); ?> </h2>
							</div> <!-- fw-author-title --> <?php 
						} //$author_title 

						if ($author_title && $author_description) { ?>
							<div class="fw-author-description"> <?php
								the_sub_field( 'author_description' ); ?>
							</div> <!-- fw-author-description --> <?php
						} else { ?>
							<div class="fw-author-description-full"> <?php
								the_sub_field( 'author_description' ); ?>
							</div> <!-- fw-author-description-full --> <?php
						} //$author_title && $author_description

						if( $author_image ) { ?>
							<div class="fw-author-image">
								<?php echo wp_get_attachment_image( $author_image, array(320, 320) );?>
							</div> <!-- fw-author-image --> <?php 
						} else { ?>
							<div class="fw-author-image"><img src="<?php plugin_dir_url( __FILE__ ) . '/images/blank-image.png'?>">
							</div> <!-- fw-author-image --> <?php 
					 	} //$author_image ?>
					</div> <!-- fw-author-container-wrapper -->
				</div> <!-- wrap -->
			</section> <!-- fw-author-box --> <?php 
		
	} elseif( get_row_layout() == 'related_content_section' ) { //Related Content Layout		
		$relatedContents = get_sub_field( 'related_content' );
		$relatedContentsTitle = get_sub_field( 'related_content_title' );
		$css_id =	get_sub_field( 'css_id' );

		if ($css_id) { ?>
			<section id="<?php the_sub_field( 'css_id' ); ?>" class="full-related-posts <?php the_sub_field( 'css_class' ); ?>" style="background-color:<?php the_sub_field('section_background_color'); ?>"> <?php  
		} else {  ?>
			<section class="full-related-posts <?php the_sub_field( 'css_class' ); ?>" style="background-color:<?php the_sub_field('section_background_color'); ?>"> <?php  
		} //else if $css_id ?>
			<div class="wrap">
				<div class="related-content-title"> <?php			
					if ($relatedContentsTitle) { ?>
						<h2 style="color:<?php the_sub_field('title_color'); ?>"><?php the_sub_field( 'related_content_title' ); ?></h2> <?php 
					} //$relatedContentsTitle ?>
				</div> <!-- related-content-title --> <?php 
					if( $relatedContents ) { ?>
						<ul class="related-posts"> <?php
							foreach( $relatedContents as $relatedContent ) { // variable must NOT be called $post (IMPORTANT) 
								setup_postdata($relatedContent ); ?>
								<div class="related-content-one-third">
									<li>
										<a href="<?php echo get_permalink( $relatedContent->ID ); ?>"><?php echo get_the_post_thumbnail( $relatedContent->ID, array(300,168) ); ?> </a>
										<h3><a href="<?php echo get_permalink( $relatedContent->ID ); ?>"><?php echo get_the_title( $relatedContent->ID ); ?> </a></h3>
									</li>
								</div> <!-- related-content-one-third --> <?php
							} //foreach ?>
						</ul> <!-- related-posts --> <?php 
								wp_reset_postdata();
					} //$relatedContents ?>
				</div> <!-- wrap -->
			</section> <!-- full-related-posts --> <?php

	} elseif( get_row_layout() == 'cta_products_section' ) { // CTA Courses & Products Section Layout
		$cta_courses_products_title = get_sub_field( 'cta_courses_products_title' );
		$css_id =	get_sub_field( 'css_id' );

		if ($css_id) { ?>
			<section id="<?php the_sub_field( 'css_id' ); ?>" class="full-cta-products <?php the_sub_field( 'css_class' ); ?>" style="background-color:<?php the_sub_field('section_background_color'); ?>"> <?php  
		} else {  ?>
			<section class="full-cta-products <?php the_sub_field( 'css_class' ); ?>" style="background-color:<?php the_sub_field('section_background_color'); ?>"> <?php  
		} //else if $css_id ?>
				<div class="wrap">
					<div class="cta-products-title"> <?php			
						if ($cta_courses_products_title) { ?>
							<h2 style="color:<?php the_sub_field('title_color'); ?>"><?php the_sub_field( 'cta_courses_products_title' ); ?></h2> <?php
						} //$cta_courses_products_title ?>
					</div> <!-- cta-products-title --> <?php 

					if ( have_rows( 'cta_courses_products' ) ) { // check if the repeater field has rows of data ?>
						<ul class="cta-products"> <?php
							while ( have_rows( 'cta_courses_products' ) ) : the_row(); 
								$ctaProducts = get_sub_field( 'cta_course_product' );						
								if( $ctaProducts ) {
									foreach( $ctaProducts as $ctaProduct ) { // variable must NOT be called $post (IMPORTANT) 
										setup_postdata($ctaProduct ); ?>
										<div class="cta-products-one-half">
											<li>
												<h3><a href="<?php echo get_permalink( $ctaProduct->ID ); ?>"><?php echo get_the_title( $ctaProduct->ID ); ?> </a></h3>
												<a href="<?php echo get_permalink( $ctaProduct->ID ); ?>"><?php echo get_the_post_thumbnail( $ctaProduct->ID, array(542,303) ); ?> </a>
												<div class="cta-products-description">
													<?php the_sub_field('cta_course_product_description'); ?>
												</div> <!-- cta-products-description -->
												<div class="cta-products-button">												
													<a href="<?php echo get_permalink( $ctaProduct->ID ); ?>" class="cta-button">
													<?php echo the_sub_field( 'cta_button_text' );?> <i class="fa <?php echo the_sub_field('cta_button_icon');?>"></i></a>
												</div> <!-- cta-products-button -->
											</li>
										</div> <!-- cta-products-one-half --> <?php
									} //foreach 
										wp_reset_postdata();
								} //$ctaProducts
							endwhile; ?>
						</ul> <!-- cta-products --> <?php
					} //cta_courses_products ?>
				</div> <!-- wrap -->
			</section> <!-- full-cta-products --> <?php

 	} elseif( get_row_layout() == 'video_section' ) { // Video Section Layout
		$section_title = get_sub_field( 'section_title' );
		$section_text = get_sub_field ('text');
		$css_id =	get_sub_field( 'css_id' );
		$text_color = get_sub_field ('text_color');

		if ($css_id) { ?>
			<section id="<?php the_sub_field( 'css_id' ); ?>" class="video-section <?php the_sub_field( 'css_class' ); ?>" style="background-color:<?php the_sub_field('background_color'); ?>; color:<?php the_sub_field('text_color'); ?>;"> <?php
		} else {  ?>
			<section class="video-section <?php the_sub_field( 'css_class' ); ?>" style="background-color:<?php the_sub_field('background_color'); ?>; color:<?php the_sub_field('text_color'); ?>;"> <?php  
		} //elseif $css_id ?>

			<div class="wrap"> <?php
				if ($section_title) { ?>
					<div class="section-title">
						<h2 style="color:<?php the_sub_field('text_color'); ?>;"><?php the_sub_field( 'section_title' ); ?></h2>
					</div> <!-- section-title --> <?php
				} //$section_title		

				if ($section_text) { ?>
					<div class="section-content" style="color:<?php the_sub_field('text_color'); ?>;"> <?php 
						the_sub_field( 'text' ); ?>
					</div> <!-- section-content --> <?php
				} //$section_text

		
				if ( have_rows( 'video_links' ) ) { // check if the repeater field has rows of data ?>
					<ul class="video-embedded"> <?php
						while ( have_rows( 'video_links' ) ) : the_row(); 
						$video_title = get_sub_field( 'video_title' );
						$video_link = get_sub_field( 'video_link'); ?>
							<div class="videos-one-half">
								<li class="videos"> <?php
									if ($video_title) { ?>
										<div class="video-title">
											<h3 style="color:<?php echo $text_color ?>;"><?php the_sub_field( 'video_title' );?></h3>
										</div> <!-- video-title --> <?php
									} //$video_title

									if ($video_link) { ?>
										<div class="embed-video"> <?php
											the_sub_field( 'video_link' );?>
										</div> <?php
									} //$video_link ?>
								</li> <!-- videos -->
							</div> <!-- videos-one-half --> <?php		
						endwhile; ?>
					</ul> <!-- video-embedded --> <?php	
				} //video_links	?>
			</div>	<!-- wrap -->
		</section> <!-- video-section --> <?php

 	} elseif( get_row_layout() == 'featured_section' ) { // Featured Icons Section Layout
		$section_title = get_sub_field( 'section_title' );
		$top_text = get_sub_field ('top_text');
		$bottom_text = get_sub_field ('bottom_text');
		$css_id =	get_sub_field('css_id');
		$text_color = get_sub_field ('text_color');
		$columns = get_sub_field ('number_of_columns');
			
		if ($css_id) { ?>
			<section id="<?php the_sub_field( 'css_id' ); ?>" class="featured-section <?php the_sub_field( 'css_class' ); ?>" style="background-image: url(<?php the_sub_field ('background_image'); ?>); background-color:<?php the_sub_field('background_color'); ?>; color:<?php echo $text_color ?>;"> <?php  
		} else {  ?>	
			<section class="featured-section <?php the_sub_field( 'css_class' ); ?>" style="background-image: url(<?php the_sub_field ('background_image'); ?>); background-color:<?php the_sub_field('background_color'); ?>; color:<?php echo $text_color ?>;"> <?php  
		} //elseif $css_id ?>

				<div class="wrap"><?php
					if ($section_title) { ?>
						<div class="section-title">
							<h2 style="color:<?php echo $text_color ?>;"><?php the_sub_field( 'section_title' ); ?></h2>
						</div><?php
					} //$section_title
				
					if ($top_text) { ?>
						<div class="section-content" style="color:<?php echo $text_color ?>;"><?php 
							the_sub_field( 'top_text' ); ?>
						</div><?php
					} //$top_text
					
					if ( have_rows( 'icons' ) ) { ?>
						<ul> <?php
							while ( have_rows( 'icons' ) ) : the_row(); ?>
								<div class="featured-block-<?php echo $columns ?>" style="color:<?php echo $text_color ?>;">
									<li class="featured-icons"> 
					  				<i class="fa <?php the_sub_field ('icon');?> fa-4x"></i>
										<h3 class="section-title" style="color:<?php echo $text_color ?>;"> <?php the_sub_field ('icon_title');?></h3>
										<div class="featured-icon-content">
											<?php the_sub_field ('icon_text'); ?>
										</div> <!-- featured-icon-content --> <?php
										if (get_sub_field( 'cta_button_url' )) { ?>
												<a href="<?php echo the_sub_field( 'cta_button_url' ); ?>" class="cta-button">
													<?php echo the_sub_field( 'cta_button_text' );?> <i class="fa <?php echo the_sub_field('cta_button_icon');?>"></i></a><?php 
										} //cta_button_url ?>
									</li> <!-- featured-icons -->
								</div> <!-- featured-block --> <?php
							endwhile; ?>
						</ul> <?php
					} //icons
		
					if ($bottom_text) { ?>
						<div class="section-content" style="color:<?php echo $text_color ?>;">
							<?php the_sub_field( 'bottom_text' ); ?>
						</div> <!-- section-content --> <?php
					} //$bottom_text ?>
				</div> <!-- wrap -->
			</section> <!-- featured-section --> <?php

 	} else if( get_row_layout() == '2_column_pricing_table' ) { // 2 column pricing table
		$css_id =	get_sub_field('css_id');

		if ($css_id) { ?>
			<section id="<?php the_sub_field( 'css_id' ); ?>" class="pricing-2 <?php the_sub_field( 'css_class' ); ?>" style="background-color: <?php echo get_sub_field('background_color'); ?>"> <?php  
		} else {  ?>
			<section class="pricing-2 <?php the_sub_field( 'css_class' ); ?>" style="background-color: <?php echo get_sub_field('background_color'); ?>"><?php  
		}  //elseif $css_id ?>

				<div class="wrap">
					<h2 class="pricing-headline" style="color: <?php echo get_sub_field('title_color'); ?>"><?php echo get_sub_field('section_title'); ?></h2><?php 
					
					if( have_rows('columns') ) { 						
						$columns = 2;
						$increment = 0; ?>
						<section class="pricing-columns"> <?php 
							while ( have_rows('columns') ) : the_row(); ?>
								<div class="pricing-table one-half <?php if($increment % $columns == 0){echo'first';}$increment++; ?>">
									<h5 class="pricing-title"><?php echo get_sub_field('column_heading'); ?></h5>
									<h6 class="price"><?php echo get_sub_field('price'); ?></h6> <?php 
									if( have_rows('features_list') ) { ?>
										<ul class="pricing-features"> <?php 
											while ( have_rows('features_list') ) : the_row(); ?>
												<li class="single-feature"> <?php 
													echo get_sub_field('feature'); ?>
												</li> <?php 
											endwhile; //features_list ?>
										</ul> <!-- pricing-features --> <?php 
									} //features_list ?>
									<div class="price-button"> <?php 
										if (get_sub_field( 'cta_button_url' )) { ?>
											<a href="<?php echo the_sub_field( 'cta_button_url' ); ?>" class="cta-button"> <?php echo the_sub_field( 'cta_button_text' );?> <i class="fa <?php echo the_sub_field('cta_button_icon');?>"></i></a> <?php 
										} //cta_button_url ?>
									</div> <!-- price-button -->
								</div> <!-- pricing-table one-half --> <?php 
							endwhile; //columns ?>
						</section> <!-- pricing-columns --> <?php 
					} //columns ?>
				</div> <!-- wrap  -->
			</section> <!-- pricing-2  --> <?php 

	} else if( get_row_layout() == '3_column_pricing_table' ) { // 3 column pricing table
		$css_id =	get_sub_field('css_id');

		if ($css_id) { ?>
			<section id="<?php the_sub_field( 'css_id' ); ?>" class="pricing-3 <?php the_sub_field( 'css_class' ); ?>" style="background-color: <?php echo get_sub_field('background_color'); ?>"> <?php 
		} else {  ?>
			<section class="pricing-3 <?php the_sub_field( 'css_class' ); ?>" style="background-color: <?php echo get_sub_field('background_color'); ?>"> <?php  
		} //elsei f $css_id ?>

				<div class="wrap">
					<h2 class="pricing-headline" style="color: <?php echo get_sub_field('title_color'); ?>"><?php echo get_sub_field('section_title'); ?></h2> <?php 
					if( have_rows('columns') ) { 
					$columns = 3;
					$increment = 0; ?>
						<section class="pricing-columns"> <?php 
							while ( have_rows('columns') ) : the_row(); ?>
								<div class="pricing-table one-third <?php if($increment % $columns == 0){echo'first';}$increment++; ?>">
									<h5 class="pricing-title"><?php echo get_sub_field('column_heading'); ?></h5>
									<h6 class="price"><?php echo get_sub_field('price'); ?></h6> <?php 
									if( have_rows('features_list') ) { ?>
										<ul class="pricing-features"> <?php 
											while ( have_rows('features_list') ) : the_row(); ?>
												<li class="single-feature"> <?php 
													echo get_sub_field('feature'); ?>
												</li> <?php 
											endwhile; //features_list ?>
										</ul> <!-- pricing-features --> <?php 
									} //features_list ?>
									<div class="price-button"> <?php 
										if (get_sub_field( 'cta_button_url' )) { ?>
										<a href="<?php echo the_sub_field( 'cta_button_url' ); ?>" class="cta-button">
											<?php echo the_sub_field( 'cta_button_text' );?> <i class="fa <?php echo the_sub_field('cta_button_icon');?>"></i></a> <?php 
										} //cta_button_url ?>
									</div> <!-- price-button -->
								</div> <!-- pricing-table one-third --> <?php 
							endwhile; //columns ?>
						</section> <!-- pricing-columns --> <?php 
					} //columns ?>
				</div> <!-- wrap -->
			</section> <!-- pricing-3 --> <?php 
			
	} else if( get_row_layout() == '4_column_pricing_table' ) { // 4 column pricing table
		$css_id =	get_sub_field('css_id');

		if ($css_id) { ?>
			<section id="<?php the_sub_field( 'css_id' ); ?>" class="pricing-4 <?php the_sub_field( 'css_class' ); ?>" style="background-color: <?php echo get_sub_field('background_color'); ?>"> <?php  
		} else {  ?>
			<section class="pricing-4 <?php the_sub_field( 'css_class' ); ?>" style="background-color: <?php echo get_sub_field('background_color'); ?>"> <?php  
		}  //else if $css_id ?>

			<div class="wrap">
				<h2 class="pricing-headline" style="color: <?php echo get_sub_field('title_color'); ?>"><?php echo get_sub_field('section_title'); ?></h2> <?php 

				if( have_rows('columns') ) { 
				$columns = 4;
				$increment = 0; ?>
					<section class="pricing-columns"> <?php 
						while ( have_rows('columns') ) : the_row(); ?>
							<div class="pricing-table one-fourth <?php if($increment % $columns == 0){echo'first';}$increment++; ?>">
								<h5 class="pricing-title"><?php echo get_sub_field('column_heading'); ?></h5>
								<h6 class="price"><?php echo get_sub_field('price'); ?></h6> <?php 
								if( have_rows('features_list') ) { ?>
									<ul class="pricing-features"> <?php 
										while ( have_rows('features_list') ) : the_row(); ?>
											<li class="single-feature"> <?php 
												echo get_sub_field('feature'); ?>
											</li> <?php 
										endwhile; //features_list ?>
									</ul> <!-- pricing-features --> <?php 
								} //features_list ?>							
								<div class="price-button"> <?php 
									if (get_sub_field( 'cta_button_url' )) { ?>
										<a href="<?php echo the_sub_field( 'cta_button_url' ); ?>" class="cta-button">
											<?php echo the_sub_field( 'cta_button_text' );?> <i class="fa <?php echo the_sub_field('cta_button_icon');?>"></i></a> <?php 
									} //cta_button_url ?>
								</div> <!-- price-button -->
							</div> <!-- pricing-table one-fourth --> <?php 
						endwhile; //columns ?>
					</section> <!-- pricing-columns --> <?php 
				} //columns ?>
			</div> <!-- wrap -->
		</section> <!-- pricing-4 --> <?php 

	} else if( get_row_layout() == 'blockquote' ) {  // Blockquote
		$css_id =	get_sub_field('css_id');

		if ($css_id) { ?>
			<section id="<?php the_sub_field( 'css_id' ); ?>" class="landing-quote <?php the_sub_field( 'css_class' ); ?>" style="background-color: <?php echo get_sub_field('background_color'); ?>"> <?php  
		} else {  ?>
			<section class="landing-quote <?php the_sub_field( 'css_class' ); ?>" style="background-color: <?php echo get_sub_field('background_color'); ?>"> <?php  
		} //else if $css_id ?>

				<div class="wrap">
					<div class="quote-text" style="color: <?php echo get_sub_field('text_color'); ?>">
						<h4 class="quote" style="color: <?php echo get_sub_field('text_color'); ?>"><?php echo get_sub_field('text'); ?></h4>
						<h6 class="quote-author" style="color: <?php echo get_sub_field('text_color'); ?>"><?php echo get_sub_field('author'); ?></h6> <?php 
						if( get_sub_field('company') ) { ?>
						<span class="company"><?php echo get_sub_field('company'); ?></span>
						<?php } ?>
					</div> <!-- quote-text -->
				</div> <!-- wrap -->
			</section> <!-- landing-quote --> <?php 
	}

	endwhile; //add blocks on top of this line
}

/* Display everything 
--------------------------------------------*/
add_action( 'get_header', 'tgt_fc_check' );
function tgt_fc_check() {
	// If "Flexible Content" field has rows of data
	if( have_rows( 'flexible_content' ) ) {
		//Enque Scripts
		add_action( 'wp_enqueue_scripts', 'tgt_scripts_support_check' );
		// Force full width content
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
		//* Remove breadcrumbs
		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
		// Remove div.site-inner's div.wrap
		add_filter( 'genesis_structural_wrap-site-inner', '__return_empty_string' );
		// Remove Page title
		remove_action('genesis_entry_header', 'genesis_do_post_title');
	    // Remove edit link
	    add_filter ( 'genesis_edit_post_link' , '__return_false' );
		// Remove the default Page content
		if (!get_field('display_default_content')) {
			remove_action( 'genesis_loop', 'genesis_do_loop' );
		}
	    // Remove Skip Links
	    remove_action ( 'genesis_before_header', 'genesis_skip_links', 5 );
	    // Dequeue Skip Links Script
	    add_action( 'wp_enqueue_scripts', 'tgt_dequeue_skip_links' );
		// Show Flexible Content field in the content area
		add_action( 'genesis_loop', 'tgt_display_fc' );
		// Add custom body class
		add_filter( 'body_class', 'tgt_body_class' );
	}
}

function tgt_scripts_support_check() {
	wp_enqueue_script( 'modernizr', plugin_dir_url( __FILE__ ) . '../js/modernizr-custom.js' );
	wp_enqueue_script( 'jquery-collapse', plugin_dir_url( __FILE__ ) . '../js/jquery.collapse.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'collapse-init', plugin_dir_url( __FILE__ ) . '../js/jquery.collapse.init.js', array( 'jquery-collapse' ), '1.0.0', true );
	wp_enqueue_script( 'flexible-responsive-menu', plugin_dir_url( __FILE__ ) . '../js/fc-responsive-menu.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_script( 'equalheights', plugin_dir_url( __FILE__ ) . '../js/jquery.equalheights.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'equalheights-init',  plugin_dir_url( __FILE__ ) . '../js/fc-equalheights-init.js', array( 'equalheights' ), '1.0.0', true ); 
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' );
}

function tgt_body_class( $classes ) {
	$classes[] = 'flexible-content';
	return $classes;
}

function tgt_dequeue_skip_links() {
	wp_dequeue_script( 'skip-links' );
}

genesis();