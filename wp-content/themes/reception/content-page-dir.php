<div id="content" class="clearfix">

	<div class="wrapper-content">

		<?php while (have_posts()) : the_post(); ?>
		
		<div class="hermes-page-intro">
			<h1 class="title-post"><?php the_title(); ?></h1>
			<?php edit_post_link( __('Edit page', 'reception'), '<p class="post-meta">', '</p>'); ?>
		</div><!-- .hermes-page-intro -->
		
		<div class="post-single clearfix">
		
			<?php the_content(); ?>
			
			<div class="cleaner">&nbsp;</div>
			
			<?php wp_link_pages(array('before' => '<p class="page-navigation"><strong>'.__('Pages', 'reception').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
				
		</div><!-- .post-single .clearfix -->
		
		<?php endwhile; ?>

		<?php get_template_part('loop-dir'); ?>

	</div><!-- .wrapper-content -->

</div><!-- #content -->

<?php get_sidebar(); ?>