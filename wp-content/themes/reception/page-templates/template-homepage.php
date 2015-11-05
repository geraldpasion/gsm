<?php
/**
 * Template Name: Homepage
 */

get_header(); ?>

<div id="main">

	<?php get_template_part('slideshow-home'); ?>
	
	<?php get_template_part('featured-pages'); ?>
	
	<?php if (is_active_sidebar('home-col-1') || is_active_sidebar('home-col-2') || is_active_sidebar('home-col-3')) { ?>
	
	<div id="widget-columns" class="clearfix">
	
		<div class="hermes-column hermes-column-1">

			<?php
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('home-col-1') ) : ?> <?php endif;
			?>
			
			<div class="cleaner">&nbsp;</div>
			
		</div><!-- .hermes-column .hermes-column-1-->
		
		<div class="hermes-column hermes-column-2">

			<?php
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('home-col-2') ) : ?> <?php endif;
			?>
			
			<div class="cleaner">&nbsp;</div>

		</div><!-- .hermes-column .hermes-column-2-->
		
		<div class="hermes-column hermes-column-3">

			<?php
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('home-col-3') ) : ?> <?php endif;
			?>
			
			<div class="cleaner">&nbsp;</div>

		</div><!-- .hermes-column .hermes-column-3-->
	
	</div><!-- #widget-columns -->
	
	<?php } ?>
	
</div><!-- #main -->
	
<?php get_footer(); ?>