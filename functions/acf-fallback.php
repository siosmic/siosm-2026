<?php
/**
 * ACF Fallback Functions & Admin Notice
 * Prevents fatal PHP errors when ACF is not active.
 */

// If ACF is already loaded, nothing to do.
if (class_exists('ACF') || class_exists('acf') || function_exists('acf')) {
    return;
}

// Display admin notice if ACF is missing
add_action('admin_notices', function () {
    if (class_exists('ACF') || class_exists('acf') || function_exists('acf')) {
        return;
    }
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><strong><?php _e('Theme:', 'siosm'); ?></strong> <?php _e('The <strong>Advanced Custom Fields (ACF)</strong> plugin is required for this theme to function properly. Please install or activate it.', 'siosm'); ?></p>
    </div>
    <?php
});

// Do not declare dummy functions on plugin management screens or during plugin activation
// to prevent "Cannot redeclare function get_field()" fatal error when ACF is being activated.
if (is_admin()) {
    global $pagenow;
    if (
        in_array($pagenow, ['plugins.php', 'plugin-install.php', 'update.php'], true) ||
        (isset($_REQUEST['action']) && in_array($_REQUEST['action'], ['activate', 'activate-plugin', 'do-plugin-upgrade'], true))
    ) {
        return;
    }
}

if (!function_exists('get_field')) {
    function get_field($selector, $post_id = false, $format_value = true) {
        return false;
    }
}

if (!function_exists('the_field')) {
    function the_field($selector, $post_id = false, $format_value = true) {
        return false;
    }
}

if (!function_exists('have_rows')) {
    function have_rows($selector, $post_id = false) {
        return false;
    }
}

if (!function_exists('the_row')) {
    function the_row() {
        return false;
    }
}

if (!function_exists('get_sub_field')) {
    function get_sub_field($selector, $format_value = true) {
        return false;
    }
}

if (!function_exists('the_sub_field')) {
    function the_sub_field($selector, $format_value = true) {
        return false;
    }
}

if (!function_exists('get_field_object')) {
    function get_field_object($selector, $post_id = false, $format_value = true, $load_value = true) {
        return false;
    }
}

if (!function_exists('acf_add_options_page')) {
    function acf_add_options_page($settings = array()) {
        return false;
    }
}

if (!function_exists('acf_add_options_sub_page')) {
    function acf_add_options_sub_page($settings = array()) {
        return false;
    }
}

if (!function_exists('get_fields')) {
    function get_fields($post_id = false, $format_value = true) {
        return false;
    }
}

if (!function_exists('update_field')) {
    function update_field($selector, $value, $post_id = false) {
        return false;
    }
}

if (!function_exists('delete_field')) {
    function delete_field($selector, $post_id = false) {
        return false;
    }
}

