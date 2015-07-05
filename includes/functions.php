<?php 
// functions for Genesis AWP Communities

add_filter( 'template_include', 'awp_template_include',99 );
/**
 * Display based on templates in plugin, or override with same name template in theme directory
 */
function awp_template_include( $template ) {

    $post_type = 'awp-community';  
    
    //echo 'tax ' . awp_communities_is_taxonomy_of($post_type) . "\n";
    //echo 'archive ' . is_post_type_archive( $post_type ) . "\n";
    //echo 'post type ' . get_post_type() . "\n";

    if ( awp_communities_is_taxonomy_of($post_type) ) {
        if ( file_exists(get_stylesheet_directory() . '/archive-' . $post_type . '.php' ) ) {
            return get_stylesheet_directory() . '/archive-' . $post_type . '.php';
        } else {
            echo GENAWPCOMM_BASE_DIR  . '/templates/archive-' . $post_type . '.php';
            return GENAWPCOMM_BASE_DIR  . '/templates/archive-' . $post_type . '.php';
        }
    }

    if ( is_post_type_archive( $post_type ) ) {
        if ( file_exists(get_stylesheet_directory() . '/archive-' . $post_type . '.php') ) {
            return $template;
        } else {
            echo GENAWPCOMM_BASE_DIR  . '/templates/archive-' . $post_type . '.php';
            return GENAWPCOMM_BASE_DIR  . '/templates/archive-' . $post_type . '.php';
        }
    }

    if ( $post_type == get_post_type() ) {
        if ( file_exists(get_stylesheet_directory() . '/single-' . $post_type . '.php') ) {
            return $template;
        } else {
        	echo GENAWPCOMM_BASE_DIR  . '/templates/single-' . $post_type . '.php';
           return GENAWPCOMM_BASE_DIR  . '/templates/single-' . $post_type . '.php';
        }
    }
   // echo ' We have selected this template: ' . $template;
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

add_action( 'init', 'build_taxonomies', 0 );  
function build_taxonomies() {  
    register_taxonomy(  
    'neighborhoods',  
    'awp-community',  // this is the custom post type(s) I want to use this taxonomy for
    array(  
        'hierarchical' => false,  
        'label' => 'Neighborhoods',  
        'query_var' => true,  
        'rewrite' => true  
    )  
);  
}
// change the archive page for Community Post Type to display up to 100 communities per page.
add_action( 'pre_get_posts', 'awp_cpt_posts_per_page' );
function awp_cpt_posts_per_page( $query ) {
    if( $query->is_main_query() && is_post_type_archive( 'awp-community' ) && ! is_admin() ) {
        $query->set( 'posts_per_page', '100' );
    }
}

?>
