<?php


/*
Plugin Name: MarketPress Products Slider
Plugin URI: http://aristeides.com
Description: Featured Products Slideshow to be used on the frontpage of MarketPress stores and single roducts multiple images slider.
Author: Aristeides Stathopoulos
Version: 1.0
Author URI: http://aristeides.com
*/


/*
 * You can set this plugin's configuration options below
 */
define('MPS_FEATURED_SLIDER_WIDTH',        1170);            //you should enter your theme's width here (px)
define('MPS_FEATURED_SLIDER_HEIGHT',       300);             //the height of the featured slider (px)
define('MPS_FEATURED_SLIDER_IMAGE_WIDTH',  580);             //the width of your slider image (px)
define('MPS_FEATURED_SLIDER_IMAGE_TITLE',  'View Product');  //the title of your slider image. WIll be visible when hovering the image
define('MPS_FEATURED_SLIDER_COUNT',        '4');             //how many products you want shown in the slider
define('MPS_FEATURED_SLIDER_SPEED',        8000);            //time for slides (ms)
define('MPS_SLIDER_TYPE',                  'slide');         //Select your animation type, 'fade' or 'slide'

/*
 * Include wpthumb if it is not already installed
 */
define( 'MARKETPRESS_FEATURED_SLIDER_PATH', plugin_dir_path(__FILE__) );
if (!class_exists('WP_Thumb') ) {
	define( 'WP_THUMB_PATH', trailingslashit( MARKETPRESS_FEATURED_SLIDER_PATH . '/includes/wpthumb' ) );
	define( 'WP_THUMB_URL', plugins_url( '/includes/wpthumb/', __FILE__ ));
	require_once( MARKETPRESS_FEATURED_SLIDER_PATH . 'includes/wpthumb/wpthumb.php' );
}
define('MPS_PLUGIN_IMAGES_URL', plugins_url( '/images/', __FILE__ ));

/*
 * Builds the slider that will be used in the frontpage of you site.
 * To include this in your homepage you MUST enter the following
 * in your template file (front-page.php, index.php or other):
 * <?php mps_featured_slider(); ?>
 */

function mps_featured_slider(){
	global $mp;
	//The Query
	$custom_query = new WP_Query( array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => MPS_FEATURED_SLIDER_COUNT
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
			slideshowSpeed: <?php echo MPS_FEATURED_SLIDER_SPEED ?>,
			controlNav: false,
			animation: '<?php echo MPS_SLIDER_TYPE ?>'
		});
	});
	</script>
	<style>
	.home-slider .flexslider ul.slides li .flex-caption {width: <?php echo (MPS_FEATURED_SLIDER_WIDTH - MPS_FEATURED_SLIDER_IMAGE_WIDTH); ?>px;}
	.home-slider .flexslider ul.slides li .image-wrapper {width: <?php echo MPS_FEATURED_SLIDER_IMAGE_WIDTH ?>px;}
	.home-slider {background-color:#ffffff;margin:0 -20px;}
	.home-slider .flexslider {overflow: hidden;border:0;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;box-shadow:0 0 0;-webkit-box-shadow:0 0 0;-moz-box-shadow:0 0 0;-o-box-shadow:0 0 0;zoom:1;margin-bottom:10px;}
	.home-slider .flexslider ul.slides { height:300px; }
	.home-slider .flexslider ul.slides li {position:relative;height:253px;}
	.home-slider .flexslider ul.slides li .flex-caption {padding:0;position:absolute;left:0;top:0;padding:40px 5px 10px 45px;background:#ffffff !important;color:#313131;font-size:14px;line-height:18px;height:100%;text-align:center;}
	.home-slider .flexslider ul.slides li .flex-caption:after, .home-slider .flexslider ul.slides li .flex-caption:before {left:100%;border:solid transparent;content:" ";height:0;width:0;position:absolute;pointer-events:none;}
	.home-slider .flexslider ul.slides li .flex-caption:after {border-left-color:#ffffff;border-width:20px;top:30%;margin-top:-20px;}
	.home-slider .flexslider ul.slides li .flex-caption:before {border-left-color:#ffffff;border-width:26px;top:30%;margin-top:-26px;}
	.home-slider .flexslider ul.slides li h2 {font-size:30px;line-height:35px;margin-bottom:10px;font-weight:bold;padding-right:25px;}
	.home-slider .flexslider ul.slides li .description {font-size:13px;color:#525351;line-height:17px;padding-right:25px;}
	.home-slider .flexslider ul.slides li .slider_product_meta { text-align:center; }
	.home-slider .flexslider ul.slides li .slider_product_meta .mp_product_price {margin-bottom:30px;padding-right:25px;font-size:40px;line-height:44px;font-weight:bold;display:inline-block;}
	.home-slider .flexslider ul.slides li .slider_product_meta .mp_product_price .mp_old_price {color:#bababa;padding-right:5px;font-weight:bold;text-decoration:line-through;}
	.home-slider .flexslider ul.slides li .slider_product_meta .mp_buy_form { text-align:center; }
	.home-slider .flexslider ul.slides li .slider_product_meta .mp_buy_form .mp_quantity { display:none; }
	.home-slider .flexslider ul.slides li .image-wrapper {float:right;height:300px;}
	.home-slider ul.flex-direction-nav {position:absolute;height:50px;width:120px;bottom:10px;right:10px;}
	.home-slider ul.flex-direction-nav li a {opacity:0.8;background:#333;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;width:45px;height:45px;}
	.home-slider ul.flex-direction-nav li a:hover { opacity:1; }
	.home-slider ul.flex-direction-nav li a.flex-prev {right:5px;background:#333 url("<?php echo MPS_PLUGIN_IMAGES_URL ?>arrow_slider_left.png") no-repeat center center;left:20px;}
	.home-slider ul.flex-direction-nav li a.flex-next {left:5px;background:#333 url("<?php echo MPS_PLUGIN_IMAGES_URL ?>arrow_slider_right.png") no-repeat center center;left:75px;}
	</style>
	<div class="region-divider"></div>
	<?php
	}
}

/*
 * The slide for individual products on the featured products slider
 */
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
			$content .= mps_product_photo( false, $post->ID, true, MPS_FEATURED_SLIDER_IMAGE_WIDTH, MPS_FEATURED_SLIDER_IMAGE_HEIGHT, true, true, false, MPS_FEATURED_SLIDER_IMAGE_TITLE );
		}
	$content .= '</li>';
	
	if ($echo)
		echo $content;
	else
		return $content;
}

/*
 * Builds the slider for single products
 * with multiple image attachments
 */
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

/*
 * Build the single product content
 */
function mps_product_with_slider($id){
	$post = get_post($product_id);
	
	$content .= '<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="mp_product_meta">';
	$content .= mp_product_price(false, $id);
	$content .= mp_buy_button(false, 'single', $id);
	$content .= '</div>';
	$content .= '<div itemprop="description" class="mp_product_content">';
	$content .= apply_filters('the_content', $post->post_content);
	$content .= '</div>';
	$content .= single_product_images_slider(false, $id);
	
	echo $content;
}

/*
 * Scale and crop photos using wpthumb.
 */
function mps_product_photo( $echo = true, $post_id = NULL, $link = true, $width = NULL, $height = NULL, $crop = true, $resize = true, $stretch = false, $title = '' ) {
	global $id;
	$post_id = ( NULL === $post_id ) ? $id : $post_id;
	$post_id = apply_filters('mp_product_image_id', $post_id);
	$post = get_post($post_id);
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	
	if ($stretch == true){
		$thumbnail_attr = wp_get_attachment_image_src( $post_thumbnail_id );
		$thumb_url      = $thumbnail_attr[0];
		$thumb_width    = $thumbnail_attr[1];
		$thumb_height   = $thumbnail_attr[2];
		
		if ($thumb_width < $width && $thumb_height < $height) {
			$thumbsize = 'small';
		}
		elseif ($thumb_width < $width && $thumb_height > $height) {
			$thumbsize = 'narrow';
		}
		elseif ($thumb_width > $width && $thumb_height < $height) {
			$thumbsize = 'short';
		}
		elseif ($thumb_width > $width && $thumb_height > $height) {
			$thumbsize = 'ok';
		}
		
		if ($thumbsize == 'small'){
			$thumbstyle = 'width: ' . $width . 'px; height: ' . $height . 'px;';
		}
		elseif ($thumbsize == 'narrow'){
			$thumbstyle = 'width: ' . $width . 'px; height: auto;';
		}
		elseif ($thumbsize == 'short'){
			$thumbstyle = 'width: auto; height: ' . $height . 'px;';
		}
		elseif ($thumbsize == 'ok'){
			$thumbstyle = '';
		}
	} else {
		$thumbstyle = '';
	}

	$size = '"width=' . $width . '&height=' . $height . '&crop=' . $crop . '"'; 
	
	$title_i18n = __($title, 'basic');

	$productlink = get_permalink($post_id);
	$image = get_the_post_thumbnail($post_id, array( 'width' => $width, 'height' => $height, 'crop' => $crop, 'resize' => $resize ), array('style' => $thumbstyle, 'itemprop' => 'image', 'class' => 'product_image', 'title' => $title_i18n));

	$content = '<div class="image-wrapper">';
	if ($link == true){
		if ($productlink){
			$content .= '<a id="product_image-' . $post_id . '"' . $class . ' href="' . $productlink . '">';
		}
	}
	$content .= $image;
	if ($link == true){
		if ($productlink){
			$content .= '</a>';
		}
	}
	$content .= '</div>';

	if ($echo)
		echo $content;
	else
		return $content;
}

/*
 * enqueue plugin's stylesheet
 * and jquery.flexslider.min.js
 */
function mps_scripts_and_styles() {
	wp_register_style('flexslider-css', plugins_url('includes/flexslider/flexslider.css', __FILE__), false, null);
	wp_enqueue_style('flexslider-css');
	
	wp_register_script('flexslider-js', plugins_url('includes/flexslider/jquery.flexslider.min.js', __FILE__), false, null, false);
	wp_enqueue_script('flexslider-js');
	
}
add_action('enqueue_scripts', 'mps_scripts_and_styles');