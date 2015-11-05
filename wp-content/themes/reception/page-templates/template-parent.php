<?php
/**
 * Template Name: Parent Page
 */

get_header(); ?>

<?php while (have_posts()) : the_post();

$post_meta = get_post_custom($post->ID);
if (isset($post_meta['hermes_post_display_featured'][0])) { $display_featured = esc_attr($post_meta['hermes_post_display_featured'][0]); };

endwhile;

if (isset($display_featured) && $display_featured == 'Yes') {

	get_template_part('slideshow');

}
?>

<div id="main" class="clearfix">

	<?php get_template_part('content', 'page-dir'); ?>

</div><!-- #main -->

<?php get_footer(); ?>