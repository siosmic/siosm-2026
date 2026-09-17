<?php

/**
 * 1. Fermer les commentaires et les pings (rétroactif et pour les nouveaux posts)
 */
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

/**
 * 2. Masquer totalement les commentaires existants sur le front-end
 */
add_filter('comments_array', '__return_empty_array', 10, 2);

/**
 * 3. Retirer le support des commentaires pour tous les types de publications
 */
add_action('init', function () {
   $post_types = get_post_types();
   foreach ($post_types as $post_type) {
      if (post_type_supports($post_type, 'comments')) {
         remove_post_type_support($post_type, 'comments');
         remove_post_type_support($post_type, 'trackbacks');
      }
   }
});

/**
 * 4. Nettoyer l'interface d'administration (Menu, Metaboxes, Redirection)
 */
add_action('admin_init', function () {
   // Rediriger quiconque essaie d'accéder à la page des commentaires via l'URL directe
   global $pagenow;
   if ($pagenow === 'edit-comments.php') {
      wp_redirect(admin_url());
      exit;
   }

   // Retirer les boîtes de commentaires sur les pages d'édition
   remove_meta_box('commentsdiv', 'post', 'normal');
   remove_meta_box('commentsdiv', 'page', 'normal');
   remove_meta_box('commentstatusdiv', 'post', 'normal');
   remove_meta_box('commentstatusdiv', 'page', 'normal');
   remove_meta_box('trackbacksdiv', 'post', 'normal');
   remove_meta_box('trackbacksdiv', 'page', 'normal');
});

/**
 * 5. Retirer l'onglet "Commentaires" du menu latéral gauche
 */
add_action('admin_menu', function () {
   remove_menu_page('edit-comments.php');
});

/**
 * 6. Retirer l'icône de la bulle de commentaires dans la barre supérieure d'administration
 */
add_action('wp_before_admin_bar_render', function () {
   global $wp_admin_bar;
   $wp_admin_bar->remove_menu('comments');
});
