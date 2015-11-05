<?php if (get_theme_mod('reception_display_slideshow') == 1 && get_theme_mod('reception_page_slideshow') != '') {

$args = array(
	'order'          => 'ASC',
	'orderby'          => 'menu_order',
	'post_type'      => 'attachment',
	'post_parent'    => get_theme_mod('reception_page_slideshow'),
	'post_mime_type' => 'image',
	'post_status'    => null,
	'numberposts'    => get_theme_mod('reception_slideshow_number')
);

$attachments = get_posts($args);
$attachments_num = count($attachments);

$i = 0;

if ( isset($attachments_num) && $attachments_num > 1 ) { ?>

<div class="wrapper-slider">

	<div id="hermes-gallery" class="flexslider">
		<ul class="hermes-slides">
	
			<?php
			foreach ($attachments as $attachment) {
			$i++; 
	
			$large_image_url = wp_get_attachment_image_src( $attachment->ID, 'reception-thumb-slideshow');
	
			?>
			<li class="hermes-gallery-slide">
			
				<img src="<?php echo $large_image_url[0]; ?>" width="1080" height="450" alt="" />
	
			</li><!-- end .hermes-gallery-slide -->
			<?php 
			} // foreach
			?>
	
		</ul><!-- .hermes-slides -->
	</div><!-- end #hermes-gallery .flexslider -->

</div><!-- .wrapper-slider -->

<?php 
} // if there are attachments
elseif ( isset($attachments_num) && $attachments_num == 1) { ?>

<div class="wrapper-slider">

	<div id="hermes-gallery">
	
			<?php
			foreach ($attachments as $attachment) {
			$i++; 
	
			$large_image_url = wp_get_attachment_image_src( $attachment->ID, 'reception-thumb-slideshow');
	
			?>
			<img src="<?php echo $large_image_url[0]; ?>" alt="<?php echo esc_attr($attachment->post_title); ?>" width="1080" height="450" />
			
			<?php 
			} // foreach
			?>
	
	</div><!-- end #hermes-gallery -->

</div><!-- .wrapper-slider -->

<?php }
} ?>