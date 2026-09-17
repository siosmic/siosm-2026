</main>
</div>



<?php
	$footer_block_id = get_field("footer_block", "option");
	$footer_block = get_post($footer_block_id)->post_content;
?>
<footer class="footer" role="contentinfo">
	<div class="container">
		<?php if (get_field("footer_block", "option")) :
			$post_id = get_field("footer_block", "option");
			$header = get_post($post_id);
			setup_postdata($header);
			echo the_content();
			wp_reset_postdata();
		endif; ?>
	</div>
</footer>


<footer class="copyright" role="contentinfo">
	<div class="container py-4 text-xs">
		&copy; Copyright <?php echo date_i18n('Y'); ?> - <?php echo get_bloginfo('name'); ?>
	</div>
</footer>

</div>
<?php wp_footer(); ?>
</body>

</html>