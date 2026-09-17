<?php get_header(); ?>

<div class="container">

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
				<div class="py-10 entry-content">

					<?php
					$hide_title = get_post_meta(get_the_ID(), '_siosm_page_options', true);
					if (! $hide_title) :
					?>
						<header class="py-4">
							<h1 class="text-primary"><?php the_title(); ?></h1>
						</header>
					<?php endif; ?>

					<?php the_content(); ?>
				</div>
			</article>

		<?php endwhile; ?>
	<?php endif; ?>

</div>

<?php
get_footer();
