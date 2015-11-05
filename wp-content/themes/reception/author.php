<?php get_header(); ?>

<div id="main" class="clearfix">

	<div id="content" class="clearfix">
	
		<div class="wrapper-content">

			<?php $curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author')); ?>
			<div class="hermes-page-intro">
				<h1 class="title-post"><?php _e('Posts by', 'reception');?> <span><?php echo $curauth->display_name; ?></span></h1>
			</div><!-- .hermes-page-intro -->
			
			<div class="divider">&nbsp;</div>
	
			<?php get_template_part('loop'); ?>
			
		</div><!-- .wrapper-content -->
	
	</div><!-- #content -->
	
	<?php get_sidebar(); ?>
	
</div><!-- #main -->

<?php get_footer(); ?>