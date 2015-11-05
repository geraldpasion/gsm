<?php if (get_theme_mod('reception_display_feat_pages') == 1) { ?>

<div class="widget clearfix">

	<?php if (get_theme_mod('reception_page_feat_1') != '' || get_theme_mod('reception_page_feat_2') != '' || get_theme_mod('reception_page_feat_3') != '') { ?>
	
	<ul class="featured-pages featured-pages-modern">

		<li class="featured-page featured-page-1">
		
			<?php 
			if (get_theme_mod('reception_page_feat_1')) {
			$hermes_loop = new WP_Query( array( 'page_id' => get_theme_mod('reception_page_feat_1') ) );
			while ( $hermes_loop->have_posts() ) : $hermes_loop->the_post(); global $post;
			?>
			
			<?php
			get_the_image( array( 'size' => 'reception-thumb-loop-gallery', 'width' => 340, 'height' => 220, 'before' => '<div class="post-cover">', 'after' => '</div><!-- end .post-cover -->' ) );
			?>

			<div class="post-content">
				<div class="post-content-wrapper">
					<h2 class="title-post"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'reception' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
				</div><!-- .post-content-wrapper -->
			</div><!-- .post-content -->
			
			<?php endwhile; } ?>
			
			<div class="cleaner">&nbsp;</div>
		
		</li><!-- .featured-page .featured-page-1 -->

		<li class="featured-page featured-page-2">
		
			<?php 
			if (get_theme_mod('reception_page_feat_2')) {
			$hermes_loop = new WP_Query( array( 'page_id' => get_theme_mod('reception_page_feat_2') ) );
			while ( $hermes_loop->have_posts() ) : $hermes_loop->the_post(); global $post;
			?>
			
			<?php
			get_the_image( array( 'size' => 'reception-thumb-loop-gallery', 'width' => 340, 'height' => 220, 'before' => '<div class="post-cover">', 'after' => '</div><!-- end .post-cover -->' ) );
			?>

			<div class="post-content">
				<div class="post-content-wrapper">
					<h2 class="title-post"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'reception' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
				</div><!-- .post-content-wrapper -->
			</div><!-- .post-content -->
			
			<?php endwhile; } ?>
			
			<div class="cleaner">&nbsp;</div>
		
		</li><!-- .featured-page .featured-page-2 -->
		
		<li class="featured-page featured-page-3">
		
			<?php 
			if (get_theme_mod('reception_page_feat_3')) {
			$hermes_loop = new WP_Query( array( 'page_id' => get_theme_mod('reception_page_feat_3') ) );
			while ( $hermes_loop->have_posts() ) : $hermes_loop->the_post(); global $post;
			?>
			
			<?php
			get_the_image( array( 'size' => 'reception-thumb-loop-gallery', 'width' => 340, 'height' => 220, 'before' => '<div class="post-cover">', 'after' => '</div><!-- end .post-cover -->' ) );
			?>

			<div class="post-content">
				<div class="post-content-wrapper">
					<h2 class="title-post"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'reception' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h2>
				</div><!-- .post-content-wrapper -->
			</div><!-- .post-content -->
			
			<?php endwhile; } ?>
			
			<div class="cleaner">&nbsp;</div>
		
		</li><!-- .featured-page .featured-page-3 -->
	</ul><!-- .featured-pages .featured-pages-modern -->
	
	<?php } ?>
	
</div><!-- .widget -->

<?php } ?>