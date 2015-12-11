<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<link href="localhost/gsm/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Latest compiled and minified CSS -->

		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
		<![endif]-->
	<?php wp_head(); ?>
	<!-- Bootstrap -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


    
</head>

<body <?php body_class(); ?>>

<div id="container">

	<div class="wrapper">
	
		<header class="clearfix">
		
			<div id="logo">
				<?php if (get_theme_mod('reception_logo_upload') != '') { ?>
				<a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('description'); ?>">
					<img src="<?php echo esc_url(get_theme_mod('reception_logo_upload')); ?>" alt="<?php bloginfo('name'); ?>" />
				</a>
				<?php } else { ?>
				<span class="logo-title"><a href="<?php echo esc_url(home_url('/')); ?>" id="logo-anchor"><?php bloginfo('name'); ?></a></span>
				<p class="logo-tagline"><?php bloginfo('description'); ?></p>
				<?php } ?>
			</div><!-- end #logo -->
			
			<?php if (get_theme_mod('reception_display_contacts') == 1) { ?>
			<ul class="header-contacts">
				<?php if (get_theme_mod('reception_header_telephone') != '') { ?><li class="hermes-contact telephone"><span class="value"><?php echo get_theme_mod('reception_header_telephone'); ?></span></li><?php } ?>
				<?php if (get_theme_mod('reception_header_address') != '') { ?><li class="hermes-contact address"><span class="label"><?php echo get_theme_mod('reception_header_address'); ?></span></li><?php } ?>
				<?php if (get_theme_mod('reception_header_email') != '' && is_email(get_theme_mod('reception_header_email'))) { ?><li class="hermes-contact email"><span class="value"><a href="mailto:<?php echo get_theme_mod('reception_header_email'); ?>"><?php echo get_theme_mod('reception_header_email'); ?></a></span></li><?php } ?>
				<?php if (get_theme_mod('reception_header_telephone') == '' && get_theme_mod('reception_header_address') == '' && get_theme_mod('reception_header_email') == '') { ?>
				<li class="hermes-contact notice"><span class="value"><?php if (current_user_can('edit_theme_options')) { _e('Please set up your contact information on the Appearance > Customize page, the General tab.','reception'); } ?></span></li>
				<?php } ?>
			</ul><!-- .header-contact -->
			<?php } ?>
			
			<nav id="menu-main">

				<a class="btn_menu" id="toggle-main" href="#"></a>

				<?php if (has_nav_menu( 'primary' )) { 
					wp_nav_menu( array(
						'container' => '', 
						'container_class' => '', 
						'menu_class' => 'dropdown', 
						'menu_id' => 'menu-main-menu', 
						'menu_class' => 'navbar-nav dropdown sf-menu clearfix', 
						'menu_id' => 'menu-main-menu',
						'sort_column' => 'menu_order', 
						'theme_location' => 'primary', 
						'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>'
					) );
				}
				else
				{

					if (current_user_can('edit_theme_options')) {
						echo '<div id="menu-main-menu"><p class="hermes-notice">';
						echo __('Please set your Main Menu on this page:','reception') . '<a href="'.get_admin_url( '', 'nav-menus.php' ).'"> ' . __('Appearance > Menus','reception') . '</a>.<br>';
						echo __('Other options and theme elements can be set up on this page:','reception') . '<a href="'.get_admin_url( '', 'customize.php' ).'"> ' . __('Appearance > Customize','reception') . '</a>.';
						echo '</p></div>';
					}

				}
				?>

			</nav><!-- #menu-main -->
		

		

		</header>