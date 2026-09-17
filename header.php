<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>

<body <?php body_class('bg-white antialiased font-poppins'); ?>>

	<div id="page" class="">

		<div
			class="fixed top-0 right-0 bottom-0 left-0 z-20 w-full h-full bg-white opacity-0 transition-all duration-500 ease-out pointer-events-none overlay">
		</div>

		<?php
		/* If menu "burger" has elements assigned */
		$menu_locations = get_nav_menu_locations();
		if (isset($menu_locations['burger']) && $menu_locations['burger'] != '') {
			get_template_part('app/ui/offcanvas', 'menu');
		}
		?>


		<header class="sticky top-0 z-20 pt-2 pb-4 w-full bg-white shadow-md transition-all duration-300">

			<div class="container flex justify-end items-center m-auto">
				<a href="<?php echo home_url(); ?>" class="pt-2 mr-auto">
					<?php //get_template_part('app/ui/logo', 'full'); 
					?>
					<span class="text-2xl font-bold"><?php echo get_bloginfo('name') ?></span>
				</a>


				<div class="flex flex-col gap-y-6 grow">

					<div class="flex justify-end items-center">
						<?php wp_nav_menu(
							array(
								'container_id' => 'primary',
								'container_class' => '',
								'menu_class' => 'menu dropdown hidden lg:flex gap-6',
								'theme_location' => 'primary',
								'li_class' => '',
								'fallback_cb' => false,
							)
						); ?>



						<?php /* Burger menu */
						$menu_locations = get_nav_menu_locations();
						if (isset($menu_locations['burger']) && $menu_locations['burger'] != '') : ?>
							<div class="ml-4 md:ml-6 burger-menu">
								<span class="rounded-full bg-primary"></span>
								<span class="rounded-full bg-primary"></span>
								<span class="rounded-full bg-primary"></span>
							</div>
						<?php endif; ?>
					</div>
				</div>

			</div>

		</header>
		<?php if (function_exists('siosm_render_megamenus')) siosm_render_megamenus(); ?>

		<div id="content" class="site-content">
			<main>