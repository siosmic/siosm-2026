<?php

/**
 * Theme Options & Dynamic Theme.json Settings
 */

// Sync ACF Colors with WordPress theme.json & Tailwind
add_filter('wp_theme_json_data_theme', function ($theme_json) {
    if (!function_exists('get_field')) {
        return $theme_json;
    }

    $primary_color   = get_field('primary_color', 'option');
    $secondary_color = get_field('secondary_color', 'option');

    if (!empty($primary_color) || !empty($secondary_color)) {
        // Read the base palette directly from theme.json
        $theme_json_path = get_template_directory() . '/theme.json';
        if (!file_exists($theme_json_path)) {
            return $theme_json;
        }

        $theme_config = json_decode(file_get_contents($theme_json_path), true);
        $palette = $theme_config['settings']['color']['palette'] ?? [];

        // Only override primary and secondary if defined in ACF
        foreach ($palette as &$color_item) {
            if ($color_item['slug'] === 'primary' && !empty($primary_color)) {
                $color_item['color'] = sanitize_hex_color($primary_color);
            } elseif ($color_item['slug'] === 'secondary' && !empty($secondary_color)) {
                $color_item['color'] = sanitize_hex_color($secondary_color);
            }
        }
        unset($color_item);

        $custom_data = [
            'version'  => 1,
            'settings' => [
                'color' => [
                    'palette' => $palette,
                ],
            ],
        ];

        $theme_json->update_with($custom_data);
    }

    return $theme_json;
});
