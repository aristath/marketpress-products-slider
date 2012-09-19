=== MarketPress Products Slider ===
Contributors: aristath
Donate link: http://aristeides.com
Tags: commerce, marketpress, flexslider, slider, slideshow, 
Requires at least: 3.4
Tested up to: 3.4.1
Stable tag: 1.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

MarketPress Products Slider adds product slider on the homepage and multiple images handling on single products.

== Description ==

MarketPress Products Slider adds product slider on the homepage and multiple images handling on single products.
For the time being, it adds the latest 3 products on the frontpage slider. In the future we will include a custom field that will allow users to select the featured products of their choosing.

It requires that you have access to your theme files to add the necessary code. (see installation section).

* It creates a products slider which can be placed in your homepage
* It creates a slider which can be used for single products that have multiple images. When used this way, remember not to insert the images to the post. Simply attaching them will suffice.

TODO:

* Custom field in products to select which ones are featured on the frontpage
* If we set wpthumb's resize=false, sometimes images are not generated. That's why it's set to true.

== Installation ==

Upload to your Plugins folder and activate.
To include the frontpage slider wherever you want, open up the template file of your choise (front-page.php, index.php or other)
and insert the following where necessary:
`<?php mps_featured_slider(); ?>`


To enable the multiple images slider for individual product pages, you must open your template file responsible for them (usually mp_product.php) and place the following where you want the content to be displayed.
`<?php mps_single_product_images_slider(true, $post->ID); ?>`
Please note that this will completely rewrite the output of your product and it will not simply add the slider.
If you have something like `<?php mp_product(); ?>` in there, you should delete it to avoid duplicate content.

== Changelog ==

= 1.0 =
* First version
