<?php get_header(); ?>

<div id="main" class="clearfix">
	
	<div id="content" class="clearfix">
	
		<div class="wrapper-content">

			<?php get_template_part('loop', 'archives'); ?>

		</div><!-- .wrapper-content -->
	
	</div><!-- #content -->
	
	<?php get_sidebar(); ?>
	
</div><!-- #main -->
	
<?php get_footer(); ?>