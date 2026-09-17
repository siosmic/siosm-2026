<?php
if (!isset($args['current_post_id'])) {
   $current_post_id = get_the_ID();
} else {
   $current_post_id = $args['current_post_id'];
}
$last_news = new WP_Query(array(
   'post_type' => 'post',
   'posts_per_page' => 3,
   'post__not_in' => array($current_post_id),
   'orderby' => 'date',
   'order' => 'DESC'
));
?>
<h2 class="mb-5 text-2xl leading-tight lg:mb-10 lg:text-3xl"><?php _e('Autres actualités', 'siosm') ?></h2>
<?php if ($last_news->have_posts()) : ?>
   <div class="flex flex-col gap-2 lg:gap-4">
      <?php while ($last_news->have_posts()) : $last_news->the_post(); ?>

         <a class="w-[calc(100%_+_(1rem_*_2))] -mx-4 flex flex-col p-2 lg:p-4 transition-all duration-300 rounded-lg hover:bg-gray-light" href="<?php the_permalink(); ?>">
            <time datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished" class="mb-1 lg:mb-2 text-[13px] lg:text-sm text-gray-medium"><?php echo get_the_date(); ?></time>
            <h4 class="text-[15px] leading-tight lg:text-base text-primary"><?php the_title(); ?></h4>
            <p class="mb-0 text-[13px] lg:text-sm"><?php echo content(20, get_the_ID()); ?></p>
         </a>

      <?php endwhile; ?>
      <?php wp_reset_postdata(); ?>
   </div>
<?php else : ?>
   <p><?php _e('Aucune autre actualité pour le moment.', 'siosm'); ?></p>
<?php endif; ?>