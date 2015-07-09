<?php 
// functions for Genesis AWP Communities

add_filter( 'template_include', 'awp_template_include',99 );
/**
 * Display based on templates in plugin, or override with same name template in theme directory
 */
function awp_template_include( $template ) {

    $post_type = 'awp-community';  
    
    
    if ( awp_communities_is_taxonomy_of($post_type) ) {
        if ( file_exists(get_stylesheet_directory() . '/archive-' . $post_type . '.php' ) ) {
            return get_stylesheet_directory() . '/archive-' . $post_type . '.php';
        } else {
      
            return GENAWPCOMM_BASE_DIR  . '/templates/archive-' . $post_type . '.php';
        }
    }

    if ( is_post_type_archive( $post_type ) ) {
        if ( file_exists(get_stylesheet_directory() . '/archive-' . $post_type . '.php') ) {
            return $template;
        } else {
         
            return GENAWPCOMM_BASE_DIR  . '/templates/archive-' . $post_type . '.php';
        }
    }

    if ( $post_type == get_post_type() ) {
        if ( file_exists(get_stylesheet_directory() . '/single-' . $post_type . '.php') ) {
            return $template;
        } else {
        
           return GENAWPCOMM_BASE_DIR  . '/templates/single-' . $post_type . '.php';
        }
    }
 
    return $template;
}


/**
 * Returns true if the queried taxonomy is a taxonomy of the given post type
 */
function awp_communities_is_taxonomy_of($post_type) {
	$taxonomies = get_object_taxonomies($post_type);
	$queried_tax = get_query_var('taxonomy');

	if ( in_array($queried_tax, $taxonomies) ) {
		return true;
	}

	return false;
}

/*
Reserved to add a default Features taxonomy in a future release.
add_action( 'init', 'build_taxonomies', 0 );  
function build_taxonomies() {  
    register_taxonomy(  
    'features',  
    'awp-community',  // this is the custom post type(s) I want to use this taxonomy for
    array(  
        'hierarchical' => false,  
        'label' => 'Features',  
        'query_var' => true,  
        'rewrite' => true  
    )  
);  
}
*/

// change the archive page for Community Post Type to display up to 100 communities per page.
add_action( 'pre_get_posts', 'awp_cpt_posts_per_page' );
function awp_cpt_posts_per_page( $query ) {
    if( $query->is_main_query() && is_post_type_archive( 'awp-community' ) && ! is_admin() ) {
        $query->set( 'posts_per_page', '100' );
    }
}

// Add featured-wide image above single posts.
add_action( 'genesis_before_entry_content', 'awp_featured_image' );
function awp_featured_image() {
    global $post;

    // Return early if not a singular or does not have thumbnail
    if ( ! get_post_type() == 'awp-community' || ! is_singular() || ! has_post_thumbnail() || is_page() ) {
        return;
    }

    echo '<div class="featured-image">';
    echo get_the_post_thumbnail( $post->ID, 'awp-feature-wide' );
    echo '</div>';
}

// remove the layout settings for the archive page of awp-community since we force it to full width

add_action( 'genesis_cpt_archives_settings_metaboxes', 'awp_remove_genesis_cpt_metaboxes' );
function awp_remove_genesis_cpt_metaboxes( $_genesis_cpt_settings_pagehook ) {
    
    // remove layout settings
    remove_meta_box( 'genesis-cpt-archives-layout-settings', $_genesis_cpt_settings_pagehook, 'main' );
    
}



?>
