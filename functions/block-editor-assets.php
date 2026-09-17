<?php
/* Register metas to later use it with TSX */
add_action('init', function () {

   register_post_meta('page', '_siosm_page_options', array(
      'show_in_rest'      => true, // Indispensable pour l'éditeur de blocs
      'single'            => true,
      'type'              => 'boolean',
      'auth_callback'     => function () {
         return current_user_can('edit_posts');
      }
   ));
});
add_action('enqueue_block_editor_assets', function () {
   $theme = wp_get_theme();

   // Détection et inclusion automatique des scripts de l'éditeur
   $editor_files = glob(get_stylesheet_directory() . '/build/js/editor-*.js');
   if ($editor_files) {
      foreach ($editor_files as $file_path) {
         $filename = basename($file_path);
         $name_clean = basename($file_path, '.js');
         $handle = 'theme-' . sanitize_title($name_clean);
         $asset_file = get_stylesheet_directory() . '/build/js/' . $name_clean . '.asset.php';

         if (file_exists($asset_file)) {
            $assets = require($asset_file);
            wp_enqueue_script(
               $handle,
               get_stylesheet_directory_uri() . '/build/js/' . $filename,
               $assets['dependencies'],
               $assets['version'],
               true
            );
         } else {
            wp_enqueue_script(
               $handle,
               get_stylesheet_directory_uri() . '/build/js/' . $filename,
               array('wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data', 'wp-core-data'),
               $theme->get('Version'),
               true
            );
         }
      }
   }
});
