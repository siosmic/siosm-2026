<?php
/**
 * Template Name: Liste des événements
 *
 * Affiche automatiquement les événements publics récupérés en temps réel via l'API Infomaniak Ticketing.
 */

get_header();

// Récupération des événements publics regroupés par événement (avec filtrage de visibilité strict)
$events     = Infomaniak_Ticketing::get_grouped_events(false, true);
$hide_title = function_exists('get_field') ? get_field('hide_title') : false;
?>

<div class="container mx-auto px-4 py-12">
	<div class="entry-content max-w-6xl mx-auto">

		<?php if (! $hide_title) : ?>
			<header class="text-center mb-12">
				<h1 class="text-3xl lg:text-5xl font-bold text-primary mb-4">
					<?php the_title(); ?>
				</h1>
				<div class="w-16 h-1 bg-primary mx-auto rounded-full"></div>
			</header>
		<?php endif; ?>

		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<?php if (get_the_content()) : ?>
					<div class="prose max-w-none mb-12 text-center text-gray-600 text-lg">
						<?php the_content(); ?>
					</div>
				<?php endif; ?>
			<?php endwhile; ?>
		<?php endif; ?>

		<?php if (is_wp_error($events)) : ?>
			<div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl text-center">
				<p class="font-medium"><?php _e('Impossible de charger la liste des événements pour le moment.', 'siosm'); ?></p>
			</div>
		<?php elseif (empty($events)) : ?>
			<div class="bg-gray-50 border border-gray-200 rounded-2xl p-12 text-center my-8">
				<i class="fa-solid fa-ticket text-4xl text-primary mb-4 block"></i>
				<h3 class="text-xl font-bold text-gray-800 mb-2"><?php _e('Aucun événement disponible actuellement', 'siosm'); ?></h3>
				<p class="text-gray-500 text-sm max-w-md mx-auto">
					<?php _e('Nos prochains événements seront bientôt publiés. N\'hésitez pas à revenir consulter cette page ultérieurement.', 'siosm'); ?>
				</p>
			</div>
		<?php else : ?>
			<div class="flex flex-col gap-8">
				<?php foreach ($events as $event) : ?>
					<?php get_template_part('app/ui/event-card', null, array('event' => $event)); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</div>

<?php get_footer(); ?>