<?php
add_action('acf/init', function() {
    $blocks_dir = get_template_directory() . '/blocks';

    // Automatic crawling into folders to register ACF blocks
    foreach (glob($blocks_dir . '/*', GLOB_ONLYDIR) as $block_dir) {
        $block_json = $block_dir . '/block.json';

        if (file_exists($block_json)) {
            register_block_type($block_dir);
        }
    }
});
