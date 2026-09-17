<?php
require_once(get_template_directory() . '/functions/acf-fallback.php');
require_once(get_template_directory() . '/functions/init-blocks.php');
require_once(get_template_directory() . '/functions/block-variation.php');
require_once(get_template_directory() . '/functions/reusable_blocks-menu.php');
require_once(get_template_directory() . '/functions/megamenu.php');
require_once(get_template_directory() . '/functions/custom-post-type.php');
require_once(get_template_directory() . '/functions/editor-styles.php');
require_once(get_template_directory() . '/functions/theme-options.php');

/* Custom functions */

/* Remove completely comments */
require_once(get_template_directory() . '/functions/remove-comments.php');

/* Add block-editor-assets (metaboxes) */
require_once(get_template_directory() . '/functions/block-editor-assets.php');

/**
 * Theme setup.
 */
function theme_setup()
{

	register_nav_menus(
		array(
			'primary' => __('Primary Menu', 'siosm'),
			'burger' => __('Burger Menu', 'siosm'),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	add_image_size('wide', 1920);

	add_theme_support('custom-logo');
	add_theme_support('post-thumbnails');

	add_theme_support('align-wide');
	add_theme_support('wp-block-styles');

	remove_theme_support('core-block-patterns');

	add_theme_support('editor-styles');
	add_editor_style();
}

add_action('after_setup_theme', 'theme_setup');

function theme_enqueue_scripts()
{
	$theme = wp_get_theme();

	// Font Awesome 6 (Free)
	wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');

	wp_enqueue_style('siosm', get_stylesheet_directory_uri() . '/build/css/app.css', array('font-awesome'), $theme->get('Version'));

	$asset_file = get_stylesheet_directory() . '/build/js/app.asset.php';
	if (file_exists($asset_file)) {
		$assets = require($asset_file);
		wp_enqueue_script(
			'siosm',
			get_stylesheet_directory_uri() . '/build/js/app.js',
			$assets['dependencies'],
			$assets['version'],
			true
		);
	} else {
		wp_enqueue_script(
			'siosm',
			get_stylesheet_directory_uri() . '/build/js/app.js',
			array('jquery'),
			$theme->get('Version'),
			true
		);
	}
}

add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');



/**
 * Adds option 'li_class' to 'wp_nav_menu'.
 *
 * @param array  $classes String of classes.
 * @param object $item    The current item.
 * @param object $args    Holds the nav menu arguments.
 * @param int    $depth   Depth of the menu item.
 *
 * @return array
 */
function nav_menu_add_li_class($classes, $item, $args, $depth)
{
	$classes = (array) $classes;
	if (isset($args->li_class)) {
		$classes[] = $args->li_class;
	}

	if (isset($args->{"li_class_" . $depth})) {
		$classes[] = $args->{"li_class_" . $depth};
	}

	return $classes;
}

add_filter('nav_menu_css_class', 'nav_menu_add_li_class', 10, 4);

/**
 * Adds option 'submenu_class' to 'wp_nav_menu'.
 *
 * @param array  $classes Array of classes.
 * @param object $args    Holds the nav menu arguments.
 * @param int    $depth   Depth of the menu item.
 *
 * @return array
 */
function nav_menu_add_submenu_class($classes, $args, $depth)
{
	$classes = (array) $classes;
	if (isset($args->submenu_class)) {
		$classes[] = $args->submenu_class;
	}

	if (isset($args->{"submenu_class_" . $depth})) {
		$classes[] = $args->{"submenu_class_" . $depth};
	}

	return $classes;
}

add_filter('nav_menu_submenu_css_class', 'nav_menu_add_submenu_class', 10, 3);


/* Custom functions */

/* Remove "Privé" on title */
add_filter('private_title_format', 'removePrivatePrefix');
add_filter('protected_title_format', 'removePrivatePrefix');
function removePrivatePrefix($format)
{
	return '%s';
}

/* Beautify title of single page */
add_filter('get_the_archive_title', function ($title) {
	if (is_category()) {
		$title = single_cat_title('', false);
	} elseif (is_tax()) {
		$title = single_term_title('', false);
	} elseif (is_tag()) {
		$title = single_tag_title('', false);
	} elseif (is_author()) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	}

	return $title;
});


/* Hide admin-bar */
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar()
{
	if (!current_user_can('edit_posts') && !is_admin()) {
		show_admin_bar(false);
	}
}

/* Redirect user from wp-admin */
function wpse66094_no_admin_access()
{
	if (defined('DOING_AJAX') && DOING_AJAX) {
		return;
	}

	if (!current_user_can('edit_posts')) {
		wp_safe_redirect(home_url());
		exit;
	}
}
add_action('admin_init', 'wpse66094_no_admin_access', 100);



/* Remove password modification email */
remove_action('after_password_reset', 'wp_password_change_notification');




/* Add custom images size in dropdown choices */
add_filter('image_size_names_choose', 'my_custom_sizes');
function my_custom_sizes($sizes)
{
	return array_merge($sizes, array(
		'wide' => __('Wide'),
	));
}


/* Custom-excerpt */
function content($limit, $id)
{

	$content = explode(' ', get_the_content(null, true, $id), $limit);
	if (count($content) >= $limit) {
		array_pop($content);
		$content = implode(" ", $content) . ' […]';
	} else {
		$content = implode(" ", $content);
	}
	$content = preg_replace('/[.+]/', '', $content);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]>', $content);
	$content = strip_tags($content);
	return $content;
}
