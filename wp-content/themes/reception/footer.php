		<footer>
		
			<p class="hermes-credit"><?php _e('Theme by', 'reception'); ?> <a href="http://www.hermesthemes.com" target="_blank">HermesThemes</a></p>
			<?php $copyright_default = __('Copyright &copy; ','reception') . date("Y",time()) . ' ' . get_bloginfo('name') . '. ' . __('All Rights Reserved', 'reception'); ?>
			<p class="copy"><?php echo esc_attr(get_theme_mod( 'hermes_copyright_text', $copyright_default )); ?></p>
		
		</footer>

	</div><!-- .wrapper -->

</div><!-- end #container -->

<?php 
wp_footer(); 
wp_reset_query();
?>
</body>
</html>