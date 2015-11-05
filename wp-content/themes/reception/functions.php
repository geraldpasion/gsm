<?php			

if ( ! isset( $content_width ) ) $content_width = 710;

/* Disable PHP error reporting for notices, leave only the important ones 
================================== */

// error_reporting(E_ERROR | E_PARSE);

/* Add javascripts and CSS used by the theme 
================================== */

function reception_scripts_styles() {

	// Loads our main stylesheet
	wp_enqueue_style( 'reception-style', get_stylesheet_uri(), array(), '2015-02-07' );
	
	if (! is_admin()) {

		wp_enqueue_script(
			'superfish',
			get_template_directory_uri() . '/js/superfish.js',
			array('jquery'),
			null
		);
		
		wp_enqueue_script(
			'reception-init',
			get_template_directory_uri() . '/js/init.js',
			array('jquery'),
			null
		);

		wp_enqueue_script(
			'flexslider',
			get_template_directory_uri() . '/js/jquery.flexslider.js',
			array('jquery'),
			null
		);
		
		if ( is_front_page() || is_singular() && wp_attachment_is_image() ) {
			wp_enqueue_script(
				'reception-init-slider',
				get_template_directory_uri() . '/js/init-slider.js',
				array('jquery','flexslider'),
				null
			);
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

		// Loads our default Google Webfont
		wp_enqueue_style( 'reception-webfonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:400,700|Roboto:300,400,400italic,700,700italic', array() );

	}

}
add_action('wp_enqueue_scripts', 'reception_scripts_styles');

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Reception supports.
 *
 * @return void
 */

function reception_setup() {

	/* Register Thumbnails Size 
	================================== */
	
	add_image_size( 'reception-thumb-slideshow', 1080, 450, true );
	add_image_size( 'reception-thumb-loop-gallery', 340, 220, true );
	add_image_size( 'reception-thumb-loop-main', 200, 200, true );
	
	/* 	Register Custom Menu 
	==================================== */
	
	register_nav_menu('primary', 'Main Menu');

	/* Add support for Localization
	==================================== */
	
	load_theme_textdomain( 'reception', get_template_directory() . '/languages' );
	
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable($locale_file) )
		require_once($locale_file);
	
	/* Add support for Custom Background 
	==================================== */
	
	add_theme_support( 'custom-background' );
	
	/* Add support for post and comment RSS feed links in <head>
	==================================== */
	
	add_theme_support( 'automatic-feed-links' ); 
	
	/* Add support for WP 4.1 title tag
	==================================== */
	
	add_theme_support( 'title-tag' );

	if ( ! function_exists( '_wp_render_title_tag' ) ) :
	    function reception_render_title() {
	?>
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php
	    }
	    add_action( 'wp_head', 'reception_render_title' );
	endif;

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css' ) );

}

add_action( 'after_setup_theme', 'reception_setup' );

/**
 * Registers one widget area.
 *
 * @return void
 */

function reception_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Sidebar', 'reception' ),
		'id'            => 'sidebar',
		'description'   => __( 'Appears in the narrow column of the site.', 'reception' ),
		'before_widget' => '<div class="widget %2$s" id="%1$s">',
		'after_widget'  => '<div class="cleaner">&nbsp;</div></div>',
		'before_title'  => '<p class="title-widget title-s">',
		'after_title'   => '</p>',
	) );

	register_sidebar( array(
		'name'          => __( 'Home: Column 1', 'reception' ),
		'id'            => 'home-col-1',
		'description'   => __( 'Appears only on the homepage of the site.', 'reception' ),
		'before_widget' => '<div class="widget %2$s" id="%1$s">',
		'after_widget'  => '<div class="cleaner">&nbsp;</div></div>',
		'before_title'  => '<p class="title-widget">',
		'after_title'   => '</p>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Home: Column 2', 'reception' ),
		'id'            => 'home-col-2',
		'description'   => __( 'Appears only on the homepage of the site.', 'reception' ),
		'before_widget' => '<div class="widget %2$s" id="%1$s">',
		'after_widget'  => '<div class="cleaner">&nbsp;</div></div>',
		'before_title'  => '<p class="title-widget">',
		'after_title'   => '</p>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Home: Column 3', 'reception' ),
		'id'            => 'home-col-3',
		'description'   => __( 'Appears only on the homepage of the site.', 'reception' ),
		'before_widget' => '<div class="widget %2$s" id="%1$s">',
		'after_widget'  => '<div class="cleaner">&nbsp;</div></div>',
		'before_title'  => '<p class="title-widget">',
		'after_title'   => '</p>',
	) );

}

add_action( 'widgets_init', 'reception_widgets_init' );

/* Enable Excerpts for Static Pages
==================================== */

add_action( 'init', 'reception_excerpts_for_pages' );

function reception_excerpts_for_pages() {
	add_post_type_support( 'page', 'excerpt' );
}

/* Custom Excerpt Length
==================================== */

function reception_new_excerpt_length($length) {
	return 35;
}
add_filter('excerpt_length', 'reception_new_excerpt_length');

/* Replace invalid ellipsis from excerpts
==================================== */

function reception_excerpt($text)
{
   return str_replace('[...]', '...', $text);
}
add_filter('the_excerpt', 'reception_excerpt');

/* Reset [gallery] shortcode styles						
==================================== */

add_filter('gallery_style', create_function('$a', 'return "<div class=\'gallery\'>";'));


/* Custom Pagination for the Blog page template						
==================================== */

function reception_pagination($numpages = '', $pagerange = '', $paged='') {

	if (empty($pagerange)) {
		$pagerange = 2;
	}
	
	/**
	* This first part of our function is a fallback
	* for custom pagination inside a regular loop that
	* uses the global $paged and global $wp_query variables.
	* 
	* It's good because we can now override default pagination
	* in our theme, and use this function in default quries
	* and custom queries.
	*/
	global $paged;
	if (empty($paged)) {
		$paged = 1;
	}
	if ($numpages == '') {
		global $wp_query;
		$numpages = $wp_query->max_num_pages;
		if(!$numpages) {
			$numpages = 1;
		}
	}
	
	/** 
	* We construct the pagination arguments to enter into our paginate_links
	* function. 
	*/
	$pagination_args = array(
		'base'            => get_pagenum_link(1) . '%_%',
		'format'          => 'page/%#%',
		'total'           => $numpages,
		'current'         => $paged,
		'show_all'        => False,
		'end_size'        => 1,
		'mid_size'        => $pagerange,
		'prev_next'       => True,
		'prev_text'       => __('&laquo;','reception'),
		'next_text'       => __('&raquo;','reception'),
		'type'            => 'plain',
		'add_args'        => false,
		'add_fragment'    => ''
	);
	
	$paginate_links = paginate_links($pagination_args);
	
	if ($paginate_links) {
		echo "<nav class='custom-pagination'>";
		echo "<span class='page-numbers page-num'>";
		echo __('Page','reception') . " $paged " . __('of','reception') . " $numpages ";
		echo "</span>";
		echo $paginate_links;
		echo "</nav>";
	}

}

/* Comments Custom Template						
==================================== */

function reception_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
			?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<div id="comment-<?php comment_ID(); ?>">
				
					<div class="comment-author vcard">
						<?php echo get_avatar( $comment, 50 ); ?>

						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div><!-- .reply -->

					</div><!-- .comment-author .vcard -->
	
					<div class="comment-body">
	
						<?php printf( __( '%s', 'reception' ), sprintf( '<cite class="comment-author-name">%s</cite>', get_comment_author_link() ) ); ?>
						<span class="comment-timestamp"><?php printf( __('%s at %s', 'reception'), get_comment_date(), get_comment_time()); ?></span><?php edit_comment_link( __( 'Edit', 'reception' ), ' <span class="comment-bullet">&#8226;</span> ' ); ?>
	
						<div class="comment-content">
						<?php if ( $comment->comment_approved == '0' ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'reception' ); ?></p>
						<?php endif; ?>
	
						<?php comment_text(); ?>
						</div><!-- .comment-content -->

					</div><!-- .comment-body -->
	
					<div class="cleaner">&nbsp;</div>
				
				</div><!-- #comment-<?php comment_ID(); ?> -->
		
			</li><!-- #li-comment-<?php comment_ID(); ?> -->
		
			<?php
		break;

		case 'pingback'  :
		case 'trackback' :
			?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<p><?php _e( 'Pingback:', 'reception' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'reception' ), ' ' ); ?></p>
			</li>
			<?php
		break;
	
	endswitch;
}

/* Add theme customizer to <head> 
================================== */

function reception_customizer_head() {

	/*
	This block refers to the functionality of the Appearance > Customize screen.
	*/
	
	$hermes_font_main = esc_attr(get_theme_mod( 'reception_font_main' ));
	$hermes_color_wrapper = esc_attr(get_theme_mod( 'reception_color_wrapper' ));
	$hermes_color_menu = esc_attr(get_theme_mod( 'reception_color_menu' ));
	$hermes_color_contacts = esc_attr(get_theme_mod( 'reception_color_contacts' ));
	$hermes_color_body = esc_attr(get_theme_mod( 'reception_color_body' ));
	$hermes_color_link = esc_attr(get_theme_mod( 'reception_color_link' ));
	$hermes_color_link_hover = esc_attr(get_theme_mod( 'reception_color_link_hover' ));
	
	if( $hermes_font_main != '' || $hermes_color_wrapper != '' || $hermes_color_menu != '' || $hermes_color_contacts != '' || $hermes_color_body != '' || $hermes_color_link != '' || $hermes_color_link_hover != '') {
		echo '<style type="text/css">';
		if (($hermes_font_main != '') && ($hermes_font_main != 'default')) {
			echo 'body { font-family: '.$hermes_font_main.'; } ';
		}
		if ($hermes_color_wrapper != '') {
			echo 'div.wrapper { background-color: '.$hermes_color_wrapper.'; } ';
		}
		if ($hermes_color_menu != '') {
			echo '#menu-main { background-color: '.$hermes_color_menu.'; } ';
		}
		if ($hermes_color_contacts != '') {
			echo '.header-contacts { background-color: '.$hermes_color_contacts.'; } ';
		}
		if ($hermes_color_body != '') {
			echo 'body { color: '.$hermes_color_body.'; } ';
		}
		if ($hermes_color_link != '') {
			echo 'a { color: '.$hermes_color_link.'; } ';
		}
		if ($hermes_color_link_hover != '') {
			echo 'a:hover, a:focus { color: '.$hermes_color_link_hover.'; } ';
		}

		echo '</style>';
	}

}
add_action('wp_head', 'reception_customizer_head');

/* Include WordPress Theme Customizer
================================== */

require_once('hermes-admin/hermes-customizer.php');

/* Include Additional Options and Components
================================== */

if ( !function_exists( 'get_the_image' ) ) {
	require_once('hermes-admin/components/get-the-image.php');
}
require_once('hermes-admin/components/wpml.php'); // enables support for WPML plug-in
require_once('hermes-admin/post-options.php');