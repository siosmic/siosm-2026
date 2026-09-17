<?php

/**
 * Slider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'last_news-' . $block['id'];
if (!empty($block['anchor'])) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'display_news';
if (!empty($block['className'])) {
	$className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
	$className .= ' align' . $block['align'];
}
if ($is_preview == 1) {
	$className .= ' is-admin';
}
wp_enqueue_script('slick', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '', false);
wp_enqueue_style('slick', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1', 'all');

$col_number = get_field('news_col_number');
$news_to_show = get_field('news_to_show');
$news = get_posts(array(
	'post_per_page' => -1,
	'post_type' => 'post'
));
?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> flex flex-col items-start flex-wrap">
	<?php if ($news) : ?>
		<div class="nav-arrows nav-arrows-news"></div>
		<div class="w-full slider-news">
			<?php foreach ($news as $news_obj) : ?>

				<?php
				$news_id = $news_obj->ID;
				if (get_field('direct_link', $news_id)) {
					$news_link = get_field('direct_link', $news_id);
				} else {
					$news_link = get_permalink($news_id);
				}
				?>
				<div <?php post_class('slide-news p-4 w-[300px]', $news_id) ?>>
					<?php if (is_array($news_link)) : ?>
						<a href="<?php echo $news_link['url']; ?>" target="<?php echo $news_link['target']; ?>">
						<?php else: ?>
							<a href="<?php echo $news_link; ?>">
							<?php endif; ?>
							<div class="overflow-hidden mb-6 w-full h-40 rounded-lg lg:h-80">
								<?php if (get_the_post_thumbnail($news_id)) : ?>
									<img src="<?php echo get_the_post_thumbnail_url($news_id, 'large'); ?>" width="100%" alt="post-thumbnail" class="object-cover w-full h-full">
								<?php endif; ?>
							</div>
							<div class="flex flex-col">
								<div class="mb-1 text-gray-medium">
									<?php
									if (get_field('event_date', $news_id)) {
										$event_date = get_field('event_date', $news_id);
										$event_date = strtotime($event_date);
										$event_date_day = date_i18n('d F', $event_date);
										$event_date_year = date_i18n('Y', $event_date);
									} else {
										$event_date_day = get_the_date('d F', $news_id);
										$event_date_year = get_the_date('Y', $news_id);
									}
									?>
									<span class="day"><?php echo $event_date_day; ?></span>
									<span class="month_year"><?php echo $event_date_year; ?></span>
								</div>
								<h4 class="mb-3 leading-tight has-primary-color"><?php echo get_the_title($news_id); ?></h4>
								<p class="hidden text-sm md:inline-flex">
									<?php if (has_excerpt($news_id)) {
										echo get_the_excerpt($news_id);
									} else {
										echo content(15, $news_id);
									} ?>
								</p>
								<i class="fal fa-long-arrow-right"></i>
							</div>
							</a>
				</div>


			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
<script>
	jQuery(document).ready(function($) {
		$('.slider-news').each(function() {
			$(this).slick({
				slidesToScroll: 1,
				slidesToShow: <?php echo $col_number ? $col_number : '3' ?>,
				autoplay: false,
				autoplaySpeed: 3500,
				draggable: false,
				infinite: false,
				variableWidth: false,
				dots: false,
				arrows: true,
				appendArrows: '.nav-arrows-news',
				prevArrow: '<svg class="fill-primary slick-prev" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M73.4 297.4C60.9 309.9 60.9 330.2 73.4 342.7L233.4 502.7C245.9 515.2 266.2 515.2 278.7 502.7C291.2 490.2 291.2 469.9 278.7 457.4L173.3 352L544 352C561.7 352 576 337.7 576 320C576 302.3 561.7 288 544 288L173.3 288L278.7 182.6C291.2 170.1 291.2 149.8 278.7 137.3C266.2 124.8 245.9 124.8 233.4 137.3L73.4 297.3z"/></svg>',
				nextArrow: '<svg class="fill-primary slick-next" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M566.6 342.6C579.1 330.1 579.1 309.8 566.6 297.3L406.6 137.3C394.1 124.8 373.8 124.8 361.3 137.3C348.8 149.8 348.8 170.1 361.3 182.6L466.7 288L96 288C78.3 288 64 302.3 64 320C64 337.7 78.3 352 96 352L466.7 352L361.3 457.4C348.8 469.9 348.8 490.2 361.3 502.7C373.8 515.2 394.1 515.2 406.6 502.7L566.6 342.7z"/></svg>',
				slide: '.slide-news',
				responsive: [{
						breakpoint: 1024,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 2
						}
					},
					{
						breakpoint: 480,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 2
						}
					}
				]
			});
		});

	});
</script>