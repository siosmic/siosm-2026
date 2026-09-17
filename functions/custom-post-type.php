<?php
/* joints Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

*/


// let's create the function for the custom type
function init_custom_post_types()
{

	// register_post_type(
	// 	'partner',
	// 	array(
	// 		'labels' => array(
	// 			'name' => __('Partenaires', 'siosm'),
	// 			'singular_name' => __('Partenaire', 'siosm'),
	// 			'all_items' => __('Partenaires', 'siosm'),
	// 			'add_new' => __('Nouveau partenaire', 'siosm'),
	// 			'add_new_item' => __('Ajouter une partenaire', 'siosm'),
	// 			'edit' => __('Modifier', 'siosm'),
	// 			'edit_item' => __('Modifier', 'siosm'),
	// 			'new_item' => __('Nouveau partenaire', 'siosm'),
	// 			'view_item' => __('Voir le partenaire', 'siosm'),
	// 			'search_items' => __('Search Post Type', 'siosm'),
	// 			'not_found' =>  __('Nothing found in the Database.', 'siosm'),
	// 			'not_found_in_trash' => __('Nothing found in Trash', 'siosm'),
	// 			'parent_item_colon' => ''
	// 		),
	// 		'description' => __('Liste des partenaires', 'siosm'),
	// 		'public' => true,
	// 		'publicly_queryable' => true,
	// 		'exclude_from_search' => false,
	// 		'show_ui' => true,
	// 		'query_var' => true,
	// 		// 'taxonomies' => array('post_tag'),
	// 		'show_in_rest' => true, // Enable Gutenberg
	// 		'menu_position' => 8,
	// 		'menu_icon' => 'dashicons-image-filter',
	// 		'rewrite'	=> array('slug' => 'partenaires', 'with_front' => false), /* url slug */
	// 		'has_archive' => 'partenaires',
	// 		'capability_type' => 'post',
	// 		'hierarchical' => false,
	// 		'supports' => array('title', 'editor', 'thumbnail', 'custom-fields', 'revisions')
	// 	)
	// );

	// register_taxonomy_for_object_type('category', 'comitee_member');

}

// adding the function to the Wordpress init
add_action('init', 'init_custom_post_types');
	

// register_taxonomy( 'type_partner', 
// 	array('partner'),
// 	array('hierarchical' => true,
// 		'labels' => array(
// 			'name' => __( 'Type', 'siosm' ), /* name of the custom taxonomy */
// 			'singular_name' => __( 'Type', 'siosm' ), /* single taxonomy name */
// 			'search_items' =>  __( 'Search', 'siosm' ), /* search title for taxomony */
// 			'all_items' => __( 'Tout', 'siosm' ), /* all title for taxonomies */
// 			'parent_item' => __( 'Parent Custom Category', 'siosm' ), /* parent title for taxonomy */
// 			'parent_item_colon' => __( 'Parent Custom Category:', 'siosm' ), /* parent taxonomy title */
// 			'edit_item' => __( 'Modifier', 'siosm' ), /* edit custom taxonomy title */
// 			'update_item' => __( 'Update Custom Category', 'siosm' ), /* update title for taxonomy */
// 			'add_new_item' => __( 'Add New Custom Category', 'siosm' ), /* add new title for taxonomy */
// 			'new_item_name' => __( 'New Custom Category Name', 'siosm' ) /* name title for taxonomy */
// 		),
// 		'show_admin_column' => true, 
// 		'show_ui' => true,
// 		'show_in_rest' => true, // Enable Gutenberg
// 		'query_var' => true,
// 		'rewrite' => array( 'slug' => 'type' ),
// 	)
// );
