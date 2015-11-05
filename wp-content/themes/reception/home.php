<?php get_header(); ?>

<div id="main" class="clearfix">

	<div id="content" class="clearfix">

		<div class="wrapper-content">

			<?php
			if ( get_option ( 'page_for_posts' ) != 0 ) {
			
				$homepage = get_post (get_option ( 'page_for_posts' ) );
				?>
				
				<div class="hermes-page-intro">
				<h1 class="title-post"><?php print $homepage->post_title; ?></h1>
				</div><!-- .hermes-page-intro -->
			
			<?php } ?>

			<?php get_template_part('loop', 'archives'); ?>

		</div><!-- .wrapper-content -->
	
	</div><!-- #content -->
	
	<?php get_sidebar(); ?>
	
</div><!-- #main -->

<?php get_footer(); ?>