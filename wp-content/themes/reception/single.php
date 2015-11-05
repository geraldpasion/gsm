<?php get_header(); ?>

<?php while (have_posts()) : the_post();

$post_meta = get_post_custom($post->ID);
if (isset($post_meta['hermes_post_display_featured'][0])) { $display_featured = esc_attr($post_meta['hermes_post_display_featured'][0]); };

endwhile;

if (isset($display_featured) && $display_featured == 'Yes') {

	get_template_part('slideshow');

}
?>

<div id="main" class="clearfix">

	<div id="content" class="clearfix">
	
		<div class="wrapper-content">

			<?php while (have_posts()) : the_post(); ?>
			
			<div class="hermes-page-intro">
				<h1 class="title-post"><?php the_title(); ?></h1>
				<p class="post-meta"><time datetime="<?php echo get_the_date('c'); ?>" pubdate><?php echo get_the_date(); ?></time> / <span class="category"><?php the_category(', '); ?></span></p>
				<?php edit_post_link( __('Edit page', 'reception'), '<p class="post-meta">', '</p>'); ?>
			</div><!-- .hermes-page-intro -->
			
			<div class="post-single clearfix">
			
				<?php the_content(); ?>
				
				<div class="cleaner">&nbsp;</div>
				
				<?php wp_link_pages(array('before' => '<p class="page-navigation"><strong>'.__('Pages', 'reception').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				<?php the_tags( '<p class="post-meta"><strong>'.__('Tags', 'reception').':</strong> ', ', ', '</p>'); ?>
					
			</div><!-- .post-single .clearfix -->
			
			<?php endwhile; ?>

			<div id="hermes-comments">
				<?php comments_template(); ?>  
			</div><!-- end #hermes-comments -->

		</div><!-- .wrapper-content -->
	
	</div><!-- #content -->
	
	<?php get_sidebar(); ?>
	
</div><!-- #main -->

<?php get_footer(); ?>