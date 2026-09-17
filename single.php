<?php get_header(); ?>

<div class="container">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<?php
			$current_post_id = get_the_ID();
			$prev_post = get_previous_post();
			if ($prev_post) {
				$prev_post_id = $prev_post->ID;
			}
			$next_post = get_next_post();
			if ($next_post) {
				$next_post_id = $next_post->ID;
			}
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('entry-content'); ?>>

				<div class="wp-block-spacer" style="height:100px;"></div>

				<div class="grid grid-cols-12">

					<div class="col-span-9 lg:col-span-8">
						<h5 class="mb-6 text-primary"><?php _e('Dernière actualités', 'siosm') ?></h5>
						<h1 class="text-4xl lg:text-5xl"><?php the_title(); ?></h1>
						<time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished" class="text-gray-medium"><?php echo get_the_date(); ?></time>

						<div class="my-10">
							<?php the_content(); ?>
						</div>

						<div class="flex justify-between mt-20">
							<?php if (!empty($prev_post)): ?>
								<a class="flex flex-col items-start w-1/3 group" href="<?php echo get_permalink($prev_post_id); ?>">
									<div class="flex gap-x-4 items-center">
										<svg class="transition-all duration-300 rotate-180 group-hover:-translate-x-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path class="stroke-primary" d="M3 12H21M21 12L14 5M21 12L14 19" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
										</svg>
										<div class="flex flex-col leading-none text-primary">
											<span><?php _e('Article', 'siosm') ?></span>
											<span><?php _e('précédent', 'siosm') ?></span>
										</div>
									</div>
									<h4 class="mt-4 text-base leading-tight text-gray-medium"><?php echo get_the_title($prev_post_id); ?></h4>
								</a>
							<?php endif; ?>
							<?php if (!empty($next_post)): ?>
								<a class="flex flex-col items-end w-1/3 group" href="<?php echo get_permalink($next_post_id); ?>">
									<div class="flex gap-x-4 items-center">
										<div class="flex flex-col leading-none text-right text-primary">
											<span><?php _e('Article', 'siosm') ?></span>
											<span><?php _e('suivant', 'siosm') ?></span>
										</div>
										<svg class="transition-all duration-300 group-hover:translate-x-3" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path class="stroke-primary" d="M3 12H21M21 12L14 5M21 12L14 19" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
										</svg>

									</div>
									<h4 class="mt-4 text-base leading-tight text-right text-gray-medium"><?php echo get_the_title($next_post_id); ?></h4>
								</a>
							<?php endif; ?>
						</div>
					</div>

					<div class="flex col-span-1 justify-center">
						<span class="flex w-[2px] h-full bg-black/10"></span>
					</div>

					<div class="col-span-2 lg:col-span-3">
						<?php echo get_template_part('app/ui/sidebar', 'last-news', array('current_post_id' => $current_post_id)); ?>
					</div>
				</div>

			</article>
		<?php endwhile; ?>
	<?php endif; ?>
</div>

<?php
get_footer();
