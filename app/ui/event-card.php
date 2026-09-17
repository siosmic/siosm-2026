<?php

/**
 * Template Part: Event Card Component (Infomaniak)
 *
 * @param array $args['event'] Données de l'événement Infomaniak
 */

if (empty($args['event'])) {
	return;
}

$event              = $args['event'];
$has_multiple_dates = count($event['occurrences']) > 1;
$occurrences        = $event['occurrences'] ?? array();
$first_occ          = ! empty($occurrences) ? $occurrences[0] : null;
$card_id            = 'event-card-' . esc_attr($event['id']);
?>

<div id="<?php echo esc_attr($card_id); ?>" class="flex flex-col gap-6 p-6 bg-white rounded-none border border-gray-200 md:flex-row lg:gap-8 md:p-8">

	<!-- Image carrée à gauche -->
	<div class="overflow-hidden relative flex-shrink-0 w-full bg-gray-100 md:w-56 lg:w-64 aspect-square">
		<?php if (! empty($event['image'])) : ?>
			<img
				src="<?php echo esc_url($event['image']); ?>"
				alt="<?php echo esc_attr($event['name']); ?>"
				class="object-cover w-full h-full"
				loading="lazy" />
		<?php else : ?>
			<div class="flex justify-center items-center w-full h-full text-3xl text-gray-400">
				<i class="fa-solid fa-ticket"></i>
			</div>
		<?php endif; ?>

		<?php if (! empty($event['category'])) : ?>
			<span class="absolute top-3 left-3 px-3 py-1 text-xs font-bold tracking-wider uppercase bg-white shadow-sm text-primary">
				<?php echo esc_html($event['category']); ?>
			</span>
		<?php endif; ?>
	</div>

	<!-- Infos à droite -->
	<div class="flex flex-col flex-1 justify-between">
		<div>
			<!-- Titre -->
			<h2 class="mb-2 text-2xl font-bold leading-tight text-gray-900 lg:text-3xl">
				<?php echo esc_html($event['name']); ?>
			</h2>

			<!-- Lieu -->
			<?php if (! empty($event['location'])) : ?>
				<p class="flex gap-2 items-center mb-4 text-sm text-gray-600">
					<i class="fa-solid fa-location-dot text-primary"></i>
					<span><?php echo esc_html($event['location']); ?></span>
				</p>
			<?php endif; ?>

			<!-- Description -->
			<?php if (! empty($event['description'])) : ?>
				<div class="mb-6 text-sm leading-relaxed text-gray-600">
					<?php echo wp_kses_post($event['description']); ?>
				</div>
			<?php endif; ?>

			<!-- Liste des dates & séances avec bouton par rangée -->
			<div class="mb-6">
				<h4 class="mb-3 text-xs font-bold tracking-wider text-gray-700 uppercase">
					<?php echo $has_multiple_dates ? __('Dates & Séances disponibles :', 'siosm') : __('Date de l\'événement :', 'siosm'); ?>
				</h4>

				<div class="flex flex-col gap-3">
					<?php foreach ($occurrences as $idx => $occ) : ?>
						<?php
						$date_str     = ! empty($occ['start_ts']) ? wp_date('l d F Y à H:i', $occ['start_ts']) : __('Date à confirmer', 'siosm');
						$is_sold_out  = ($occ['status'] === 'sold_out');
						$direct_url   = ! empty($occ['direct_url']) ? $occ['direct_url'] : $event['global_url'];
						$tickets_left = $occ['tickets_available'];
						?>
						<div class="flex flex-col gap-4 justify-between p-4 bg-gray-50 border border-gray-100 sm:flex-row sm:items-center">

							<!-- Date et Places -->
							<div class="flex-1">
								<div class="flex gap-2 items-center text-sm font-semibold text-gray-900">
									<i class="fa-regular fa-calendar-days text-primary"></i>
									<span><?php echo esc_html($date_str); ?></span>
								</div>

								<div class="mt-1 text-xs">
									<?php if ($is_sold_out) : ?>
										<span class="font-semibold text-red-600">[<?php _e('Complet', 'siosm'); ?>]</span>
									<?php elseif ($tickets_left !== null && $tickets_left > 0) : ?>
										<span class="font-medium text-emerald-700">
											<i class="mr-1 text-emerald-600 fa-solid fa-bolt"></i><?php echo esc_html($tickets_left); ?> <?php _e('place(s) restante(s)', 'siosm'); ?>
										</span>
									<?php else : ?>
										<span class="text-gray-500"><?php _e('Places disponibles', 'siosm'); ?></span>
									<?php endif; ?>
								</div>
							</div>

							<!-- Bouton individuel d'inscription pour cette date -->
							<div class="flex-shrink-0 wp-block-buttons">
								<div class="wp-block-button">
									<a
										href="<?php echo esc_url($direct_url); ?>"
										target="_blank"
										rel="noopener noreferrer"
										class="wp-block-button__link text-xs !py-2 !px-5 <?php echo $is_sold_out ? 'opacity-50 pointer-events-none' : ''; ?>">
										<?php echo $is_sold_out ? __('Complet', 'siosm') : __('S\'inscrire', 'siosm'); ?>
									</a>
								</div>
							</div>

						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<!-- Footer avec Tarif -->
		<div class="flex justify-between items-center pt-4 mt-2 border-t border-gray-100">
			<span class="text-xs tracking-wider text-gray-500 uppercase"><?php _e('Tarif indicatif :', 'siosm'); ?></span>
			<span class="text-base font-bold text-gray-900"><?php echo esc_html($event['pricing_label']); ?></span>
		</div>

	</div>

</div>