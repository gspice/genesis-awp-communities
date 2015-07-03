<?php

/**
 * Registers and Formats post types
 *
 * @package Winning Agent Pro
 * @subpackage Customizations
 * @author  Carrie Dils
 * @license GPL-2.0+
 *
 */

add_action( 'widgets_init', 'awp_register_custom_post_type' );
function awp_register_custom_post_type() {
//registers "community" post type
register_post_type( 'awp-community',
	array(
		'labels'				=> array(
			'name'				=> __( 'Communities', 'awp' ),
			'singular_name'		=> __( 'Community', 'awp' ),
		),
		'has_archive'			=> true,
		'hierarchical'			=> true,
		'menu_icon'				=> 'dashicons-admin-home',
		'public'				=> true,
		'rewrite'				=> array( 'slug' => 'community', 'with_front' => false ),
		'supports'				=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'genesis-seo', 'genesis-cpt-archives-settings' ),
		'taxonomies'			=> array( 'category' ),

	)
);
}



