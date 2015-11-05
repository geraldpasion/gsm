<?php get_header(); ?>

<div id="main" class="clearfix">

	<div id="content" class="clearfix">
	
		<div class="wrapper-content">

			<div class="hermes-page-intro">
				<h1 class="title-post"><?php single_cat_title(); ?></h1>
			</div><!-- .hermes-page-intro -->
			
			<?php if (category_description()) { ?>
			<div class="post-single category-description">
			
				<?php echo category_description(); ?>
				
				<div class="cleaner">&nbsp;</div>
				
			</div><!-- .post-single -->
	
			<?php } ?>

			<div class="divider">&nbsp;</div>

			<?php get_template_part('loop'); ?>	
			
		</div><!-- .wrapper-content -->
	
	</div><!-- #content -->
	
	<?php get_sidebar(); ?>
	
</div><!-- #main -->

<?php get_footer(); ?>