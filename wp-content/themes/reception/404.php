<?php get_header(); ?>

<div id="main" class="clearfix">

	<div id="content" class="clearfix">
	
		<div class="wrapper-content">

			<div class="hermes-page-intro">
				<h1 class="title-post"><?php _e('Page not found', 'reception'); ?></h1>
			</div><!-- .hermes-page-intro -->
			
			<div class="post-single clearfix">
	
				<p><?php _e( 'Apologies, but the requested page cannot be found. Perhaps searching will help find a related page.', 'reception' ); ?></p>
				
				<div class="cleaner">&nbsp;</div>
				
				<div class="divider divider-notop">&nbsp;</div>
				
				<h3 class="title-s"><?php _e( 'Browse Categories', 'reception' ); ?></h3>
				<ul>
					<?php wp_list_categories('title_li=&hierarchical=0&show_count=1'); ?>	
				</ul>
			
				<h3 class="title-s"><?php _e( 'Monthly Archives', 'reception' ); ?></h3>
				<ul>
					<?php wp_get_archives('type=monthly&show_post_count=1'); ?>	
				</ul>
				<div class="cleaner">&nbsp;</div>
				
			</div><!-- .post-single -->	

		</div><!-- .wrapper-content -->
	
	</div><!-- #content -->
	
	<?php get_sidebar(); ?>
	
</div><!-- #main -->

<?php get_footer(); ?>