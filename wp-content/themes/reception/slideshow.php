<?php 

// If it is a post or page, retrieve all attached images to it.

if ( is_single() || is_page() || is_page_template() ) {

	$args = array(
		'order'          => 'ASC',
		'orderby'          => 'menu_order',
		'post_parent'    => $post->ID,
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'post_status'    => null,
		'numberposts'    => -1
	);
	
	$attachments = get_posts($args);
	$attachments_num = count($attachments);
	
	if ($attachments_num == 0) {
	
		if ( has_post_thumbnail( $post->ID ) ) {
			$featured_image_id = get_post_thumbnail_id($post->ID);

			unset($attachments,$attachments_num);
			
			$args = array(
				'p'    => $featured_image_id,
				'post_type'      => 'attachment',
				'post_mime_type' => 'image'
			);
			
			$attachments = get_posts($args);
			$attachments_num = count($attachments);

		}
	}

} 

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

<?php } ?>