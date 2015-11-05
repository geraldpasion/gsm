<?php get_header(); ?>

<div id="main" class="clearfix">

	<div id="content" class="clearfix">
	
		<div class="wrapper-content">

			<div class="hermes-page-intro">
				<h1 class="title-post"><?php /* tag archive */ if( is_tag() ) { ?><?php _e('Post Tagged with:', 'reception'); ?> "<?php single_tag_title(); ?>"
				<?php /* daily archive */ } elseif (is_day()) { ?><?php _e('Archive for', 'reception'); ?> <?php the_time('F jS, Y'); ?>
				<?php /* search archive */ } elseif (is_month()) { ?><?php _e('Archive for', 'reception'); ?> <?php the_time('F, Y'); ?>
				<?php /* yearly archive */ } elseif (is_year()) { ?><?php _e('Archive for', 'reception'); ?> <?php the_time('Y'); ?>
				<?php } ?></h1>
			</div><!-- .hermes-page-intro -->
			
			<div class="divider">&nbsp;</div>
	
			<?php get_template_part('loop'); ?>
			
		</div><!-- .wrapper-content -->
	
	</div><!-- #content -->
	
	<?php get_sidebar(); ?>
	
</div><!-- #main -->

<?php get_footer(); ?>