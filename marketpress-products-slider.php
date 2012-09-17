<?php


/*
Plugin Name: MarketPress Products Slider
Plugin URI: http://aristeides.com
Description: Featured Products Slideshow to be used on the frontpage of MarketPress stores and single roducts multiple images slider.
Author: Aristeides Stathopoulos
Version: 1.0
Author URI: http://aristeides.com
*/

function mps_featured_slider(){
	global $mp;
	//The Query
	$custom_query = new WP_Query( array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => '3'
	));
	$slides_count = $custom_query->post_count;
	if ($slides_count >= 1) { 
	?>
	<div class="home-slider">
		<div class="flexslider">
			<ul class="slides">
				<?php foreach ($custom_query->posts as $post) {
					mps_slider_product(true, $post->ID);
				;} ?>
			</ul>
		</div>
	</div>
	<script type="text/javascript" charset="utf-8">
	jQuery(window).load(function() {
		jQuery('.home-slider .flexslider').flexslider({
			slideshowSpeed: 10000,
			controlNav: false,
			animation: 'slide'
		});
	});
	</script>
	<div class="region-divider"></div>
	<?php
	}
}

function mps_slider_product($echo = true, $product_id, $title = true, $content = 'full', $image = 'single', $meta = true) {
	global $mp;
	$post = get_post($product_id);
	
	$content = '<li '.mp_product_class(false, 'mp_product', $post->ID).'itemscope itemtype="http://schema.org/Product">';
		$content .= '<div class="flex-caption">';
		if ($title) {
			$content .= '<a href="' . get_permalink($post->ID) . '"><h2 itemprop="name" class="product_name">' . $post->post_title . '</h2></a>';
		}
		if ($content) {
			$content .= '<div class="description" itemprop="description">';
			if ($content == 'excerpt') {
				$content .= $mp->product_excerpt($post->post_excerpt, $post->post_content, $post->ID);
			} else {
				$content .= apply_filters('the_content', $post->post_content);
			}
			$content .= '</div>';
			if ($meta) {
				$content .= '<div class="slider_product_meta" itemprop="offers" itemscope itemtype="http://schema.org/Offer">';
					//price
					$content .= mp_product_price(false, $post->ID);
					//button
					$content .= mp_buy_button(false, 'single', $post->ID);
				$content .= '</div>';
			}
		}
		$content .= '</div>';
		if ($image) {
			$content .= mps_slider_product_image( false, $image, $post->ID );
		}
	$content .= '</li>';
	
	if ($echo)
		echo $content;
	else
		return $content;
}

function mps_slider_product_image( $echo = true, $context = 'list', $post_id = NULL, $size = NULL ) {
	global $id;
	$post_id = ( NULL === $post_id ) ? $id : $post_id;
	$post_id = apply_filters('mp_product_image_id', $post_id);
	$post = get_post($post_id);
	$settings = get_option('mp_settings');
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	$size = 'slide';
	//link
	$temp = wp_get_attachment_image_src( $post_thumbnail_id, 'large' );
	$link = get_permalink($post_id);
	$title = __('View Product', 'mps');
	$image = get_the_post_thumbnail($post_id, $size, array('itemprop' => 'image', 'class' => 'alignleft product_image_'.$context, 'title' => $title));
	//add the link
	if ($link)
		$image = '<div class="image-wrapper"><a id="product_image-' . $post_id . '"' . $class . ' href="' . $link . '">' . $image . '</a></div>';
	
	if ($echo)
		echo $image;
	else
		return $image;
}

function mps_single_product_images_slider($echo, $id){
	$attachments = get_posts( array(
		'post_type' => 'attachment',
		'posts_per_page' => -1,
		'post_parent' => $id,
	));
	
	if ( $attachments ) {
		$content = '<div class="single-product-image-slider">';
		$content .= '<div class="flexslider">';
		$content .= '<ul class="slides">';
		
		foreach ( $attachments as $attachment ) {
			$class = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
			$img_attributes = wp_get_attachment_image_src($attachment->ID, 'full' );
			$img = '<img itemprop="image" src="' . $img_attributes[0] . '" />';
			$content .= '<li class="' . $class . ' data-design-thumbnail">' . $img . '</li>';
		}
		$content .= '</ul></div></div>';
		$content .= '<script type="text/javascript" charset="utf-8">
					jQuery(window).load(function() {
						jQuery(".single-product-image-slider .flexslider").flexslider({
							slideshowSpeed: 7000,
							animation: "slide"
						});
					});
					</script>';
		$content .= '<div class="region-divider"></div>';
		
	}
	if ($echo)
		echo $content;
	else
		return $content;
	
}

function mps_product_with_slider($id){
	$post = get_post($product_id);
	
	$content .= single_product_images_slider(false, $id);
	$content .= '<div itemprop="description" class="mp_product_content">';
	$content .= apply_filters('the_content', $post->post_content);
	$content .= '</div>';
	$content .= '<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="mp_product_meta">';
	$content .= mp_product_price(false, $id);
	$content .= mp_buy_button(false, 'single', $id);
	$content .= '</div>';
	
	echo $content;
}

function mps_scripts_and_styles() {
	wp_register_style('flexslider-css', plugins_url('includes/flexslider/flexslider.css', __FILE__), false, null);
	wp_enqueue_style('flexslider-css');
	
	wp_register_script('flexslider-js', plugins_url('includes/flexslider/jquery.flexslider.min.js', __FILE__), false, null, false);
	wp_enqueue_script('flexslider-js');
	
}
add_action('enqueue_scripts', 'mps_scripts_and_styles');
