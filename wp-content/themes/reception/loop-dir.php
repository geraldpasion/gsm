<?php 
global $hermes_options;
$child_of = $post->ID;

$loop = new WP_Query( array( 'post_parent' => $child_of, 'post_type' => 'page', 'nopaging' => 1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );

if ($loop->have_posts()) {
	$i = 0;
	?>

	<ul class="hermes-rooms hermes-posts-archive hermes-rooms-list">
	
	<?php while ( $loop->have_posts() ) : $loop->the_post(); $i++; 

		?>

		<li class="hermes-post hermes-room">
			
			<?php
			get_the_image( array( 'size' => 'reception-thumb-loop-main', 'width' => 200, 'height' => 200, 'before' => '<div class="post-cover">', 'after' => '</div><!-- end .post-cover -->' ) );
			?>

			<div class="post-content">
				<h2 class="title-post title-m"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'hermes_textdomain' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<p class="post-excerpt"><?php echo get_the_excerpt(); ?></p>
				<span class="read-more"><a href="<?php the_permalink(); ?>" rel="nofollow" class="read-more-anchor"><?php _e('Continue Reading','reception'); ?></a></span>
			</div><!-- .post-content -->
			<div class="cleaner">&nbsp;</div>
		</li><!-- .hermes-room -->

	<?php endwhile; ?>
	
	</ul><!-- end .hermes-rooms .hermes-rooms-list  -->
<?php 
} // if there are pages
wp_reset_query();
?>

<div class="cleaner">&nbsp;</div>