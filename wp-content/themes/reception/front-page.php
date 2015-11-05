<?php get_header(); ?>

<div id="main" class="clearfix">

	<?php if ( get_option( 'show_on_front' ) == 'posts' ) {
	
		include( get_home_template() );

	} elseif ( get_option ( 'page_on_front' ) != get_option ( 'page_for_posts' ) ) { 
	
		get_template_part('content', 'page');
	
	} else {
		
		include( get_home_template() );
		
	}
	?>
	
</div><!-- #main -->
	
<?php get_footer(); ?>