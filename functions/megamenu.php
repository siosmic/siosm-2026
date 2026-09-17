<?php

/**
 * Mega Menu connected to Dynamic Blocks (wp_block).
 *
 * Provides:
 * 1. A custom meta box in Appearance > Menus to create and add mega menu items.
 * 2. Ability to select/change connected dynamic block inside each menu item.
 * 3. Frontend rendering of the dynamic block inside a modern mega menu panel on hover.
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * 1. Register Meta Box in Appearance > Menus.
 */
function siosm_register_megamenu_nav_menu_metabox()
{
	add_meta_box(
		'siosm-megamenu-metabox',
		__('Mega Menu', 'siosm'),
		'siosm_render_megamenu_nav_menu_metabox',
		'nav-menus',
		'side',
		'default'
	);
}
add_action('admin_head-nav-menus.php', 'siosm_register_megamenu_nav_menu_metabox');

/**
 * Ensure the metabox is not hidden by default in Screen Options.
 */
function siosm_megamenu_default_unhidden_metabox($hidden, $screen)
{
	if (isset($screen->id) && 'nav-menus' === $screen->id) {
		$hidden = array_diff((array) $hidden, array('siosm-megamenu-metabox'));
	}
	return $hidden;
}
add_filter('default_hidden_meta_boxes', 'siosm_megamenu_default_unhidden_metabox', 10, 2);

/**
 * Render the Mega Menu meta box content in nav-menus.php.
 */
function siosm_render_megamenu_nav_menu_metabox()
{
	$blocks = get_posts(
		array(
			'post_type'      => 'wp_block',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'post_status'    => array('publish'),
		)
	);
?>
	<div class="megamenudiv" id="megamenudiv">
		<div id="tabs-panel-megamenu-all" class="tabs-panel tabs-panel-active" style="padding: 10px 0;">
			<p>
				<label class="howto" for="megamenu-item-name" style="font-weight: 600; display: block; margin-bottom: 4px;">
					<span><?php esc_html_e('Label du menu', 'siosm'); ?></span>
				</label>
				<input
					id="megamenu-item-name"
					type="text"
					class="widefat menu-item-textbox"
					placeholder="<?php esc_attr_e('Ex : Solutions, Découvrir...', 'siosm'); ?>" />
			</p>

			<p>
				<label class="howto" for="megamenu-item-block" style="font-weight: 600; display: block; margin-bottom: 4px;">
					<span><?php esc_html_e('Bloc dynamique à connecter', 'siosm'); ?> *</span>
				</label>
				<select id="megamenu-item-block" class="widefat">
					<option value=""><?php esc_html_e('-- Sélectionner un bloc dynamique --', 'siosm'); ?></option>
					<?php if (! empty($blocks)) : ?>
						<?php foreach ($blocks as $block) : ?>
							<option value="<?php echo esc_attr($block->ID); ?>" data-title="<?php echo esc_attr($block->post_title); ?>">
								<?php echo esc_html($block->post_title ? $block->post_title : sprintf(__('Bloc #%d (sans titre)', 'siosm'), $block->ID)); ?>
							</option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
			</p>

			<?php if (empty($blocks)) : ?>
				<p class="description" style="color: #d63638; font-size: 12px; margin-top: 4px;">
					<?php
					printf(
						/* translators: %s: Link to create dynamic block */
						__('Aucun bloc dynamique trouvé. <a href="%s" target="_blank">Créer un premier bloc dynamique</a>.', 'siosm'),
						esc_url(admin_url('post-new.php?post_type=wp_block'))
					);
					?>
				</p>
			<?php else : ?>
				<p class="description" style="font-size: 12px; margin-top: 4px;">
					<a href="<?php echo esc_url(admin_url('edit.php?post_type=wp_block')); ?>" target="_blank" style="text-decoration: none;">
						+ <?php esc_html_e('Gérer les blocs dynamiques', 'siosm'); ?>
					</a>
				</p>
			<?php endif; ?>

			<p style="margin-top: 10px;">
				<label class="howto" for="megamenu-item-url" style="font-weight: 600; display: block; margin-bottom: 4px;">
					<span><?php esc_html_e('URL du lien (optionnel)', 'siosm'); ?></span>
				</label>
				<input id="megamenu-item-url" type="text" class="widefat code menu-item-textbox" value="#" />
			</p>
		</div>

		<p class="button-controls wp-clearfix" style="margin-top: 10px;">
			<span class="add-to-menu" style="float: right;">
				<button type="button" id="submit-megamenudiv" class="button button-primary right">
					<?php esc_html_e('Ajouter au menu'); ?>
				</button>
				<span class="spinner" style="float: none; vertical-align: middle; margin-right: 5px;"></span>
			</span>
		</p>

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(document).on('click', '#submit-megamenudiv', function(e) {
					e.preventDefault();
					e.stopPropagation();

					var $btn = $(this);
					var $container = $('#megamenudiv');
					var $spinner = $container.find('.spinner');
					var $nameInput = $('#megamenu-item-name');
					var $blockSelect = $('#megamenu-item-block');
					var $urlInput = $('#megamenu-item-url');

					var blockId = $blockSelect.val();
					var selectedOption = $blockSelect.find('option:selected');
					var blockTitle = selectedOption.data('title') || selectedOption.text();
					var label = $nameInput.val().trim();
					var url = $urlInput.val().trim() || '#';

					if (!blockId) {
						alert("<?php echo esc_js(__('Veuillez sélectionner un bloc dynamique à connecter.', 'siosm')); ?>");
						$blockSelect.focus();
						return false;
					}

					if (!label) {
						label = blockTitle.trim();
					}

					var menuId = $('#menu').val();
					var nonce = $('#menu-settings-column-nonce').val();

					if (!menuId || menuId === '0') {
						alert("<?php echo esc_js(__('Veuillez sélectionner ou créer un menu avant d\'ajouter des éléments.', 'siosm')); ?>");
						return false;
					}

					$spinner.addClass('is-active');
					$btn.prop('disabled', true);

					var params = {
						action: 'add-menu-item',
						menu: menuId,
						'menu-settings-column-nonce': nonce,
						'menu-item': {
							'-1': {
								'menu-item-type': 'custom',
								'menu-item-object': 'custom',
								'menu-item-title': label,
								'menu-item-url': url,
								'menu-item-classes': 'menu-item-megamenu',
								'menu-item-megamenu-block': blockId
							}
						}
					};

					$.post(ajaxurl, params, function(menuMarkup) {
						var ins = $('#menu-instructions');
						menuMarkup = $.trim(menuMarkup);

						if (menuMarkup && menuMarkup !== '0' && menuMarkup !== '-1') {
							$('#menu-to-edit').append(menuMarkup);
							if (ins.length && !ins.hasClass('menu-instructions-inactive')) {
								ins.addClass('menu-instructions-inactive');
							}
							if (typeof wpNavMenu !== 'undefined') {
								if (typeof wpNavMenu.initSortables === 'function') {
									wpNavMenu.initSortables();
								}
								if (typeof wpNavMenu.refreshAdvancedAccessibility === 'function') {
									wpNavMenu.refreshAdvancedAccessibility();
								}
							}
							$nameInput.val('');
							$blockSelect.val('');
							$urlInput.val('#');
						} else {
							alert("<?php echo esc_js(__('Erreur lors de l\'ajout de l\'élément au menu.', 'siosm')); ?> (" + menuMarkup + ")");
						}

						$spinner.removeClass('is-active');
						$btn.prop('disabled', false);
					}).fail(function(xhr, status, error) {
						alert("<?php echo esc_js(__('Erreur réseau lors de la communication avec WordPress :', 'siosm')); ?> " + error);
						$spinner.removeClass('is-active');
						$btn.prop('disabled', false);
					});

					return false;
				});
			});
		</script>
	</div>
<?php
}

/**
 * 2. Save dynamic block ID to menu item meta.
 */
function siosm_save_megamenu_nav_menu_item($menu_id, $menu_item_db_id, $args)
{
	$block_id = 0;
	$post_data = isset($GLOBALS['_POST']) ? $GLOBALS['_POST'] : array();

	if (!empty($args['menu-item-megamenu-block'])) {
		$block_id = absint($args['menu-item-megamenu-block']);
	} elseif (isset($post_data['menu-item-megamenu-block'][$menu_item_db_id])) {
		$block_id = absint($post_data['menu-item-megamenu-block'][$menu_item_db_id]);
	} elseif (isset($post_data['menu-item']) && is_array($post_data['menu-item'])) {
		$posted_items = wp_unslash($post_data['menu-item']);
		foreach ($posted_items as $posted_item) {
			if (!empty($posted_item['menu-item-megamenu-block'])) {
				$block_id = absint($posted_item['menu-item-megamenu-block']);
				break;
			}
		}
	}

	if ($block_id > 0) {
		update_post_meta($menu_item_db_id, '_menu_item_megamenu_block', $block_id);
	} elseif (isset($post_data['menu-item-megamenu-block'][$menu_item_db_id])) {
		// Field was explicitly submitted as empty -> remove meta
		delete_post_meta($menu_item_db_id, '_menu_item_megamenu_block');
	}
}
add_action('wp_update_nav_menu_item', 'siosm_save_megamenu_nav_menu_item', 10, 3);

/**
 * 3. Add custom field to each menu item inside the menu editor.
 */
function siosm_add_megamenu_custom_fields_to_item($item_id, $item, $depth, $args)
{
	$saved_block_id = absint(get_post_meta($item_id, '_menu_item_megamenu_block', true));

	$blocks = get_posts(
		array(
			'post_type'      => 'wp_block',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
			'post_status'    => array('publish'),
		)
	);
?>
	<p class="field-megamenu-block description description-wide" style="margin: 10px 0; border-top: 1px dashed #ddd; padding-top: 8px;">
		<label for="edit-menu-item-megamenu-block-<?php echo esc_attr($item_id); ?>">
			<strong><?php esc_html_e('Bloc dynamique Mega Menu', 'siosm'); ?></strong>
			<br />
			<select
				id="edit-menu-item-megamenu-block-<?php echo esc_attr($item_id); ?>"
				class="widefat edit-menu-item-megamenu-block"
				name="menu-item-megamenu-block[<?php echo esc_attr($item_id); ?>]">
				<option value=""><?php esc_html_e('-- Aucun (menu classique) --', 'siosm'); ?></option>
				<?php foreach ($blocks as $block) : ?>
					<option value="<?php echo esc_attr($block->ID); ?>" <?php selected($saved_block_id, $block->ID); ?>>
						<?php echo esc_html($block->post_title ? $block->post_title : sprintf(__('Bloc #%d (sans titre)', 'siosm'), $block->ID)); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</label>

		<?php if ($saved_block_id) : ?>
			<span class="description" style="display: block; margin-top: 4px;">
				<a href="<?php echo esc_url(get_edit_post_link($saved_block_id)); ?>" target="_blank" style="text-decoration: none;">
					<?php esc_html_e('Modifier ce bloc dynamique dans un nouvel onglet', 'siosm'); ?>
				</a>
			</span>
		<?php endif; ?>
	</p>
<?php
}
add_action('wp_nav_menu_item_custom_fields', 'siosm_add_megamenu_custom_fields_to_item', 10, 4);

/**
 * 4. Display "Mega Menu" badge on menu item header in admin list.
 */
function siosm_setup_nav_menu_item_megamenu_badge($item)
{
	if (! empty($item->ID)) {
		$block_id = get_post_meta($item->ID, '_menu_item_megamenu_block', true);
		if (! empty($block_id)) {
			$item->type_label = __('Mega Menu', 'siosm');
		}
	}
	return $item;
}
add_filter('wp_setup_nav_menu_item', 'siosm_setup_nav_menu_item_megamenu_badge');

/**
 * 5. Helper function to render a dynamic block content.
 */
function siosm_get_megamenu_block_html($block_id)
{
	if (empty($block_id)) {
		return '';
	}

	$post = get_post($block_id);
	if (! $post || 'wp_block' !== $post->post_type || 'publish' !== $post->post_status) {
		return '';
	}

	$content = $post->post_content;
	if (empty($content)) {
		return '';
	}

	// Render Gutenberg blocks & shortcodes
	$html = do_blocks($content);
	$html = do_shortcode($html);

	return $html;
}

/**
 * 6. Add CSS classes to mega menu items on the frontend.
 */
function siosm_megamenu_nav_menu_css_classes($classes, $item, $args, $depth)
{
	if (0 === $depth) {
		$block_id = get_post_meta($item->ID, '_menu_item_megamenu_block', true);
		if (! empty($block_id)) {
			$classes[] = 'menu-item-megamenu';
			$classes[] = 'megamenu-item-' . $item->ID;
			if (! in_array('menu-item-has-children', $classes, true)) {
				$classes[] = 'menu-item-has-children';
			}
		}
	}
	return $classes;
}
add_filter('nav_menu_css_class', 'siosm_megamenu_nav_menu_css_classes', 10, 4);

/**
 * 7. Add accessibility and target attributes for mega menu items.
 */
function siosm_megamenu_nav_menu_link_attributes($atts, $item, $args, $depth)
{
	if (0 === $depth) {
		$block_id = get_post_meta($item->ID, '_menu_item_megamenu_block', true);
		if (! empty($block_id)) {
			$atts['aria-haspopup'] = 'true';
			$atts['aria-expanded'] = 'false';
			$atts['data-megamenu-target'] = 'megamenu-' . $item->ID;
		}
	}
	return $atts;
}
add_filter('nav_menu_link_attributes', 'siosm_megamenu_nav_menu_link_attributes', 10, 4);

/**
 * 8. Inject mega menu panel HTML inside walker output for offcanvas/mobile accordion.
 */
function siosm_megamenu_nav_menu_start_el($item_output, $item, $depth, $args)
{
	if (0 === $depth) {
		$block_id = get_post_meta($item->ID, '_menu_item_megamenu_block', true);
		if (! empty($block_id)) {
			// For mobile accordion (offcanvas), render inline
			if (isset($args->menu_class) && false !== strpos($args->menu_class, 'accordion')) {
				$block_html = siosm_get_megamenu_block_html($block_id);
				if (! empty($block_html)) {
					$item_output .= '<div class="megamenu-panel"><div class="px-3 py-2">' . $block_html . '</div></div>';
				}
			}
		}
	}
	return $item_output;
}
add_filter('walker_nav_menu_start_el', 'siosm_megamenu_nav_menu_start_el', 10, 4);

/**
 * 9. Render all desktop Mega Menu panels directly inside <header> after div.container.
 */
function siosm_render_megamenus($location = 'primary')
{
	$locations = get_nav_menu_locations();
	if (empty($locations[$location])) {
		return;
	}

	$menu = wp_get_nav_menu_object($locations[$location]);
	if (! $menu) {
		return;
	}

	$menu_items = wp_get_nav_menu_items($menu->term_id);
	if (empty($menu_items)) {
		return;
	}

	foreach ($menu_items as $item) {
		if (empty($item->menu_item_parent) || '0' === (string) $item->menu_item_parent) {
			$block_id = get_post_meta($item->ID, '_menu_item_megamenu_block', true);
			if (! empty($block_id)) {
				$block_html = siosm_get_megamenu_block_html($block_id);
				if (! empty($block_html)) {
				?>
					<div
						id="megamenu-<?php echo esc_attr($item->ID); ?>"
						class="megamenu-panel"
						data-menu-item="<?php echo esc_attr($item->ID); ?>"
						role="region"
						aria-label="<?php echo esc_attr($item->title); ?>">
						<div class="container mx-auto px-4 py-8 lg:px-8">
							<?php echo $block_html; ?>
						</div>
					</div>
				<?php
				}
			}
		}
	}
}
