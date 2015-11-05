<?php
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

$custom_args = array(
	'post_type' => 'post',
	'posts_per_page' => 4,
	'paged' => $paged
);

$reception_query = new WP_Query( $custom_args ); ?>

<?php if ( $reception_query->have_posts() ) : ?>
	
	<ul class="hermes-posts hermes-posts-archive">
		
		<?php while ( $reception_query->have_posts() ) : $reception_query->the_post(); ?>
		
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

	<?php
	if ( function_exists('reception_pagination') ) {
		reception_pagination($reception_query->max_num_pages, "", $paged);
	}
	?>
	
	<?php wp_reset_postdata(); ?>

<?php endif; ?>