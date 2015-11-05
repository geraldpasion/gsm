<?php
 
/*----------------------------------*/
/* Custom Posts Options				*/
/*----------------------------------*/

function reception_options_box() {
	
	add_meta_box('reception_post_template', 'Post Options', 'reception_post_options', 'post', 'side', 'high');
	add_meta_box('reception_post_template', 'Page Options', 'reception_post_options', 'page', 'side', 'high');

}

add_action('add_meta_boxes', 'reception_options_box');

function reception_custom_add_save($postID){
	
	// called after a post or page is saved
	if($parent_id = wp_is_post_revision($postID))
	{
		$postID = $parent_id;
	}
	
	// Check if our nonce is set.
	if ( ! isset( $_POST['reception_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['reception_meta_box_nonce'], 'reception_meta_box' ) ) {
		return;
	}

	if (isset($_POST['save']) || isset($_POST['publish'])) {
		
		if (isset($_POST['hermes_post_display_featured']) && ($_POST['hermes_post_display_featured'] == 'Yes' || $_POST['hermes_post_display_featured'] == 'No') ) { reception_update_custom_meta($postID, esc_attr($_POST['hermes_post_display_featured']), 'hermes_post_display_featured'); }
		
	}
}

add_action('save_post', 'reception_custom_add_save');

function reception_update_custom_meta($postID, $newvalue, $field_name) {
	// To create new meta
	if(!get_post_meta($postID, $field_name)){
		add_post_meta($postID, $field_name, $newvalue);
	}else{
		// or to update existing meta
		update_post_meta($postID, $field_name, $newvalue);
	}
	
}

// Regular Posts Options
function reception_post_options() {
	global $post;
	
	wp_nonce_field( 'reception_meta_box', 'reception_meta_box_nonce' );
	
	?>
	<fieldset>
		<div>
			<p>
 				<label for=""><?php _e('Display attached images as a slideshow','reception'); ?></label><br />
				<select name="hermes_post_display_featured" id="hermes_post_display_featured">
					<option<?php selected( get_post_meta($post->ID, 'hermes_post_display_featured', true), 'Yes' ); ?>><?php _e('Yes','reception'); ?></option>
					<option<?php selected( get_post_meta($post->ID, 'hermes_post_display_featured', true), 'No' ); ?>><?php _e('No','reception'); ?></option>
				</select>
			</p>
  		</div>
	</fieldset>
	<?php
}