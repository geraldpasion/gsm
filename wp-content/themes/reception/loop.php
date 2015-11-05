<ul class="hermes-posts hermes-posts-archive">
	
	<?php while (have_posts()) : the_post(); unset($prev); $m++; ?>
	<li <?php post_class('hermes-post'); ?>>

		<?php
		get_the_image( array( 'size' => 'reception-thumb-loop-main', 'width' => 200, 'height' => 200, 'before' => '<div class="post-cover">', 'after' => '</div><!-- end .post-cover -->' ) );
		?>
		
		<div class="post-content">
			<h2 class="title-post"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'reception' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
			<p class="post-meta"><time datetime="<?php echo get_the_date('c'); ?>" pubdate><?php echo get_the_date(); ?></time> / <span class="category"><?php the_category(', '); ?></span></p>
			<p class="post-excerpt"><?php echo get_the_excerpt(); ?></p>
			<span class="read-more"><a href="<?php the_permalink(); ?>" rel="nofollow" class="read-more-anchor"><?php _e('Continue Reading','reception'); ?></a></span>
		</div><!-- end .post-content -->

		<div class="cleaner">&nbsp;</div>
		
	</li><!-- end .hermes-post -->
	<?php endwhile; ?>
	
</ul><!-- end .hermes-posts -->

<?php get_template_part( 'pagination'); ?>