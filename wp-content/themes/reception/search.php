<?php get_header(); ?>

<div id="main" class="clearfix">

	<div id="content" class="clearfix">
	
		<div class="wrapper-content">

			<div class="hermes-page-intro">
				<h1 class="title-post"><?php _e('Search Results for', 'reception');?>: <strong><?php the_search_query(); ?></strong></h1>
			</div><!-- .hermes-page-intro -->
			
			<div class="divider">&nbsp;</div>
	
			<?php get_template_part('loop'); ?>
			
		</div><!-- .wrapper-content -->
	
	</div><!-- #content -->
	
	<?php get_sidebar(); ?>
	
</div><!-- #main -->

<?php get_footer(); ?>